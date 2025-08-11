<?php
/**
*@package pXP
*@file gen-ACTTipoTramite.php
*@author  (admin)
*@date 26-03-2025 01:17:15
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoTramite extends ACTbase{    
			
	function listarTipoTramite(){
		$this->objParam->defecto('ordenacion','id_tipo_tramite');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoTramite','listarTipoTramite');
		} else{
			$this->objFunc=$this->create('MODTipoTramite');
			
			$this->res=$this->objFunc->listarTipoTramite($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoTramite(){
		$this->objFunc=$this->create('MODTipoTramite');	
		if($this->objParam->insertar('id_tipo_tramite')){
			$this->res=$this->objFunc->insertarTipoTramite($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoTramite($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoTramite(){
			$this->objFunc=$this->create('MODTipoTramite');	
		$this->res=$this->objFunc->eliminarTipoTramite($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>