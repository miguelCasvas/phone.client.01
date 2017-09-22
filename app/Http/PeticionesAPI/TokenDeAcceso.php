<?php

namespace App\Http\PeticionesAPI;

trait TokenDeAcceso
{
    /**
     * @param $token
     * @return array
     */
    public function generaToken($token)
    {

        # Cabecera default para generar peticiones a rutas protegidas
        $header =
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];

        return $header;
    }
}