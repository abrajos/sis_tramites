<?php
/**
*@package pXP
*@file gen-ACTTramiteDetalle.php
*@author  (admin)
*@date 26-03-2025 01:17:21
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTramiteDetalle extends ACTbase{    
			
	function listarTramiteDetalle(){
		$this->objParam->defecto('ordenacion','id_tramite_detalle');

		$this->objParam->defecto('dir_ordenacion','asc');

		if($this->objParam->getParametro('id_tramite')!=''){
			$this->objParam->addFiltro("tradet.id_tramite = ".$this->objParam->getParametro('id_tramite'));	
		}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramiteDetalle','listarTramiteDetalle');
		} else{
			$this->objFunc=$this->create('MODTramiteDetalle');
			
			$this->res=$this->objFunc->listarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTramiteDetalle(){
		$this->objFunc=$this->create('MODTramiteDetalle');	
		if($this->objParam->insertar('id_tramite_detalle')){
			$this->res=$this->objFunc->insertarTramiteDetalle($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTramiteDetalle(){
			$this->objFunc=$this->create('MODTramiteDetalle');	
		$this->res=$this->objFunc->eliminarTramiteDetalle($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function derivarTramiteDetalle()
    {
        //crea el objetoFunSeguridad que contiene todos los metodos del sistema de seguridad
        $this->objFunSeguridad = $this->create('MODTramiteDetalle');
        $this->res = $this->objFunSeguridad->derivarTramiteDetalle($this->objParam);
        //imprime respuesta en formato JSON
        $this->res->imprimirRespuesta($this->res->generarJson());

    }


	function listarOtTramite(){
		$this->objParam->defecto('ordenacion','id_tramite_detalle');

		$this->objParam->defecto('dir_ordenacion','asc');

	//	if($this->objParam->getParametro('estado_tramite')!=''){
			$this->objParam->addFiltro("tradet.estado_tramite = "."'' OT''");	
		//}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramiteDetalle','listarOtTramite');
		} else{
			$this->objFunc=$this->create('MODTramiteDetalle');
			
			$this->res=$this->objFunc->listarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarTopografo(){
		$this->objParam->defecto('ordenacion','id_tramite_detalle');

		$this->objParam->defecto('dir_ordenacion','asc');

	//	if($this->objParam->getParametro('estado_tramite')!=''){
			$this->objParam->addFiltro("tradet.estado_tramite = "."''TOPOGRAFO''");	
		//}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramiteDetalle','listarTramiteDetalle');
		} else{
			$this->objFunc=$this->create('MODTramiteDetalle');
			
			$this->res=$this->objFunc->listarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}	
	
	function listarArquitecto(){
		$this->objParam->defecto('ordenacion','id_tramite_detalle');

		$this->objParam->defecto('dir_ordenacion','asc');

	//	if($this->objParam->getParametro('estado_tramite')!=''){
			$this->objParam->addFiltro("tradet.estado_tramite = "."''ARQUITECTO''");	
		//}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramiteDetalle','listarTramiteDetalle');
		} else{
			$this->objFunc=$this->create('MODTramiteDetalle');
			
			$this->res=$this->objFunc->listarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarAbogado(){
		$this->objParam->defecto('ordenacion','id_tramite_detalle');

		$this->objParam->defecto('dir_ordenacion','asc');

	//	if($this->objParam->getParametro('estado_tramite')!=''){
			$this->objParam->addFiltro("tradet.estado_tramite = "."''ABOGADO''");	
		//}

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramiteDetalle','listarTramiteDetalle');
		} else{
			$this->objFunc=$this->create('MODTramiteDetalle');
			
			$this->res=$this->objFunc->listarTramiteDetalle($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
}

?>