<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reporteModel
 *
 * @author Ing. Miguel Antonio Cabreja Aldana
 * @versión 1.0
 */
require_once( Zend_Registry::get('config')->dir_aplication."pvd/evaluaciones/plantillas/comun/recursos/reporte/ReportWriter.php");
class reporteModel  extends ZendExt_Model {
   
    public function setUp() 
    { 
        parent::ZendExt_Model(); 
    } 
    public function generarReporte($formato,$tituloReporte,$datos){
		// print_r(Zend_Registry::get('config')->dir_aplication);die;
        if($formato=='XLS'){
            $this->getExcel($tituloReporte,$datos);
        }
    }
    private function getExcel($tituloReporte,$datos){
        $xls = new ReportWriter();    
        $xls_int = array('type'=>'int');
		$xls_date = array('type'=>'date');
		//print_r($tituloReporte);die;
        $aux=array();
        $aux=$datos['datos'];
		$header = array('C&Oacute;DIGO','DENOMINACI&Oacute;N','FECHA FIN','FECHA INICIO');       
		$xls->OpenRow();        
		foreach($header as $cod=>$val)
            $xls->NewCell($val,false,array('bold'=>true));
		$xls->CloseRow();    
		for($i=0;$i<count($aux);$i++){
			$xls->OpenRow();
			$xls->NewCell($aux[$i]['idindicadortexto'],false,$xls_int);
			$xls->NewCell($aux[$i]['denom'],true); //Auto alineado 
			$xls->NewCell($aux[$i]['fechafin'],false,$xls_date);
			$xls->NewCell($aux[$i]['fechainicio'],false,$xls_date);
			$xls->CloseRow();
		}
		$xls->GetXLS(true,$tituloReporte);
    }
}

?>
