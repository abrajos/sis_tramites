<?php
/**
*@package pXP
*@file gen-ACTBoleta.php
*@author  (admin)
*@date 22-04-2025 06:17:41
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTBoleta extends ACTbase{    
			
	function listarBoleta(){
		$this->objParam->defecto('ordenacion','id_boleta');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('id_tramite')!=''){
            $this->objParam->addFiltro("trami.id_tramite = ".$this->objParam->getParametro('id_tramite'));    
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODBoleta','listarBoleta');
		} else{
			$this->objFunc=$this->create('MODBoleta');
			
			$this->res=$this->objFunc->listarBoleta($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarBoleta(){
		$this->objFunc=$this->create('MODBoleta');	
		if($this->objParam->insertar('id_boleta')){
			$this->res=$this->objFunc->insertarBoleta($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarBoleta($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarBoleta(){
			$this->objFunc=$this->create('MODBoleta');	
		$this->res=$this->objFunc->eliminarBoleta($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>