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

    public function model(array $row)
    {
        set_time_limit(0);
        // Verificar que la fila no esté vacía
        if (empty($row[0])) {
            return null;
        }

        $this->rows++;
        Session::put('import_progress', $this->rows);

   

        // Verificar si el código ya existe en la base de datos
        if (Empresa::where('codigo', trim($row[0]))->exists()) {
            return null;  // No insertar si el código ya existe
        }

        return new Empresa([
            'codigo' => trim($row[0]),
            'rut' => trim($row[1]),
            'nombre' => trim($row[2]),
            'contacto' =>trim($row[3]),
            'email' => !empty($row[4]) ? trim($row[4]) : null
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
