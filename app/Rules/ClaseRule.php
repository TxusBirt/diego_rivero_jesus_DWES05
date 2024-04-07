<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ClaseRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // obtengo valores de las propiedades
        $capacidad = request()->input('capacidad');
        $cuatroPorCuatro = request()->input('cuatro_por_cuatro');
        $electrico = request()->input('electrico');
        // Verificar las condiciones
        if ($value == 'furgoneta') {
            // Si "electrico" no es nulo, 4x4 y capacidad tienen que ser nulos
            if ($capacidad === null || $cuatroPorCuatro !== null || $electrico !== null){
                $fail("El vehiculo es una $value y sólo tiene la  propiedad capacidad disponible");
            } 
        } elseif ($value == 'turismo') {
            // Si "electrico" no es nulo, 4x4 y capacidad tienen que ser nulos
            if ($capacidad !== null || $cuatroPorCuatro !== null || $electrico === null){
                $fail("El vehiculo es un $value y sólo tiene la  propiedad electrico disponible");
            } 
        } elseif ($value == 'todoterreno') {
            // Si "electrico" no es nulo, 4x4 y capacidad tienen que ser nulos
            if ($capacidad !== null || $cuatroPorCuatro === null || $electrico !== null){
                $fail("El vehiculo es un $value y sólo tiene la  propiedad 4x4 disponible");
            } 
        }
    }
}
