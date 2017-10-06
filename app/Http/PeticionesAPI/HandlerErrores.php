<?php
/**
 * Created by PhpStorm.
 * User: Gepeto_1223
 * Date: 4/10/2017
 * Time: 10:28 AM
 */

namespace App\Http\PeticionesAPI;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\MessageBag;

class HandlerErrores
{

    public static function controlDeErrores(Cliente $cliente, $url = null)
    {

        $objHandler = new HandlerErrores();

        try{

            $erroresPeticion = json_decode(json_encode($cliente->exception->message), true);
            $url = $url ?: redirect()->back();
            switch ($cliente->exception->error){

                # Campos invalidos de formulario
                case 'Invalid form':
                        return
                            $objHandler->erroresFormularios($erroresPeticion, $url);
                    break;

                # Registro no encontrado
                case 'Id Not Found':

                default :
                        $salida = json_encode($cliente->exception);
                        throw new \Exception($salida);
                    break;
            }


        }catch(\Exception $e){
            abort(500, $e->getMessage());
        }

    }

    /**
     * Control de errores para cuando se genera una respuesta error de formulario por el API
     *
     * @param array $errores
     * @param $url
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function erroresFormularios(array $errores, $url)
    {

        $message = new MessageBag($errores);
        $redireccion = ($url instanceof RedirectResponse) ? $url : redirect($url);

        return $redireccion
            ->withInput()
            ->withErrors($message, 'default');

    }

    public function errorRegistroNoEncontrado()
    {

    }
}