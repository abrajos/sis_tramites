<?php
/**
*@package pXP
*@file gen-ACTDatosLegal.php
*@author  (admin)
*@date 15-09-2025 18:37:32
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDatosLegal extends ACTbase{    
			
	function listarDatosLegal(){
		$this->objParam->defecto('ordenacion','id_datos_legal');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_tramite_detalle')!=''){
			$this->objParam->addFiltro("tradet.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));	
		}
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDatosLegal','listarDatosLegal');
		} else{
			$this->objFunc=$this->create('MODDatosLegal');
			
			$this->res=$this->objFunc->listarDatosLegal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDatosLegal(){
		$this->objFunc=$this->create('MODDatosLegal');	
		if($this->objParam->insertar('id_datos_legal')){
			$this->res=$this->objFunc->insertarDatosLegal($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDatosLegal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDatosLegal(){
			$this->objFunc=$this->create('MODDatosLegal');	
		$this->res=$this->objFunc->eliminarDatosLegal($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>