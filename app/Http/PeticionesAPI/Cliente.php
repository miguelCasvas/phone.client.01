<?php

namespace App\Http\PeticionesAPI;


use GuzzleHttp\Client;
use function GuzzleHttp\default_ca_bundle;
use GuzzleHttp\Exception\ClientException;

class Cliente
{

    const TIPO_FORMULARIO = ['form_params', 'multipart'];

    private $urlApi;

    public $respuesta;

    public $exception;

    public $error;

    public function __construct()
    {
        $this->urlApi = env('API_URL');

        if ($this->urlApi == null)
            abort(500, 'url del api no definida');

    }

    /**
     * Creación y retorno de la conexion
     *
     * @return Client
     */
    private function clienteConexion()
    {
        return

            new Client([
                'base_uri' => $this->urlApi
            ]);
    }

    /**
     * Estructura basica para generar peticiones GET
     *
     * @param $url
     * @param array $params
     * @param null $cabecera
     * @return $this
     */
    public function peticionGET($url, $params = [], $cabecera = null)
    {
        try{

            $this->respuesta =
                $this->clienteConexion()
                    ->request('GET', $url, [
                        'headers'   => $cabecera,
                        'query'     => $params
                    ]);

        }catch (ClientException $e){
            $this->handlerError($e);
        }

        return $this;
    }

    /**
     * Envio de peticiones POST al API
     *
     * @param $url
     * @param array $params
     * @param $form
     * @param null $cabecera
     * @return \Illuminate\Http\RedirectResponse|mixed|\Psr\Http\Message\ResponseInterface
     */
    public function peticionPOST($url, $form, $params = [], $cabecera = null)
    {
        $tpoForm = $this->tipoFormulario(@$params['tipoFormulario']);

        try{

            $this->respuesta =
                $this->clienteConexion()
                    ->request('POST', $url, [
                        'headers'       => $cabecera,
                        'query'         => $params,
                        $tpoForm        => $form
                    ]);

        }catch (ClientException $e){
            $this->handlerError($e);
        }

        return $this;
    }

    /**
     * Respuesta  JSON de la petición
     *
     * @return mixed
     */
    public function formatoRespuesta($tpo = 'JSON')
    {

        $datosPeticion = null;

        # Si existe un error en la peticion lo retornara
        if ($this->hasError())
            return $this->exception;

        switch ($tpo){
            case '...':
                break;

            case 'JSON':
                $datosPeticion =
                    json_decode( (string) $this->respuesta->getBody() );
                break;
        }

        return $datosPeticion;
    }
    
    /**
     * valida que el tipo de formulario seleccionado este permitido
     *
     * @param string $form
     * @return string
     */
    public function tipoFormulario($form = null)
    {
        $form = $form ?: 'form_params';

        if ( in_array($form, self::TIPO_FORMULARIO) == false)
            abort(500, 'El tipo de formulario no es correcto!');

        return $form;

    }

    /**
     * Control de errores en peticion
     *
     * @param \GuzzleHttp\Exception\ClientException $e
     * @return mixed
     */
    public function handlerError(ClientException $e)
    {
        $this->error = $e;

        if ($e->hasResponse()) {
            $this->exception = (string) $e->getResponse()->getBody();
            $this->exception = json_decode($this->exception);
            $this->exception->code = (int) $e->getCode();
        } else {
            $this->exception = json_decode((string) $e->getMessage());
            $this->exception->code = 500;
        }

        return $this->exception;
    }

    /**
     * Valida si existe error en la respuesta del API
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->error instanceof ClientException;
    }
}