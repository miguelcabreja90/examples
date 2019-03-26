<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NomClasificacionRiesgo
 *
 * @author Migu3
 */
class NomClasificacionRiesgo extends BaseNomClasificacionRiesgo {

    public function setUp() {
        parent::setUp();
    }

    public function getTodos() {
        $q = new Doctrine_Query();
        $result = $q->from('NomClasificacionRiesgo')
                ->orderBy('idtipoclasificacionriesgo DESC')
                ->execute();
        return $result->toArray();
    }

    public function existe($id, $denominacion) {
        try {
            $query = new Doctrine_Query ();
            $result = $query->select('p.*')
                    ->from('NomClasificacionRiesgo p')
                    ->where("p.idtipoclasificacionriesgo=? and p.denominacion=?", array($id, $denominacion))
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
            if (count($result))
                return true;
            else
                return false;
        } catch (Doctrine_Exception $e) {
            return $e;
        }
    }

    public function getPorLimite($denominacion,$limit = 15, $start = 0) {
        $query = Doctrine_Query::create()
                ->select('dc.*')
                ->from('NomClasificacionRiesgo dc')
                ->orderBy('dc.idtipoclasificacionriesgo DESC')
                ->limit($limit)
                ->offset($start);

        if (!empty($denominacion)) {
            $query->addWhere('dc.denominacion ilike ?', "%$denominacion%");
        }
        return $query->fetchArray();
    }

    public function getCantListTodos() {
        try {
            $query = new Doctrine_Query ();
            $result = $query->select('p.*')
                            ->from('NomClasificacionRiesgo p')->count();
            return $result;
        } catch (Doctrine_Exception $e) {
            return $e;
        }
    }

    public function verifExist($denominacion) {
        try {
            $query = new Doctrine_Query ();
            $result = $query->select('p.*')
                    ->from('NomClasificacionRiesgo p')
                    ->where("denominacion=?", array($denominacion))
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
            if (count($result))
                return true;
            else
                return false;
        } catch (Doctrine_Exception $e) {
            return $e;
        }
    }

}

?>
