<?php

namespace App\Http\Controllers;
use App\Models\DTO\VehiculosDTO;
use App\Models\DTO\VehiculoDTO;
use App\Models\DTO\FurgonetaDTO;
use App\Models\DTO\TodoterrenoDTO;
use App\Models\DTO\TurismoDTO;
use App\Models\DTO\PrestadoDTO;
use App\Models\Vehiculo;
use App\Models\Furgoneta;
use App\Models\Todoterreno;
use App\Models\Turismo;
use App\Models\Usuario;
use App\Http\httpCode\ClientErrorCod;
use Illuminate\Http\Request;
use App\Http\httpCode\SuccessCod;
use App\Http\Requests\ValidarUpdate;
use App\Http\Requests\ValidarCreate;

class VehiculoController extends Controller
{
  
    // funcion para recuperar todos los registros de la BBDD
    public function getAll()
    {
        // join para acceder a todos los datos de la clase general y las especificas
        $vehiculos = Vehiculo::select('vehiculos.*',  'todoterrenos.cuatro_por_cuatro', 'furgonetas.capacidad', 'turismos.electrico')
                        ->leftjoin('todoterrenos', 'vehiculos.id', '=', 'todoterrenos.vehiculo_id')
                        ->leftjoin('turismos', 'vehiculos.id', '=', 'turismos.vehiculo_id')
                        ->leftjoin('furgonetas', 'vehiculos.id', '=', 'furgonetas.vehiculo_id')
                        ->get();
        
        // DTO para encapsular los datos
        $vehiculosDTO = [];
        // genero array con los datos de todos los vehiculos
        foreach ($vehiculos as $vehiculo) {
            $vehiculosDTO[] = new VehiculosDTO($vehiculo); 
        }
        // conviero array en json para enviar respuesta
        $vehiculosDTOjson = collect($vehiculosDTO)->toJson();
       
        return $vehiculosDTOjson;
    }
    // funcion para recuperar los registros de la BBDD por un parametro
    public function getId($id)
    {
        // Join para acceder a todos los datos que necesito para realizar las consultas
        $vehiculos = Vehiculo::select('vehiculos.*',  'todoterrenos.cuatro_por_cuatro', 'furgonetas.capacidad', 'turismos.electrico', 'usuarios.nombre', 'usuarios.departamento')
        ->leftjoin('todoterrenos', 'vehiculos.id', '=', 'todoterrenos.vehiculo_id')
        ->leftjoin('turismos', 'vehiculos.id', '=', 'turismos.vehiculo_id')
        ->leftjoin('furgonetas', 'vehiculos.id', '=', 'furgonetas.vehiculo_id')
        ->leftjoin('usuarios', 'vehiculos.usuario_id', '=', 'usuarios.usuario_id');
        // opción cuando el id es un valor numerico para acceder a un registro concreto
        if (is_numeric($id)) {
            // accedo a los datos por id
            $vehiculoPorId = $vehiculos->find($id);
            // compruebo que el registro existe
            if (!$vehiculoPorId) {
                // si no existe lo indico

                return  ClientErrorCod::notFound('El registro con id ' . $id . ' no existe');
            } else {
                // si existe encapsulo los datos en el DTO lo que me 
                // permite mostrar los datos que quiero
                $vehiculoIdDTO= new VehiculosDTO($vehiculoPorId);
                // Convierto en json para enviar respuesta
                $vehiculosIdDTOJson = json_encode($vehiculoIdDTO);
                return $vehiculosIdDTOJson;
            }
        // opcion si quiero acceder a los vehiculos que están prestados
        } elseif  ($id=='prestado') {
            // genero array que contenga los vehiculos que busco mostrar
            $vehiculosPrestadoDTO = [];
            // consulta que me genera la lista de los vehiculos a mostrar
            $vehiculosPrestados = $vehiculos->where('prestado', 'si')->get();
            // bucle para acceder a cada vehiculo para encapsular los datos que me interesa mostrar
            // de cada vehiculo
            foreach ($vehiculosPrestados as $vehiculo) {
                $vehiculosPrestadoDTO[] = new PrestadoDTO($vehiculo);  
            }
            // Convierto en json para enviar respuesta
            $vehiculosPrestadoDTOJson = json_encode($vehiculosPrestadoDTO);
            return $vehiculosPrestadoDTOJson;
        // opcion para mostrar solo los vehiculos de una clase determinada
        } elseif ($id=='furgoneta' || $id=='turismo' || $id=='todoterreno') {
            // genero array que contenga los vehiculos que busco mostrar
            $vehiculosClaseDTO = [];
            // consulta que me genera la lista de los vehiculos a mostrar
            $vehiculosPorClase = $vehiculos->where('clase', $id)->get();
            // bucle para acceder a cada vehiculo para encapsular los datos que me interesa mostrar
            // de cada vehiculo
            foreach ($vehiculosPorClase as $vehiculo) {
                $vehiculosClaseDTO[] = new VehiculosDTO($vehiculo); 
            }
            $vehiculosClaseDTOJson = json_encode($vehiculosClaseDTO);
            return $vehiculosClaseDTOJson;
        // si no coincide el parametro de url con los disponibles lanzo mensaje de error
        } else {
             return ClientErrorCod::notFound('El parametro '. $id . ' es invalido. Registros no encontrados');
        }
            
    }
    // funcion para insertar nuevos vehiculos en la BBDD
    // He generado un form request para validar los datos que introduzco
    // con una clase denominada ValidarCreate
    public function create(ValidarCreate $request)
    {
        // objengo los datos de la solicitud y los convierto 
        // para poder manejarlos con eloquent
        $datosCrear=$request->json()->all();
    
        if(isset($datosCrear['id'])) {

            return ClientErrorCod::unprocessable('El campo id se establece de forma automatica');
        }
        // encapsulo los datos que recibo para manejarlos
        $vehiculoDTO= new VehiculoDTO($datosCrear);
        // genero un registro en la tabla vehiculos
        $vehiculoNuevo = Vehiculo::create($vehiculoDTO->toArray());
        // genero un registro en la tabla correspondiente dependiendo de
        // la clase que se envíe en la solicitud
        // Utilizo los DTO que he generado de cada clase para manejar los datos
        if ($datosCrear['clase']=='furgoneta'){
            if ($datosCrear['capacidad'] !== null) {
                $furgonetaDTO = new FurgonetaDTO ($vehiculoNuevo, $datosCrear);
                Furgoneta::create($furgonetaDTO->toArray());
            }
        } elseif ($datosCrear['clase']=='todoterreno') {
            if ($datosCrear['cuatro_por_cuatro']!==null){
                $todoterrenoDTO = new TodoterrenoDTO ($vehiculoNuevo, $datosCrear);
                Todoterreno::create($todoterrenoDTO->toArray());
            } 
        } elseif ($datosCrear['clase']=='turismo') {
            if ($datosCrear['electrico']!==null){
                $turismoDTO = new TurismoDTO ($vehiculoNuevo, $datosCrear);
                Turismo::create($turismoDTO->toArray());
            } 
        } else {
            return ClientErrorCod::unprocessable('El resgistro no se ha podido crear');
        }
        return SuccessCod::ok('registros añadidos correctamente');         
    }


    public function update(ValidarUpdate $request, $id)
    {
        // obtengo los datos de la solicitud y los convierto 
        // para poder manejarlos con eloquent
        $datosActualizar=$request->json()->all();
        if(isset($datosActualizar['id'])) {

            return ClientErrorCod::unprocessable('El campo id no se puede actualizar');
        }
        // localizo y obtengo los datos del vehiculo a actualizar
        $vehiculoAct=Vehiculo::find($id);
        // actualizar registros cuando cambiamos la clase al vehículo
        if (!$vehiculoAct) {
            return ClientErrorCod::notFound('El registro con id ' . $id . ' no existe');
        }
        if(isset($datosActualizar['clase']) && ($datosActualizar['clase'] != $vehiculoAct->clase) ) {
            // Borrar el registro correspondiente de la clase antigua
            if ($vehiculoAct->clase=='todoterreno') {
                Todoterreno::find($id)->delete();
            } elseif ($vehiculoAct->clase=='turismo') {
                Turismo::find($id)->delete();
            } elseif ($vehiculoAct->clase=='furgoneta') {
                Furgoneta::find($id)->delete();
            } else {
                return ClientErrorCod::badRequest('registro sin clase asignada');
            }
            // Creo un registro con los datos de la nueva clase y el valor de su propiedad
            if($datosActualizar['clase']=='todoterreno') {
                // bucle para acceder a los datos enviados
                foreach ($datosActualizar as $key => $value) {
                    if ($key=='cuatro_por_cuatro' && $value != null) {
                        // Introduzco los valores enviados
                        $todoterreno = Todoterreno::create([
                            'vehiculo_id' => $id, 
                            'cuatro_por_cuatro' => $value
                        ]);
                    } else {
                        // los datos que no pertenecen a la tabla especifica todoterreno
                        // se introducen en la general vehiculos
                        $vehiculoAct->$key = $value;
                    }
                }
            } elseif ($datosActualizar['clase']=='furgoneta') {
                foreach ($datosActualizar as $key => $value) {
                    if ($key=='capacidad' && $value != null) {
                        $furgoneta = Furgoneta::create([
                            'vehiculo_id' => $id, 
                            'capacidad' => $value
                        ]);
                    }  else {
                        $vehiculoAct->$key = $value;
                    }
                }
            } elseif ($datosActualizar['clase']=='turismo') {
                foreach ($datosActualizar as $key => $value) {
                    if ($key=='electrico' && $value != null) {
                        $turismo = Turismo::create([
                            'vehiculo_id' => $id, 
                            'electrico' => $value
                        ]);
                    } else {
                        $vehiculoAct->$key = $value;
                    }
                }
            }
        // actualización de datos cuando la clase es la misma a la que tiene el registro
        // o no está ese dato entre los enviados
        } else {
            // Bucle para acceder a los datos enviados
            foreach ($datosActualizar as $key => $value) {
                // condicionales que actualizan los datos en las clases esepcificas
                // primero actualizo los datos de las clases especificas y 
                // luego de la general vehiculo
                if ($key=='cuatro_por_cuatro' && $value != null) {
                    $todoterreno = Todoterreno::find($id);
                    $todoterreno->cuatro_por_cuatro=$value;
                    $todoterreno->save();
                } elseif ($key=='capacidad' && $value != null) {
                    $furgoneta = Furgoneta::find($id);
                    $furgoneta->capacidad=$value;
                    $furgoneta->save();               
                } elseif ($key=='electrico' && $value != null) {
                    $turismo = Turismo::find($id);
                    $turismo->electrico=$value;
                    $turismo->save();          
                // actualización de datos si pertenecen a la tabla de vehiculos     
                } else {
                    // En caso de que se envien las clases especificas sin datos o con valor nulo
                    if ($key=='cuatro_por_cuatro') {
                        // Si se envia datos de la caracteristica especifica de la clase 
                        // a la que pertenece el vehiculo a actualizar
                        // estos no pueden ser nulos 
                        if($vehiculoAct->clase=='todoterreno') {
                            return response("El valor 4x4 no puede ser nulo en todoterrenos",419);
                        } else {
                            continue;
                        }
                    } elseif ($key=="capacidad"){
                        if($vehiculoAct->clase=='furgoneta') {
                            return response("El valor capacidad no puede ser nulo en furgonetas",419);
                        } else {
                            continue;
                        }
                    } elseif ($key=='electrico'){
                        if($vehiculoAct->clase=='turismo') {
                            return response("El valor electrico no puede ser nulo en turismo",419);
                        } else {
                            continue;
                        }
                    } else {
                        // actualizo las propiedades de la tabla vehiculos
                            $vehiculoAct->$key = $value;
                    }
                }   
                        
            }
        }
        // guardo los cambios de las propiedades actualizadas en vehiculos
        $vehiculoAct->save();
        return SuccessCod::ok('registros actualizados correctamente. Recuerde que si disponible=no la propiedad prestado, se actualizará a no automaticamente y si prestado = no las propeidades fecha inicio, fecha fin y usuario_id se actualizaran a nulo automaticamente');    
    
    }
    public function delete($id)
    {
        $vehiculoId = Vehiculo::find($id);
       
        if (!$vehiculoId) {
            return ClientErrorCod::notFound('El registro con id ' . $id . ' no existe');
        } else {
            if ($vehiculoId->clase=='furgoneta' && Furgoneta::find($id)) {
                Furgoneta::findOrFail($id)->delete();
            } elseif($vehiculoId->clase=='turismo' && Turismo::find($id)) {
                Turismo::findOrFail($id)->delete();
            } elseif($vehiculoId->clase=='todoterreno' && Todoterreno::find($id)) {
                Todoterreno::find($id)->delete();
            } 
        $vehiculoId->delete();
        return SuccessCod::ok('registro eliminado correctamente');    
        }
    }
}