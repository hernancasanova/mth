<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caso;
use App\Actualizacion;
use App\Estado;
use App\Empresa;
use App\Archivo;
use DB;
use App\Custom\Adjuntos;

//use Ramsey\Uuid\Uuid;
//use Uuid;
use Illuminate\Support\Str;

class CasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        $user_id=request()->has('user_id')?request()->get('user_id'):null;
        $caso=request()->has('caso')?request()->get('caso'):null;
        $id_estado=request()->has('id_estado')?request()->get('id_estado'):null;
        $id_empresa=request()->has('id_empresa')?request()->get('id_empresa'):null;
        //$nombre_empresa=request()->has('nombre_empresa')?request()->get('nombre_empresa'):null;
        $fecha_inicio_creacion=request()->has('fecha_inicio_creacion')?request()->get('fecha_inicio_creacion'):null;
        $fecha_fin_creacion=request()->has('fecha_fin_creacion')?request()->get('fecha_fin_creacion'):null;
        $fecha_inicio_envio=request()->has('fecha_inicio_envio')?request()->get('fecha_inicio_envio'):null;
        $fecha_fin_envio=request()->has('fecha_fin_envio')?request()->get('fecha_fin_envio'):null;
        $fecha_inicio_recepcion=request()->has('fecha_inicio_recepcion')?request()->get('fecha_inicio_recepcion'):null;
        $fecha_fin_recepcion=request()->has('fecha_fin_recepcion')?request()->get('fecha_fin_recepcion'):null;
        $fecha_inicio_respuesta_final=request()->has('fecha_inicio_respuesta_final')?request()->get('fecha_inicio_respuesta_final'):null;
        $fecha_fin_respuesta_final=request()->has('fecha_fin_respuesta_final')?request()->get('fecha_fin_respuesta_final'):null;
        $empresas_id=null;
        if(is_null($id_empresa)) {
          $empresas_id=DB::table('empresa_user')
                        ->select('empresa_user.empresa_id')
                        ->where('empresa_user.user_id','=',$user_id)
                        ->get()->pluck('empresa_id')->toArray();
        }
        $casos=DB::table('casos')
            ->leftJoin('estados','casos.estado_id','=','estados.id')
            ->leftJoin('empresas','casos.empresa_id','=','empresas.id')
            ->when($caso, function ($query, $caso) {
                return $query->where('casos.nombre_caso','=',$caso);
            })
            ->when($id_estado, function ($query, $id_estado) {
                return $query->where('estados.id','=',$id_estado);
            })
            ->when($id_empresa, function ($query, $id_empresa) {
                return $query->where('empresas.id','=',$id_empresa);
            })
            ->when($fecha_inicio_creacion, function ($query, $fecha_inicio_creacion) {
                return $query->where('casos.fecha_creacion','>=',$fecha_inicio_creacion);
            })
            ->when($fecha_fin_creacion, function ($query, $fecha_fin_creacion) {
                return $query->where('casos.fecha_creacion','<=',$fecha_fin_creacion);
            })
            ->when($fecha_inicio_envio, function ($query, $fecha_inicio_envio) {
                return $query->where('casos.fecha_envio','>=',$fecha_inicio_envio);
            })
            ->when($fecha_fin_envio, function ($query, $fecha_fin_envio) {
                return $query->where('casos.fecha_envio','<=',$fecha_fin_envio);
            })
            ->when($fecha_inicio_recepcion, function ($query, $fecha_inicio_recepcion) {
                return $query->where('casos.fecha_recepcion','>=',$fecha_inicio_recepcion);
            })
            ->when($fecha_fin_recepcion, function ($query, $fecha_fin_recepcion) {
                return $query->where('casos.fecha_recepcion','<=',$fecha_fin_recepcion);
            })
            ->when($fecha_inicio_respuesta_final, function ($query, $fecha_inicio_respuesta_final) {
                return $query->where('casos.fecha_respuesta_final','>=',$fecha_inicio_respuesta_final);
            })
            ->when($fecha_fin_respuesta_final, function ($query, $fecha_fin_respuesta_final) {
                return $query->where('casos.fecha_respuesta_final','<=',$fecha_fin_respuesta_final);
            })
            ->when($empresas_id, function ($query, $empresas_id) {
                return $query->wherein('casos.empresa_id',$empresas_id);
            })
            //->wherein('casos.empresa_id',$empresas_id)
            ->select('casos.*','empresas.nombre_empresa','estados.nombre_estado',DB::raw('DATE_PART(\'day\',now()-casos.fecha_creacion) as dias'))
            ->get();
        return response([
            'casos'=> $casos,
            //'empresas_user'=>$empresas_user,
            //'nombre_empresa'=>$nombre_empresa,
            'status_code' => 200,
        ], 200);
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
        //PARA CREAR EL REGISTRO EN LA TABLA DE ACTUALIZACIONES
        $user_id= request()->has('user_id')?request()->get('user_id'):null;
        $fecha_modificacion= request()->has('fecha_modificacion')?request()->get('fecha_modificacion'):null;
        //PARA CREAR EL REGISTRO EN LA TABLA DE CASOS
        $nombre_caso = request()->has('nombre_caso')?request()->get('nombre_caso'):null;
        $fecha_creacion = request()->has('fecha_creacion')?request()->get('fecha_creacion'):null;
        $fecha_envio = request()->has('fecha_envio')?request()->get('fecha_envio'):null;
        $fecha_recepcion = request()->has('fecha_recepcion')?request()->get('fecha_recepcion'):null;
        $fecha_respuesta_final = request()->has('fecha_respuesta_final')?request()->get('fecha_respuesta_final'):null;
        $empresa_id = request()->has('empresa_id')?request()->get('empresa_id'):null;   
        $estado_id = request()->has('estado_id')?request()->get('estado_id'):null;


        //SE CREA EL CASO EN LA TABLA CASOS
        $caso_id=Caso::insertGetId(['fecha_creacion'=>$fecha_creacion,'fecha_envio'=>$fecha_envio,'fecha_recepcion'=>$fecha_recepcion,
            'fecha_respuesta_final'=>$fecha_respuesta_final,'estado_id'=>$estado_id,'empresa_id'=>$empresa_id,'nombre_caso'=>$nombre_caso,'created_at'=>'now()','updated_at'=>'now()']);

        if($caso_id){
            //SE CREA LA ACTUALIZACION
            $actualizacion_id=Actualizacion::insertGetId([
                'user_id' => $user_id,
                'estado_id' => $estado_id,
                'caso_id' => $caso_id,
                'comentario' => 'caso creado',
                'fecha_modificacion' => 'now()',
                'created_at'=>'now()',
                'updated_at'=>'now()',
            ]);
            $keys=array();
            if($actualizacion_id){
                //GUARDANDO ARCHIVO EN DIRECTORIO storage/app 
                foreach($request->files as $key=>$file) {
                       $ruta_adjuntos=storage_path('app').'/';
                       $nombre_original=$file->getClientOriginalName();
                       $tmp_name = Str::uuid()->toString();
                       $path_hash = Adjuntos::hashAdjunto();
                       //$path_hash = Archivos::hashAdjunto();
                       $file_ext = $file->getClientOriginalExtension();
                       if(!is_dir($ruta_adjuntos.$path_hash)) {
                           mkdir($ruta_adjuntos.$path_hash, 0777, true);
                           chmod($ruta_adjuntos.$path_hash, 0777);
                       }

                       $file->move($ruta_adjuntos.$path_hash,  $tmp_name.'.'.$file_ext);
                       //chmod($ruta_adjuntos.$path_hash.“/”.$nombre_original.“.”.$file_ext, 0777);
                       $tipo=explode('_',$key);
                       $archivo_id = Archivo::insertGetId([
                           'nombre_original'=>$nombre_original,
                           'nombre_fisico' => $tmp_name.'.'.$file_ext,
                           'ruta_fisica' => $ruta_adjuntos.$path_hash,
                           'actualizacion_id' => $actualizacion_id,
                           'tiposarchivo_id' => $tipo[1],
                           'created_at'=>'now()',
                           'updated_at'=>'now()',
                       ]);
                       /*if ($archivo_id) {
                           return response()->json([
                                'mensaje' => 'archivo agregado con exito',
                            ], 200);
                       }else{
                            return response()->json([
                                'mensaje' => 'archivo no se pudo guardar',
                            ], 500);
                       }*/
                }
                if(count($archivos)>0){
                    return response()->json([
                                'mensaje' => 'archivos se guardaron con exito',
                                'status_code'=>200,
                            ], 200);
                }
            }
             else{
                return response()->json([
                    'mensaje' => 'no se pudo crear la actualizacion',
                    'status_code'=>500,
                ], 200);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $caso=DB::table('casos')
            ->leftJoin('empresas','casos.empresa_id','=','empresas.id')
            ->leftJoin('estados','casos.estado_id','=','estados.id')
            ->where('casos.id','=',$id)
            ->select('casos.*','empresas.nombre_empresa','estados.nombre_estado')
            ->first();
        return response([
            'caso'=> $caso,
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
        //AQUÍ SE VERIFICA EL ESTADO DE LA ACTUALIZACION PARA PODER ACTUALIZAR LA FECHA CORRESPONDIENTE EN LA TABLA DE CASOS
        $estado_id=request()->has('estado_id')?request()->get('estado_id'):null;
        if($estado_id==1||$estado_id==3){
            $fecha='fecha_recepcion';
        }
        if($estado_id==2){
            $fecha='fecha_respuesta_final';
        }
        //ACTUALIZA EL CAMPO ESTADO_ID EN LA TABLA DE CASOS Y LA FECHA CORRESPONDIENTE SEGUN EL ESTADO
        $caso=DB::table('casos')
            ->where('id',$id)
            ->update(['estado_id' => $request->estado_id, $fecha=>'now()']);
            /*->when($estado_id==1, function ($query, $estado_id) {
                return $query->update(['estado_id' => $estado_id,
                                       'fecha_recepcion' => now(),
            ]);
            })
            ->when($estado_id==2, function ($query, $estado_id) {
                return $query->update(['estado_id' => $estado_id,
                                       'fecha_respuesta_final' => now(),
            ]);
            });*/


        //RETORNA TODOS LOS CAMPOS NECESARIOS PARA REFRESCAR EL LISTADO DE CASOS
        $casos=DB::table('casos')
            ->leftJoin('estados','casos.estado_id','=','estados.id')
            ->leftJoin('empresas','casos.empresa_id','=','empresas.id')
            ->select('casos.*','empresas.nombre_empresa','estados.nombre_estado',DB::raw('DATE_PART(\'day\',now()-casos.fecha_creacion) as dias'))
            //->select('casos.nombre_caso','casos.fecha_creacion','casos.fecha_envio','casos.fecha_recepcion','casos.fecha_respuesta_final','empresas.nombre_empresa','estados.nombre_estado',DB::raw('DATE_PART(\'day\',now()-casos.fecha_creacion) as dias'))
            ->get();

        //CREA UNA NUEVA ACTUALIZACION EN LA TABLA DE ACTUALIZACIONES
        $actualizacion_id=Actualizacion::insertGetId([
            'user_id' => $request['user_id'],
            'estado_id' => $request['estado_id'],
            'caso_id' => $request['caso_id'],
            'comentario' => $request['comentario'],
            'fecha_modificacion' => 'now()',
            'created_at'=>'now()',
            'updated_at'=>'now()',
        ]);
        if ($actualizacion_id) {
            foreach($request->files as $file) {
                   $ruta_adjuntos=storage_path('app').'/';
                   $nombre_original=$file->getClientOriginalName();
                   $tmp_name = Str::uuid()->toString();
                   $path_hash = Adjuntos::hashAdjunto();
                   $file_ext = $file->getClientOriginalExtension();
                   if(!is_dir($ruta_adjuntos.$path_hash)) {
                       mkdir($ruta_adjuntos.$path_hash, 0777, true);
                       chmod($ruta_adjuntos.$path_hash, 0777);
                   }
                   $file->move($ruta_adjuntos.$path_hash,  $tmp_name.'.'.$file_ext);
                   //chmod($ruta_adjuntos.$path_hash.“/”.$nombre_original.“.”.$file_ext, 0777);
                   //echo $actualizacion_id;
                   //$tipo=explode('_',$key);
                   $archivo_id = Archivo::insertGetId([
                       'nombre_original'=>$nombre_original,
                       'nombre_fisico' => $tmp_name.'.'.$file_ext,
                       'ruta_fisica' => $ruta_adjuntos.$path_hash,
                       'actualizacion_id' => $actualizacion_id,
                       'tiposarchivo_id' => 4,
                       'created_at'=>'now()',
                       'updated_at'=>'now()',
                   ]);          
            }
            return response()->json([
                          'casos'=>$casos,
                          'status_code'=>200,
                                ], 200);
        }
        else{
            return response()->json([
                        'status_code'=>500,
                              ], 500);
        }
        /*return response([
            'casos'        => $casos,
            'status_code' => 200,
        ], 200);*/
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
