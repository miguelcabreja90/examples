<?php
/** Include PHPExcel */
class DatNominaModel extends ZendExt_Model {

    /**
     * Constructor de la clase.
     */
    public function DatNominaModel() {
        parent::ZendExt_Model();
    }

    
    
    public function exportarNomina($id, $formato = "PDF"){
		//Creando el objeto de phpexel
		$objPHPExcel = new PHPExcel();
		
		//Cambiandole la dimension a las filas 
		$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(40);
		$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(40);
		
		$letra = 1;
		$letraconvertida = "";
		foreach($arrcolumna as $x=>$camposnomina){
		$letraconvertida = chr($letra+64);
		//Concatenando 6 y 7 desde A hasta Q para escribir los campos
		$objPHPExcel->getActiveSheet()->mergeCells(''.$letraconvertida.'6:'.$letraconvertida.'7');
		$objPHPExcel->getActiveSheet()->setCellValue($letraconvertida.'6',$camposnomina['denominacion'].'');	
		//Dandole formato 'center'	
		$objPHPExcel->getActiveSheet()->getStyle($letraconvertida.'6')->getAlignment()->applyFromArray(
	 	array(
	 			'horizontal' => 'center',
	 			'vertical'   => 'center',
	 			'rotation'   => 0,
	 			'wrap'			=> TRUE
	 		)
	    );
		//Dandole borders 
		$objPHPExcel->getActiveSheet()->getStyle($letraconvertida.'6')->getBorders()->applyFromArray(
      		array(
      			'top'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	 )
        );
		$objPHPExcel->getActiveSheet()->getStyle($letraconvertida.'6')->getBorders()->applyFromArray(
      		array(
      			'right'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	 )
        );
	$objPHPExcel->getActiveSheet()->getStyle($letraconvertida.'7')->getBorders()->applyFromArray(
      		array(
      			'right'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	 )
        );
		$objPHPExcel->getActiveSheet()->getStyle($letraconvertida.'7')->getBorders()->applyFromArray(
      		array(
      			'bottom'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	 )
        );
		$letra ++;
		}
		$sum = 0;
		$numero = 8;
		$letraaux = 1;
		$contador = 0;
		$letracentro = 1;
		$montototal=0;
		$letracondicion = $letra-1;
		$arrfilassubtotales = array();
		
		$objPHPExcel->getActiveSheet()->freezePane('A8');
		foreach($arrCentros as $key => $c){
		    $letraconvertidaaux = chr($letraaux+64);
			//Concatenando para escribir el nombre de las divisiones
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$numero.':'.$letraconvertida.''.$numero.'');
		    $objPHPExcel->getActiveSheet()->setCellValue('A'.$numero.'',$c->division.'');
			//Dandole formato 'center' a las divisiones
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numero.'')->getAlignment()->applyFromArray(
	 	    array(
	 			'horizontal' => 'center',
	 			'vertical'   => 'center',
	 			'rotation'   => 0,
	 			'wrap'			=> TRUE
	 		)
	        );
			//Dandole formato 'bold' a las divisiones
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numero.'')->getFont()->applyFromArray(
	 		array(
	 			'name'		=> 'Arial',
	 			'bold'		=> TRUE,
	 			'italic'	=> FALSE,
	 			'strike'	=> FALSE,
	 			'color'		=> array(
	 				'rgb' => '000000'
				)
	 		)
	        );
			//Dandole borders
			for($q=1; $q<=$letracondicion; $q++){
			$objPHPExcel->getActiveSheet()->getStyle(chr($q+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'bottom'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	    )
            );
			$objPHPExcel->getActiveSheet()->getStyle(chr($q+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'top'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	    )
            );
			if($q == $letracondicion){
			$objPHPExcel->getActiveSheet()->getStyle(chr($q+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'right'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	     )
             );
			}
		    }
			$numero++;
			foreach($c->centros as $i => $centro){
					//Concatenando para escribir el nombre de los centros
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$numero.':'.$letraconvertida.''.$numero.'');
		            $objPHPExcel->getActiveSheet()->setCellValue('A'.$numero.'',$centro->centro.'');
					//Dandole formato 'bold' a las divisiones
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$numero.'')->getFont()->applyFromArray(
	 		        array(
	 		       	    'name'		=> 'Arial',
	 			        'bold'		=> TRUE,
	 			        'italic'	=> FALSE,
	 			        'strike'	=> FALSE,
	 			        'color'		=> array(
	 				    'rgb' => '000000'
				        )
	 		        )
	                );
			//Dandole borders		
			for($w=1; $w<=$letracondicion; $w++){
			$objPHPExcel->getActiveSheet()->getStyle(chr($w+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'bottom'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	    )
            );
			$objPHPExcel->getActiveSheet()->getStyle(chr($w+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'top'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	    )
            );
			if($w == $letracondicion){
			$objPHPExcel->getActiveSheet()->getStyle(chr($w+64).$numero.'')->getBorders()->applyFromArray(
      		array(
      			'right'     => array(
      				'style' => PHPExcel_Style_Border::BORDER_THIN,
     				'color' => array(
      					'rgb' => '000000'
      				)
      			)
      	     )
             );
			}
		    }
					
					$numero++;
					$inicioceldaspersona = $numero;
					$contpersona = 0;
				foreach($centro->personas as $j => $persona){
						$arrDatospersona = array_values($persona);
					    				
						$temp = array();
						foreach($persona as $g=> $k)
						{
						 	array_push($temp,$k);
							
						}
						$sum += $temp[(count($temp)-1)];
						for($m=1; $m<=$letracondicion; $m++){
						//Escribiendo los datos de la persona
						$objPHPExcel->getActiveSheet()->setCellValue(chr($m+64).''.$numero.'',$arrDatospersona[$m].'');
					    }
						//Dandole borders		
			            for($z=1; $z<=$letracondicion; $z++){
			              $objPHPExcel->getActiveSheet()->getStyle(chr($z+64).$numero.'')->getBorders()->applyFromArray(
      		              array(
      		                    	'bottom'     => array(
      		 		                'style' => PHPExcel_Style_Border::BORDER_THIN,
     			                 	'color' => array(
      				              	'rgb' => '000000'
      			                                 	) 
      			                                         )
      	                       )
                          );
			              $objPHPExcel->getActiveSheet()->getStyle(chr($z+64).$numero.'')->getBorders()->applyFromArray(
      		              array(
      			                    'right'     => array(
      				                'style' => PHPExcel_Style_Border::BORDER_THIN,
     				                'color' => array(
      				              	'rgb' => '000000'
      				                                 )
      			                                        )
      	                        )
                          );
			            }
					    $numero++;
						$contpersona++;
					}
					$numerocelda = $inicioceldaspersona + $contpersona;
					$numeroceldaparasuma = $numerocelda - 1;
					
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$numerocelda.':C'.$numerocelda.'');
		            $objPHPExcel->getActiveSheet()->setCellValue('A'.$numerocelda.'','Sub Total');
					//Dandole formato 'bold' a la palabra "Sub Total"
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$numerocelda)->getFont()->applyFromArray(
	 		        array(
	 			    //'name'		=> 'Arial',
	 			    'bold'		=> TRUE,
	 			    'italic'	=> FALSE,
	 			    'strike'	=> FALSE,
	 			    'color'		=> array(
	 				'rgb' => '000000'
			          	)
	 		          )
	                );
					//Dandole formato 'center' a la palabra "Sub Total"		
	             	$objPHPExcel->getActiveSheet()->getStyle('A'.$numerocelda)->getAlignment()->applyFromArray(
	 	            array(
	 			    'horizontal' => 'center',
	 			    'vertical'   => center,
	 			    'rotation'   => 0,
	 			    'wrap'			=> TRUE
	 		          )
	                );
					//Dandole borders		
			        for($g=1; $g<=$letracondicion; $g++){
			              $objPHPExcel->getActiveSheet()->getStyle(chr($g+64).$numero.'')->getBorders()->applyFromArray(
      		              array(
      			                    'right'     => array(
      				                'style' => PHPExcel_Style_Border::BORDER_THIN,
     				                'color' => array(
      				              	'rgb' => '000000'
      				                                 )
      			                                        )
      	                        )
                          );
						  $objPHPExcel->getActiveSheet()->getStyle(chr($g+64).$numero.'')->getFont()->applyFromArray(
	 		        array(
	 			    //'name'		=> 'Arial',
	 			    'bold'		=> TRUE,
	 			    'italic'	=> FALSE,
	 			    'strike'	=> FALSE,
	 			    'color'		=> array(
	 				'rgb' => '000000'
			          	)
	 		          )
	                );
			        }
					$letrad = 4;
					for($l=$letrad; $l<=$letracondicion; $l++){
			          $objPHPExcel->getActiveSheet()->setCellValue(chr($l+64).$numero.'', '=SUM('.chr($l+64).''.$inicioceldaspersona.':'.chr($l+64).''.$numeroceldaparasuma.')');    
			        }
					$arrfilassubtotales[$contador] = $numero;
					$contador++;
					$numero++;
			}
			$letraaux++;
			
		}
	   /*Aqui va el codigo para calcular el subtotal general haciendo uso de 
		*
		* @$arrfilassubtotales: Arreglo con los numeros de las filas donde se encuentran los subtotales por centros de costo
		*
	    */
	
     	
		
		//Codigo para exportar el documento Exel. Para salvar en un directorio usar la direccion en el save; echo($objWriter->save('directorio'));
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Nómina.xls" ');
        header('Cache-Control: max-age=0');
	    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		ob_end_clean();
		echo($objWriter->save('php://output'));
		$excel->disconnectWorksheets();
        unset($objPHPExcel);
		}
		
    }
    

}
