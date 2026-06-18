<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth', 'middleware' => 'check.estudio'], function () {

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

        Route::get('/home', 'HomeController@index')->name('home');
        
        Route::get('/home/estudio/{id_estudio}', 'HomeController@estudio')->name('home.estudio');

        Route::resource('/clientes', 'ClienteController');
        
        Route::resource('/artistas', 'ArtistaController');
        
        Route::resource('/estacoes', 'EstacaoController')->parameters(['estacoes' => 'estacao']);
        
        Route::resource('/orcamentos', 'OrcamentoController');
        
        Route::get('/orcamentos/{orcamento}/cancelar/', 'OrcamentoController@cancelar')->name('orcamentos.cancelar');
        
        Route::get('/orcamentos/{orcamento}/recuperar/', 'OrcamentoController@recuperar')->name('orcamentos.recuperar');
        
        Route::resource('/agendamentos', 'AgendamentoController');

        Route::get('/agendamentos/{agendamento}/finalizar/', 'AgendamentoController@finalizar')->name('agendamentos.finalizar');
        
        Route::get('/agendamentos/{agendamento}/cancelar/', 'AgendamentoController@cancelar')->name('agendamentos.cancelar');

        Route::get('/downloadPDF/{id}','AgendamentoController@downloadPDF')->name('downloadPDF');
    });

});

Auth::routes(['register' => false, 'reset' => false]);