<?php

namespace Tests\Unit;

use App\Agendamento;
use App\Orcamento;
use App\Services\GoogleCalendarService;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class GoogleCalendarServiceTest extends TestCase
{
    public function test_sync_sends_calendar_event_with_agendamento_data()
    {
        $requests = [];

        $service = new GoogleCalendarService(function ($method, $url, $headers, $body) use (&$requests) {
            $requests[] = compact('method', 'url', 'headers', 'body');

            return [
                'status' => 200,
                'body' => json_encode(['id' => 'adminkagendamento123']),
            ];
        }, $this->enabledConfig());

        $agendamento = $this->agendamento();

        $this->assertTrue($service->sync($agendamento));
        $this->assertCount(1, $requests);
        $this->assertSame('POST', $requests[0]['method']);
        $this->assertSame('https://www.googleapis.com/calendar/v3/calendars/primary/events', $requests[0]['url']);
        $this->assertSame('Bearer test-token', $requests[0]['headers']['Authorization']);
        $this->assertSame('Admink - Tatuagem geometrica', $requests[0]['body']['summary']);
        $this->assertSame('adminkagendamento123', $requests[0]['body']['id']);
        $this->assertSame('2026-06-18T10:00:00-03:00', $requests[0]['body']['start']['dateTime']);
        $this->assertSame('2026-06-18T12:00:00-03:00', $requests[0]['body']['end']['dateTime']);
        $this->assertSame('America/Sao_Paulo', $requests[0]['body']['start']['timeZone']);
        $this->assertStringContainsString('Observacao: Sessao com linhas finas', $requests[0]['body']['description']);
    }

    public function test_sync_returns_false_when_google_api_fails()
    {
        $service = new GoogleCalendarService(function () {
            return [
                'status' => 500,
                'body' => json_encode(['error' => 'calendar unavailable']),
            ];
        }, $this->enabledConfig());

        $this->assertFalse($service->sync($this->agendamento()));
    }

    public function test_sync_returns_false_when_http_client_throws_exception()
    {
        $service = new GoogleCalendarService(function () {
            throw new RuntimeException('timeout');
        }, $this->enabledConfig());

        $this->assertFalse($service->sync($this->agendamento()));
    }

    private function agendamento()
    {
        $timeZone = new DateTimeZone('America/Sao_Paulo');

        $agendamento = new Agendamento([
            'data_horario_inicio' => new DateTime('2026-06-18 10:00:00', $timeZone),
            'data_horario_fim' => new DateTime('2026-06-18 12:00:00', $timeZone),
            'observacao' => 'Sessao com linhas finas',
        ]);
        $agendamento->id_agendamento = 123;

        $orcamento = new Orcamento([
            'tatuagem_nome' => 'Tatuagem geometrica',
        ]);
        $orcamento->id_orcamento = 456;

        $agendamento->setRelation('orcamento', $orcamento);

        return $agendamento;
    }

    private function enabledConfig()
    {
        return [
            'enabled' => true,
            'calendar_id' => 'primary',
            'timezone' => 'America/Sao_Paulo',
            'access_token' => 'test-token',
            'timeout' => 10,
        ];
    }
}
