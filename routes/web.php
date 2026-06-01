<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\SuscripcionesController;
use App\Http\Livewire\ApiTeamsList;
use App\Http\Controllers\StripeWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/payment-success', function () {
//     return view('payment-success');
// })->name('payment.success');




Route::view('/terms', 'livewire.legal.terms')->name('terms');
Route::view('/privacy', 'livewire.legal.privacy')->name('privacy');

// Inscripciones y pagos
Route::middleware('auth')->group(function () {
    Route::get('/inscribirse/{torneo}', [InscripcionesController::class, 'inscribirse'])->name('inscribirse');
    Route::get('/pay-again/{inscripcion}', [InscripcionesController::class, 'payAgain'])->name('payment.payAgain');
    Route::get('/payment/success/{inscripcion_id}', [InscripcionesController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [InscripcionesController::class, 'cancel'])->name('payment.cancel');


    

Route::get('/planes', [SuscripcionesController::class, 'index'])->name('planes');
Route::get('/planes/checkout/{plan}', [SuscripcionesController::class, 'checkout'])->name('planes.checkout');
Route::get('/suscripcion/success', [SuscripcionesController::class, 'success'])->name('suscripcion.success');
Route::get('/suscripcion/cancel', [SuscripcionesController::class, 'cancel'])->name('suscripcion.cancel');
});
//


//

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::middleware(['auth', 'role:Administrador'])->group(function () {


    Route::view('tournaments', 'livewire.torneos.index')->middleware('auth', 'can:modulo-torneos');
    Route::view('matchdays', 'livewire.jornadas.index')->middleware('auth', 'can:modulo-jornadas');
    Route::view('players', 'livewire.jugadores.index')->middleware('auth', 'can:modulo-jugadores');
    Route::view('results', 'livewire.resultados.index')->middleware('auth', 'can:modulo-resultados');
    Route::view('matches', 'livewire.partidos.index')->middleware('auth', 'can:modulo-partidos');
    Route::view('teams', 'livewire.equipos.index')->middleware('auth');
    Route::view('profile', 'livewire.perfils.index')->middleware('auth', 'can:modulo-perfil');
    Route::view('standings', 'livewire.posiciones.index')->middleware('auth');
    Route::view('allpredictions', 'livewire.allpronosticos.index')->middleware('auth');
    Route::view('predictions', 'livewire.pronosticos.index')->middleware('auth', 'can:modulo-pronosticos');
});


Route::middleware(['auth', 'checksubscription'])->group(function () {

    Route::view('allpredictions', 'livewire.allpronosticos.index')->middleware('auth');
    Route::view('predictions', 'livewire.pronosticos.index')->middleware('auth', 'can:modulo-pronosticos');
    Route::view('standings', 'livewire.posiciones.index')->middleware('auth');
    Route::view('results', 'livewire.resultados.index')->middleware('auth', 'can:modulo-resultados');




});
Route::middleware(['auth'])->group(function () {
    Route::view('matchdays', 'livewire.jornadas.index')->middleware('auth', 'can:modulo-jornadas');

    Route::view('rules', 'livewire.reglamento.index')->middleware('auth');
    Route::view('password', 'livewire.cambiarpassword.index');
    Route::view('registrations', 'livewire.inscripciones.index')->middleware('auth');
    Route::view('profile', 'livewire.perfils.index')->middleware('auth', 'can:modulo-perfil');
    

   
    Route::view('groups/{grupo}/join', 'livewire.grupos.join')->name('groups.join');

       Route::get('groups/codigo/{codigo}', function ($codigo) {
    $grupo = \App\Models\Grupo::where('codigo_invitacion', $codigo)->firstOrFail();
    return redirect()->route('groups.join', $grupo->id);
})->name('groups.join.codigo');

  // Jugador: ver invitaciones / grupos donde participa
    Route::view('mis-invitaciones', 'livewire.grupos.invitaciones')
        ->name('mis-invitaciones');
        Route::view('groups/{grupo}', 'livewire.grupos.panel')
    ->middleware('auth')
    ->name('groups.panel');


});



Route::middleware(['auth', 'suscripcion.activa'])->group(function () {
    Route::view('groups', 'livewire.grupos.index')->name('groups');

});


/* espanol
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::view('inscripciones', 'livewire.inscripciones.index')->middleware('auth');
    Route::view('torneos', 'livewire.torneos.index')->middleware('auth','can:modulo-torneos');
    Route::view('jornadas', 'livewire.jornadas.index')->middleware('auth', 'can:modulo-jornadas');
    Route::view('jugadores', 'livewire.jugadores.index')->middleware('auth', 'can:modulo-jugadores');
    Route::view('resultados', 'livewire.resultados.index')->middleware('auth', 'can:modulo-resultados');
    Route::view('partidos', 'livewire.partidos.index')->middleware('auth', 'can:modulo-partidos');
    Route::view('equipos', 'livewire.equipos.index')->middleware('auth', 'can:modulo-equipos');
    Route::view('perfil', 'livewire.perfils.index')->middleware('auth', 'can:modulo-perfil');
    Route::view('posiciones', 'livewire.posiciones.index')->middleware('auth');




});*/
/*Rutas accesibles por cualquier usuario autenticado (sin importar rol)
Route::middleware(['auth'])->group(function () {
    Route::view('resultados', 'livewire.resultados.index')->middleware('can:modulo-resultados');
    Route::view('reglamento', 'livewire.reglamento.index')->middleware('auth');
    Route::view('password', 'livewire.cambiarpassword.index');
    Route::view('suscripciones', 'livewire.suscripciones.index')->middleware('auth');
    Route::view('posiciones', 'livewire.posiciones.index')->middleware('auth');
    Route::view('allpronosticos', 'livewire.allpronosticos.index')->middleware('auth');
    Route::view('pronosticos', 'livewire.pronosticos.index')->middleware('auth', 'can:modulo-pronosticos');


});*/

Route::post('/change-language', function (Request $request) {
    $locale = $request->input('locale');
    session(['locale' => $locale]);
    return back();
})->name('change.language');

Route::post('/change-country', function () {

    request()->validate([
        'country_code' => 'required|in:CO,ES,FR,US'
    ]);

    session([
        'country_code' => request('country_code')
    ]);

    return back();

})->name('change.country');