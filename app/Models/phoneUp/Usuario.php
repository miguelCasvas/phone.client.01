<?php namespace App\Models\phoneUp;

use App\Http\PeticionesAPI\Cliente;
use App\Http\PeticionesAPI\TokenDeAcceso;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class Usuario implements Authenticatable
{
    use Implementacion_Authenticatable,
        TokenDeAcceso, getDatosAPI;

    public $token;
    public $datos;

    /**
     *  Validacion de credenciales para acceso a API
     *
     * @param $user
     * @param $pw
     */
    public function validaCredenciales($user, $pw)
    {
        # Credenciales del cliente
        $idCliente = env('ID_CLIENT');
        $pwCliente = env('PW_CLIENT');

        #Validar identificador y clave de cliente
        if ($idCliente == null || $pwCliente == null)
            abort(500, 'Esta pagina no se encuentra vinculada con ' . config('app.name'));

        # Campos para validar credenciales
        $formulario = [
                'grant_type' => 'password',
                'client_id' => $idCliente,
                'client_secret' => $pwCliente,
                'username' => $user,
                'password' => $pw,
                'scope' => '*'
        ];

        $this->datos =
            $this->clienteApi()->peticionPOST('/oauth/token', $formulario)->formatoRespuesta();

        $autenticacionExitosa = $this->autenticacionExitosa();

        if ($autenticacionExitosa)
            $this->obtenerInformacion($this->datos->access_token);


        return $this;
    }

    /**
     * Cargue de información del usuario
     *
     * @param $token
     */
    private function obtenerInformacion($token)
    {
        $this->token = $token;
        $cabecera = $this->generaToken($token);

        $datosTemp =
            $this->clienteApi()->peticionGET('miusuario', [], $cabecera);

        if ($datosTemp->hasError())
            abort(500, 'Error en el cargue de la informacion, vuelva a intentarlo!');

        foreach ($datosTemp->formatoRespuesta()->data as $colum => $vlr)
            $this->datos->{$colum} = $vlr;

//        dd($this->datos);
    }

    /**
     * @return Cliente
     */
    private function clienteApi()
    {
        return new Cliente();
    }

    /**
     * Valida si en la informacion que se obtiene de la consulta llega la propiedad error
     *
     * @return bool
     */
    public function autenticacionExitosa()
    {
        return isset($this->datos->error) == false;
    }
}