<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NomClasificacionRiesgoModel
 *
 * @author Migu3
 */
class NomClasificacionRiesgoModel extends ZendExt_Model {

    public function setUp() {
        parent::ZendExt_Model();
    }

    public function Insertar(NomClasificacionRiesgo $nomclasificacionriesgo) {
        $nomclasificacionriesgo->save();
        return $nomclasificacionriesgo->idtipoclasificacionriesgo;
    }

    public function Actualizar(NomClasificacionRiesgo $nomclasificacionriesgo) {
        $nomclasificacionriesgo->save();
//           $this->conn->beginTransaction();
//		try{
//			$nomclasificacionriesgo = Doctrine::getTable('NomClasificacionRiesgo')->find($object['$idtipoclasificacionriesgo']);
//			if ($nomclasificacionriesgo!=false){
//				foreach ($object as $k=>$v)
//					$nomclasificacionriesgo->$k = $v;		
//				$nomclasificacionriesgo->save();
//				$this->conn->commit();
//				return true;
//			}
//		}
//		catch (Doctrine_Exception $e){
//			$this->conn->rollback();
//			throw $e;
//		}
    }

    public function Eliminar($idtipoclasificacionriesgo) {
        try {
            $nomclasificacionriesgo = Doctrine::getTable('NomClasificacionRiesgo')->find($idtipoclasificacionriesgo);

            if ($nomclasificacionriesgo != false) {
                $nomclasificacionriesgo->delete();
                return true;
            }
        } catch (Doctrine_Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

}

?>
