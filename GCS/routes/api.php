<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");*/

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

//Route::post('/login', 'UserController@login');

/*Route::middleware('auth:usuarios')->get('/usuarios', function (Request $request) {
    return $request->getTokenForRequest();
});*/
//Route::middleware('auth:api')->get('/casos', 'CasoController@index');

/*Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', function (Request $request) {
    
    //if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
	if (auth()->attempt($request->only('email', 'password'))) {
        // Authentication passed...
        $user = auth()->user();//obtiene los datos del user autenticado
        $user->api_token = Str::random(60);
        $user->save();
    	return response([
            'api_token'=>$user->api_token,
            'user'=>$user->email,
            'password'=>$user->password,
            'user_id'=>$user->id,
            'status_code' => 200,
        ], 200);
    }
    else{
    	return response([
            'status_code' => 401,

        ], 200);
    }
});

Route::middleware('auth:api')->post('logout', function (Request $request) {
    if (auth()->user()) {
        $user = auth()->user();
        $user->api_token = null; // se limpia el api token
        $user->save();
        return response([
            'status_code' => 200,
        ], 200);
    }else{
        return response([
                'status_code' => 401,
            ], 200);
    }
});

Route::middleware('auth:api')->post('cambiarContrasena', function (Request $request) {
        if (!(Hash::check($request->get('contrasenaActual'), Auth::user()->password))) {
            // The passwords not matches
            //return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            //return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
            return response([
                'error'=>'La contraseña actual no coincide con ningun registro',
                'status_code' => 422,
            ], 200);
        }
        //uncomment this if you need to validate that the new password is same as old one

        if(strcmp($request->get('contrasenaActual'), $request->get('contrasenaNueva')) == 0){
            return response([
                'error'=>'La contraseña nueva no puede coincidir con la contraseña actual',
                'status_code' => 422,
            ], 200);
            //Current password and new password are same
            //return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            //return response()->json(['errors' => ['current'=> ['New Password cannot be same as your current password']]], 422);
        }
        $validatedData = $request->validate([
            'contrasenaActual' => 'required',
            'contrasenaNueva' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('contrasenaNueva'));
        $user->save();
        return response([
                'status_code' => 200,
            ], 200);
});

Route::resource('users','UserController')->middleware('auth:api');
//Route::resource('usuarios','UsuarioController');
Route::resource('casos','CasoController')->middleware('auth:api');
//Route::resource('casos','CasoController');
//Route::resource('actualizaciones','ActualizacionController');
Route::resource('actualizaciones','ActualizacionController')->middleware('auth:api');

//Route::get('casos2', 'CasoController@buscaCasos');
Route::resource('estados','EstadoController')->middleware('auth:api');
Route::resource('empresas','EmpresaController')->middleware('auth:api');
Route::resource('empresasUser','EmpresaUserController')->middleware('auth:api');
Route::resource('archivos','ArchivoController')->middleware('auth:api');//funcion show del controlador
Route::get('archivos/{id}/descargar','ArchivoController@descargar')->middleware('auth:api');//
