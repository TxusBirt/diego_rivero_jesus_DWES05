<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CuatroPorCuatro implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtener el valor de los otros campos
        $electrico = request()->input('electrico');
        $capacidad = request()->input('capacidad');
        // Verificar las condiciones
        if ($value !== null) {
            // Si "capacidad" no es nulo, 4x4 y electrico tienen que ser nulos
            if ($electrico !== null || $capacidad !== null){
                $fail("valor incorrecto en 4X4. Si es todoterreno es si o no, si no, $attribute es nulo ");
            }
        } 
    }
}
