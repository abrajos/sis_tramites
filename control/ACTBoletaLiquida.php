<?php
/**
*@package pXP
*@file gen-ACTBoletaLiquida.php
*@author  (admin)
*@date 23-09-2025 02:24:49
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTBoletaLiquida extends ACTbase{    
			
	function listarBoletaLiquida(){
		$this->objParam->defecto('ordenacion','id_boleta_liquida');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('id_tramite_detalle')!=''){
            $this->objParam->addFiltro("tradet.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));    
        }
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODBoletaLiquida','listarBoletaLiquida');
		} else{
			$this->objFunc=$this->create('MODBoletaLiquida');
			
			$this->res=$this->objFunc->listarBoletaLiquida($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarBoletaLiquida(){
		$this->objFunc=$this->create('MODBoletaLiquida');	
		if($this->objParam->insertar('id_boleta_liquida')){
			$this->res=$this->objFunc->insertarBoletaLiquida($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarBoletaLiquida($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarBoletaLiquida(){
			$this->objFunc=$this->create('MODBoletaLiquida');	
		$this->res=$this->objFunc->eliminarBoletaLiquida($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>