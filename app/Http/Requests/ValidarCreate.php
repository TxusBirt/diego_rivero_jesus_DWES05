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
class ValidarCreate extends FormRequest
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
            // las validaciones basadas en rules las hago para retringir los valores de determinadas proiedades
            // en funcion de los valores de otras propiedades
            'marca'=> 'required',
            'modelo'=>'required',
            'clase'=> ['required','in:turismo,furgoneta,todoterreno', new ClaseRule],
            'kilometros'=>['required','gte:0'],
            'year'=>['required','gte:0', 'integer'],
            'disponible'=>['required', 'in:si,no', new Disponible],
            'prestado'=>['required', 'in:si,no', new Prestado],
            'fecha_inicio'=>['required_with:fecha_fin','nullable', 'date_format:Y/m/d','required_if:prestado,si'],
            'fecha_fin'=>['required_with:fecha_inicio','nullable','date_format:Y/m/d','after:fecha_inicio','required_if:prestado,si'],
            'usuario_id'=>['nullable', 'unique:vehiculos',Rule::exists('usuarios', 'usuario_id'),'required_if:prestado,si'],
            'revision'=>['nullable', 'in:si,no', new Revision],
            'cuatro_por_cuatro'=>['nullable', 'in:si,no', 'required_if:clase,todoterreno', new CuatroPorCuatro],
            'electrico'=>['nullable', 'in:si,no', 'required_if:clase,turismo', new Electrico],
            'capacidad'=>['nullable','in:alta,media,baja', 'required_if:clase,furgoneta', new Capacidad]

        ];
    }
    public function messages(): array
    {
        return [
           // mensajes personalizados para orientra al usuario
            'marca'=> 'El campo "marca" es obligatorio',
            'modelo'=>'El campo "modelo" es obligatorio',
            'clase.in'=> 'El campo "clase" es obligatorio y debe ser una de las siguientes: furgoneta, turismo, todoterreno',
            'kilometros.required' => 'El campo "kilometros" es obligatorio',
            'kilometros.gte'=>'En "kilometros" se debe introducir un numero igual o mayor que cero',
            'year.gte'=>'En año se debe introducir un numero entero igual o mayor que cero',
            'disponible.in'=>'"disponible" es un campo obligatorio. Los valores validos son si o no',
            'prestado.required'=>'"prestado" es un campo obligatorio. Los valores validos son si o no',
            'fecha_inicio.date'=>'Introduzca una fecha de inicio valida con el formato "yyyy/mm/dd"',
            'fecha_fin.date'=>'Introduzca una fecha valida con el formato "yyyy/mm/dd"',
            'fecha_fin.after'=>'Introduzca una fecha final valida que sea mayor que la fecha de inicio',
            'usuario_id.exists'=>'Debe introducir un id de usuario existente',
            'revision.in'=>'En "revision" los valores validos son si o no',
            'cuatro_por_cuatro.in'=>'Los valores validos en "cuatro_por_cuatro" son si o no',
            'electrico.in'=>'Los valores validos en "electrico" son si o no',
            'capacidad.in'=>'Los valores admitidos en "capacidad" son alta, media y baja'
           
        ];
    }

}
