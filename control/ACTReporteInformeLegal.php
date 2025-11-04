<?php
/**
*@package pXP
*@file gCTReporteInforme.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RInformeLegal.php');
require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');


class ACTReporteInformeLegal extends ACTbase{    
			
	

	function emitirInformeLegal(){
		
		$idtramite = $this->objParam->getParametro('id_tramite_detalle');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("tradet.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));
        $this->objParam->addParametroConsulta('ordenacion', 'tradet.id_tramite_detalle');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 10000);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultlistarCabeceraInformeLegal = $this->objFunc->listarCabeceraInformeLegal($this->objParam);
        
        if($resultlistarCabeceraInformeLegal->getTipo()=='ERROR'){
          $resultlistarCabeceraInformeLegal->imprimirRespuesta($resultlistarCabeceraInformeLegal-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultlistarCabeceraInformeLegal->getDatos();
		//var_dump($resultData[0]['desc_funcionario1']);exit;
        $num_informe = $resultData[0]['num_informe'];
		$nombrea = $resultData[0]['nombrea'];
		$cargoa = $resultData[0]['cargoa'];
		$via = $resultData[0]['via'];
		$cargovia = $resultData[0]['cargovia'];
		$de = $resultData[0]['de'];
		$cargode = $resultData[0]['cargode'];
		$mes = $resultData[0]['mes'];
		$dia = $resultData[0]['dia'];
		$anio = $resultData[0]['anio'];
		$referencia = $resultData[0]['referencia'];
		$cite_tramite = $resultData[0]['cite_tramite'];
		$id_tipo_tramite = $resultData[0]['id_tipo_tramite'];
		$id_tramite = $resultData[0]['id_tramite'];
		$observacion = $resultData[0]['observacion'];
		$conclusion = $resultData[0]['conclusion'];
		$nro_matricula = $resultData[0]['nro_matricula'];
		$superficie = $resultData[0]['superficie'];
		$asiento = $resultData[0]['asiento'];
		$fecha_asiento = $resultData[0]['fecha_asiento'];
		$nro_testimonio = $resultData[0]['nro_testimonio'];
		$fecha_testimonio = $resultData[0]['fecha_testimonio'];
		$nro_notario = $resultData[0]['nro_notario'];
		$nombre_notario = $resultData[0]['nombre_notario'];
		$nro_rmta = $resultData[0]['nro_rmta'];
		$fecha_rmta = $resultData[0]['fecha_rmta'];

		
		$distrito = $resultData[0]['distrito'];
		$zona = $resultData[0]['zona'];
		$manzana = $resultData[0]['manzana'];
		$lote = $resultData[0]['lote'];
		$aprobacion = $resultData[0]['aprobacion'];
		$area_agro = $resultData[0]['area_agro'];
		$cod_catastral = $resultData[0]['cod_catastral'];
		$ddrr_registro = $resultData[0]['ddrr_registro'];
		$kami = $resultData[0]['kami'];
		$superficie_leg = $resultData[0]['superficie_leg'];
		
		/*$this->objFunc = $this->create('MODReporte');
		$resultlistarCuerpoInformeLegal = $this->objFunc->listarCuerpoInformeLegal($this->objParam);
        
        if($resultlistarCuerpoInformeLegal->getTipo()=='ERROR'){
          $resultlistarCuerpoInformeLegal->imprimirRespuesta($resultlistarCuerpoInformeLegal-> generarMensajeJson());
          exit;
        }
		
		$resultDataCuerpoInformeLegal = $resultlistarCuerpoInformeLegal->getDatos();
		
		$distrito = $resultDataCuerpoInformeLegal[0]['distrito'];
		$zona = $resultDataCuerpoInformeLegal[0]['zona'];
		$manzana = $resultDataCuerpoInformeLegal[0]['manzana'];
		$lote = $resultDataCuerpoInformeLegal[0]['lote'];
		$aprobacion = $resultDataCuerpoInformeLegal[0]['aprobacion'];
		$area_agro = $resultDataCuerpoInformeLegal[0]['area_agro'];
		$cod_catastral = $resultDataCuerpoInformeLegal[0]['cod_catastral'];
		$ddrr_registro = $resultDataCuerpoInformeLegal[0]['ddrr_registro'];
		$kami = $resultDataCuerpoInformeLegal[0]['kami'];
*/
		$this->objFunc = $this->create('MODReporte');
		$resultListarPersonas = $this->objFunc->listarFormularioPersonasTradet($this->objParam);
        
        if($resultListarPersonas->getTipo()=='ERROR'){
          $resultListarPersonas->imprimirRespuesta($resultListarPersonas-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		
		$mainDataSet = $resultListarPersonas->getDatos();
		//var_dump($resultListarVacacion->getDatos());exit;
		
		//$mainDataSet = $resultListarInformes->getDatos();
		//$resultData2 = $resultlistarVacacion->getDatos();
		//$mainDataSet[] = array("listarCuerpoInformeLegal" => $resultlistarCuerpoInformeLegal, );
		
		//var_dump($mainDataSet);exit;
		
		$dataSource->putParameter('num_informe', $num_informe);
		$dataSource->putParameter('nombrea', $nombrea);
		$dataSource->putParameter('cargoa', $cargoa);
		$dataSource->putParameter('via', $via);
		$dataSource->putParameter('cargovia', $cargovia);
		$dataSource->putParameter('de', $de);
		$dataSource->putParameter('cargode', $cargode);
		$dataSource->putParameter('mes', $mes);
		$dataSource->putParameter('dia', $dia);
		$dataSource->putParameter('anio', $anio);
		$dataSource->putParameter('referencia', $referencia);
		
		$dataSource->putParameter('cite_tramite', $cite_tramite);
		$dataSource->putParameter('nombre_tramite', $nombre_tramite);
		$dataSource->putParameter('id_tipo_tramite', $id_tipo_tramite);
		$dataSource->putParameter('id_tramite', $id_tramite);
		$dataSource->putParameter('observacion', $observacion);
		$dataSource->putParameter('conclusion', $conclusion);
		$dataSource->putParameter('nro_matricula', $nro_matricula);
		$dataSource->putParameter('superficie', $superficie);
		$dataSource->putParameter('asiento', $asiento);
		$dataSource->putParameter('fecha_asiento', $fecha_asiento);
		$dataSource->putParameter('nro_testimonio', $nro_testimonio);
		$dataSource->putParameter('fecha_testimonio', $fecha_testimonio);
		$dataSource->putParameter('nro_notario', $nro_notario);
		$dataSource->putParameter('nombre_notario', $nombre_notario);
		$dataSource->putParameter('nro_rmta', $nro_rmta);
		$dataSource->putParameter('fecha_rmta', $fecha_rmta);

		$dataSource->putParameter('distrito', $distrito);
		$dataSource->putParameter('zona', $zona);
		$dataSource->putParameter('manzana', $manzana);
		$dataSource->putParameter('lote', $lote);
		$dataSource->putParameter('aprobacion', $aprobacion);
		$dataSource->putParameter('area_agro', $area_agro);
		$dataSource->putParameter('cod_catastral', $cod_catastral);
		$dataSource->putParameter('ddrr_registro', $ddrr_registro);
		$dataSource->putParameter('kami', $kami);
		$dataSource->putParameter('superficie_leg', $superficie_leg);

		
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RInformeLegal();
        
        $reporte->setDataSource($dataSource); 
        //$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf';
		$nombreArchivo = 'RInformeLegal.pdf';
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