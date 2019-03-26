<?php

class NomclasificacionriesgoController extends ZendExt_Controller_Secure {

    function init() {
        parent::init();
    }

    function nomclasificacionriesgoAction() {
        $this->view->jsayuda = $this->integrator->ayuda->devolverJS();
        $this->render();
    }

    function todosnomclasificacionriesgoAction() {
        $limit = $this->_request->getPost("limit");
        $start = $this->_request->getPost("start");
        $denominacion = $this->_request->getPost("denominacion");
        $datospara = NomClasificacionRiesgo::getPorLimite($denominacion,$limit, $start);
        $cantf = NomClasificacionRiesgo::getCantListTodos();
        $arr = Array();
        if (count($datospara)) {
            $result = array('total' => $cantf, 'data' => $datospara);
            echo json_encode($result);
            return;
        }
        $nom = array('data' => $arr);
        echo json_encode($nom);
        return;
    }

    function adicionarnomclasificacionriesgoAction() {
        try {
            $objClasificacionRiesgo = new NomClasificacionRiesgo();
            $val = NomClasificacionRiesgo::verifExist($this->_request->getPost('denominacion'));
            if (!$val) {
                $objClasificacionRiesgo->denominacion = $this->_request->getPost('denominacion');
                $objClasificacionRiesgo->descripcion = $this->_request->getPost('descripcion');
                if ($this->_request->getPost('fechainicio')) {
                    $fecha = split('/', $this->_request->getPost('fechainicio'));
                    $objClasificacionRiesgo->fecha_inicio = $fecha[2] . $fecha[1] . $fecha[0];
                }
                if ($this->_request->getPost('fechafin')) {
                    $fecha = split('/', $this->_request->getPost('fechafin'));
                    $objClasificacionRiesgo->fecha_fin = $fecha[2] . $fecha[1] . $fecha[0];
                }
                $model = new NomClasificacionRiesgoModel();
                $a = $model->Insertar($objClasificacionRiesgo);
                if (is_numeric($a))
                    ;
                echo('{"codMsg":1,"mensaje": "La clasificaci&oacute;n  se adicionado satisfactoriamente."}');
            }
            else
                echo( '{"codMsg":3,"mensaje": "La clasificaci&oacute;n que quiere adicionar ya existe."}');
        } catch (Doctrine_Exception $e) {
            throw $e;
        }
    }

    function modificarnomclasificacionriesgoAction() {
        $val = NomClasificacionRiesgo::existe($this->_request->getPost('idtipoclasificacionriesgo'), $this->_request->getPost('denominacion'));
        if (!$val) {
            $obj = Doctrine::getTable('NomClasificacionRiesgo')->find($this->_request->getPost('idtipoclasificacionriesgo'));
            $obj->idtipoclasificacionriesgo = $this->_request->getPost('idtipoclasificacionriesgo');
            $obj->denominacion = $this->_request->getPost('denominacion');
            $obj->descripcion = $this->_request->getPost('descripcion');
            if ($this->_request->getPost('fechainicio')) {
                $fecha = split('/', $this->_request->getPost('fechainicio'));
                $obj->fecha_inicio = $fecha[2] . $fecha[1] . $fecha[0];
            }
            if ($this->_request->getPost('fechafin')) {
                $fecha = split('/', $this->_request->getPost('fechafin'));
                $obj->fecha_fin = $fecha[2] . $fecha[1] . $fecha[0];
            } else {
                $obj->fecha_fin = null;
            }
            //print_r($obj);die;
            $model = new NomClasificacionRiesgoModel();
            $model->Actualizar($obj);
            echo( '{"codMsg":1,"mensaje": "La clasificaci&oacute;n ha sido modificada satisfactoriamente."}');
        }
        else
            echo( '{"codMsg":3,"mensaje": "Ya existe una clasificaci&oacute;n con esa denominaci&oacute;n."}');
    }

    function eliminarnomclasificacionriesgoAction() {
        $objModel = new NomClasificacionRiesgoModel();
        $id = $this->_request->getPost('idtipoclasificacionriesgo');
        if (empty($id)) {
            $m->codMes = 3;
            $m->mensaje = "No ahy valor";
            echo json_encode($m);
        } else {
            $objModel->Eliminar($this->_request->getPost('idtipoclasificacionriesgo'));
            $m->codMsg = 1;
            $m->mensaje = "La clasificaci&oacute;n  ha sido eliminada satisfactoriamente.";
            echo json_encode($m);
        }
    }

}

?>