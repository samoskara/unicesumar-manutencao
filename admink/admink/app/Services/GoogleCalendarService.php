<?php

namespace App\Services;

use App\Agendamento;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use RuntimeException;
use Throwable;

class GoogleCalendarService
{
    private const EVENTS_ENDPOINT = 'https://www.googleapis.com/calendar/v3/calendars/%s/events';
    private const TOKEN_ENDPOINT = 'https://oauth2.googleapis.com/token';

    private $httpClient;
    private $config;

    public function __construct(callable $httpClient = null, array $config = [])
    {
        $this->httpClient = $httpClient;
        $this->config = array_merge($this->defaultConfig(), $config);
    }

    public function sync(Agendamento $agendamento)
    {
        if (!$this->isEnabled()) {
            return false;
        }

        try {
            $accessToken = $this->resolveAccessToken();

            if (!$accessToken) {
                $this->reportFailure('Google Calendar sync skipped: missing OAuth token.');
                return false;
            }

            $response = $this->sendRequest(
                'POST',
                sprintf(self::EVENTS_ENDPOINT, rawurlencode($this->calendarId())),
                [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                $this->buildEvent($agendamento)
            );

            $status = isset($response['status']) ? (int) $response['status'] : 0;

            if ($status >= 200 && $status < 300) {
                return true;
            }

            $this->reportFailure('Google Calendar sync failed.', [
                'status' => $status,
                'body' => isset($response['body']) ? $response['body'] : null,
            ]);

            return false;
        } catch (Throwable $exception) {
            $this->reportFailure('Google Calendar sync failed with exception.', [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    public function buildEvent(Agendamento $agendamento)
    {
        $event = [
            'summary' => $this->buildSummary($agendamento),
            'description' => $this->buildDescription($agendamento),
            'start' => [
                'dateTime' => $this->formatDateTime($agendamento->data_horario_inicio),
                'timeZone' => $this->timeZone(),
            ],
            'end' => [
                'dateTime' => $this->formatDateTime($agendamento->data_horario_fim),
                'timeZone' => $this->timeZone(),
            ],
        ];

        if ($agendamento->getKey()) {
            $event['id'] = 'adminkagendamento' . $agendamento->getKey();
            $event['extendedProperties'] = [
                'private' => [
                    'admink_agendamento_id' => (string) $agendamento->getKey(),
                ],
            ];
        }

        return $event;
    }

    private function resolveAccessToken()
    {
        if (!empty($this->config['access_token'])) {
            return $this->config['access_token'];
        }

        if (empty($this->config['client_id']) || empty($this->config['client_secret']) || empty($this->config['refresh_token'])) {
            return null;
        }

        $response = $this->sendRequest(
            'POST',
            self::TOKEN_ENDPOINT,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query([
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'refresh_token' => $this->config['refresh_token'],
                'grant_type' => 'refresh_token',
            ])
        );

        $status = isset($response['status']) ? (int) $response['status'] : 0;
        $body = isset($response['body']) ? $response['body'] : '';
        $data = json_decode($body, true);

        if ($status < 200 || $status >= 300 || empty($data['access_token'])) {
            return null;
        }

        return $data['access_token'];
    }

    private function sendRequest($method, $url, array $headers, $body)
    {
        if ($this->httpClient) {
            return call_user_func($this->httpClient, $method, $url, $headers, $body);
        }

        if (!function_exists('curl_init')) {
            throw new RuntimeException('The cURL PHP extension is required to sync Google Calendar.');
        }

        $headerLines = [];

        foreach ($headers as $name => $value) {
            $headerLines[] = $name . ': ' . $value;
        }

        $payload = is_string($body) ? $body : json_encode($body);
        $handle = curl_init($url);

        curl_setopt_array($handle, [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headerLines,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_TIMEOUT => (int) $this->config['timeout'],
        ]);

        $responseBody = curl_exec($handle);

        if ($responseBody === false) {
            $message = curl_error($handle);
            curl_close($handle);

            throw new RuntimeException($message);
        }

        $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        return [
            'status' => $status,
            'body' => $responseBody,
        ];
    }

    private function buildSummary(Agendamento $agendamento)
    {
        $orcamento = $this->loadedRelation($agendamento, 'orcamento');

        if ($orcamento && !empty($orcamento->tatuagem_nome)) {
            return 'Admink - ' . $orcamento->tatuagem_nome;
        }

        return 'Admink - Agendamento';
    }

    private function buildDescription(Agendamento $agendamento)
    {
        $lines = [];

        if ($agendamento->getKey()) {
            $lines[] = 'Agendamento #' . $agendamento->getKey();
        }

        $orcamento = $this->loadedRelation($agendamento, 'orcamento');

        if ($orcamento && method_exists($orcamento, 'getKey') && $orcamento->getKey()) {
            $lines[] = 'Orcamento #' . $orcamento->getKey();
        }

        if (!empty($agendamento->observacao)) {
            $lines[] = 'Observacao: ' . $agendamento->observacao;
        }

        return implode("\n", $lines);
    }

    private function loadedRelation($model, $relation)
    {
        if (method_exists($model, 'relationLoaded') && $model->relationLoaded($relation)) {
            return $model->getRelation($relation);
        }

        return null;
    }

    private function formatDateTime($value)
    {
        $timeZone = new DateTimeZone($this->timeZone());

        if ($value instanceof DateTimeInterface) {
            $date = new DateTimeImmutable('@' . $value->getTimestamp());
        } else {
            $date = new DateTime((string) $value, $timeZone);
        }

        return $date->setTimezone($timeZone)->format(DateTime::ATOM);
    }

    private function defaultConfig()
    {
        $servicesConfig = [];

        if (function_exists('config')) {
            try {
                $servicesConfig = config('services.google_calendar', []);
            } catch (Throwable $exception) {
                $servicesConfig = [];
            }
        }

        return array_merge([
            'enabled' => $this->envValue('GOOGLE_CALENDAR_ENABLED', false),
            'calendar_id' => $this->envValue('GOOGLE_CALENDAR_ID', 'primary'),
            'timezone' => $this->envValue('GOOGLE_CALENDAR_TIMEZONE', 'America/Sao_Paulo'),
            'access_token' => $this->envValue('GOOGLE_CALENDAR_ACCESS_TOKEN'),
            'client_id' => $this->envValue('GOOGLE_CALENDAR_CLIENT_ID'),
            'client_secret' => $this->envValue('GOOGLE_CALENDAR_CLIENT_SECRET'),
            'refresh_token' => $this->envValue('GOOGLE_CALENDAR_REFRESH_TOKEN'),
            'timeout' => $this->envValue('GOOGLE_CALENDAR_TIMEOUT', 10),
        ], $servicesConfig ?: []);
    }

    private function envValue($key, $default = null)
    {
        if (function_exists('env')) {
            return env($key, $default);
        }

        return $default;
    }

    private function isEnabled()
    {
        return filter_var($this->config['enabled'], FILTER_VALIDATE_BOOLEAN);
    }

    private function calendarId()
    {
        return $this->config['calendar_id'] ?: 'primary';
    }

    private function timeZone()
    {
        return $this->config['timezone'] ?: 'America/Sao_Paulo';
    }

    private function reportFailure($message, array $context = [])
    {
        if (!function_exists('logger')) {
            return;
        }

        try {
            logger()->warning($message, $context);
        } catch (Throwable $exception) {
            // Logging must never block the scheduling flow.
        }
    }
}
