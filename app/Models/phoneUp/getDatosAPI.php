<?php
/**
 * Created by PhpStorm.
 * User: Gepeto_1223
 * Date: 17/09/2017
 * Time: 12:42 AM
 */

namespace App\Models\phoneUp;


trait getDatosAPI
{
    /**
     * Retorna dato obtenido del API
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if(isset($this->datos->{$property}))
            return $this->datos->{$property};

//        $trace = debug_backtrace();
//        trigger_error(
//            'Propiedad indefinida mediante __get(): ' . $name .
//            ' en ' . $trace[0]['file'] .
//            ' en la línea ' . $trace[0]['line'],
//            E_USER_NOTICE);

        return null;
    }

}