<?php
/**
*@package pXP
*@file gen-ACTLote.php
*@author  (admin)
*@date 17-04-2025 00:18:04
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTLote extends ACTbase{    
			
	function listarLote(){
		$this->objParam->defecto('ordenacion','id_lote');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_tramite_detalle')!=''){
            $this->objParam->addFiltro("trami.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));    
        }
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODLote','listarLote');
		} else{
			$this->objFunc=$this->create('MODLote');
			
			$this->res=$this->objFunc->listarLote($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarLote(){
		$this->objFunc=$this->create('MODLote');	
		if($this->objParam->insertar('id_lote')){
			$this->res=$this->objFunc->insertarLote($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarLote($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarLote(){
			$this->objFunc=$this->create('MODLote');	
		$this->res=$this->objFunc->eliminarLote($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>