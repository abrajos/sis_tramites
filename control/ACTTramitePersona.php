<?php
/**
*@package pXP
*@file gen-ACTTramitePersona.php
*@author  (admin)
*@date 01-04-2025 15:44:33
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTramitePersona extends ACTbase{    
			
	function listarTramitePersona(){
		$this->objParam->defecto('ordenacion','id_tramite_persona');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_tramite')!=''){
			$this->objParam->addFiltro("traper.id_tramite = ".$this->objParam->getParametro('id_tramite'));	
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramitePersona','listarTramitePersona');
		} else{
			$this->objFunc=$this->create('MODTramitePersona');
			
			$this->res=$this->objFunc->listarTramitePersona($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTramitePersona(){
		$this->objFunc=$this->create('MODTramitePersona');	
		if($this->objParam->insertar('id_tramite_persona')){
			$this->res=$this->objFunc->insertarTramitePersona($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTramitePersona($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTramitePersona(){
			$this->objFunc=$this->create('MODTramitePersona');	
		$this->res=$this->objFunc->eliminarTramitePersona($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>