<?php

namespace App\Http\Requests;

use App\Rules\Capacidad;
use App\Rules\ClaseRule;
use App\Rules\CuatroPorCuatro;
use App\Rules\Disponible;
use App\Rules\Electrico;
use App\Rules\Prestado;
use App\Rules\Revision;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class ValidarUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // valido las propiedades de las tablas para que los datos tengan consistencia e integridad
            // las validaciones basadas en rules las hago para retringir los valores de determinadas propiedades
            // en funcion de los valores de otras propiedades
            'marca'=>'alpha',
            'modelo'=>'alpha',
            'clase'=> ['in:turismo,furgoneta,todoterreno', new ClaseRule],
            'kilometros'=>'gte:0',
            'year'=>['gte:0', 'integer'],
            'disponible'=>['in:si,no', new Disponible],
            'prestado'=>['in:si,no', new Prestado],
            'fecha_inicio'=>['nullable', 'date_format:Y/m/d', 'required_if:prestado,si'],
            'fecha_fin'=>['nullable','date_format:Y/m/d','after:fecha_inicio','required_if:prestado,si'],
            'usuario_id'=>['nullable', 'unique:vehiculos', Rule::exists('usuarios', 'usuario_id'), 'required_if:prestado,si'],
            'revision'=>['nullable', 'in:si,no', new Revision],
            'cuatro_por_cuatro'=>['nullable', 'in:si,no', new CuatroPorCuatro,'required_if:clase,todoterreno'],
            'electrico'=>['nullable', 'in:si,no', new Electrico, 'required_if:clase,turismo'],
            'capacidad'=>['nullable','in:alta,media,baja', new Capacidad, 'required_if:clase,furgoneta']

        ];
    }
    public function messages(): array
    {
        return [
            // mensajes personalizados para orientra al usuario
            'marca'=> 'El campo marca se debe actualizar con caracteres alfanumericos',
            'modelo'=>'El campo modelo se debe actualizar con caracteres alfanumericos',
            'clase.in'=> 'El campo clase es obligatorio y debe ser una de las siguientes: furgoneta, turismo, todoterreno',
            'kilometros.gte'=>'Se debe introducir un numero igual o mayor que cero',
            'year.gte'=>'Se debe introducir un numero entero igual o mayor que cero',
            'disponible.in'=>'Los valores validos en "disponible" son si o no',
            'prestado.in'=>'Los valores validos en "prestado" son si o no',
            'fecha_inicio.date'=>'Introduzca una fecha valida con el formato "yyyy/mm/dd"',
            'fecha_fin.date'=>'Introduzca una fecha valida con el formato "yyyy/mm/dd"',
            'fecha_fin.after'=>'Introduzca una fecha valida que sea mayor que la fecha de inicio',
            'usuario_id.exists'=>'Debe introducir un id de usuario existente',
            'revision.in'=>'Los valores validos en "revision" son si o no',
            'cuatro_por_cuatro.in'=>'Los valores validos en "cuatro_por_cuatro" son si o no',
            'cuatro_por_cuatro.required_if'=>'Se requiere valor en "cuatro_por_cuatro" si la clase es todoterreno',
            'electrico.in'=>'Los valores validos en "electrico" son si o no',
            'electrico.required_if'=>'Se requiere valor en "electrico" si la clase es turismo',
            'capacidad.in'=>'Los valores admitidos en "capacidad" son alta, media y baja',
            'capacidad.required_if'=>'Se requiere valor si en "capacidad" la clase es furgoneta'
        ];
    }
    // Preparo la solicitud mediante una validacion previa que se envía para que cumpla con una serie de criterios 
    // de forma que haya consistencia en los datos.
    protected function prepareForValidation()
    { 
        // Si el campo "disponible" se establece como "no", establecer "prestado" como "no"
        // y los campos relativos al prestamo serán nulos (fecha_inicio, fecha_fin, usuario_id)
        if ($this->disponible == 'no') {
            $this->merge([
                // Establecer el valor predeterminado para "prestado" como "no"
                'prestado' => 'no', 
                // Establecer los valores predeterminados nulos
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'usuario_id' => null
            ]);
        }
         // Si el campo "prestado" se establece como "no", establecer  "fechas y usuarios" como nulo
        if ($this->prestado=='no') {

            $this->merge([
                // Establecer los valores predeterminados nulos
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'usuario_id' => null
            ]);
        }
        if ($this->revision=='no') {

            $this->merge([
                'fecha_inicio' => null,
                'fecha_fin' => null,
                'usuario_id' => null,
                'disponible' => 'no',
                'prestado' => 'no'
            ]);
        }
    }
}
