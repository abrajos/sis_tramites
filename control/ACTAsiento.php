<?php
/**
*@package pXP
*@file gen-ACTAsiento.php
*@author  (admin)
*@date 20-06-2026 10:56:00
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTAsiento extends ACTbase{    
			
	function listarAsiento(){
		$this->objParam->defecto('ordenacion','id_asiento');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_matricula')!=''){
            $this->objParam->addFiltro("asien.id_matricula = ".$this->objParam->getParametro('id_matricula'));    
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODAsiento','listarAsiento');
		} else{
			$this->objFunc=$this->create('MODAsiento');
			
			$this->res=$this->objFunc->listarAsiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarAsiento(){
		$this->objFunc=$this->create('MODAsiento');	
		if($this->objParam->insertar('id_asiento')){
			$this->res=$this->objFunc->insertarAsiento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarAsiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarAsiento(){
			$this->objFunc=$this->create('MODAsiento');	
		$this->res=$this->objFunc->eliminarAsiento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>