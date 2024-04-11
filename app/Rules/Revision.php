<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
// regla para que al insertar o actualizar valores en el campo revision 
// se cumplan los siguientes criterios: si se actualiza a no entonces no
// se puede prestar ni esta disponible y los datos relativos al prestamo tienen que ser nulos
class Revision implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtener el valor de los otros campos
        $disponible = request()->input('disponible');
        $prestado = request()->input('prestado');
        $usuarioId = request()->input('usuario_id');
        $fecha_inicio = request()->input('fecha_inicio');
        $fecha_fin = request()->input('fecha_fin');
        // Verificar las condiciones
        if ($value === 'no') {
            // Si "revision" es "no", entonces "prestado" debe ser "no", disponible "no" y los otros campos deben ser nulos
            if ($disponible == 'si' || $prestado == 'si' || $usuarioId !== null || 
                $fecha_inicio !== null || $fecha_fin !== null) {
                $fail("Si el campo $attribute toma el valor 'no' los campos disponible y prestado son 'no' y los campos 'usuario_id' y 'fecha_inicio' y fecha_fin deben ser nulos.");
            }
        }
    }
}
