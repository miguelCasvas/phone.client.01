<?php
namespace App\Http\PeticionesAPI;


class PeticionesSeguras extends Cliente
{
    use TokenDeAcceso;

    private function inclusionToken($token = null)
    {
        # Cabecera default para generar peticiones a rutas protegidas
        return
            $this->generaToken(\Auth::user()->token);

    }

    public function peticionPOST($url, $form, $params = [], $cabecera = null)
    {
        $cabecera = $this->inclusionToken();

        return
            parent::peticionPOST($url, $form, $params, $cabecera); // TODO: Change the autogenerated stub

    }

    public function peticionPUT($url, $form, $params = [], $cabecera = null)
    {
        $cabecera = $this->inclusionToken();

        return parent::peticionPUT($url, $form, $params, $cabecera); // TODO: Change the autogenerated stub
    }

    public function peticionGET($url, $params = [], $cabecera = null)
    {
        $cabecera = $this->inclusionToken();

        return
            parent::peticionGET($url, $params, $cabecera); // TODO: Change the autogenerated stub
    }

    public function peticionDELETE($url, $params = [], $cabecera = null)
    {
        $cabecera = $this->inclusionToken();

        return parent::peticionDELETE($url, $params, $cabecera); // TODO: Change the autogenerated stub
    }

}