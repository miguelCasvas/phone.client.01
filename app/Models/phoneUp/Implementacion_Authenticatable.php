<?php
/**
 * Created by PhpStorm.
 * User: Gepeto_1223
 * Date: 15/09/2017
 * Time: 6:49 PM
 */

namespace App\Models\phoneUp;


trait Implementacion_Authenticatable
{
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'email';
    }


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        # SE DEBE ENVIAR EL ID DEL USUARIO PERO
        # PARA EFECTOS DE API SE ESTA ENVIANDO TODO EL OBJETO usuario
        # ESTE OBJETO LO RESIVE EL METODO
        # retrieveById() de la clase App\Http\AuthPhoneUp\PhoneUp_Api_Driver
        return $this;
    }


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return 'password';
    }


    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return '';
    }


    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {}


    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }
}