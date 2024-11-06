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
            1 => new SecondSheetImport() // Específicamente la segunda hoja (índice 1)
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

        // Limpiar los datos antes de insertarlos
        $telefono = !empty($row[11]) ? '+56' . substr(preg_replace('/\D/', '', $row[11]), -9) : null;

        // Verificar si el código ya existe en la base de datos
        if (Empresa::where('codigo', trim($row[0]))->exists()) {
            Log::info("El código {$row[0]} ya existe en la base de datos.");
            return null;  // No insertar si el código ya existe
        }

        return new Empresa([
            'codigo' => trim($row[0]),
            'nombre' => trim($row[1]),
            'email' => !empty($row[10]) ? trim($row[10]) : null,
            'telefono' => $telefono,
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
