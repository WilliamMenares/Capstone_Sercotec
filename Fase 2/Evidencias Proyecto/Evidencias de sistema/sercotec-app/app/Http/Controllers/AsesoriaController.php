<?php

namespace App\Http\Controllers;


use App\Models\Encuesta;
use App\Models\Respuestas;



class AsesoriaController extends Controller
{
    public function index()
    {
        // Paginar con 6 registros por página
        $encuestas = Encuesta::orderBy('id', 'desc')->get();

        return view("asesorias")->with("encuestas", $encuestas);
    }

    public function getase()
    {
        // Cargar encuestas con las relaciones formulario, empresa y los ámbitos del formulario
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
