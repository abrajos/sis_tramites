<?php
/**
*@package pXP
*@file gen-ACTMatricula.php
*@author  (admin)
*@date 17-04-2025 00:18:08
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTMatricula extends ACTbase{    
			
	function listarMatricula(){
		$this->objParam->defecto('ordenacion','id_matricula');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_tramite')!=''){
            $this->objParam->addFiltro("trami.id_tramite = ".$this->objParam->getParametro('id_tramite'));    
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMatricula','listarMatricula');
		} else{
			$this->objFunc=$this->create('MODMatricula');
			
			$this->res=$this->objFunc->listarMatricula($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarMatricula(){
		$this->objFunc=$this->create('MODMatricula');	
		if($this->objParam->insertar('id_matricula')){
			$this->res=$this->objFunc->insertarMatricula($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMatricula($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarMatricula(){
			$this->objFunc=$this->create('MODMatricula');	
		$this->res=$this->objFunc->eliminarMatricula($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>