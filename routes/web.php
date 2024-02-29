<?php

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
use App\User;
use App\Role;
use App\Range;
use App\Alarm;
use App\Equivalence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

Auth::routes();

/*--------------------------------- ADMIN ------------------------------------*/

Route::group(['middleware' => ['auth','is_admin']], function(){

		Route::get('/', function(){
			return view('users.all');
		});

		Route::get('/admin/dashboard', function(){
			return view('users.all');
		});
		/*---------------- USUARIOS ------------------*/
		Route::post('usuarios/create', 'UserController@create');
		Route::name('usuarios_todos')->get('/usuarios/todos', 'UserController@index');
		Route::name('usuarios_report')->get('/usuarios/report', 'UserController@exportUsers');
		Route::name('usuarios_print')->get('/usuarios/print', 'UserController@printUsers');
		Route::name('usuarios.destroy')->get('usuarios/{id}/destroy', 'UserController@destroy');
		Route::name('usuarios.lock')->get('usuarios/{id}/lock', 'UserController@lockUser');
		Route::name('usuarios.unlock')->get('usuarios/{id}/unlock', 'UserController@unlockUser');
		Route::name('usuarios.editar')->get('usuarios/{id}/edit', 'UserController@edit');
		Route::name('usuarios.update')->put('usuarios/{id}/update', 'UserController@update');
		Route::name('usuarios.ver')->get('usuarios/{id}/ver', 'UserController@show');
		Route::get('/usuarios/nuevo', function(){
			return view('users.new');
		});
		Route::get('/usuarios/editar', function(){
			return view('users.edit');
		});
		Route::post('user/updateAvatar', 'UserController@updateAvatar');
		/*--------------- SUCURSAL ---------------*/
		Route::post('branchoffice/create', 'BranchOfficeController@create');
		Route::post('branchoffice/create_show', 'BranchOfficeController@create_show');
		Route::post('branchoffice/update', 'BranchOfficeController@update');
		Route::name('branchoffice.destroy')->get('branchoffice/{id}/destroy', 'BranchOfficeController@destroy');
		/*--------------- MEDICIONES --------------*/
		Route::name('usuarios.sucursal')->get('usuarios/{idu}/sucursal/{ids}', 'MeasurementController@index');
		Route::post('measurement/store', 'MeasurementController@store');
		Route::name('measurement/update')->put('measurement/update/{id}', 'MeasurementController@update');
		Route::name('usuarios.sucursal.nuevo')->get('usuarios/{idu}/sucursal/{ids}/{type}/nuevo', 'MeasurementController@create');
		Route::post('usuarios/sucursal/Medida/nuevo', 'MeasurementController@createMeasurementLink');
		Route::name('usuarios.sucursal.edit')->get('usuarios/{idu}/sucursal/{ids}/{type}/{idm}', 'MeasurementController@edit');
		Route::name('usuarios.sucursal.editar')->get('usuarios/{idu}/sucursal/{ids}/{type}/{idm}/{status}', 'MeasurementController@edit');
		Route::name('measurement.delete')->get('measurement/delete/{id}', 'MeasurementController@destroy');
		Route::name('usuario.sucursal.show')->get('usuario/{idu}/sucursal/{ids}/{type}/{idm}', 'MeasurementController@show');
		Route::name('files/store')->post('files/store', 'FileController@store');
		Route::name('files/delete/{id}')->get('files/delete/{id}', 'FileController@destroy');
		Route::name('usuario.tipo.listado')->get('usuario/{id}/{type}/listado','MeasurementController@grid');
		Route::name('measurement/duplicate')->get('measurement/{id}/duplicate', 'MeasurementController@duplicate');
		/*--------------- Values --------------*/
		Route::post('values/store', 'ValueController@store');
		Route::get('/{type}/mediciones/ver/{id}', 'ValueController@show');
		Route::delete('values/{id}', function($id){
			$obj = App\Value::find($id);
			$alarms = $obj->AlarmtUnion()->get();
    		foreach ($alarms as $a) {
    			App\Alarm::findOrFail($a->id)->delete();
    		}
    		$obj->delete();
			return Redirect::back();
		});
		Route::put('values/{id}','ValueController@update');
		Route::get('certificado/{idm}/{campo}', 'MeasurementController@deleteCertif');
		/*---------------- Rangos --------------*/
		Route::get('/rangos/{type}', 'RangesController@index');
		Route::put('rangos/{id}','RangesController@update');
		Route::put('rangos/criticidad/{id}','CriticalityController@update');
		Route::name('rangeTermoNew')->post('/rangos/new','RangesController@store');
		Route::name('rangos/update')->get('/rangos/update/{idrange}','RangesController@update');
		Route::name('rangos/delete')->get('/rangos/delete/{idrange}','RangesController@destroy');
		/*--------------- Rangos Values ----------*/
		Route::post('rangos/valores/new','RangeValueController@store');
		Route::put('rangos/valores/update/{id}','RangeValueController@update');
		Route::name('getTermData')->post('getTermData', 'RangesController@updateTermoAjax');
		Route::delete('rangos-valores/{id}', function($id) {
	    	$obj = App\RangeValue::find($id)->delete();
	    	return Redirect::back();
	    });
	    /*--------------- Rangos States -----------*/
	    Route::put('rangos-estados/{id}','StateController@update');
	    /*--------------- Equivalences ------------*/
	    Route::post('rangos/quivalence/new','EquivalenceController@store');
	    Route::delete('rangos-quivalence/{id}', function($id) {
	    	$obj = App\Equivalence::find($id)->delete();
	    	return Redirect::back();
	    });
	    /*--------------- Reportes ----------------*/
	    Route::post('reporte/store','ReportController@store');
	    Route::post('reporte/update','ReportController@update');
	    Route::name('reporte.delete')->get('reporte/delete/{id}', 'ReportController@destroy');
	    /*--------------- Alarmas ----------------*/
	    Route::post('alarma/store','AlarmController@store');
	    Route::post('alarma/update','AlarmController@update');
	    Route::name('alarma.delete')->get('alarma/delete/{id}', 'AlarmController@destroy');

	    /*---------------- SUCURSALES ---------------*/
		Route::get('/mediciones-srt', function(){
			return view('sucursales.srt');
		});//listo

		/*----------------- PAGOS -------------------*/
		Route::get('/pagos','PaymentController@index');
		Route::post('/pagos/new','PaymentController@store');
		Route::name('/pagos/delete')->get('/pagos/{id}/destroy', 'PaymentController@destroy');
		Route::name('/pagos/email')->get('/pagos/email/{id}', 'PaymentController@sendMail');

		/*----------------- BANNERS -----------------*/
		Route::get('/banners','BannerController@index');
		Route::post('/banners/store','BannerController@store');
		Route::post('/banners/update','BannerController@update');
		Route::name('/banners/delete')->get('banners/delete/{id}', 'BannerController@destroy');

		/*---------------- PDF ------------------*/
		Route::get('exportMedition/{idu}/{ids}/{type}/{idm}','MeasurementController@exportMedition');
		Route::get('exportMedition/{type}/{id}','ValueController@exportMedition');
		/*---------------- PRINT ----------------*/
		Route::get('printMedition/{type}/{id}','ValueController@printMedition');
		/*---------------- AJAX -----------------*/
		Route::name('gethint')->post('gethint', 'MeasurementController@patResponseAjax');
		Route::name('gethint_range')->post('gethint_range', 'MeasurementController@patResponseAjaxRange');
		/*------------------ EXCEL --------------*/
		Route::get('exportMeditionExcel/{idu}/{ids}/{type}/{idm}', 'ExcelController@exportMeasurement');
});//fin middleware


/*--------------------------------- USERS ------------------------------------*/

Route::group(['middleware' => 'auth'], function(){

	Route::get('/','DashboardController@index');
	Route::get('users/dashboard', 'DashboardController@index');
	Route::get('usuario/{id}/edit', 'UserController@edit');
	Route::name('tipo.sucursal.listado')->get('{type}/sucursal/{idm}/listado','MeasurementController@gridUser');
	Route::name('sucursal.show')->get('sucursal/{ids}/{type}/{idm}', 'MeasurementController@showUser');
	Route::get('/{type}/mediciones/ver/{id}', 'ValueController@show');
	Route::get('mediciones-srt/show', 'MeasurementController@showSrt');
	Route::get('{type}/sucursales','MeasurementController@gridUserList');
	Route::name('usuarios.sucursal')->get('usuarios/{idu}/sucursal/{ids}', 'MeasurementController@index');
	Route::post('user/updateAvatar', 'UserController@updateAvatar');
	/*--------------- Reportes ----------------*/
    Route::post('reporte/store','ReportController@store');
    Route::post('reporte/update','ReportController@update');
    Route::name('reporte.delete')->get('reporte/delete/{id}', 'ReportController@destroy');
    /*--------------- Alarmas ----------------*/
    Route::post('alarma/store','AlarmController@store');
    Route::post('alarma/update','AlarmController@update');
    Route::name('alarma.delete')->get('alarma/delete/{id}', 'AlarmController@destroy');
	/*---------------- AJAX -----------------*/
	Route::name('getdate')->post('getdate', 'DashboardController@dashboardResponseAjax');
	/*---------------- PDF ------------------*/
	Route::get('exportSRT/{ids}','MeasurementController@exportSRT');
});//fin middleware