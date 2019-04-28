<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/peleaBasica', 'PeleaController@peleaBasica');
Route::get('/victima','PeleaController@agregarVictima');
Route::get('/avatar', 'PeleaController@agregarAvatar');
Route::get('/perfil','PeleaController@consultarPerfil');
Route::get('/miRanking','PeleaController@miRankingGlobal');
Route::get('/miRankingLiga', 'PeleaController@miRankingLiga');
Route::get('/afiliarGym','PeleaController@afiliacionGym');
Route::get('/desafiliarGym','PeleaController@desafiliacionGym');
Route::get('/topRankingGlobal','PeleaController@topRankingGlobal');
Route::get('/topRankingLiga','PeleaController@topRankingLiga');
Route::get('/inscribirCombateLiga', 'PeleaController@inscribirLigaCombate');
Route::get('/misDatosLiga', 'PeleaController@misDatosLiga');
Route::get('/peleaLiga', 'PeleaController@peleaLiga');
Route::get('/misMedallas', 'PeleaController@misMedallas');
Route::get('/todasMisMedallas', 'PeleaController@todasMisMedallas');
Route::get('/inscribirTorneo', 'PeleaController@inscribirTorneo');
Route::get('/torneo', 'PeleaController@torneo');
Route::get('/inscribirConcurso', 'PeleaController@inscribirConcurso');
Route::get('/concurso', 'PeleaController@concurso');
Route::get('/detalleTorneo', 'PeleaController@detalleTorneo');
Route::get('/detalleConcurso', 'PeleaController@detalleConcurso');
Route::get('/gimnasios', 'PeleaController@todosLosGimnasios');
Route::get('/torneos', 'PeleaController@todosLosTorneos');
Route::get('/concursos', 'PeleaController@todosLosConcursos');
//Route::get('/esUsuarioValido', 'PeleaController@esUsuarioValido');
Route::get('/detalleGimnasio', 'PeleaController@gimnasio');