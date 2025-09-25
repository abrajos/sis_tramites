<?php
/**
*@package pXP
*@file gCTReporteInforme.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

require_once (dirname(__FILE__) . '/../reportes/pxpReport/ReportWriter.php');
require_once (dirname(__FILE__) . '/../reportes/RFormularioBoleta.php');
require_once (dirname(__FILE__) . '/../reportes/pxpReport/DataSource.php');


class ACTReporteFormularioBoleta extends ACTbase{    
			
	

	function emitirBoleta(){
		
		$idboletatramite = $this->objParam->getParametro('id_boleta_liquida');
		$idtramite = $this->objParam->getParametro('id_tramite_detalle');
		$idusuarioreg = $this->objParam->getParametro('id_usuario_reg');
        //$fechaHasta = $this->objParam->getParametro('fecha_hasta');
        $this->objParam->addFiltro("bolliq.id_boleta_liquida = ".$this->objParam->getParametro('id_boleta_liquida'));
        $this->objParam->addParametroConsulta('ordenacion', 'bolliq.id_boleta_liquida');
        $this->objParam->addParametroConsulta('dir_ordenacion', 'asc');
        $this->objParam->addParametroConsulta('cantidad', 10);
        $this->objParam->addParametroConsulta('puntero', 0);
        $this->objFunc = $this->create('MODReporte');
        $resultresultlistarBoletaLiquida = $this->objFunc->listarBoletaLiquida($this->objParam);
        
        if($resultresultlistarBoletaLiquida->getTipo()=='ERROR'){
          $resultresultlistarBoletaLiquida->imprimirRespuesta($resultresultlistarBoletaLiquida-> generarMensajeJson());
          exit;
        }
		
		//var_dump($resultListarVacacion->getDatos());exit;
		$dataSource = new DataSource();
        $resultData = $resultresultlistarBoletaLiquida->getDatos();
		//var_dump($resultData[0]['desc_funcionario1']);exit;
        $id_boleta_liquida = $resultData[0]['id_boleta_liquida'];
		$plano_bs = $resultData[0]['plano_bs'];
		$division_m = $resultData[0]['division_m'];
		$fecha_emision = $resultData[0]['fecha_emision'];
		$anexion_bs = $resultData[0]['anexion_bs'];
		$monto_literal = $resultData[0]['monto_literal'];
		$plano_cons_bs = $resultData[0]['plano_cons_bs'];
		$id_tramite = $resultData[0]['id_tramite'];
		$concepto_a_m = $resultData[0]['concepto_a_m'];
		$nombre_concepto_b = $resultData[0]['nombre_concepto_b'];
		$concepto_a_bs = $resultData[0]['concepto_a_bs'];
		$plano_m = $resultData[0]['plano_m'];
		$plano_cons_m = $resultData[0]['plano_cons_m'];
		$anexion_m = $resultData[0]['anexion_m'];
		$estado_reg = $resultData[0]['estado_reg'];
		$linea_nivel_m = $resultData[0]['linea_nivel_m'];
		$division_bs = $resultData[0]['division_bs'];
		$concepto_b_bs = $resultData[0]['concepto_b_bs'];
		$linea_nivel_bs = $resultData[0]['linea_nivel_bs'];
		$avance_m = $resultData[0]['avance_m'];
		$avance_bs = $resultData[0]['avance_bs'];
		$nombre_concepto_a = $resultData[0]['nombre_concepto_a'];
		$cite_tramite = $resultData[0]['cite_tramite'];
		$concepto_b_m = $resultData[0]['concepto_b_m'];
		$plano_verja_m = $resultData[0]['plano_verja_m'];
		$total_bs = $resultData[0]['total_bs'];
		$total_redon = $resultData[0]['total_redon'];
		$nro_boleta = $resultData[0]['nro_boleta'];
		$id_tramite_detalle = $resultData[0]['id_tramite_detalle'];
		$plano_verja_bs = $resultData[0]['plano_verja_bs'];
		$id_usuario_reg = $resultData[0]['id_usuario_reg'];
		$fecha_reg = $resultData[0]['linea_nfecha_regivel_m'];		
		$usuario_ai = $resultData[0]['usuario_ai'];
		$id_usuario_ai = $resultData[0]['id_usuario_ai'];
		$fecha_mod = $resultData[0]['fecha_mod'];

		$plano_cons_tot = $resultData[0]['plano_cons_tot'];
		$plano_tot = $resultData[0]['plano_tot'];
		$plano_verja_tot = $resultData[0]['plano_verja_tot'];
		$linea_nivel_tot = $resultData[0]['linea_nivel_tot'];
		$anexion_tot = $resultData[0]['anexion_tot'];
		$division_tot = $resultData[0]['division_tot'];
		$avance_tot = $resultData[0]['avance_tot'];
		$concep_a_tot = $resultData[0]['concep_a_tot'];
		$concep_b_tot = $resultData[0]['concep_b_tot'];
		

		
		$this->objFunc = $this->create('MODReporte');
		$resultListarPersonas = $this->objFunc->listarFormularioPersonasBoleta($this->objParam);
        
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
		
		$dataSource->putParameter('plano_bs', $plano_bs);
		$dataSource->putParameter('division_m', $division_m);
		$dataSource->putParameter('fecha_emision', $fecha_emision);
		$dataSource->putParameter('anexion_bs', $anexion_bs);
		$dataSource->putParameter('monto_literal', $monto_literal);
		$dataSource->putParameter('plano_cons_bs', $plano_cons_bs);
		$dataSource->putParameter('concepto_a_m', $concepto_a_m);
		$dataSource->putParameter('nombre_concepto_b', $nombre_concepto_b);
		$dataSource->putParameter('concepto_a_bs', $concepto_a_bs);
		$dataSource->putParameter('plano_m', $plano_m);
		$dataSource->putParameter('plano_cons_m', $plano_cons_m);
		
		$dataSource->putParameter('anexion_m', $anexion_m);
		$dataSource->putParameter('linea_nivel_m', $linea_nivel_m);
		$dataSource->putParameter('division_bs', $division_bs);
		$dataSource->putParameter('concepto_b_bs', $concepto_b_bs);
		$dataSource->putParameter('linea_nivel_bs', $linea_nivel_bs);
		$dataSource->putParameter('avance_m', $avance_m);
		
		$dataSource->putParameter('avance_bs', $avance_bs);
		$dataSource->putParameter('nombre_concepto_a', $nombre_concepto_a);
		$dataSource->putParameter('cite_tramite', $cite_tramite);
		
		$dataSource->putParameter('concepto_b_m', $concepto_b_m);
		$dataSource->putParameter('plano_verja_m', $plano_verja_m);
		$dataSource->putParameter('total_bs', $total_bs);
		$dataSource->putParameter('total_redon', $total_redon);
		$dataSource->putParameter('nro_boleta', $nro_boleta);
		$dataSource->putParameter('plano_verja_bs', $plano_verja_bs);
		$dataSource->putParameter('plano_cons_tot', $plano_cons_tot);
		$dataSource->putParameter('plano_tot', $plano_tot);
		$dataSource->putParameter('plano_verja_tot', $plano_verja_tot);
		$dataSource->putParameter('linea_nivel_tot', $linea_nivel_tot);
		$dataSource->putParameter('anexion_tot', $anexion_tot);
		$dataSource->putParameter('division_tot', $division_tot);
		$dataSource->putParameter('avance_tot', $avance_tot);
		$dataSource->putParameter('concep_a_tot', $concep_a_tot);
		$dataSource->putParameter('concep_b_tot', $long_rasante);
				
		$dataSourceArray = Array();
        $dataSourceClasificacion = new DataSource();
        $dataSetClasificacion = Array();
        $totalCostoClasificacion = 0;
        //$mainDataSet = array();
        $costoTotal = 0;
		$dataSource->setDataSet($mainDataSet);
		
		//var_dump($dataSource->getDataset()); exit;
		
		$reporte = new RFormularioBoleta();
        
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