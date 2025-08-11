<?php
/**
*@package pXP
*@file gen-ACTTramite.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RResolucion.php');
require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');


class ACTReporteResolucion extends ACTbase{    
			
	

	function emitirResolucion(){
		
		$idtramite = $this->objParam->getParametro('id_tramite');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("trami.id_tramite = ".$this->objParam->getParametro('id_tramite'));
        $this->objParam->addParametroConsulta('ordenacion', 'trami.id_tramite');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 10000);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultlistarDatosResolucion = $this->objFunc->listarDatosFormulario($this->objParam);
        
        if($resultlistarDatosResolucion->getTipo()=='ERROR'){
          $resultlistarDatosResolucion->imprimirRespuesta($resultlistarDatosResolucion-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultlistarDatosResolucion->getDatos();
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
		$num_resolucion = $resultData[0]['num_resolucion'];
		$mes_resolucion = $resultData[0]['mes_resolucion'];
		$dia_resolucion = $resultData[0]['dia_resolucion'];
		$anio_resolucion = $resultData[0]['anio_resolucion'];
		
		$this->objFunc = $this->create('MODReporte');
		$resultListarInformes = $this->objFunc->listarFormularioPersonas($this->objParam);
        
        if($resultListarInformes->getTipo()=='ERROR'){
          $resultListarInformes->imprimirRespuesta($resultListarInformes-> generarMensajeJson());
          exit;
        }
		
		$resultDataInformes = $resultListarInformes->getDatos();
		$domicilio = $resultDataInformes[0]['domicilio'];
		$tipo_persona = $resultDataInformes[0]['tipo_persona'];
		$fecha_poder = $resultDataInformes[0]['fecha_poder'];
		$notario = $resultDataInformes[0]['notario'];
		$nro_notaria = $resultDataInformes[0]['nro_notaria'];
		$nombre_completo1 = $resultDataInformes[0]['nombre_completo1'];
		$celular1 = $resultDataInformes[0]['celular1'];
		$correo = $resultDataInformes[0]['correo'];
		$ci = $resultDataInformes[0]['ci'];
		$expedicion = $resultDataInformes[0]['expedicion'];
		$nro_poder = $resultDataInformes[0]['nro_poder'];


		$this->objFunc = $this->create('MODReporte');
		$resultListarLegal = $this->objFunc->listarAbogado($this->objParam);
        
        if($resultListarLegal->getTipo()=='ERROR'){
          $resultListarLegal->imprimirRespuesta($resultListarLegal-> generarMensajeJson());
          exit;
        }
		
		$resultDataLegal = $resultListarLegal->getDatos();
		$asiento = $resultDataLegal[0]['asiento'];
		$decreto_registrador = $resultDataLegal[0]['decreto_registrador'];
		$fecha_asiento = $resultDataLegal[0]['fecha_asiento'];
		$fecha_testimonio = $resultDataLegal[0]['fecha_testimonio'];
		$nombre_notario = $resultDataLegal[0]['nombre_notario'];
		$nro_matricula = $resultDataLegal[0]['nro_matricula'];
		$nro_notario = $resultDataLegal[0]['nro_notario'];
		$nro_testimonio = $resultDataLegal[0]['nro_testimonio'];
		$superficie = $resultDataLegal[0]['superficie'];
		$descripcion = $resultDataLegal[0]['descripcion'];
		$num_informeLegal = $resultDataLegal[0]['num_informe'];
		$fecha_regLegal = $resultDataLegal[0]['fecha_reg'];
		$estado_tramiteLegal = $resultDataLegal[0]['estado_tramite'];
		$desc_funcionario1Legal = $resultDataLegal[0]['desc_funcionario1'];

		$this->objFunc = $this->create('MODReporte');
		$resultListarOT = $this->objFunc->listarAbogado($this->objParam);
        
        if($resultListarOT->getTipo()=='ERROR'){
          $resultListarOT->imprimirRespuesta($resultListarOT-> generarMensajeJson());
          exit;
        }

		$resultDataOT = $resultListarOT->getDatos();
		$num_informeOT = $resultDataOT[0]['num_informe'];
		$fecha_regOT = $resultDataOT[0]['fecha_reg'];
		$desc_funcionario1OT = $resultDataOT[0]['desc_funcionario1'];
		$estado_tramiteOT = $resultDataOT[0]['estado_tramite'];
		$calleOT = $resultDataOT[0]['calle'];
		$avenidaOT = $resultDataOT[0]['avenida'];
		$zonaOT = $resultDataOT[0]['zona'];
	
		$this->objFunc = $this->create('MODReporte');
		$resultListarTopografo = $this->objFunc->listarTopografo($this->objParam);
        
        if($resultListarTopografo->getTipo()=='ERROR'){
          $resultListarTopografo->imprimirRespuesta($resultListarTopografo-> generarMensajeJson());
          exit;
        }
		
		$resultDataTop = $resultListarTopografo->getDatos();
		$num_informeTop = $resultDataTop[0]['num_informe'];
		$fecha_regTop = $resultDataTop[0]['fecha_reg'];
		$desc_funcionario1Top = $resultDataTop[0]['desc_funcionario1'];
		$estado_tramiteTop = $resultDataTop[0]['estado_tramite'];
		$calleTop = $resultDataTop[0]['calle'];
		$avenidaTop = $resultDataTop[0]['avenida'];
		$zonaTop = $resultDataTop[0]['zona'];
		$distritoTop = $resultDataTop[0]['distrito'];
		$manzanaTop = $resultDataTop[0]['manzana'];

		$this->objFunc = $this->create('MODReporte');
		$resultListarArquitecto = $this->objFunc->listarArquitecto($this->objParam);
        
        if($resultListarArquitecto->getTipo()=='ERROR'){
          $resultListarArquitecto->imprimirRespuesta($resultListarArquitecto-> generarMensajeJson());
          exit;
        }
		
		$resultDataArq = $resultListarArquitecto->getDatos();
		$estado_tramiteArq = $resultDataArq[0]['estado_tramite'];
		$fecha_regArq = $resultDataArq[0]['fecha_reg'];
		$num_informeArq = $resultDataArq[0]['num_informe'];
		$fecha_rmtaArq = $resultDataArq[0]['fecha_rmta'];
		$nro_rmtaArq = $resultDataArq[0]['nro_rmta'];
		$tipo_aprobacionArq = $resultDataArq[0]['tipo_aprobacion'];
		$desc_funcionario1Arq = $resultDataArq[0]['desc_funcionario1'];
		

		$this->objFunc = $this->create('MODReporte');
		$resultListarBoleta = $this->objFunc->listarBoleta($this->objParam);
        
        if($resultListarBoleta->getTipo()=='ERROR'){
          $resultListarBoleta->imprimirRespuesta($resultListarBoleta-> generarMensajeJson());
          exit;
        }
		
		$resultDataBol = $resultListarBoleta->getDatos();
		$comp_pagoBol = $resultDataBol[0]['comp_pago'];
		$expedienteBol = $resultDataBol[0]['expediente'];
		$fecha_pagoBol = $resultDataBol[0]['fecha_pago'];
		$montoBol = $resultDataBol[0]['monto'];
		$nro_liquidacionBol = $resultDataBol[0]['nro_liquidacion'];
		$nombre_completo1Bol = $resultDataBol[0]['nombre_completo1'];
		

		$this->objFunc = $this->create('MODReporte');
		$resultListarLote = $this->objFunc->listarLote($this->objParam);
        
        if($resultListarLote->getTipo()=='ERROR'){
          $resultListarLote->imprimirRespuesta($resultListarLote-> generarMensajeJson());
          exit;
        }

		$resultDataLot = $resultListarLote->getDatos();
		$lote = $resultDataLot[0]['lote'];
		$tipo_cesionLot = $resultDataLot[0]['tipo_cesion'];
		$nombreLot = $resultDataLot[0]['nombre'];
		$superficieLot = $resultDataLot[0]['superficie'];
		

		//var_dump($resultListarVacacion->getDatos());exit;
		
		//$mainDataSet = $resultListarInformes->getDatos();
		//$resultData2 = $resultlistarVacacion->getDatos();
		$mainDataSet[] = array("listaPersonas" => $resultListarInformes, );
		$mainDataSet[] = array("listaAbogado" => $resultListarLegal, );
		$mainDataSet[] = array("listaOT" => $resultListarOT, );
		$mainDataSet[] = array("listaTopografo" => $resultListarTopografo, );
		$mainDataSet[] = array("listaArquitecto" => $resultListarArquitecto, );
		$mainDataSet[] = array("listaBoleta" => $resultListarBoleta, );
		$mainDataSet[] = array("listaLote" => $resultListarLote, );
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
		$dataSource->putParameter('num_resolucion', $num_resolucion);
		$dataSource->putParameter('mes_resolucion', $mes_resolucion);
		$dataSource->putParameter('dia_resolucion', $dia_resolucion);
		$dataSource->putParameter('anio_resolucion', $anio_resolucion);
		//ListarPersonas
		$dataSource->putParameter('domicilio', $domicilio);
		$dataSource->putParameter('tipo_persona', $tipo_persona);
		$dataSource->putParameter('fecha_poder', $fecha_poder);
		$dataSource->putParameter('notario', $notario);
		$dataSource->putParameter('nro_notaria', $nro_notaria);
		$dataSource->putParameter('nombre_completo1', $nombre_completo1);
		$dataSource->putParameter('celular1', $celular1);
		$dataSource->putParameter('correo', $correo);
		$dataSource->putParameter('ci', $ci);
		$dataSource->putParameter('expedicion', $expedicion);
		$dataSource->putParameter('nro_poder', $nro_poder);
		
		//Legal
		$dataSource->putParameter('asiento', $asiento);
		$dataSource->putParameter('decreto_registrador', $decreto_registrador);
		$dataSource->putParameter('fecha_asiento', $fecha_asiento);
		$dataSource->putParameter('fecha_testimonio', $fecha_testimonio);
		$dataSource->putParameter('nombre_notario', $nombre_notario);
		$dataSource->putParameter('nro_matricula', $nro_matricula);
		$dataSource->putParameter('nro_notario', $nro_notario);
		$dataSource->putParameter('nro_testimonio', $nro_testimonio);
		$dataSource->putParameter('superficie', $superficie);
		$dataSource->putParameter('descripcion', $descripcion);
		$dataSource->putParameter('num_informeLegal', $num_informeLegal);
		$dataSource->putParameter('fecha_regLegal', $fecha_regLegal);
		$dataSource->putParameter('estado_tramiteLegal', $estado_tramiteLegal);
		$dataSource->putParameter('desc_funcionario1Legal', $desc_funcionario1Legal);
		//OT
		$dataSource->putParameter('num_informeOT', $num_informeOT);
		$dataSource->putParameter('fecha_regOT', $fecha_regOT);
		$dataSource->putParameter('desc_funcionario1OT', $desc_funcionario1OT);
		$dataSource->putParameter('estado_tramiteOT', $estado_tramiteOT);
		$dataSource->putParameter('calleOT', $calleOT);
		$dataSource->putParameter('avenidaOT', $avenidaOT);
		$dataSource->putParameter('zonaOT', $zonaOT);
		//Topografo
		$dataSource->putParameter('num_informeTop', $num_informeTop);
		$dataSource->putParameter('fecha_regTop', $fecha_regTop);
		$dataSource->putParameter('desc_funcionario1Top', $desc_funcionario1Top);
		$dataSource->putParameter('estado_tramiteTop', $estado_tramiteTop);
		$dataSource->putParameter('calleTop', $calleTop);
		$dataSource->putParameter('avenidaTop', $avenidaTop);
		$dataSource->putParameter('zonaTop', $zonaTop);
		$dataSource->putParameter('distritoTop', $distritoTop);
		$dataSource->putParameter('manzanaTop', $manzanaTop);
		//Arquitect
		$dataSource->putParameter('estado_tramiteArq', $estado_tramiteArq);
		$dataSource->putParameter('fecha_regArq', $fecha_regArq);
		$dataSource->putParameter('num_informeArq', $num_informeArq);
		$dataSource->putParameter('fecha_rmtaArq', $fecha_rmtaArq);
		$dataSource->putParameter('nro_rmtaArq', $nro_rmtaArq);
		$dataSource->putParameter('tipo_aprobacionArq', $tipo_aprobacionArq);
		$dataSource->putParameter('desc_funcionario1Arq', $desc_funcionario1Arq);
		//Boleta
		$dataSource->putParameter('comp_pagoBol', $comp_pagoBol);
		$dataSource->putParameter('expedienteBol', $expedienteBol);
		$dataSource->putParameter('fecha_pagoBol', $fecha_pagoBol);
		$dataSource->putParameter('montoBol', $montoBol);
		$dataSource->putParameter('nro_liquidacionBol', $nro_liquidacionBol);
		$dataSource->putParameter('nombre_completo1Bol', $nombre_completo1Bol);
		//Lote
		$dataSource->putParameter('lote', $lote);
		$dataSource->putParameter('tipo_cesionLot', $tipo_cesionLot);
		$dataSource->putParameter('nombreLot', $nombreLot);
		$dataSource->putParameter('superficieLot', $superficieLot);

		
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RResolucion();
        
        $reporte->setDataSource($dataSource); 
        //$nombreArchivo = 'SolicitudVA'.uniqid(md5(session_id())).'.pdf';
		$nombreArchivo = 'RResolucion.pdf';
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