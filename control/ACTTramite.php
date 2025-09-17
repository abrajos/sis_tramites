<?php
/**
*@package pXP
*@file gen-ACTTramite.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RFormularioTramite.php');

require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');

class ACTTramite extends ACTbase{    
			
	function listarTramite(){
		$this->objParam->defecto('ordenacion','id_tramite');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTramite','listarTramite');
		} else{
			$this->objFunc=$this->create('MODTramite');
			
			$this->res=$this->objFunc->listarTramite($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTramite(){
		$this->objFunc=$this->create('MODTramite');	
		if($this->objParam->insertar('id_tramite')){
			$this->res=$this->objFunc->insertarTramite($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTramite($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTramite(){
			$this->objFunc=$this->create('MODTramite');	
		$this->res=$this->objFunc->eliminarTramite($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function derivarTramite()
    {
        //crea el objetoFunSeguridad que contiene todos los metodos del sistema de seguridad
        $this->objFunSeguridad = $this->create('MODTramite');
        $this->res = $this->objFunSeguridad->derivarTramite($this->objParam);
        //imprime respuesta en formato JSON
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

	function formularioSolicitud(){
		
		$idtramite = $this->objParam->getParametro('id_tramite');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("trami.id_tramite = ".$this->objParam->getParametro('id_tramite'));
        $this->objParam->addParametroConsulta('ordenacion', 'trami.id_tramite');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 1);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultlistarDatosFormulario = $this->objFunc->listarDatosFormulario($this->objParam);
        
        if($resultlistarDatosFormulario->getTipo()=='ERROR'){
          $resultlistarDatosFormulario->imprimirRespuesta($resultlistarDatosFormulario-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultlistarDatosFormulario->getDatos();
		//var_dump($resultData[0]['desc_funcionario1']);exit;
        $cite_tramite = $resultData[0]['cite_tramite'];
		$nombre_tramite = $resultData[0]['nombre_tramite'];
		$ubicacion = $resultData[0]['ubicacion'];
		$fojas = $resultData[0]['fojas'];
		$cuenta = $resultData[0]['cuenta'];
		$mes = $resultData[0]['mes'];
		$dia = $resultData[0]['dia'];
		$anio = $resultData[0]['anio'];
		$hora = $resultData[0]['hora'];
		$minuto = $resultData[0]['minuto'];
		$celular1 = $resultData[0]['celular1'];
		$correo = $resultData[0]['correo'];
		$observacion = $resultData[0]['observacion'];
		
		$this->objFunc = $this->create('MODReporte');
		$resultListarPersonas = $this->objFunc->listarFormularioPersonas($this->objParam);
        
        if($resultListarPersonas->getTipo()=='ERROR'){
          $resultListarPersonas->imprimirRespuesta($resultListarPersonas-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		
		$mainDataSet = $resultListarPersonas->getDatos();
		//$resultData2 = $resultlistarVacacion->getDatos();
		//$mainDataSet[] = array("listaDetalle" => $resultlistarVacacion, );
		//var_dump($mainDataSet);exit;
		$dataSource->putParameter('cite_tramite', $cite_tramite);
		$dataSource->putParameter('nombre_tramite', $nombre_tramite);
		$dataSource->putParameter('ubicacion', $ubicacion);
		$dataSource->putParameter('fojas', $fojas);
		$dataSource->putParameter('cuenta', $cuenta);
		$dataSource->putParameter('mes', $mes);
		$dataSource->putParameter('dia', $dia);
		$dataSource->putParameter('anio', $anio);
		$dataSource->putParameter('hora', $hora);
		$dataSource->putParameter('minuto', $minuto);
		$dataSource->putParameter('celular1', $celular1);
		$dataSource->putParameter('correo', $correo);
		$dataSource->putParameter('observacion', $observacion);
		
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RFormularioTramite();
        
        $reporte->setDataSource($dataSource); 
        //$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf';
		$nombreArchivo = 'RFormularioTramite.pdf';
        $reportWriter = new ReportWriter($reporte, dirname(__FILE__) . '/../../reportes_generados/' . $nombreArchivo);
        $reportWriter->writeReport(ReportWriter::PDF);

        $mensajeExito = new Mensaje();
        $mensajeExito->setMensaje('EXITO', 'Reporte.php', 'Reporte generado', 'Se generó con éxito el reporte: ' . $nombreArchivo, 'control');
        $mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->res = $mensajeExito;
        $this->res->imprimirRespuesta($this->res->generarJson());
		
		/*$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf'; 				
		//$dataSource = $this->recuperarCodigoQR();
		$dataSource = $this->solicitarVacacion();		
		$orientacion = 'L';
		$titulo = 'Solicitud Vacacion';				
		$width = 200;  
		$height = 150;
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',array($width, $height));		
		$this->objParam->addParametro('titulo_archivo',$titulo);        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		
		$clsRep = $dataSource->getDatos();
		//var_dump($clsRep);
		eval('$reporte = new '.$clsRep['v_clase_reporte'].'($this->objParam);');
		$reporte->datosHeader('unico', $dataSource->getDatos());
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');  		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());*/
	}
	
}

?>