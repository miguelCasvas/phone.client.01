<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->setClienteApiSegura();
    }

    /**
     * Realiza la consulta al api de todos los Roles activos
     *
     * @return mixed
     */
    public function listadoRoles()
    {
        $url = 'roles';
        $request = $this->verificarErrorAPI($this->clienteApi->peticionGET($url));
        $roles = $request->formatoRespuesta();

        return $roles;
    }

    /**
     * Retorna un arreglo con el id del Rol como key
     * y el nombre del rol como value para campos Select
     *
     * @return array
     */
    public function listadoRolesSelect()
    {
        $roles = $this->listadoRoles()->data;
        $arregloRoles[] = 'Selección';

        foreach ($roles as $rol)
            $arregloRoles[$rol->id_rol] = $rol->nombre_rol;

        return $arregloRoles;
    }
}
