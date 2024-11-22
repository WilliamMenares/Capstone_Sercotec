<?php

namespace App\Imports;

use App\Models\Empresa;
use Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class EmpresaImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new SecondSheetImport() // Específicamente la segunda hoja (índice 1)
        ];
    }
}

class SecondSheetImport implements ToModel, WithStartRow, SkipsOnError, SkipsOnFailure, WithValidation
{
    use SkipsErrors, SkipsFailures;

    private $rows = 0;

    // Empezar desde la fila 2 para saltar encabezados
    public function startRow(): int
    {
        return 2;
    }

    public function limpiarRut($rut)
    {
        // 1. Eliminar puntos, espacios y caracteres extraños excepto números y guiones
        $rut = preg_replace('/[^0-9kK-]/', '', $rut);

        // 2. Verificar si ya tiene un guion, separarlo
        if (strpos($rut, '-') !== false) {
            $partes = explode('-', $rut);
            $numeros = $partes[0]; // Parte numérica antes del guion
            $digitoVerificador = $partes[1]; // Parte después del guion
        } else {
            // Si no tiene guion, asumir que los últimos caracteres son el dígito verificador
            $numeros = substr($rut, 0, -1); // Todos los dígitos excepto el último
            $digitoVerificador = substr($rut, -1); // Último carácter
        }

        // 3. Asegurarse de que los números estén limpios y continuos
        $numeros = ltrim($numeros, '0'); // Quitar ceros iniciales si los hay

        // 4. Devolver el RUT formateado
        return $numeros . '-' . strtoupper($digitoVerificador);
    }


    public function model(array $row)
{
    set_time_limit(0);

    // Verificar que la fila no esté vacía
    if (empty($row[0]) || empty($row[1])) {
        return null;
    }

    $this->rows++;
    Session::put('import_progress', $this->rows);

    // Limpiar el RUT
    $rutLimpio = $this->limpiarRut(trim($row[1]));

    // Paso 1: Verificar si existe un registro con código "No asignado"
    $registroNoAsignado = Empresa::where('codigo', 'Sin Asignar')->first();

    if ($registroNoAsignado) {
        // Paso 2: Obtener el RUT del registro con "No asignado"
        $rutNoAsignado = $registroNoAsignado->rut;

        // Paso 3: Verificar si el RUT del registro en el archivo coincide
        if ($rutLimpio === $this->limpiarRut($rutNoAsignado)) {
            // Paso 4: Actualizar el código del registro en la base de datos
            $registroNoAsignado->update([
                'codigo' => trim($row[0]),
            ]);
            return null; // No crear un nuevo registro, ya que solo estamos actualizando
        }
    }

    // Paso 5: Crear un nuevo registro si el código no existe
    if (Empresa::where('codigo', trim($row[0]))->exists()) {
        return null;  // No insertar si el código ya existe
    }

    return new Empresa([
        'codigo' => trim($row[0]),
        'rut' => $rutLimpio,
        'nombre' => trim($row[2]),
        'contacto' => trim($row[3]),
        'email' => !empty($row[4]) ? trim($row[4]) : null,
    ]);
}



    // Reglas de validación
    public function rules(): array
    {
        return [
            // Puedes agregar otras reglas de validación aquí si es necesario
        ];
    }
}
