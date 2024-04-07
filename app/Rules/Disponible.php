<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
// regla para que al insertar o actualizar valores en el campo disponible
// se cumplan los siguientes criterios: si se actualiza a no entonces no
// se puede prestar y los datos relativos al prestamo tienen que ser nulos
class Disponible implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
      // Obtener el valor de los otros campos
      $prestado = request()->input('prestado');
      $usuarioId = request()->input('usuario_id');
      $fecha_inicio = request()->input('fecha_inicio');
      $fecha_fin = request()->input('fecha_fin');
      // Verificar las condiciones
      if ($value === 'no') {
          // Si "disponible" es "no", entonces "prestado" debe ser "no" y los otros campos deben ser nulos
          if ($prestado !== 'no' || $usuarioId !== null || $fecha_inicio !== null || $fecha_fin !== null) {
              $fail("Si el vehículo no está disponible, el campo $attribute debe ser 'no' y los campos 'usuario_id' y 'fecha_inicio' y fecha_fin deben ser nulos.");
          }
      }
    }
}
