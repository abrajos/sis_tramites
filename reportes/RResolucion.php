<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';
//require_once dirname(__FILE__) . '/../../lib/tcpdf/tcpdf.php';
//ini_set('display_errors', 'On');
class CustomReport extends TCPDF {

    private $dataSource;

    public function setDataSource(DataSource $dataSource) 
    {
        $this->dataSource = $dataSource;
    }

    public function getDataSource() 
    {
        return $this->dataSource;
    }

    public function Header() 
    {

    }

    public function Footer() 
    {
        //TODO: implement the footer manager
        $dataSource = $this->getDataSource();
        //$this->SetFooterMargin(PDF_MARGIN_FOOTER);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 6);
        $this->Cell(0, 0, 'usuario: '.$dataSource->getParameter('cuenta'), 0, 1, 'L');
        
        $html = 'Numero Tramite: '.$dataSource->getParameter('cite_tramite')."\n".'Tramite: '.$dataSource->getParameter('nombre_tramite')."\n".'Usuario: '.$dataSource->getParameter('cuenta')."\n".'Sistema de Tramites ';
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        $this->write2DBarcode($html, 'QRCODE,M', 170, 260, 30, 30, $style, 'N');
    } 
}

Class RResolucion extends Report {
    function write($fileName) 
    {
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();
        // set document information
        $pdf->SetCreator(PDF_CREATOR);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(2);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // Crea la pagina para mostrar los totales de los almacenes.
        $pdf->AddPage('P', 'A4');
        $hGlobal = 5;
        $hMedium = 7.5;
        $hLong = 15;
        $pdf->SetFontSize(10);
        //var_dump($dataSource->getDataSet());exit();
		$propietariosList = "";
		foreach ($dataSource->getDataSet() as $row) {
			$tipo_persona = $row['tipo_persona'];
			if ( $tipo_persona == "propietario"){
				if ($count == 0) {
					$propietariosList = $row['nombre_completo1'];
				} else {
					$propietariosList .= "|".$row['nombre_completo1'];
				}
			}
		}

		$propietarios = explode("|", $propietariosList);
		$propName = '';
		if (count($propietarios) ==  1) {
			$propName = $propietariosList;
		} elseif (count($propietarios) <  3) {
			$propName = $propietarios[0]." y ".$propietarios[1];
		} else {
			for ($i=0; $i < count($propietarios); $i++) { 
				if ($i == 0) {
					$propName = $propietarios[0];
				} elseif ($i > 0 && $i < count($propietarios) - 2) {
					$propName .= ", ".$propietarios[$i];
				} else {
					$propName .= " y ".$propietarios[$i];
				}
			}
		} 

        if ($dataSource->getParameter('nombre_tramite') == "Plano de Urbanización"){
            // header
            $titleText1 = '<b>RESOLUCIÓN MUNICIPAL<br>TÉCNICO ADMINISTRATIVA<br>Nº '.$dataSource->getParameter('num_resolucion').'/'.$dataSource->getParameter('anio_resolucion').'</b>';
            $referenceText0 = '<b>A</b>, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS: </b>';
            $detailtext = 'La solicitud adjunta presentada para la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'<br><b>CONSIDERANDO:</b>';
            // body de informe
            $bodyText0 = '<b>Que</b>, mediante memorial presentado en fecha '.$dataSource->getParameter('dia').' de '.$dataSource->getParameter('mes').' de '.$dataSource->getParameter('anio').' adjunta documentación que acredita su derecho propietario presentada por los Sr(es). '.$propName.' quienes solicitan la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>.';
            $bodyText1 = '<b>Que</b>, según informe técnico '.$dataSource->getParameter('num_informeOT').' de fecha '.$dataSource->getParameter('fecha_regOT').' emitido por '.$dataSource->getParameter('desc_funcionario1OT').' en calidad de Responsable de Ordenamiento Territorial, refiere que para la prosecución de trámite se debe respetar las proyecciones de vía aplicables a los Distritos '.$dataSource->getParameter('distritoTop').', vías establecidas en zona '.$dataSource->getParameter('zonaOT').', '.$dataSource->getParameter('calleOT').' de 12.50 mts y '.$dataSource->getParameter('avenidaOT').' de 10.00 mts de perfil de vía dando cumplimiento a la normativa vigente para sus respectivas cesiones.';
            $bodyText2 = '<b>Que</b>, según el <b>Informe Técnico Topográfico N°'.$dataSource->getParameter('num_informeTop').'/2025 de fecha '.$dataSource->getParameter('fecha_regTop').' elaborado por la '.$dataSource->getParameter('desc_funcionario1Top').'</b> como <b>Topógrafo de la Dirección de Urbanismo y Catastro</b>; el predio objeto del presente trámite se encuentra ubicado en Colcapirhua, <b>Distrito '.$dataSource->getParameter('distritoTop').', Manzana '.$dataSource->getParameter('manzanaTop').'</b>, '.$dataSource->getParameter('calleTop').' de 12.50 mts y '.$dataSource->getParameter('avenidaTop').' de 10.00 mts. Concluye recomendando dar continuidad al trámite administrativo.';
            $bodyText3 = '<b>Que</b>, según <b>Informe Legal N° '.$dataSource->getParameter('num_informe').'</b> de fecha '.$dataSource->getParameter('fecha_reg').' emitido por la Abg. '.$dataSource->getParameter('desc_funcionario1').', como <b>Abogado de la Dirección de Urbanismo y Catastro</b>, quien refiere que el trámite ha cumplido con los requisitos legales, por lo que recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>, y que de acuerdo a la documentación presentada por los Sr(es). <b>'.$propName.'</b> quienes acreditan ser propietarios de un predio de <b>Sup. '.$dataSource->getParameter('superficie').' m2</b>, con registro en Derechos Reales bajo Matricula '.$dataSource->getParameter('nro_matricula').' asiento A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').' conforme Escritura Pública de transferencia de lote de terreno otorgado por Notaria de Primera Clase N° '.$dataSource->getParameter('nro_notario').' a cargo de la Notaria Dra. '.$dataSource->getParameter('nombre_notario').'.'; 
            $bodyText4 = '<b>Que</b>, según el <b>Informe Técnico de Urbanismo</b> de fecha '.$dataSource->getParameter('fecha_reg').', suscrito por el Arq. '.$dataSource->getParameter('desc_funcionario1').', como <b>Arquitecto II de la Dirección de Urbanismo y Catastro</b>, quien manifiesta que todas las propiedades que entren en proceso de urbanización y regularización tienen la obligación de ceder un porcentaje de superficie con destino a vías, áreas verdes y/o equipamientos de acuerdo al artículo 3 modifica el artículo 33 del reglamento para Urbanizaciones y Edificaciones PLANUR  en relación al porcentaje de cesiones obligatorias, por tanto corresponde el pago de cesiones, otorgando 444.30 m2 de cesión en vías y 1463.20 m2 en área verde y/o equipamiento, asimismo establece que de acuerdo al informe topográfico e informe legal correspondiente y previa verificación de los requisitos establecidos en la normativa aplicable al caso, el trámite cumple las disposiciones del Reglamento <b>PLANUR</b> por lo que, recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>.';
            $bodyText5 = '<b>Que</b>, en cumplimiento a la Resolución Municipal N° 56/2011 modificado por la Resolución Municipal N° 65/2015 en la que refiere en su artículo Primero la instrucción a la Máxima Autoridad Ejecutiva ordenar a la Dirección de Urbanismo remitir el tramite con informes técnicos del jefe de Normas previa cancelación a caja ante el Ente Deliberante todas las Urbanizaciones mayores a 2.500 m2 precedentemente de su aprobación, en este entendido y con la finalidad de efectuar la respectiva verificación y cumplimiento de porcentajes de cesión en urbanizaciones mayores a 2.500 m2, mediante informe emitido en conjunto de.';
            $bodyText6 = '<b>Que</b>, según la boleta de liquidación Nº 025135 suscrito por la Arq. '.$dataSource->getParameter('desc_funcionario1Arq').', como Arquitecta II de la Dirección de Urbanismo y Catastro, comprobante de pago  Nº '.$dataSource->getParameter('comp_pagoBol').', expedido por la Dirección de Finanzas se acredita el pago de Bs.- '.$dataSource->getParameter('montoBol').' ('.$dataSource->getParameter('nro_liquidacionBol').') en fecha '.$dataSource->getParameter('fecha_pagoBol').' y boleta de liquidación Nº 027582 emitido por el  Arq. Wilfredo Camacho Pardo  como Arquitecto II. de la Dirección de Urbanismo y Catastro con comprobante de pago N° '.$dataSource->getParameter('comp_pagoBol').' expedido por la Dirección de Finanzas se acredita el pago de Bs.- '.$dataSource->getParameter('montoBol').'.- ('.$dataSource->getParameter('nro_liquidacionBol').') en fecha '.$dataSource->getParameter('fecha_pagoBol').' por concepto de la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>. (Expediente '.$dataSource->getParameter('expedienteBol').')';
            $bodyText7 = '<b>Que</b>, en el presente caso, se han cumplido con los requisitos técnicos y administrativos exigidos por el Gobierno Autónomo Municipal de Colcapirhua, por lo que, corresponde dar curso a lo impetrado.';
            // resolucion
            $detailtext2 = '<b>POR TANTO:</b>';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme a la Designación establecida por el Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = '<b>RESUELVE</b>';
            $conclusion2 = '<b>PRIMERO.-</b> <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>; del bien inmueble de propiedad de el/los Señor(es) '.$propName.' de acuerdo al siguiente detalle:';
            $detailtext3 = '<b>DATOS DE UBICACIÓN</b>';
            $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;"><tbody>
                        <tr><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Municipio: Colcapirhua</td><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Zona: '.$dataSource->getParameter('zonaOT').'</td></tr>
                        <tr><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Distrito: '.$dataSource->getParameter('distritoTop').'</td><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Lote: '.$dataSource->getParameter('lote').'</td></tr>
                        <tr><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Manzano: '.$dataSource->getParameter('manzanaTop').'</td><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Via: '.$dataSource->getParameter('calleOT').'</td></tr>
                        <tr><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;"></td><td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Via: '.$dataSource->getParameter('avenidaOT').'</td></tr>
                    </tbody>
                </table>';
            $detailtext4 = '<b>RELACIÓN DE SUPERFICIES</b>';
            $table1 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN MENSURA</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE CESIÓN EN VÍAS</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE CESIÓN ÁREA VERDE Y/O EQUIPAMIENTO</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE  TOTAL ÚTIL</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LONGITUD DE RASANTE</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                        </tbody>
                    </table>';
            $table2 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td  colspan="3"  style="width: 100%; padding: 5px; text-align: right; vertical-align: middle;">DIVISIÓN DE LOTES</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">DETALLE</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">CANT</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">UNID.</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LOTE N° 1</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LOTE N° 2</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LOTE N° 3</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LOTE N° 4</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                            <tr><td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE UTIL</td><td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td><td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td></tr>
                        </tbody>
                    </table>';
            $detailtext5 = '<b>SEGUNDO.- COLINDANCIAS GENERALES:</b>';
            $table3 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $detailtext6 = '<b>COLINDANCIAS ESPECÍFICAS:</b>';
            $detailtext7 = '<b>COLINDANCIAS: LOTE 1</b>';
            $table4 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $detailtext8 = '<b>COLINDANCIAS: LOTE 2</b>';
            $table5 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $detailtext9 = '<b>COLINDANCIAS: LOTE 3</b>';
            $table6 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $detailtext10 = '<b>COLINDANCIAS: LOTE 4</b>';
            $table7 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $detailtext11 = '<b>ÁREA VERDE Y/O EQUIPAMIENTO</b>';
            $table8 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td></tr>
                            <tr><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td><td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td></tr>
                        </tbody>
                        </table>';
            $conclusion2 = '<b>TERCERO.-</b> En virtud al artículo 3 de la ley 314 que modifica el artículo 33 del PLANUR y articulo 39 del Reglamento para Urbanizaciones y Edificaciones PLANUR en el que refiere que todas las propiedades que entren en proceso de urbanización y regularización están en la obligación de ceder un porcentaje con destino a vías, áreas verdes y equipamientos y que el Municipio suscribirá escrituras traslativas de dominio cuando las cesiones comprendan superficies de un lote mínimo de 190 m2, al ser superficie de cesión en vías de 444.30 m2 y cesión en áreas en áreas verde y/o equipamiento de 1463.20 m2 haciendo un total de 1907.50 m2 mayor a lo establecida por normativa deberá efectuar la suscripción de escritura traslativa de dominio de las cesiones cedidas.';
            $conclusion3 = '<b>CUARTO.-</b> Conforme el <b>Art. 71 de la Ley 2492 del Nuevo Código Tributario</b> en su Parágrafo I). Establece: Toda persona natural o jurídica de derecho Público o Privado, sin costo alguno, está obligada a proporcionar a la Administración Tributaria Toda clase de datos, informes o antecedentes con efectos tributarios, emergentes de sus relaciones económicas, profesionales o financieras con otras personas, cuando fuere requerido expresamente por la Administración Tributaria';
            $conclusion4 = '<b>QUINTO.-</b> La presente Resolución Municipal Técnica Administrativa no define, ni declara derecho propietario sobre el predio, solo determina la situación física y la ubicación proporcionada por el impetrante, enmarcado en el principio de buena fe de los datos proporcionados por la parte declarante siendo único y exclusivo responsable, deslindando y exonerando de cualquier responsabilidad futura al Gobierno Autónomo Municipal de Colcapirhua.';
            $conclusion5 = '<b>SEXTO.-</b>  La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los Reglamentos y Normas vigentes, aplicar sanciones pecuniarias al propietario en caso que las infrinja o que modifique el proyecto aprobado con la presente Resolución Municipal Técnico Administrativa';
            $conclusion6 = 'Comuníquese a quien corresponda con copia para archivo respectivo.';

            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'C', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText7, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->AddPage();
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext7, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext8, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->AddPage();
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext9, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext10, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table7, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext11, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table8, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        } elseif ($dataSource->getParameter('nombre_tramite') == "Plano de Regularización de Lote") {
            $titleText1 = '<b>Ley Municipal N° 442/2024 - Decreto Municipal N° 004/2024<br>RESOLUCIÓN ADMINISTRATIVA MUNICIPAL<br>Ing. Carlos Rodrigo Jiménez Orellana<br>R.A.M  Nº '.$dataSource->getParameter('num_resolucion').'/'.$dataSource->getParameter('anio_resolucion').'</b>';
            $referenceText0 = '<b>Trámite N° <br>Colcapirhua, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS:<b>';
            $detailtext0 = 'La solicitud de <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').' </b> realizada por '.$propName.', documentación adjunta al trámite, los antecedentes, y;';
            $detailtext1 = '<b>CONSIDERANDO I:</b>';
            $bodyText0 = '<b>Que</b>, el trámite administrativo presentado en fecha 01/07/2024 por '.$propName.',  solicita la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>, acogiéndose a los alcances de la Ley Municipal N° 442/2024 y reglamento aprobado por Decreto Municipal N° 004/2024 de 01/03/2024.';
            $detailtext2 = '<b>CONSIDERANDO II:</b>';
            $bodyText1 = '<b>Que</b>, el <b>Informe Legal de fecha '.$dataSource->getParameter('fecha_regLegal').'</b>, emitido por la Abg. '.$dataSource->getParameter('desc_funcionario1Legal').', Unidad Especial de Límites, refiere que la solicitud es atendida conforme a la Ley Municipal Nº 442 y su reglamento, recomendando la prosecución del trámite administrativo de acuerdo a la documentación revisada de <b>'.$propName.'</b>, quien es propitaria de un lote con una superficie de '.$dataSource->getParameter('superficie').' m2, bajo la matrícula computarizada Nº '.$dataSource->getParameter('nro_matricula').' Asiento A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').', según Testimonio de Derechos Reales de fecha '.$dataSource->getParameter('fecha_testimonio').' (Escritura Pública de compra venta de lote y sub-inscripción de oficio) de fecha '.$dataSource->getParameter('fecha_regLegal').' así mismo se aclara que se consignó erróneamente los datos técnicos y RMTA Nº '.$dataSource->getParameter('nro_rmtaArq').' emitida por el GAM de Quillacollo, consignación que no tiene relación con la transferencia registrada, misma que según solicitud se procede a la corrección registrada en el A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').', cumple con los requisitos.';
            $bodyText2 = '<b>Que</b>, según <b>certificación G.A.M.C./SMP/UL/CITE Nº 121/2024 de fecha '.$dataSource->getParameter('desc_funcionario1OT').'</b>, emitido por Lic. Lorena Linares Quevedo, Responsable de Ordenamiento Territorial; certifica la ubicación del predio en área urbano intensivo dentro el radio urbano homologado del municipio de Colcapirhua, según Ley Municipal N° 147 de 06/02/2018 aprobado con Resolución Ministerial Nº 100/2018 y en zona de límites descrito por la Ley Municipal N° 442/2024.';
            $bodyText3 = '<b>Que</b>, según <b>certificación G.A.M.C./DIR-PLANIF/O.T/644/2024 de fecha 15/05/2024<b>, emitido por Lic. Marcelo Arnez Orellana, Técnico de Ordenamiento Territorial; certifica vías en zona de límites de la jurisdicción municipal de Colcapirhua conforme a la Ley Municipal Nº 442, vías conforme a la consolidación, conectividad, articulación y estructuración municipal; y conforme el plano de estructuración vial urbana establecidas en PLANUR, Ley Municipal Nº 350/2023 y Ley Municipal N° 454/2024.';
            $bodyText4 = '<b>Que</b>, según el <b>Informe Técnico Topográfico Nº '.$dataSource->getParameter('fecha_reg').' de fecha '.$dataSource->getParameter('num_informe').'</b>, emitido por '.$dataSource->getParameter('desc_funcionario1').', Topógrafa  de la Dirección de Urbanismo y Catastro; realiza la inspección de campo y verificación técnica, determinando que el predio se encuentra ubicado dentro de la jurisdicción de '.$dataSource->getParameter('zonaTop').', Distrito '. $dataSource->getParameter('distritoTop').', Zona '.$dataSource->getParameter('zonaTop').', Manzana '.$dataSource->getParameter('manzanaTop').', Lote '.$dataSource->getParameter('lote').', '.$dataSource->getParameter('avenidaTop').' de 15.00 m., conforme informe topográfico si se encuentra en rasante municipal asimismo, informa de la relación de superficies, colindantes, tipo de servicio y situación física del inmueble, por lo que recomienda la prosecución de la solicitud.';
            $bodyText5 = '<b>Que</b>, el Informe Técnico - Urbanismo de fecha '.$dataSource->getParameter('fecha_regArq').', emitido por Arq. '.$dataSource->getParameter('desc_funcionario1Arq').', como arquitecto III de la Unidad Especial de Límites, informa de la ubicación, relación de superficies, colindancia general, y aclara que la cesión corresponde al 20 % en dinero efectivo conforme Art. 41 del reglamento a la Ley Municipal Nº 442/2024, concluyendo que el trámite cumple con los requisitos técnicos establecidos en las normas urbanas, Ley Municipal Nº 442 y su reglamento, por lo que recomienda la prosecución y aprobación de los planos relativos al inmueble.';
            $bodyText6 = '<b>Que</b>, según formulario Nº 027304 de fecha '.$dataSource->getParameter('fecha_regArq').' suscrito por Arq. '.$dataSource->getParameter('desc_funcionario1Arq').', Técnico de Legalizaciones Unidad Especial de Límites  de la Dirección de urbanismo y Catastro, y según comprobante de pago Nº '.$dataSource->getParameter('comp_pagoBol').' de fecha '.$dataSource->getParameter('fecha_pagoBol').', expedida por la Dirección de Recaudaciones, se acredita el pago de Bs. '.$dataSource->getParameter('montoBol').'.- ('.$dataSource->getParameter('nro_liquidacionBol').' 00/100 Bolivianos), por concepto de <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>.';
            $bodyText7 = 'Que, el trámite administrativo registrado bajo el expediente N° '.$dataSource->getParameter('expedienteBol').' es atendido y tramitado de acuerdo a la Ley Municipal N° 442/2023 y Decreto Reglamentario N° 004/2024, por lo que, habiendo cumplido con los requisitos legales, técnicos y administrativos exigidos por el Gobierno Autónomo Municipal de Colcapirhua, corresponde dar curso a lo impetrado.';
            $detailtext3 = 'POR TANTO:';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme a la Designación establecida por el Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = 'RESUELVE';
            $conclusion2 = '<b>PRIMERO.- </b><b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>; del bien inmueble de propiedad de los Señor(es) <b>'.$propName.'</b> de acuerdo al siguiente detalle:';
            $detailtext4 = '<b>UBICACIÓN:</b>';
            $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;"><tbody>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: right; vertical-align: middle;">Municipio:</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;"></td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: right; vertical-align: middle;">Distrito:</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('distritoTop').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: right; vertical-align: middle;">Zona:</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: right; vertical-align: middle;">Manzano:</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('manzanaTop').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: right; vertical-align: middle;">Via:</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('avenidaOT').'</td>
                        </tr>
                    </tbody>
                </table>';
            $detailtext5 = '<b>RELACIÓN DE SUPERFICIES</b>';
            $table1 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA LOTE Nº 1</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN MENSURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE  TOTAL ÚTIL LOTE Nº 1</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LONGITUD DE RASANTE</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                        </tbody>
                    </table>';
            $detailtext6 = '<b>COLINDANCIAS GENERALES:</b>';
            $table2 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="width: 30%; padding: 5px; text-align: center; vertical-align: middle;"><b>LOTE</b></td>
                                <td style="width: 20%; padding: 5px; text-align: left; vertical-align: middle;"><b>NORTE</b></td>
                                <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Paso de Servidumbre</td>
                            </tr>
                            <tr>
                                <td style="width: 20%; padding: 5px; text-align: left; vertical-align: middle;"><b>SUD</b></td>
                                <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Hugo Robert Hinojosa Heredia</td>
                            </tr>
                            <tr>
                                <td style="width: 20%; padding: 5px; text-align: left; vertical-align: middle;"><b>ESTE</b></td>
                                <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Av. Franz Tamayo de 15.00 m.</td>
                            </tr>
                            <tr>
                                <td style="width: 20%; padding: 5px; text-align: left; vertical-align: middle;"><b>OESTE</b></td>
                                <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Froilán Basto García</td>
                            </tr>
                    </tbody>
                    </table>';
            $conclusion3 = '<b>SEGUNDO.-</b> Disponer el REGISTRO CATASTRAL EN ÁREA DE PROTECCIÓN, a los fines de la consolidación impositiva, debiendo la Jefatura de Catastro asignar un código catastral y dar cumplimiento a la Ley Municipal Nº 442/2024 y su reglamento.';
            $conclusion4 = '<b>TERCERO.-</b> En mérito al Art. 19 de la Ley Municipal N° 442/2024 y habiendo el administrado declarado que la documentación y los datos proporcionados a la institución son veraces, sin omisiones ni falsedades de ningún tipo, el Gobierno Autónomo Municipal de Colcapirhua se exime de cualquier conflicto de derecho propietario, por lo que el presente proceso de regularización tiene carácter estrictamente ADMINISTRATIVO, mismo que circunscribe al objeto (lote), no así al sujeto (poseedor), en consecuencia, la presente Resolución Administrativa Municipal y plano aprobado NO OTORGA, NI DECLARA EL DERECHO PROPIETARIO DEL INMUEBLE.';
            $conclusion5 = '<b>CUARTO.-</b>La Dirección de Urbanismo y Catastro queda encargada del cumplimiento de la presente resolución, con la cooperación y coordinación directa de las Direcciones, Jefaturas y demás unidades con competencia en el tratamiento técnico, administrativo y legal del GAMC, debiendo aplicar los procedimientos, procesos administrativos y/o procesos sancionadores que correspondan conforme al caso, y los previstos por la Ley Municipal N° 442/2024 de “CONSOLIDACIÓN, PLANIFICACIÓN, REGULARIZACIÓN TÉCNICA Y ADMINISTRATIVA Y TRATAMIENTO ESPECIAL DE ZONAS LIMÍTROFES DE LA JURISDICCIÓN DEL GOBIERNO AUTÓNOMO MUNICIPAL DE COLCAPIRHUA”, Decreto Municipal Reglamentario N° 004/2024 de 01/03/2024, y demás normativa vigente y conexa que rige la materia.';
            $conclusion6 = '<b>REGÍSTRESE, NOTIFÍQUESE, CÚMPLASE</b>; debiendo remitirse las copias a quiénes corresponda para el trámite ulterior respectivo y/o su archivo.';
            
            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->writeHTMLCell(180, 0, '', '', $detailtext1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText7, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->writeHTMLCell(180, 0, '', '', $detailtext3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            
            
            $pdf->AddPage();
        } elseif ($dataSource->getParameter('nombre_tramite') == "Plano de Lote") {
            $titleText1 = '<b>RESOLUCIÓN MUNICIPAL<br>TÉCNICO ADMINISTRATIVA Nº 000896/2025</b>';
            $referenceText0 = 'A, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS: </b>';
            $detailtext0 = 'La solicitud adjunta presentada para la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'<br>CONSIDERANDO:</b>';
            $bodyText0 = '<b>Que</b>, mediante memorial presentado en fecha 25 de septiembre de 2025  adjunta documentación que acredita su derecho propietario presentada por el Señor(es) <b>'.$propName.'</b> por lo que solicita la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>';
            $bodyText1 = '<b>Que</b>, según el <b>Informe Técnico Topográfico '.$dataSource->getParameter('num_informeTop').'/2025</b> de fecha '.$dataSource->getParameter('fecha_regTop').', elaborado por top. '.$dataSource->getParameter('desc_funcionario1Top').' como Topógrafo I de la Dirección de  Urbanismo y Catastro; el predio objeto del presente trámite se encuentra ubicado en la Zona '.$dataSource->getParameter('zonaTop').', Distrito '.$dataSource->getParameter('distritoTop').'. Manzana '.$dataSource->getParameter('manzanaTop').', Lote '.$dataSource->getParameter('lote').', '.$dataSource->getParameter('calleTop').' de 10.00 m., según Informe topográfico si se encuentra en rasante Concluye recomendando dar continuidad al trámite administrativo';
            $bodyText2 = '<b>Que</b>, según <b>Informe Legal Nº '.$dataSource->getParameter('num_informeLegal').'/2025</b> de fecha 14 de octubre de 2025 emitido por la Lic. '.$dataSource->getParameter('desc_funcionario1Legal').', como <b>Abogado II de la Dirección de Urbanismo y Catastro</b> quien refiere que el trámite ha cumplido con los requisitos legales, por lo que recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b> que de acuerdo a la documentación presentada por el Señor(es) <b>'.$propName.'</b> quien es propietario de un predio de Sup.'.$dataSource->getParameter('superficie').' m2, debidamente registrado en Derechos Reales  bajo Matricula Computarizada <b>Nº '.$dataSource->getParameter('nro_matricula').'</b> Asiento A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').', conforme Testimonio Nº '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgado ante Notario de Fe Publica Nº '.$dataSource->getParameter('nro_notario').', Dr. '.$dataSource->getParameter('nombre_notario').' (Escritura Pública de transferencia de un lote de terreno),cumple con los requisitos.';
            $bodyText3 = '<b>Que</b>, según el <b>Informe Técnico de Urbanismo</b> de fecha 11 de  noviembre de 2025 suscrito por el Arq. '.$dataSource->getParameter('desc_funcionario1Arq').' como Arquitecto III de la Dirección de Urbanismo y Catastro   quien manifiesta  que  de acuerdo al informe topográfico e informe legal correspondiente y previa verificación de los requisitos establecidos en la normativa aplicable al caso, el trámite cumple las disposiciones del Reglamento <b>PLANUR</b> por lo que, recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>.';
            $bodyText4 = 'Que, el predio cuenta con plano de Regularización y Fraccionamiento  de lote  aprobado con  RMTA. Nº '.$dataSource->getParameter('nro_rmtaArq').'/2018 de fecha '.$dataSource->getParameter('fecha_rmtaArq').' y que en virtud al artículo 133 del Reglamento para urbanizaciones y edificaciones PLANUR, en concordancia y aplicación del inciso b Articulo 48 c del Reglamento General de Urbanización y Subdivisión de propiedades Urbanas aprobado por O.M. 1061/1991 se encuentra exento del pago  de cesiones';
            $bodyText5 = '<b>Que</b>, según la boleta de liquidación <b>Nº '.$dataSource->getParameter('nro_liquidacionBol').'</b> suscrito por el Arq. '.$dataSource->getParameter('desc_funcionario1Arq').' como Arquitecto III de la Dirección de Urbanismo y Catastro  y comprobante  de pago <b>Nº '.$dataSource->getParameter('comp_pagoBol').'</b> expedido por la Dirección de Finanzas se acredita el pago de Bs.- '.$dataSource->getParameter('montoBol').'.- ('.$dataSource->getParameter('nombre_completo1Bol').' 00/100 Bolivianos) en fecha '.$dataSource->getParameter('fecha_pagoBol').' por concepto de la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b> (Expediente Nº '.$dataSource->getParameter('expedienteBol').')';
            $bodyText6 = '<b>Que</b>, en el presente caso, se han cumplido con los requisitos técnicos y administrativos exigidos por el Gobierno Autónomo Municipal de Colcapirhua, por lo que, corresponde dar curso a lo impetrado.';
            $detailtext1 = '<b>POR TANTO:</b>';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme designación por Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = '<b>RESUELVE</b>';
            $conclusion2 = '<b>PRIMERO.-</b> <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'<b>; del inmueble de propiedad del Señor(es) <b>'.$propName.'</b> de acuerdo al siguiente detalle:';
            $detailtext2 = '<b>DATOS DE UBICACIÓN:</b>';
            $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;"><tbody>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Municipio: Colcapirhua</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Zona: '.$dataSource->getParameter('zonaOT').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Distrito: '.$dataSource->getParameter('distritoTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Lote: '.$dataSource->getParameter('lote').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Manzano: '.$dataSource->getParameter('manzanaTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('calleOT').'</td>
                        </tr>
                    </tbody>
                </table>';
            $detailtext3 = '<b>RELACIÓN DE SUPERFICIES:</b>';
            $table1 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN MENSURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE  TOTAL ÚTIL</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LONGITUD DE RASANTE</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                        </tbody>
                    </table>';
            $detailtext4 = '<b>COLINDANCIAS GENERALES:</b>';
            $table3 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td>
                            </tr>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td>
                            </tr>
                        </tbody>
                        </table>';
            $conclusion3 = '<b>SEGUNDO.-</b> Conforme el <b>Art. 71 de la Ley 2492 del Nuevo Código Tributario</b> en su Parágrafo I). Establece: Toda persona natural o jurídica de derecho Público o Privado, sin costo alguno, está obligada a proporcionar a la Administración Tributaria Toda clase de datos, informes o antecedentes con efectos tributarios, emergentes de sus relaciones económicas, profesionales o financieras con otras personas, cuando fuere requerido expresamente por la Administración Tributaria.';
            $conclusion4 = '<b>TERCERO.-</b> La presente Resolución Municipal Técnica Administrativa no define, ni declara derecho propietario sobre el predio, solo determina la situación física y la ubicación proporcionada por el impetrante, enmarcado en el principio de buena fe de los datos proporcionados por la parte declarante siendo único y exclusivo responsable, deslindando y exonerando de cualquier responsabilidad futura al Gobierno Autónomo Municipal de Colcapirhua.';
            $conclusion5 = '<b>CUARTO.-</b> La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los Reglamentos y Normas vigentes, aplicar sanciones pecuniarias al propietario en caso que las infrinja o que modifique el proyecto aprobado con la presente Resolución Municipal Técnico Administrativa';
            $conclusion6 = 'Comuníquese a quien corresponda con copia para archivo respectivo';

            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->writeHTMLCell(180, 0, '', '', $detailtext1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

        } elseif ($dataSource->getParameter('nombre_tramite') == "Plano Técnico de Ubicación de Lote (A.P.A.U.)") {
            $titleText1 = '<b>RESOLUCIÓN MUNICIPAL<br>TÉCNICO ADMINISTRATIVA Nº '.$dataSource->getParameter('num_resolucion').'/2025</b>';
            $referenceText0 = 'A, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS: </b>';
            $detailtext0 = 'La solicitud adjunta presentada para la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'<br>CONSIDERANDO:</b>';
            
            $bodyText0 = '<b>Que</b>, mediante memorial presentado en fecha 25 de agosto de 2023 adjunta documentación que acredita su derecho propietario presentada por el Señor(es) <b>'.$propName.'</b> quien solicita la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>, en su superficie total de '.$dataSource->getParameter('superficieLot').' m2';
            $bodyText1 = '<b>Que</b>, según informe técnico <b>'.$dataSource->getParameter('num_informeOT').'</b> de fecha '.$dataSource->getParameter('fecha_regOT').' emitido por la Lic. '.$dataSource->getParameter('desc_funcionario1OT').' en calidad de Responsable de Ordenamiento Territorial, refiere que de acuerdo a la ubicación del predio en la homologación de Area Urbana del Centro Poblado de Colcapirhua, este se encuentra en el Area Productiva Agropecuaria Urbana, respetando la proyección de vías realizadas por unidad de ordenamiento territorial, vías proyectadas en el área urbana '.$dataSource->getParameter('calleOT').' de 10.00 mts. Y '.$dataSource->getParameter('avenidaOT').' de 10.00 mts. de perfil de vía hasta cuando se realice el cambio de uso de suelo por lo que el predio no podrá sufrir subdivisión, ni realizar cesiones mientras se encuentre en el área productiva agropecuaria urbana, por lo que recomienda a la Dirección de Urbanismo la prosecución del tramite';
            $bodyText2 = '<b>Que</b>, según el <b>Informe Técnico Topográfico N° '.$dataSource->getParameter('num_informeTop').'/2025<b> de fecha '.$dataSource->getParameter('fecha_regTop').' elaborado por la Top. '.$dataSource->getParameter('desc_funcionario1Top').' como Topógrafo de la Dirección de Urbanismo y Catastro; el predio objeto del presente trámite se encuentra ubicado en la Colcapirhua, Distrito '.$dataSource->getParameter('distritoTop').', Manzana '.$dataSource->getParameter('manzanaTop').'-A.P.A.U., Lote I, '.$dataSource->getParameter('calleTop').' de 10.00 mts., '.$dataSource->getParameter('avenidaTop').' de 10.00 mts., conforme informe fotográfico no se encuentra en rasante municipal, Concluye recomendando dar continuidad al trámite administrativo';  
            $bodyText3 = '<b>Que</b>, según <b>Informe Legal N° '.$dataSource->getParameter('num_informeLegal').'</b> de fecha '.$dataSource->getParameter('fecha_regLegal').' emitido por la Abg. '.$dataSource->getParameter('desc_funcionario1Legal').', como <b>Abogado II de la Dirección de Urbanismo y Catastro</b>, quien refiere que el trámite ha cumplido con los requisitos legales, por lo que recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>, y que de acuerdo a la documentación presentada por el señor(es) <b>'.$propName.'</b> quien acredita ser propietario de un predio de <b>Sup. '.$dataSource->getParameter('superficie').' m2</b>, Zona Colcapirhua, Distrito A, Manzana 0438-A.P.A.U., con registro en Derechos Reales bajo Matricula '.$dataSource->getParameter('nro_matricula').' asiento A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').' registrado en oficinas de derechos Reales, conforme escritura Pública de fecha 10 de octubre de 1996, emitido por Notaria de Fe pública; Saúl Farfan, testimonio Nº '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgado ante Notaria de Fe Publica Nº '.$dataSource->getParameter('nro_notario').' '.$dataSource->getParameter('nombre_notario').', Dando cumplimiento a lo que se establece el Decreto Supremo Nª 5056 de fecha 22 de noviembre de 2023.';
            $bodyText4 = '<b>Que</b>, según el <b>Informe Técnico de Urbanismo</b> de fecha '.$dataSource->getParameter('fecha_regArq').', suscrito por la Arq. '.$dataSource->getParameter('desc_funcionario1Arq').', como Arquitecta III de la Dirección de Urbanismo y Catastro, quien manifiesta que de acuerdo al informe topográfico e informe legal correspondiente y previa verificación de los requisitos establecidos en la norma aplicable al caso, el tramite cumple las dispersiones establecidas PLANUR por lo que, recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>';
            $bodyText5 = '<b>Que</b>, según la boleta de liquidación Nº '.$dataSource->getParameter('nro_liquidacionBol').' suscrito por el Arq. '.$dataSource->getParameter('desc_funcionario1Arq').', como Arquitecta II de la Dirección de Urbanismo y Catastro, comprobante de pago  Nº '.$dataSource->getParameter('comp_pagoBol').', expedido por la Dirección de Finanzas se acredita el pago de Bs.- '.$dataSource->getParameter('montoBol').' ('.$dataSource->getParameter('nombre_completo1Bol').' 00/100 Bolivianos) en fecha '.$dataSource->getParameter('fecha_pagoBol').' por concepto de la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b> (Expediente '.$dataSource->getParameter('expedienteBol').')';
            $detailtext1 = '<b>CONSIDERANDO II:</b>';
            $bodyText6 = '<b>Que</b>, la Administración Pública debe buscar que sus actos se efectivicen y logren su finalidad, en el caso en concreto, ampliando lo favorable y considerando los principios de verdad material, eficacia, economía, simplicidad y celeridad previsto por el artículo 4 de !a Ley N° 2341 de Procedimiento  Administrativo que consta en los incisos d) Principio de verdad material: La Administración Pública investigará la verdad material en oposición a la verdad formal que rige el procedimiento civil; j) Principio de eficacia: Todo procedimiento administrativo debe lograr su finalidad, evitando dilaciones indebidas; e inciso k) Principio de economía, simplicidad y celeridad: Los procedimientos administrativos se desarrollarán con economía, simplicidad y celeridad, evitando la realización de trámites, formalismos o diligencias innecesarias”, corresponde formalizar un hecho verificable, mediante pericia técnica como es la mensura, con el acto Administrativo correspondiente, siempre y cuando, no afectan derechos particulares ni de la entidad pública.';
            $bodyText7 = '<b>Que</b>, el Art. 55 del D.S. 27113, Reglamento a la Ley 2341 prevé lo siguiente: “Artículo 55°.- (Nulidad de procedimientos) Será procedente la revocación de un acto anulable por vicios de procedimiento, únicamente cuando el vicio ocasione indefensión de los administrados o lesione el interés público. La autoridad administrativa, para evitar nulidades de actos administrativos definitivos o actos equivalentes, de oficio o a petición de parte, en cualquier estado del procedimiento, dispondrá la nulidad de obrados hasta el vicio más antiguo o adoptará las medidas más convenientes para corregir los defectos u omisiones observadas.”';
            $bodyText8 = '<b>Que</b>, el Art. 7 de la Ley 247 señala en el numeral 2) lo siguiente: “2. Correcciones e Inscripciones Técnicas. Las correcciones técnicas de superficie, ubicación y colindancias procederán mediante subinscripción de una escritura pública de aclaración unilateral, respaldada por una Resolución Técnica Administrativa Municipal, certificado catastral u otro documento emitido por la autoridad competente del Municipio en coordinación con Derechos Reales.”';
            $bodyText9 = '<b>Que</b>, en el marco de la Ley Nº 144 de 26 de Junio de 2011 Art. 14, Decreto Supremo 1809 de 27 de Noviembre de 2013, y Decreto Supremo Nº 2960 de 26 de octubre de 2016 Art. 2 y Art. 3. Las Área productivas agropecuarias urbanas no podrán ser objeto de cambio de uso de suelo ni urbanizadas manteniendo este uso por al menos diez(10)años, a partir de su delimitación.';
            $bodyText10 = '<b>Que</b>, mediante Decreto Supremo 5065 de fecha 22 de noviembre de 2022 refiere en su artículo único:  A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberanía, se modifica el Parágrafo I del Artículo 3 del Decreto Supremo Nº 1809, de 27 de noviembre de 2013, con el siguiente texto:';
            $bodyText11 = '<b>I.</b> Las áreas productivas agropecuarias urbanas no podrán ser objeto de cambio de uso de suelo ni urbanizadas en un plazo de quince (15) años, a partir de la publicación del presente Decreto Supremo."';
            $bodyText12 = '<b>Que</b>, la Ley Municipal Nº 147, de 06 de febrero de 2018, Art. 4 “Homologación”: El Alcalde Municipal queda encargado de tramitar la homologación del área urbana aprobada mediante la presente Ley Municipal, ante la instancia correspondiente del Nivel Central del Estado, conforme los Plazos establecidos.';
            $bodyText13 = '<b>Que</b>, de acuerdo a la Homologación de la Mancha Urbana en virtud a la Resolución Ministerial N° 100/2018, que señala que los predios que se encuentren en el sector de Area productiva Agropecuaria no podrán sufrir subdivisión, ni serán afectados con los porcentajes de cesión; con los que deberán cumplir cuando se encuentren en Zona Urbana; por lo que en el caso presente corresponde emitir la presente Resolución para la Aprobación de Plano de Lote en Área Productiva Agropecuaria Urbana.';
            $detailtext2 = '<b>POR TANTO:</b>';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme a la Designación establecida por el Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = '<b>RESUELVE</b>';
            $conclusion2 = '<b>PRIMERO.-</b> <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>; del bien inmueble de propiedad del Señor(es) <b>'.$propName.'</b> de acuerdo al siguiente detalle:';
            $detailtext3 = '<b>DATOS DE UBICACIÓN:</b>';
            $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;"><tbody>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Municipio: Colcapirhua</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Zona: '.$dataSource->getParameter('zonaOT').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Distrito: '.$dataSource->getParameter('distritoTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Lote: '.$dataSource->getParameter('lote').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Manzano: '.$dataSource->getParameter('manzanaTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('calleOT').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;"></td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">'.$dataSource->getParameter('avenidaOT').'</td>
                        </tr>
                    </tbody>
                </table>';
            $detailtext4 = '<b>RELACIÓN DE SUPERFICIES</b>';
            $table1 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN MENSURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE TOTAL</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                        </tbody>
                    </table>';
            $detailtext5 = '<b>COLINDANCIAS GENERALES:</b>';
            $table2 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td>
                            </tr>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td>
                            </tr>
                        </tbody>
                        </table>';
            $conclusion3 = '<b>SEGUNDO.-</b> La aprobación de plano de Lote en Área Productiva de ninguna manera supone ajustar el predio al proceso de Urbanización NI CAMBIO DE USO DEL SUELO, si bien el inmueble está contemplado dentro el Área PRODUCTIVO AGROPECUARIO formando parte del Área urbana; una vez cumplido el plazo señalado según normativa vigente y efectuado lo dispuesto por el Decreto Supremo 5065 de 22 de noviembre de 2022 se interponga el correspondiente tramite de urbanización en forma posterior, debe mantener la superficie según escritura con cargo a Urbanización y Cesiones Obligatorias.';
            $conclusion4 = '<b>TERCERO.-</b> La presente Resolución Municipal Técnica Administrativa no define, ni declara derecho propietario sobre el predio, solo determina la situación física y la ubicación proporcionada por el impetrante, enmarcado en el principio de buena fe de los datos proporcionados por la parte declarante siendo único y exclusivo responsable, deslindando y exonerando de cualquier responsabilidad futura al Gobierno Autónomo Municipal de Colcapirhua.';
            $conclusion5 = '<b>CUARTO.-</b> La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los Reglamentos y Normas vigentes, aplicar sanciones pecuniarias al propietario en caso que las infrinja o que modifique el proyecto aprobado con la presente Resolución Municipal Técnico Administrativa';
            $conclusion6 = 'Comuníquese a quien corresponda con copia para archivo respectivo.';

            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText7, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText8, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText9, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText10, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText11, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText12, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText13, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->AddPage();

        } elseif ($dataSource->getParameter('nombre_tramite') == "Plano de Regularización de Lote" && 0 != 0) {
            $titleText1 = '<b>RESOLUCIÓN MUNICIPAL<br>TÉCNICO ADMINISTRATIVA Nº '.$dataSource->getParameter('num_resolucion').'/2025</b>';
            $referenceText0 = 'A, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS: </b>';
            $detailtext0 = 'La solicitud adjunta presentada para la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'<br>CONSIDERANDO:</b>';

            $bodyText0 = '<b>Que</b>, mediante memorial presentado en fecha 22 de septiembre de 2025 adjunta documentación que acredita su derecho propietario presentada por los Señor(es) <b>'.$propName.'</b> por lo que solicita la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>';
            $bodyText1 = '<b>Que</b>, según el <b>Informe Técnico Topográfico '.$dataSource->getParameter('num_informeTop').' de fecha '.$dataSource->getParameter('fecha_regTop').'</b>, elaborado por la Ing. '.$dataSource->getParameter('desc_funcionario1Top').', como Topógrafo de la Dirección de Urbanismo y Catastro; el predio objeto del presente trámite se encuentra ubicado en la Zona '.$dataSource->getParameter('zonaTop').', Distrito '.$dataSource->getParameter('distritoTop').', Manzano '.$dataSource->getParameter('manzanaTop').', '.$dataSource->getParameter('calleTop').' de 10.00 m, si se encuentra en rasante Municipal Concluye recomendando dar continuidad al trámite administrativo.';
            $bodyText2 = '<b>Que</b>, según <b>Informe Legal Nº '.$dataSource->getParameter('num_informeLegal').'</b> de fecha '.$dataSource->getParameter('fecha_regLegal').' emitido por la Lic. '.$dataSource->getParameter('desc_funcionario1Legal').', como <b>Abogado II de la Dirección de Urbanismo y Catastro</b> quien refiere que el trámite ha cumplido con los requisitos legales, por lo que recomienda dar curso a la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b> que de acuerdo a la documentación presentada por los Señor(es) <b>'.$propName.'</b> quienes son propietarios de un predio de Sup. <b>'.$dataSource->getParameter('superficie').' m2</b>, debidamente registrado en Derechos Reales bajo Matricula Computarizada Nº <b>'.$dataSource->getParameter('nro_matricula').'</b> Asiento A-'.$dataSource->getParameter('asiento').' de fecha '.$dataSource->getParameter('fecha_asiento').', Según Testimonio Nº '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').' emitido por la Notaria de Fe Publica Nº '.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').' (Escritura Pública de Transferencia de un Inmueble).';
            $bodyText3 = '<b>Que</b>, cuenta con Plano  de lote aprobado  con R.M.T.A. Nº '.$dataSource->getParameter('nro_rmtaArq').' de '.$dataSource->getParameter('fecha_rmtaArq').' y que en virtud al artículo 133 del Reglamento para urbanizaciones y edificaciones PLANUR, en concordancia y aplicación del inciso b Articulo 48 c del Reglamento General de Urbanización y Subdivisión de propiedades Urbanas aprobado por O.M. 1061/1991 se encuentra exento del pago  de cesiones.';
            $bodyText4 = '<b>Que</b>, según la boleta de liquidación <b>Nº '.$dataSource->getParameter('nro_liquidacionBol').'</b> suscrito por el Arq. '.$dataSource->getParameter('desc_funcionario1Arq').' como Arquitecto II de la Dirección de Urbanismo y Catastro  y comprobante de pago <b>Nº '.$dataSource->getParameter('comp_pagoBol').'</b> expedido por la Dirección de Finanzas se acredita el pago de <b>Bs.- '.$dataSource->getParameter('montoBol').'</b>- ('.$dataSource->getParameter('nombre_completo1Bol').' 00/100 Bolivianos) en fecha '.$dataSource->getParameter('fecha_pagoBol').' por concepto de la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>  (Expediente Nº '.$dataSource->getParameter('expedienteBol').').';
            $bodyText5 = '<b>Que</b>, en el presente caso, se han cumplido con los requisitos técnicos y administrativos exigidos por el Gobierno Autónomo Municipal de Colcapirhua, por lo que, corresponde dar curso a lo impetrado.';
            $detailtext1 = '<b>POR TANTO:</b>';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme designación por Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = '<b>RESUELVE</b>';
            $conclusion2 = '<b>PRIMERO.-</b> <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>; del inmueble de propiedad de los Señor(es) <b>'.$propName.'</b> de acuerdo al siguiente detalle:';
            $detailtext2 = '<b>DATOS DE UBICACIÓN:</b>';
            $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;"><tbody>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Municipio: Colcapirhua</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Zona: '.$dataSource->getParameter('zonaOT').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Distrito: '.$dataSource->getParameter('distritoTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Lote: '.$dataSource->getParameter('lote').'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Manzano: '.$dataSource->getParameter('manzanaTop').'</td>
                            <td style="width: 50%; padding: 5px; text-align: left; vertical-align: middle;">Calle: '.$dataSource->getParameter('calleOT').'</td>
                        </tr>
                    </tbody>
                </table>';
            $detailtext3 = '<b>RELACIÓN DE SUPERFICIES:</b>';
            $table1 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN ESCRITURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('superficieLot').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE SEGÚN MENSURA</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">SUPERFICIE  TOTAL ÚTIL</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                            <tr>
                                <td style="width: 65%; padding: 5px; text-align: right; vertical-align: middle;">LONGITUD DE RASANTE</td>
                                <td style="width: 20%; padding: 5px; text-align: center; vertical-align: middle;">'.$dataSource->getParameter('zonaOT').'</td>
                                <td style="width: 15%; padding: 5px; text-align: center; vertical-align: middle;">m2</td>
                            </tr>
                        </tbody>
                    </table>';
            $detailtext4 = '<b>COLINDANCIAS GENERALES:</b>';
            $table2 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Norte: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Sud:</td>
                            </tr>
                            <tr>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Este: </td>
                                <td style="width: 50%; padding: 5px; text-align: center; vertical-align: middle;">Oeste:</td>
                            </tr>
                        </tbody>
                        </table>';
            $conclusion3 = '<b>SEGUNDO.-</b> Conforme el Art. 71 de la Ley 2492 del Nuevo Código Tributario en su Parágrafo I). Establece: Toda persona natural o jurídica de derecho Público o Privado, sin costo alguno, está obligada a proporcionar a la Administración Tributaria Toda clase de datos, informes o antecedentes con efectos tributarios, emergentes de sus relaciones económicas, profesionales o financieras con otras personas, cuando fuere requerido expresamente por la Administración Tributaria';
            $conclusion4 = '<b>TERCERO.-</b> La presente Resolución Municipal Técnica Administrativa no define, ni declara derecho propietario sobre el predio, solo determina la situación física y la ubicación proporcionada por el impetrante, enmarcado en el principio de buena fe de los datos proporcionados por la parte declarante siendo único y exclusivo responsable, deslindando y exonerando de cualquier responsabilidad futura al Gobierno Autónomo Municipal de Colcapirhua.';
            $conclusion5 = '<b>CUARTO.-</b> La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los Reglamentos y Normas vigentes, aplicar sanciones pecuniarias al propietario en caso que las infrinja o que modifique el proyecto aprobado con la presente Resolución Municipal Técnico Administrativa.';
            $conclusion6 = 'Comuníquese a quien corresponda con copia para archivo respectivo.';

            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $table2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->AddPage();
        } elseif ($dataSource->getParameter('nombre_tramite') == "Vivienda Multifamiliar Comercio") {
            $titleText1 = '<b>RESOLUCIÓN MUNICIPAL<br>TÉCNICO ADMINISTRATIVA DE RECHAZO<br>Nº '.$dataSource->getParameter('num_resolucion').'/2025</b>';
            $referenceText0 = 'A, '.$dataSource->getParameter('dia_resolucion').' de '.$dataSource->getParameter('mes_resolucion').' de '.$dataSource->getParameter('anio_resolucion').'<br><b>VISTOS: </b>';
            $detailtext0 = '<b>CONSIDERANDO:</b>';	
            $bodyText0 = '<b>Que</b>, mediante memorial presentado en fecha  15 de enero de 2025 adjuntan documentación que acredita su derecho propietario los Sr(es). <b>'.$propName.'</b> por lo que solicitan la <b style="text-transform: uppercase;">APROBACION DE '.$dataSource->getParameter('nombre_tramite').'</b>';
            $bodyText1 = '<b>Que</b>, mediante Pronunciamiento Técnico de fecha 5 de febrero de 2025 elaborado por la Arq. '.$dataSource->getParameter('desc_funcionario1Arq').' como Arquitecto I de la Dirección de Urbanismo y Catastro refiere que de acuerdo la revisión de sus planos de construcción se evidencia que el mismo ya se encuentra en proceso de construcción infringiendo los artículos 96. 107 y 102 del PLANUR';
            $bodyText2 = '<b>Que</b>, el artículo 96 del PLANUR establece que todo proyecto urbano o arquitectónico que no cumpla con lo establecido en el presente reglamento será rechazado y ninguna autoridad del órgano ejecutivo y deliberante podrá ignorar la aplicación de las normas técnicas, administrativas, legales y económicas.';
            $bodyText3 = '<b>Que</b>, el artículo 107 del PLNUR refiere que para iniciar la construcción de una edificación de cualquier naturaleza es necesario contar con el respectivo plano arquitectónico aprobado por la alcaldía de Colcapirhua, no siendo suficiente que el trámite se encuentre en curso de aprobación.';
            $bodyText4 = '<b>Que</b>, el artículo 112 refiere que se considera infracción a construir cualquier edificación sin contar previamente con plano aprobado por la Alcaldía. del lote o del proyecto arquitectónico.';
            $bodyText5 = '<b>Que</b>, mediante informe legal N° '.$dataSource->getParameter('num_informeLegal').' de fecha '.$dataSource->getParameter('fecha_regLegal').' emitida por la Lic. '.$dataSource->getParameter('desc_funcionario1Legal').' como Abogada II de la Dirección de Urbanismo y Catastro refiere que se puede observar que la construcción multifamiliar comercio se encuentra infringiendo a la norma vigente por lo que no corresponde a la prosecución del trámite recomendando efectuar la Resolución de Rechazo del trámite';
            $bodyText6 = '<b>Que</b>, en el presente caso, no se han cumplido con la normativa técnica y administrativa exigidos por el Gobierno Autónomo Municipal de Colcapirhua, por lo que, no corresponde dar curso a lo impetrado.';
            $detailtext1 = '<b>POR TANTO:</b>';
            $conclusion1 = 'El Secretario Municipal de Planificación del Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua, conforme designación por Decreto Edil Nº 09/2023 de fecha 04 de Mayo de 2023 y en uso de las legítimas atribuciones que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales:';
            $titleText2 = '<b>RESUELVE<b>';
            $conclusion2 = '<b>PRIMERO.-</b> RECHAZAR LA '.$dataSource->getParameter('nombre_tramite').' de los Sr(es). '.$propName.'</b> por no cumplir con normativa técnica y administrativa para su aprobación.';
            $conclusion3 = '<b>SEGUNDO.-</b> La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los Reglamentos y Normas vigentes, asimismo aplicar sanciones o iniciar el proceso administrativo si corresponde por incumplimiento al reglamento interno de personal del Gobierno Autónomo Municipal de Colcapirhua.';
            $conclusion4 = 'Comuníquese a quien corresponda con copia para archivo respectivo.';

            $pdf->writeHTMLCell(180, 0, '', '', $titleText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $referenceText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText0, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText5, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $bodyText6, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $detailtext1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion1, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $titleText2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion2, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion3, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', $conclusion4, 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

            $pdf->AddPage();
        }

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Output($fileName, 'F');
    }
}

?>