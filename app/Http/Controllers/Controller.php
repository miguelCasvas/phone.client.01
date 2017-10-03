<?php

namespace App\Http\Controllers;

use App\Http\PeticionesAPI\Cliente;
use App\Http\PeticionesAPI\PeticionesSeguras;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \App\Http\PeticionesAPI\Cliente
     * @var \App\Http\PeticionesAPI\PeticionesSeguras
     */
    protected $clienteApi;

    public function __construct()
    {

    }

    protected function setClienteApi()
    {
        $this->clienteApi = new Cliente();
    }

    protected function setClienteApiSegura()
    {
        $this->clienteApi = new PeticionesSeguras();
    }

    /**
     * Verificar si se genera error en la consulta al API y
     * dar manejo a dicho error
     *
     * @param Cliente $response
     * @return Cliente
     */
    protected function verificarErrorAPI(\App\Http\PeticionesAPI\Cliente $response)
    {

        if ($response->hasError()){

            if ($response->exception->code == 500){
                $salida = $response->exception->error . $response->exception->message;
                abort($response->exception->code, $salida);
            }
            elseif ($response->exception->code == 400){

                dd($response, 'HOLA LA');
            }
        }

        return $response;
    }
}
