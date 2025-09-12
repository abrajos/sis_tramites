<?php
/**
*@package pXP
*@file gCTReporteInforme.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RInformeTopo.php');
require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');


class ACTReporteInforme extends ACTbase{    
			
	

	function emitirInformeTopo(){
		
		$idtramite = $this->objParam->getParametro('id_tramite_detalle');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("tradet.id_tramite_detalle = ".$this->objParam->getParametro('id_tramite_detalle'));
        $this->objParam->addParametroConsulta('ordenacion', 'tradet.id_tramite_detalle');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 10000);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultlistarCabeceraInforme = $this->objFunc->listarCabeceraInforme($this->objParam);
        
        if($resultlistarCabeceraInforme->getTipo()=='ERROR'){
          $resultlistarCabeceraInforme->imprimirRespuesta($resultlistarCabeceraInforme-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultlistarCabeceraInforme->getDatos();
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
		
		
		$this->objFunc = $this->create('MODReporte');
		$resultListarCuerpoInforme = $this->objFunc->listarCuerpoInforme($this->objParam);
        
        if($resultListarCuerpoInforme->getTipo()=='ERROR'){
          $resultListarCuerpoInforme->imprimirRespuesta($resultListarCuerpoInforme-> generarMensajeJson());
          exit;
        }
		
		$resultDataCuerpoInforme = $resultListarCuerpoInforme->getDatos();
		$cite_tramite = $resultDataCuerpoInforme[0]['cite_tramite'];
		$nombre_tramite = $resultDataCuerpoInforme[0]['nombre_tramite'];
		$distrito = $resultDataCuerpoInforme[0]['distrito'];
		$zona = $resultDataCuerpoInforme[0]['zona'];
		$manzana = $resultDataCuerpoInforme[0]['manzana'];
		$lote = $resultDataCuerpoInforme[0]['lote'];
		$calle = $resultDataCuerpoInforme[0]['calle'];
		$avenida = $resultDataCuerpoInforme[0]['avenida'];
		$tipo_calle = $resultDataCuerpoInforme[0]['tipo_calle'];
		$rasante_municipal = $resultDataCuerpoInforme[0]['rasante_municipal'];
		$colindante_norte = $resultDataCuerpoInforme[0]['colindante_norte'];
		$colindante_sur = $resultDataCuerpoInforme[0]['colindante_sur'];
		$colindante_oeste = $resultDataCuerpoInforme[0]['colindante_oeste'];
		$colindante_este = $resultDataCuerpoInforme[0]['colindante_este'];
		$super_escritura = $resultDataCuerpoInforme[0]['super_escritura'];
		$super_mensura = $resultDataCuerpoInforme[0]['super_mensura'];
		$super_excedente = $resultDataCuerpoInforme[0]['super_excedente'];
		$super_inexistente = $resultDataCuerpoInforme[0]['super_inexistente'];
		$super_total = $resultDataCuerpoInforme[0]['super_total'];
		$long_rasante = $resultDataCuerpoInforme[0]['long_rasante'];
		$vias = $resultDataCuerpoInforme[0]['vias'];
		$agua_potable = $resultDataCuerpoInforme[0]['agua_potable'];
		$alcantarillado = $resultDataCuerpoInforme[0]['alcantarillado'];
		$alumbrado_publico = $resultDataCuerpoInforme[0]['alumbrado_publico'];
		$telefonia = $resultDataCuerpoInforme[0]['telefonia'];
		$equipamiento = $resultDataCuerpoInforme[0]['equipamiento'];
		$transporte = $resultDataCuerpoInforme[0]['transporte'];
		$observacion = $resultDataCuerpoInforme[0]['observacion'];
		$conclusion = $resultDataCuerpoInforme[0]['conclusion'];

		//var_dump($resultListarVacacion->getDatos());exit;
		
		//$mainDataSet = $resultListarInformes->getDatos();
		//$resultData2 = $resultlistarVacacion->getDatos();
		$mainDataSet[] = array("listarCuerpoInforme" => $resultListarCuerpoInforme, );
		
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
		
		//ListarCuerpoInforme
		
		$dataSource->putParameter('cite_tramite', $cite_tramite);
		$dataSource->putParameter('nombre_tramite', $nombre_tramite);
		$dataSource->putParameter('distrito', $distrito);
		$dataSource->putParameter('zona', $zona);
		$dataSource->putParameter('manzana', $manzana);
		$dataSource->putParameter('lote', $lote);
		$dataSource->putParameter('calle', $calle);
		$dataSource->putParameter('avenida', $avenida);
		$dataSource->putParameter('tipo_calle', $ctipo_callei);
		$dataSource->putParameter('rasante_municipal', $rasante_municipal);
		$dataSource->putParameter('colindante_norte', $colindante_norte);
		$dataSource->putParameter('colindante_sur', $colindante_sur);
		$dataSource->putParameter('colindante_oeste', $colindante_oeste);
		$dataSource->putParameter('colindante_este', $colindante_este);
		$dataSource->putParameter('super_escritura', $super_escritura);
		$dataSource->putParameter('super_mensura', $super_mensura);
		$dataSource->putParameter('super_excedente', $super_excedente);
		$dataSource->putParameter('super_inexistente', $super_inexistente);
		$dataSource->putParameter('super_total', $super_total);
		$dataSource->putParameter('long_rasante', $long_rasante);
		$dataSource->putParameter('vias', $vias);
		$dataSource->putParameter('agua_potable', $agua_potable);
		$dataSource->putParameter('alcantarillado', $alcantarillado);
		$dataSource->putParameter('alumbrado_publico', $alumbrado_publico);
		$dataSource->putParameter('telefonia', $telefonia);
		$dataSource->putParameter('equipamiento', $equipamiento);
		$dataSource->putParameter('transporte', $transporte);
		$dataSource->putParameter('observacion', $observacion);
		$dataSource->putParameter('conclusion', $conclusion);
		

		
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RInformeTopo();
        
        $reporte->setDataSource($dataSource); 
        //$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf';
		$nombreArchivo = 'RInformeTopo.pdf';
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