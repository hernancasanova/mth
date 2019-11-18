<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use App\Archivo;
use DB;
use Uuid;
use SSH;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;*/
use App\Custom\Adjuntos;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        /*$tiposarchivos=DB::table('archivos')
        ->select('archivos.tipo')
        ->get();
        return response([
            'tiposarchivos'        => $tiposarchivos,
            'status_code' => 200,
        ], 200);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->file(Adjuntos::view($id));
        //if($id==54){return response()->file(Adjuntos::view($id));}
        //else{return response()->file(Adjuntos::download($id));}
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
    public function descargar($id)
    {
        return response()->file(Adjuntos::download($id));
    }


    
    /*static function hashAdjunto(){
        return rand(0,255)."/".rand(0,255);
    }
    static function getAdjunto($adjunto_id){
        return Adjunto::select("adj_ruta","adj_nombrereal","adj_nombreoriginal")->find($adjunto_id);
    }
    static function download($adjunto_id){
        $adjunto = Adjuntos::getAdjunto($adjunto_id);
        header("Content-disposition: attachment; filename=$adjunto->adj_nombreoriginal");
        header("Content-type: MIME");
        readfile($adjunto->adj_ruta."/".$adjunto->adj_nombrereal);
    }
    static function update($adjunto_id){
        
    }
    static function delete($adjunto_id){
        Adjunto::where("id", $adjunto_id)->delete();
    }
    static function create($request, $actividad_id = NULL, $actualizacion_id = NULL, $pago_id = NULL, $tipo_adjunto = NULL){
        $ruta_adjuntos = Config::get('constans.RUTA_ADJUNTOS');
        $adjuntos = [];
        if(!empty($pago_id)){ // Adjunto pertenecinte a Pago (Bouchers)
            $file = $request->file('archivo');
            $tmp_name = Uuid::generate()->string;
            $path_hash = Adjuntos::hashAdjunto();
            $file_ext = $file->getClientOriginalExtension();
            if(!is_dir($ruta_adjuntos.$path_hash)) {
                mkdir($ruta_adjuntos.$path_hash, 0777, true);
                chmod($ruta_adjuntos.$path_hash, 0777);
            }
            $file->move($ruta_adjuntos.$path_hash,  $tmp_name.".".$file_ext);
            chmod($ruta_adjuntos.$path_hash."/".$tmp_name.".".$file_ext, 0777);
            $descripcion = request()->has('descripcionAdjunto')?request()->get('descripcionAdjunto'):'';
            $adjunto_id = Adjunto::insertGetId([
                'adj_nombrereal' => $tmp_name.".".$file_ext,
                'adj_ruta' => $ruta_adjuntos.$path_hash,
                'pago_id' => $pago_id,
                'boucher' => $request->numero_boucher,
                'tipoadjunto_id' => $tipo_adjunto,
                'adj_nombreoriginal' => $file->getClientOriginalName(),
                'descripcion' => $descripcion,
                'created' => 'NOW()',
                'modified' => 'NOW()'
            ]);
            $adjuntos = $adjunto_id;            
        }
        else{ // Adjunto perteneciente a actividades
            foreach($request->files as $array) {
                foreach($array as $file){
                    $tmp_name = Uuid::generate()->string;
                    $path_hash = Adjuntos::hashAdjunto();
                    $file_ext = $file->getClientOriginalExtension();
                    if(!is_dir($ruta_adjuntos.$path_hash)) {
                        mkdir($ruta_adjuntos.$path_hash, 0777, true);
                        chmod($ruta_adjuntos.$path_hash, 0777);
                    }
                    $file->move($ruta_adjuntos.$path_hash,  $tmp_name.".".$file_ext);
                    chmod($ruta_adjuntos.$path_hash."/".$tmp_name.".".$file_ext, 0777);
                    $adjunto_id = Adjunto::insertGetId([
                        'adj_nombrereal' => $tmp_name.".".$file_ext,
                        'adj_ruta' => $ruta_adjuntos.$path_hash,
                        'actividad_id' => $actividad_id,
                        'adj_nombreoriginal' => $file->getClientOriginalName(),
                        'actualizacion_id' => $actualizacion_id,
                        'created' => 'NOW()',
                        'modified' => 'NOW()'
                    ]);
                    $adjuntos[] = $adjunto_id;
                }
            }
        }
        return $adjuntos;
    }

    static function create_documento($request, $documento_id = NULL){
        //$ruta_adjuntos = '/var/adjuntos/web/0/0/web/';
        $ruta_adjuntos = Config::get('constans.RUTA_ADJUNTOS');
        $adjuntos = [];
        foreach($request->files as $file) {
            //foreach($array as $file){
                $tmp_name = Uuid::generate()->string;
                $path_hash = Adjuntos::hashAdjunto();
                $file_ext = $file->getClientOriginalExtension();
                if(!is_dir($ruta_adjuntos.$path_hash)) {
                    mkdir($ruta_adjuntos.$path_hash, 0777, true);
                    chmod($ruta_adjuntos.$path_hash, 0777);
                }
                $file->move($ruta_adjuntos.$path_hash,  $tmp_name.".".$file_ext);
                chmod($ruta_adjuntos.$path_hash."/".$tmp_name.".".$file_ext, 0777);
                $descripcion = request()->has('descripcionAdjunto')?request()->get('descripcionAdjunto'):'';
                $adjunto_id = Adjunto::insertGetId([
                    'adj_nombrereal' => $tmp_name.".".$file_ext,
                    'adj_ruta' => $ruta_adjuntos.$path_hash,
                    'documento_id' => $documento_id,
                    'user_id' => Auth::user()->id,
                    'adj_nombreoriginal' => $file->getClientOriginalName(),
                    'descripcion' => $descripcion,
                    'created' => 'NOW()',
                    'modified' => 'NOW()'
                ]);
                $adjuntos[] = $adjunto_id;
           // }
        }
        return $adjuntos;
    }


    static function view($adjunto_id){
        $adjunto = Adjuntos::getAdjunto($adjunto_id);
        return ($adjunto->adj_ruta."/".$adjunto->adj_nombrereal);
    }*/
}
