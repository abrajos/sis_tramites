<?php
/**
*@package pXP
*@file gen-ACTTrmta.php
*@author  (admin)
*@date 17-04-2025 00:18:12
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTrmta extends ACTbase{    
			
	function listarTrmta(){
		$this->objParam->defecto('ordenacion','id_rmta');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_tramite_detalle')!=''){
            $this->objParam->addFiltro("trami.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));    
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTrmta','listarTrmta');
		} else{
			$this->objFunc=$this->create('MODTrmta');
			
			$this->res=$this->objFunc->listarTrmta($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTrmta(){
		$this->objFunc=$this->create('MODTrmta');	
		if($this->objParam->insertar('id_rmta')){
			$this->res=$this->objFunc->insertarTrmta($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTrmta($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTrmta(){
			$this->objFunc=$this->create('MODTrmta');	
		$this->res=$this->objFunc->eliminarTrmta($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>