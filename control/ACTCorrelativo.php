<?php
/**
*@package pXP
*@file gen-ACTCorrelativo.php
*@author  (admin)
*@date 26-08-2025 21:14:57
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCorrelativo extends ACTbase{    
			
	function listarCorrelativo(){
		$this->objParam->defecto('ordenacion','id_correlativo');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCorrelativo','listarCorrelativo');
		} else{
			$this->objFunc=$this->create('MODCorrelativo');
			
			$this->res=$this->objFunc->listarCorrelativo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCorrelativo(){
		$this->objFunc=$this->create('MODCorrelativo');	
		if($this->objParam->insertar('id_correlativo')){
			$this->res=$this->objFunc->insertarCorrelativo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCorrelativo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCorrelativo(){
			$this->objFunc=$this->create('MODCorrelativo');	
		$this->res=$this->objFunc->eliminarCorrelativo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>