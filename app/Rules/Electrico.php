<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Electrico implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    // Obtener el valor de los otros campos
      $capacidad = request()->input('capacidad');
      $cuatroPorCuatro = request()->input('cuatro_por_cuatro');
      // Verificar las condiciones
      if ($value !== null) {
          // Si "electrico" no es nulo, 4x4 y capacidad tienen que ser nulos
          if ($capacidad !== null || $cuatroPorCuatro !== null){
              $fail("valor incorrecto en electrico. Si es turismo es si o no, si no, $attribute es nulo ");
          }
      } 
    }
}
