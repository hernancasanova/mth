<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actualizacion;
use App\Caso;
use App\Estado;
use App\Empresa;
use App\Usuario;
use DB;

class ActualizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$id_caso=request()->has('id_caso')?request()->get('id_caso'):null;
        $actualizaciones=DB::table('actualizaciones')
            ->leftJoin('estados','actualizaciones.estado_id','=','estados.id')
            ->leftJoin('usuarios','actualizaciones.usuario_id','=','usuarios.id')
            ->leftJoin('casos','actualizaciones.caso_id','=','casos.id')
            ->where('actualizaciones.caso_id', $id_caso)
            //->select('actualizaciones.*','estados.nombre_estado','usuarios.nombre_usuario')
            ->select('actualizaciones.*','estados.nombre_estado','usuarios.nombre_usuario')
            ->get();
        return response([
            'data'        => $actualizaciones,
            'status_code' => 200,
        ], 200);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$actualizacion = new Actualizacion();
        $actualizacion->usuario_id=$request->usuario_id;
        $actualizacion->estado_id=$request->estado_id;
        $actualizacion->caso_id=$request->caso_id;
        $actualizacion->comentario=$request->comentario;
        $actualizacion->fecha_modificacion=$request->fecha_modificacion;
        $actualizacion->save();*/
        /*$actualizacion=Actualizacion::create([
            'usuario_id' => $request['usuario_id'],
            'estado_id' => $request['estado_id'],
            'caso_id' => $request['caso_id'],
            'comentario' => $request['comentario'],
            'fecha_modificacion' => $request['fecha_modificacion'],
        ]);
        return response([
            'estado_actualizacion'=>'actualizacion realizada',
            'status_code' => 200,
        ], 200);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//id del caso
    {
        //
        //$id_caso=request()->has('id_caso')?request()->get('id_caso'):null;
        /*$archivos=DB::table('archivos')
            ->where('archivos.actualizaciones_id', $id)
            ->select('archivos.nombre_original')
            ->get();*/
        $id_archivoprincipal=2;
        $actualizaciones=DB::table('actualizaciones')
            ->leftJoin('estados','actualizaciones.estado_id','=','estados.id')
            ->leftJoin('users','actualizaciones.user_id','=','users.id')
            ->leftJoin('casos','actualizaciones.caso_id','=','casos.id')
            ->leftJoin('archivos','actualizaciones.id','=','archivos.actualizacion_id')
            ->where('actualizaciones.caso_id', $id)
            //->select('actualizaciones.*','estados.nombre_estado','usuarios.nombre_usuario')
            ->select('actualizaciones.fecha_modificacion','actualizaciones.comentario','estados.nombre_estado','users.name',DB::raw('STRING_AGG(archivos.nombre_original,\' \') as Archivos_adjuntos'))
            ->groupBy('actualizaciones.fecha_modificacion','actualizaciones.comentario','estados.nombre_estado','users.name')
            ->get();
        $archivoprinc=DB::table('archivos')
            ->leftJoin('actualizaciones','archivos.actualizacion_id','=','actualizaciones.id')
            ->where('archivos.tiposarchivo_id','=',$id_archivoprincipal)
            ->where('actualizaciones.caso_id','=',$id)
            ->select('archivos.id')
            ->first();
        //dump($archivoprinc);
        //$archivoprinc=DB::table('archivos')

        //dump($actualizaciones);
        /*$caso=DB::table('casos')
        ->leftJoin('estados','actualizaciones.estado_id','=','estados.id')
        ->leftJoin('empresas','actualizaciones.empresa_id','=','empresas.id')
        ->where('casos.id', $id)
        ->select('casos.*','empresas.nombre_empresa','estados.nombre_estado')
        ->get();*/
        return response([
            //'caso'  =>  $caso,
            'archivoprinc'=>$archivoprinc,
            'actualizaciones'  => $actualizaciones,
            'status_code' => 200,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
