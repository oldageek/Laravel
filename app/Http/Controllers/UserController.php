<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "Accion de pruebas de USER-CONTROLLER";
    }

    // Metodo de registro de usuario
    public function register(Request $request) {

        // Recoger los datos del usuario por post
        $json = $request -> input('json', null);
        $params = json_decode($json);  //objeto
        $params_array = json_decode($json, true); // array

        if (!empty($params) && !empty($params_array)) {
            // Limpiar datos
            $params_array = array_map('trim', $params_array);
    
            // Validar datos
            $validate = Validator::make($params_array, [
                'name'      => 'required|alpha',
                'surname'   => 'required|alpha',
                'email'     => 'required|email|unique:users',  // Comprobar si el usuario existe (unico)
                'password'  => 'required'
            ]);
    
            if ($validate -> fails()) {
                // La validacion ha fallado
                $data = array(
                    'status'    => 'error',
                    'code'      => 404,
                    'message'   => 'El usuario no se ha creado',
                    'errors'    => $validate -> errors()
                );
            } else {
                // Validacion pasada correctamente

                // Cifrar contrasena
                $pwd = hash('sha256', $params -> password);

                // Crear el usuario
                $user = new User();
                $user -> name = $params_array['name'];
                $user -> surname = $params_array['surname'];
                $user -> email = $params_array['email'];
                $user -> password = $pwd;
                $user -> role = 'ROLE_USER';

                // Guardar el usuario
                $user -> save();

                $data = array(
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'El usuario se ha creado correctamente',
                    'user' => $user 
                );
            }
        } else {
            $data = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Los datos enviados no son correctos'
            );
        }


        return response() -> json($data, $data['code']);
    }

    // Metodo de login
    public function login(Request $request){

        $jwtAuth = new \App\Helpers\JwtAuth();

        $email = 'olda@gmail.com';
        $password = 'olda';
        $pwd = hash('sha256', $password);
        
        return $jwtAuth -> signup($email, $pwd);
    }
}
