<?php
/**
*@package pXP
*@file gen-ACTDatoTecnico.php
*@author  (admin)
*@date 26-03-2025 01:17:12
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDatoTecnico extends ACTbase{    
			
	function listarDatoTecnico(){
		$this->objParam->defecto('ordenacion','id_dato_tecnico');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_tramite_detalle')!=''){
			$this->objParam->addFiltro("trami.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));	
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDatoTecnico','listarDatoTecnico');
		} else{
			$this->objFunc=$this->create('MODDatoTecnico');
			 
			$this->res=$this->objFunc->listarDatoTecnico($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDatoTecnico(){
		$this->objFunc=$this->create('MODDatoTecnico');	
		if($this->objParam->insertar('id_dato_tecnico')){
			$this->res=$this->objFunc->insertarDatoTecnico($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDatoTecnico($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDatoTecnico(){
			$this->objFunc=$this->create('MODDatoTecnico');	
		$this->res=$this->objFunc->eliminarDatoTecnico($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>