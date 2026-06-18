<?php

function formatarValor($valor)
{
    return str_replace(['.', ','], ['', '.'], $valor);
}