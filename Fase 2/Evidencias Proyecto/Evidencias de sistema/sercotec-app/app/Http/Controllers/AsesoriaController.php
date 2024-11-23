<?php

namespace App\Http\Controllers;


use App\Models\Encuesta;
use App\Models\Feedback;
use App\Models\Respuestas;



class AsesoriaController extends Controller
{
    public function index()
    {
        // Paginar con 6 registros por página
        $encuestas = Encuesta::with(['formulario.ambitos.preguntas.respuestas.tipo', 'empresa'])->get();

        return view("asesorias")->with("encuestas", $encuestas);
    }

    public function getase()
    {
        $encuestas = Encuesta::with(['formulario.ambitos.preguntas.respuestas.tipo', 'empresa'])->get();

        return response()->json($encuestas);
    }








    public function destroy($id)
    {
        // Encuentra la encuesta
        $encuesta = Encuesta::findOrFail($id);

        // Encuentra todas las respuestas asociadas a la encuesta
        $respuestas = Respuestas::where('id_encuesta', $id)->get();

        // Elimina todas las respuestas
        foreach ($respuestas as $respuesta) {
            $respuesta->delete();
        }

        // Elimina la encuesta
        $encuesta->delete();

        // Redirige con mensaje de éxito
        return redirect()->route('asesorias.index')->with('success', 'Asesoria eliminada con éxito.');
    }




}
