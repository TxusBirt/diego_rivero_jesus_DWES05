<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Capacidad implements ValidationRule
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
        $cuatroPorCuatro = request()->input('cuatro_por_cuatro');
        // Verificar las condiciones
        if ($value !== null) {
          // Si "capacidad" no es nulo, 4x4 y electrico tienen que ser nulos
            if ($electrico !== null || $cuatroPorCuatro !== null){
                $fail("valor incorrecto en capacidad. Si es furgoneta es baja,media o alta, si no, $attribute es nulo ");
            }
        } 

    }
}
