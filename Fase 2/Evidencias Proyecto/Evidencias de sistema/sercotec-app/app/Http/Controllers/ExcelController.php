<?php

namespace App\Http\Controllers;

use App\Imports\EmpresaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Validators\ValidationException;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ], [
                'file.required' => 'Debe seleccionar un archivo',
                'file.mimes' => 'El archivo debe ser de tipo Excel (xlsx o xls)'
            ]);

            Session::put('import_progress', 0);

            Excel::import(new EmpresaImport, $request->file('file'));

            return response()->json([
                'status' => 'success',
                'message' => 'Importación completada exitosamente',
                'insertedRows' => Session::get('import_progress', 0)
            ]);

        } catch (SheetNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró la segunda hoja en el archivo Excel. Asegúrese de que el archivo tenga al menos dos hojas.'
            ], 422);
        } catch (ValidationException $e) {
            $failures = collect($e->failures())
                ->map(function ($failure) {
                    return "Error en la fila {$failure->row()}: " . implode(', ', $failure->errors());
                })
                ->take(5) // Mostrar solo los primeros 5 errores
                ->join("\n");

            return response()->json([
                'status' => 'error',
                'message' => 'Se encontraron errores en los datos:',
                'errors' => $failures
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProgress()
    {
        return response()->json([
            'insertedRows' => Session::get('import_progress', 0)
        ]);
    }
}