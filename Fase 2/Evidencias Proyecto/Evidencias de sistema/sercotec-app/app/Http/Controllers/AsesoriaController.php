<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\Feedback;
use App\Models\Respuestas;
use Barryvdh\DomPDF\Facade\Pdf;

class AsesoriaController extends Controller
{
    public function index()
    {
        $encuestas = Encuesta::with([
            'user',
            'empresa',
            'formulario.ambito.pregunta.respuesta.respuestasTipo'
        ])->get();

        $feedbacks = Feedback::all();

        return view("asesorias", compact('encuestas', 'feedbacks'));
    }

    public function getase()
    {
        $encuestas = Encuesta::with([
            'formulario.ambito.pregunta.respuesta.respuestasTipo',
            'empresa',
            'user'
        ])->get();

        return response()->json($encuestas);
    }







    public function destroy($id)
    {
        // Encuentra la encuesta
        $encuesta = Encuesta::findOrFail($id);

        // Encuentra todas las respuestas asociadas a la encuesta
        $respuestas = Respuestas::where('encuesta_id', $id)->get();

        // Elimina todas las respuestas
        foreach ($respuestas as $respuesta) {
            $respuesta->delete();
        }

        // Elimina la encuesta
        $encuesta->delete();

        // Redirige con mensaje de éxito
        return redirect()->route('asesorias.index')->with('success', 'Asesoria eliminada con éxito.');
    }

    public function generarPDF($id)
    {
        $encuesta = Encuesta::with([
            'formulario.ambito.pregunta.respuesta.respuestasTipo',
            'empresa',
            'user'
        ])->findOrFail($id);

        $feedbacks = Feedback::all();

        $pdf = PDF::loadView('pdf', compact('encuesta', 'feedbacks'));

        return $pdf->download('asesoria_' . $id . '.pdf');
    }
}
