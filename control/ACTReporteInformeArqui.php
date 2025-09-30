<?php
/**
*@package pXP
*@file gCTReporteInforme.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RInformeArqui.php');
require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');


class ACTReporteInformeArqui extends ACTbase{    
			
	

	function emitirInformeArqui(){
		
		$idtramite = $this->objParam->getParametro('id_tramite_detalle');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("tradet.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));
        $this->objParam->addParametroConsulta('ordenacion', 'tradet.id_tramite_detalle');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 10000);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultlistarCabeceraInformeArqui = $this->objFunc->listarCabeceraInformeArqui($this->objParam);
        
        if($resultlistarCabeceraInformeArqui->getTipo()=='ERROR'){
          $resultlistarCabeceraInformeArqui->imprimirRespuesta($resultlistarCabeceraInformeArqui-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultlistarCabeceraInformeArqui->getDatos();
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
		$nombre_tramite = $resultData[0]['nombre_tramite'];
		$id_tipo_tramite = $resultData[0]['id_tipo_tramite'];
		$id_tramite = $resultData[0]['id_tramite'];
		$observacion = $resultData[0]['observacion'];
		$conclusion = $resultData[0]['conclusion'];
				
		$this->objFunc = $this->create('MODReporte');
		$resultlistarCuerpoInformeArqui = $this->objFunc->listarCuerpoInformeArqui($this->objParam);
        
        if($resultlistarCuerpoInformeArqui->getTipo()=='ERROR'){
          $resultlistarCuerpoInformeArqui->imprimirRespuesta($resultlistarCuerpoInformeArqui-> generarMensajeJson());
          exit;
        }
		
		$resultDataCuerpoInformeArqui = $resultlistarCuerpoInformeArqui->getDatos();
		
		$id_tramite = $resultDataCuerpoInformeArqui[0]['id_tramite'];
		$cite_tramite = $resultDataCuerpoInformeArqui[0]['cite_tramite'];
		$id_tipo_tramite = $resultDataCuerpoInformeArqui[0]['id_tipo_tramite'];
		$fecha_leg = $resultDataCuerpoInformeArqui[0]['fecha_leg'];
		$inf_leg = $resultDataCuerpoInformeArqui[0]['inf_leg'];
		$legal = $resultDataCuerpoInformeArqui[0]['legal'];
		$fecha_top = $resultDataCuerpoInformeArqui[0]['fecha_top'];
		$inf_top = $resultDataCuerpoInformeArqui[0]['inf_top'];
		$topo = $resultDataCuerpoInformeArqui[0]['topo'];
		$distrito = $resultDataCuerpoInformeArqui[0]['distrito'];
		$zona = $resultDataCuerpoInformeArqui[0]['zona'];
		$manzana = $resultDataCuerpoInformeArqui[0]['manzana'];
		$lote = $resultDataCuerpoInformeArqui[0]['lote'];
		$calle = $resultDataCuerpoInformeArqui[0]['calle'];
		$avenida = $resultDataCuerpoInformeArqui[0]['avenida'];
		$super_escritura = $resultDataCuerpoInformeArqui[0]['super_escritura'];
		$super_mensura = $resultDataCuerpoInformeArqui[0]['super_mensura'];
		$super_total = $resultDataCuerpoInformeArqui[0]['super_total'];
		$long_rasante = $resultDataCuerpoInformeArqui[0]['long_rasante'];
		$colindante_este = $resultDataCuerpoInformeArqui[0]['colindante_este'];
		$colindante_norte = $resultDataCuerpoInformeArqui[0]['colindante_norte'];
		$colindante_oeste = $resultDataCuerpoInformeArqui[0]['colindante_oeste'];
		$colindante_sur = $resultDataCuerpoInformeArqui[0]['colindante_sur'];
		$nro_boleta = $resultDataCuerpoInformeArqui[0]['nro_boleta'];
		$nro_rmta = $resultDataCuerpoInformeArqui[0]['nro_rmta'];
		$fecha_rmta = $resultDataCuerpoInformeArqui[0]['fecha_rmta'];
		$tipo_aprobacion = $resultDataCuerpoInformeArqui[0]['tipo_aprobacion'];


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
		
		$dataSource->putParameter('id_tramite', $id_tramite);
		$dataSource->putParameter('cite_tramite', $cite_tramite);
		$dataSource->putParameter('id_tipo_tramite', $id_tipo_tramite);
		$dataSource->putParameter('fecha_leg', $fecha_leg);
		$dataSource->putParameter('inf_leg', $inf_leg);
		$dataSource->putParameter('legal', $legal);
		$dataSource->putParameter('fecha_top', $fecha_top);
		$dataSource->putParameter('inf_top', $inf_top);
		$dataSource->putParameter('topo', $topo);
		$dataSource->putParameter('distrito', $distrito);
		$dataSource->putParameter('zona', $zona);
		$dataSource->putParameter('manzana', $manzana);
		$dataSource->putParameter('lote', $lote);
		$dataSource->putParameter('calle', $calle);
		$dataSource->putParameter('avenida', $avenida);
		$dataSource->putParameter('super_escritura', $super_escritura);
		$dataSource->putParameter('super_mensura', $super_mensura);
		$dataSource->putParameter('super_total', $super_total);
		$dataSource->putParameter('long_rasante', $long_rasante);
		$dataSource->putParameter('colindante_este', $colindante_este);
		$dataSource->putParameter('colindante_norte', $colindante_norte);
		$dataSource->putParameter('colindante_oeste', $colindante_oeste);
		$dataSource->putParameter('colindante_sur', $colindante_sur);
		$dataSource->putParameter('nro_boleta', $nro_boleta);
		$dataSource->putParameter('nro_rmta', $nro_rmta);
		$dataSource->putParameter('fecha_rmta', $fecha_rmta);
		$dataSource->putParameter('tipo_aprobacion', $tipo_aprobacion);

		
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RInformeArqui();
        
        $reporte->setDataSource($dataSource); 
        //$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf';
		$nombreArchivo = 'RInformeArqui.pdf';
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