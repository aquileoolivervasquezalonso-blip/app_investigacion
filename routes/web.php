<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\CuerpoAcademicoController;
use App\Http\Controllers\LineaInvestigacionController;
use App\Http\Controllers\InvestigadorController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\VinculacionController;
use App\Http\Controllers\ConvocatoriaCongresoController;
use App\Http\Controllers\RevistaCientificaController;
use App\Http\Controllers\InformeInvestigacionController;
use App\Http\Controllers\PlanTrabajoController;
use App\Http\Controllers\ConvocatoriaProdepController;
use App\Http\Controllers\AsistenciaCongresoController;
use App\Http\Controllers\UserController;

// Métodos permitidos en todos los recursos
$soloCrud = ['index', 'store', 'show', 'update', 'destroy'];

/* ----------------------- PÚBLICO ----------------------- */
Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

Route::resource('noticias', NoticiaController::class)->only($soloCrud);
Route::resource('cuerpos-academicos', CuerpoAcademicoController::class)
    ->parameters(['cuerpos-academicos' => 'cuerpoAcademico'])->only($soloCrud);
Route::resource('lineas-investigacion', LineaInvestigacionController::class)
    ->parameters(['lineas-investigacion' => 'lineaInvestigacion'])->only($soloCrud);
Route::resource('investigadores', InvestigadorController::class)
    ->parameters(['investigadores' => 'investigador'])->only($soloCrud);
Route::resource('proyectos', ProyectoController::class)->only($soloCrud);
Route::resource('publicaciones', PublicacionController::class)
    ->parameters(['publicaciones' => 'publicacion'])->only($soloCrud);
Route::resource('vinculaciones', VinculacionController::class)
    ->parameters(['vinculaciones' => 'vinculacion'])->only($soloCrud);
Route::resource('convocatorias-congresos', ConvocatoriaCongresoController::class)
    ->parameters(['convocatorias-congresos' => 'convocatoriaCongreso'])->only($soloCrud);
Route::resource('revistas-cientificas', RevistaCientificaController::class)
    ->parameters(['revistas-cientificas' => 'revistaCientifica'])->only($soloCrud);

/* ----------------------- AUTENTICACIÓN ----------------------- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ----------------------- PRIVADO (auth) ----------------------- */
Route::middleware('auth')->group(function () use ($soloCrud) {
    Route::get('/panel', [AuthController::class, 'panel'])->name('panel');

    Route::resource('informes-investigacion', InformeInvestigacionController::class)
        ->parameters(['informes-investigacion' => 'informeInvestigacion'])->only($soloCrud);
    Route::resource('planes-trabajo', PlanTrabajoController::class)
        ->parameters(['planes-trabajo' => 'planTrabajo'])->only($soloCrud);
    Route::resource('convocatorias-prodep', ConvocatoriaProdepController::class)
        ->parameters(['convocatorias-prodep' => 'convocatoriaProdep'])->only($soloCrud);
    Route::resource('asistencias-congresos', AsistenciaCongresoController::class)
        ->parameters(['asistencias-congresos' => 'asistenciaCongreso'])->only($soloCrud);
});

/* ----------------------- ADMIN (solo admin) ----------------------- */
Route::middleware(['auth', 'admin'])->group(function () use ($soloCrud) {
    Route::resource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'user'])->only($soloCrud);
});
