<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';
//require_once dirname(__FILE__) . '/../../lib/tcpdf/tcpdf.php';
//ini_set('display_errors', 'On');

class CustomReport extends TCPDF {
    private $dataSource;
    public function setDataSource(DataSource $dataSource) {
        $this->dataSource = $dataSource;
    }

    public function getDataSource() {
        return $this->dataSource;
    }

    /*
    public function Header() {
        $dataSource = $this->getDataSource();
        $height = 6;
        $midHeight = 9;
        $longHeight = 18;

        $x = $this->GetX();
        $y = $this->GetY();

        // ESTO ES LO QUE FALTA:
        $this->SetX(15); // Forzamos el cursor al margen izquierdo para el contenido
        $this->SetY(45); // Forzamos el cursor debajo del header
        
        $this->SetXY($x, $y);

        $this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], 16, 12, 36);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFontSize(16);
        $this->SetFont('', 'B');
        
        $this->Cell(180, $longHeight, ' INFORME LEGAL', ' ', 0, 'R', false, '', 0, false, 'T', 'C');
        $this->Ln(5);
        $this->SetFontSize(12);
        $this->Cell(180, $longHeight, $dataSource->getParameter('num_informe'), 'B', 0, 'R', false, '', 0, false, 'T', 'C');
        $x = $this->GetX();
        $y = $this->GetY();
    }
    */

    public function Header() {
        $dataSource = $this->getDataSource();
        $longHeight = 18;

        // 1. Posición inicial FIJA para los elementos del Header
        $this->SetXY(15, 10);

        // 2. Imagen (Logo)
        $logo = dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'];
        if (file_exists($logo)) {
            $this->Image($logo, 16, 12, 36);
        }

        // 3. Título del Informe
        $this->SetFontSize(16);
        $this->SetFont('', 'B');
        // Usamos ln=1 para que el siguiente elemento baje automáticamente
        $this->Cell(180, $longHeight, ' INFORME LEGAL', 0, 1, 'R');

        // 4. Número de Informe (con línea abajo 'B')
        $this->SetX(15); // Regresamos al margen izquierdo para la celda de 180
        $this->SetFontSize(12);
        // Ajustamos la altura a 10 para que no sea tan gigante como el título
        $this->Cell(180, 10, $dataSource->getParameter('num_informe'), 'B', 1, 'R');

        // 5. EL TRUCO FINAL: Dejar el cursor listo para el contenido
        // Esto asegura que cuando empiece el texto (Antecedentes, Conclusiones),
        // empiece exactamente a los 45mm de altura, libre del header.
        $this->SetXY(15, 45); 
    }

    public function Footer() {
        $dataSource = $this->getDataSource();
        
        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 6);
        $this->Cell(180, 0, 'usuario: '.$dataSource->getParameter('de'), 0, 1, 'L');
        $this->Cell(180, 10, 'Pagina: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $html = 'Numero Tramite: '.$dataSource->getParameter('num_informe')."\n".'Tramite: '.$dataSource->getParameter('nombre_tramite')."\n".'Usuario: '.$dataSource->getParameter('de')."\n".'Sistema de Tramites ';
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        
        // $this->write2DBarcode($html, 'QRCODE,M', 170, $this->GetY() - 10, 30, 30, $style, 'N');
        // CORRECCIÓN SUGERIDA:
        // En lugar de restar al GetY (que es impredecible), usa una posición fija 
        // relativa al final de la página (ej. a 35mm del borde inferior)
        $y_fija = $this->GetPageHeight() - 35;

        $this->write2DBarcode($html, 'QRCODE,M', 170, $y_fija, 30, 30, $style, 'N');

    } 

}

Class RInformeLegal extends Report {
    function write($fileName) {
        $propietariosList = "";
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();
        // set document information
        $pdf->SetCreator(PDF_CREATOR);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(15, 45, 15); // 45mm arriba para no pisar el Header
        //$pdf->SetHeaderMargin(8);
        $pdf->SetHeaderMargin(10);    // Donde inicia el logo
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetFooterMargin(40);    // Espacio reservado para el Footer/QR

        //set auto page breaks
        // Forzar el salto de página automático a los 40mm del final
        $pdf->SetAutoPageBreak(TRUE, 40);
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Crea la pagina para mostrar los totales de los almacenes.
        //$pdf->AddPage('P', array(215.9, 330));
        // RECIÉN AQUÍ CREAS LA PÁGINA
        $pdf->AddPage('P', array(215.9, 330));

        $hGlobal = 5;
        $hMedium = 7.5;
        $hLong = 15;
        
				
		$pdf->SetFontSize(10);
		$pdf->SetFont('', 'B');
        $pdf->Cell($w = 15, $h = $hMedium, $txt = 'A: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->SetFont('', 'N');
		$pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('nombrea'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(4);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 15, $h = $hMedium, $txt = '   ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
		$pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('cargoa'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(5);           
        $pdf->SetFont('', 'B');             
	    $pdf->Cell($w = 15, $h = $hMedium, $txt = 'Via: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->SetFont('', 'N');
        $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('via'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(4);
        $pdf->SetFont('', 'B');
	    $pdf->Cell($w = 15, $h = $hMedium, $txt = '    ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	  
        $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('cargovia'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 15, $h = $hMedium, $txt = 'De: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->SetFont('', 'N');
        $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('de'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(4);
        $pdf->SetFont('', 'B');
	    $pdf->Cell($w = 15, $h = $hMedium, $txt = '    ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	  
        $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('cargode'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 15, $h = $hMedium, $txt = 'Fecha: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->SetFont('', 'N');
        $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Colcapirhua, '.$dataSource->getParameter('dia').' de '.$dataSource->getParameter('mes').' de '.$dataSource->getParameter('anio'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B');
	    $pdf->Cell($w = 180, $h = $hMedium, $txt = 'REF:       '.strtoupper($dataSource->getParameter('referencia')), 'B', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
		$pdf->Ln(8);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 63, $h = $hMedium, $txt = 'ANTECEDENTES ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(8);
        $pdf->SetFont('', 'N');
        $pdf->Cell($w = 63, $h = $hMedium, $txt = 'De mi consideración: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(8);
        $pdf->MultiCell(180, $h = $hMedium, 'Conforme a la documentación presentada por:', 0, 'L', 0, 0, '', '', true);
        $pdf->Ln(5);
        $count = 0;
        foreach ($dataSource->getDataSet() as $row) {
            $tipo_persona = $row['tipo_persona'];
            //var_dump("tipo: ",$tipo_persona); 
            if ( $tipo_persona == "propietario"){
                if ($count == 0) {
                    $propietariosList = $row['nombre_completo1'];
                } else {
                    $propietariosList .= "|".$row['nombre_completo1'];
                } 

                $count++;
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->SetFont('', 'N');
	            $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->Ln();
            }                
        }
            
        $pdf->SetFont('', 'N');
        $pdf->MultiCell(180, $h = $hMedium, 'Es propietario de un lote de terreno ubicado, según FOLIO REAL (Registrado en Derechos Reales, SEGÚN LOS SIGUIENTES DATOS: ', 0, 'J', 0, 0, '', '', true);
        $pdf->Ln(9);
            
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Provincia: Quillacollo', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Sección: Quinta', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Municipio: Colcapirhua ', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Zona: '.$dataSource->getParameter('zona'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Distrito: '.$dataSource->getParameter('distrito'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Manzano: '.$dataSource->getParameter('manzana'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Lote: '.$dataSource->getParameter('lote'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Superficie: '.$dataSource->getParameter('superficie').' m2', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Teniendo su derecho propietario debidamente', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Cell($w = 90, $h = $hMedium, $txt = ' ', $border = '', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Registrado en Derechos Reales de: '.$dataSource->getParameter('ddrr_registro'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Bajo Matricula computarizada N°: '.$dataSource->getParameter('nro_matricula'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Con Asiento N°: '.$dataSource->getParameter('asiento'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'de fecha: '.$dataSource->getParameter('fecha_asiento'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);
        $pdf->Cell($w = 180, $h = $hMedium, $txt = 'Complemento: '.$dataSource->getParameter('complemento_matri'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(7);

        $pdf->Cell($w = 160, $h = $hMedium, $txt = 'Aprobado mediante: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(7);

        $pdf->Cell($w = 90, $h = $hMedium, $txt = $dataSource->getParameter('tipo').' N°: '.$dataSource->getParameter('nro_rmta'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'De Fecha: '.$dataSource->getParameter('fecha_rmta'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(7);

        $pdf->Cell($w = 180, $h = $hMedium, $txt = 'Tipo aprobación: '.$dataSource->getParameter('tipo_aprobacion'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(7);
        $pdf->Cell($w = 180, $h = $hMedium, $txt = 'Complementaria: '.$dataSource->getParameter('complemento'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(7);

        $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Código Catastral N°: '.$dataSource->getParameter('cod_catastral'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Cell($w = 90, $h = $hMedium, $txt = ' ', $border = '', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
        $pdf->Ln(10);

        $pdf->MultiCell(180, $h = $hMedium, 'Conforme el testimonio N° '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgado por la Notaria de Fe Pública N° '.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').', (Escritura Pública de transferencia de un lote de terreno).', 0, 'J', 0, 0, '', '', true);
        $pdf->Ln(9);
            
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 19, $h = $hMedium, $txt = 'FUNDAMENTO LEGAL.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->Ln(8);
        $pdf->SetFont('', 'N');
        /*aqui estamos poniendo algo para subir */
        //console.log();
        //var_dump($dataSource->getParameter('tipo_rechazo'));
        if($dataSource->getParameter('aprobacion') == 'no' ){
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
            if ($dataSource->getParameter('tipo_rechazo') == "FRU"){
                /** 
                 * FRU 
                 * */  
    
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, la Ley N° 2341 de Procedimiento Administrativo, en el inc. K) del Art. 4 establece que los procedimientos administrativos, deben responder a los principios de economía, simplicidad y celeridad, evitando la realización de trámites, formalismos o diligencias innecesarias.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, según el límite de homologación 100/2018 de fecha 12 de abril de 2018, emitido por el ministerio de la presidencia, el predio se encuentra fuera del radio urbano (FRU) del municipio de Colcapirhua.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                if($dataSource->getParameter('observacion') != ''){
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                }
                $pdf->checkPageBreak(60);
                //$pdf->AddPage();
                $pdf->Ln(5); // Espacio extra antes de la sección de conclusiones
                $pdf->writeHTMLCell(180, 0, '', '', '<br><br><b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Realizado el Informe legal, conforme los antecedentes líneas arriba, quien es propietario <b>'.$propName.'</b>, en la cual teniendo un '.$dataSource->getParameter('conclusion').', se puede observar que se encuentra la Ubicado el predio Fuera del Área Urbano (FRU), la Resolución Municipal BI-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal BI-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            } elseif ($dataSource->getParameter('tipo_rechazo') == "Innova"){
                /** 
                 * Innova
                 * */        
            
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según el <b>Código de Procedimiento Civil en su Art. 9. (Obligatoriedad).-</b> Las decisiones de las autoridades judiciales deben ser acatadas por todas las autoridades y personas individuales o colectivas. Las autoridades en general están en la obligación de prestar asistencia para el cumplimiento de las resoluciones judiciales.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, De acuerdo el <b>Código de Procedimiento Civil en su Art. 5. (Normas Procesales).-</b> Las  normas procesales son de orden público y en consecuencia, de obligado acatamiento, tanto por la autoridad judicial como por las partes y eventuales terceros. Se exceptúan de estas reglas, las normas que, aunque procesales, sean de carácter facultativo, por referirse a intereses privados de las partes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                if($dataSource->getParameter('observacion') != ''){
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                }
                $pdf->checkPageBreak(60); 
                $pdf->Ln(5); // Espacio extra antes de la sección de conclusiones
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Realizado el Informe legal, conforme los antecedentes líneas arriba, quien es propietario <b>'.$propName.'</b>, en la cual teniendo un pronunciamiento de la Ene. En Sistemas de Información Geográfica Catastral, '.$dataSource->getParameter('conclusion').' <b>Prohibición de Innovar</b>, emitido por autoridad competente; por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            } elseif ($dataSource->getParameter('tipo_rechazo') == "APAU"){
                /** 
                 * APAU
                 * */    
                $htmlAPAU1 = '<b>LA LEY 715 DE SERVICIO DE REFORMA AGRARIA</b> establece en su <b>Artículo 48. (Indivisibilidad)</b>.';
                $htmlViñetas0 = '<ul>';
                $htmlViñetas0 .= '<li style="tesxt-align: justify">' . $htmlAPAU1 . '</li>';
                $htmlViñetas0 .= '</ul>';
                $htmlAPAU2 = '"La propiedad agraria, bajo ning&uacute;n t&iacute;tulo podr&aacute; dividirse en superficies menores a las establecidas para la peque&ntilde;a propiedad. Las sucesiones hereditarias se mantendrán bajo régimen de indivisión forzosa. Con excepción del solar campesino, la propiedad agraria tampoco podrá titularse en superficies menores a la pequeña propiedad"';
                    
                $htmlAPAU3 = '<b>La Ley 442 LEY ESPECIAL DE CONSOLIDACIÓN, PLANIFICACIÓN, REGULARIZACIÓN TECNICA Y ADMINISTRATIVA Y TRATAMIENTO ESPECIAL DE ZONAS LIMITROFES DE LA JURISDICCIÓN DEL GOBIERNO AUTÓNOMO MUNICIPAL DE COLCAPIRHUA"</b> refiere en el numeral 5, articulo 7 (definiciones). <br><b>Área productiva Agropecuaria Urbana;</b> Porción de territorio urbano con uso de suelo agropecuario, forestal, piscicola, que mantendrá este uso por al menos diez (10) años.';
                $htmlAPAU4 = '<b>EL DECRETO SUPREMO 5065 establece en su artículo único.</b>';
                $htmlViñetas1 = '<ul>';
                $htmlViñetas1 .= '<li style="tesxt-align: justify">' . $htmlAPAU3 . '</li>';
                $htmlViñetas1 .= '<li style="tesxt-align: justify">' . $htmlAPAU4 . '</li>'; // Añade todas las cadenas que necesites
                $htmlViñetas1 .= '</ul>';
                $htmlAPAU5 = 'A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberanía, se modifica el Parágrafo I del Artículo 3 del Decreto Supremo N° 1809, de 27 de noviembre de 2013, con el siguiente texto:';
                $htmlAPAU6 = '<b>"I. Las áreas productivas agropecuarias urbanas no podrán ser objeto de cambio de uso de suelo ni urbanizadas en un plazo de quince (15) años, a partir de la publicación del presente Decreto  Supremo."</b>';
                    
                $pdf->writeHTMLCell(180, 0, '7', '', $htmlViñetas0, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU2, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '7', '', $htmlViñetas1, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU5, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU6, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                // $pdf->AddPage();
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                if($dataSource->getParameter('observacion') != ''){
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                }
                $pdf->checkPageBreak(60); 
                $pdf->Ln(5); // Espacio extra antes de la sección de conclusiones
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $htmlAPAU8 = 'En virtud a los antecedentes descritos y la normativa vigente, se establecen los siguientes aspectos:';
                $htmlAPAU9 = 'De acuerdo a documentación presentada se puede observar un fraccionamiento del predio y el registro en derechos reales de la parte fraccionada, el cual al ser un terreno ubicado en <b>área productiva agropecuaria NO es susceptible a ser fraccionado</b>, toda vez que la regularización del predio se debe realizar sobre la totalidad de la superficie y no así sobre una parte fraccionada, pudiendo efectuarse la urbanización y fraccionamiento una vez se efectúe el cambio de uso de suelo.';
                $htmlAPAU10 = 'En cumplimiento a la normativa vigente al encontrarse el terreno en <b>área productiva agropecuaria</b> y al no ser objeto de cambio de uso de suelo ni urbanizable en el plazo de 15 años a partir de la publicación del Decreto Supremo N° 1809, de 27 de noviembre de 2013, solamente se podrá efectuar la aprobación del predio en Area Productiva Agropecuaria sobre la totalidad de la superficie, '.$dataSource->getParameter('conclusion').', por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis y emisión de un informe, de la parte técnica, asimismo se deberá remitir el trámite a la <b>Dirección de Asesoría Legal del Gobierno Autónomo Municipal de Colcapirhua</b>, para que en coordinación con las Oficinas de Derechos Reales se pueda corroborar la legalidad y veracidad de la documentación técnica - legal bajo el principio de buena fe que solicito el propietario derivando el mismo al fraccionamiento y posterior inscripción del predio que se encuentra ubicado actualmente en <b>Área Productiva (A.P.A.U.)</b>, sin contar con alguna Resolución de tipo Municipal, Agraria o Nacional para este efecto';
                    
                $htmlViñetas2 = '<ul>';
                $htmlViñetas2 .= '<li style="tesxt-align: justify">' . $htmlAPAU9 . '</li>';
                $htmlViñetas2 .= '<li style="tesxt-align: justify">' . $htmlAPAU10 . '</li>'; // Añade todas las cadenas que necesites
                $htmlViñetas2 .= '</ul>';
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU8, 0, 1, 0, true, 'J', true);
                $pdf->Ln(1.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '7', '', $htmlViñetas2, 0, 1, 0, true, 'J', true);
                $pdf->Ln(1.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto se informa y se pone en conocimiento para fines consiguientes.', 0, 1, 0, true, 'J', true);
            } elseif ($dataSource->getParameter('tipo_rechazo') == "Doble"){
                /** 
                 * Doble
                 * */  
                
                $pdf->writeHTMLCell(180, 0, '', '', '<b>Que, De acuerdo al Art. 86 de la Ley 2341 (Conocimiento del T1ramite).-<b> "Los administrados que intervengan en un procedimiento, sus representantes o abogados, tendrá derecho a conocer en cualquier momento el estado del trámite ya tomar vista de las actuaciones".', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', '<b>Que, de acuerdo a la Resolución Municipal BI - Secretarial N° 1/2020 de fecha 11 de diciembre de 2020<b> emitida por Secretaria Municipal Técnica de Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                if($dataSource->getParameter('observacion') != ''){
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                }
                $pdf->checkPageBreak(60); 
                $pdf->Ln(5); // Espacio extra antes de la sección de conclusiones
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Realizado el Informe legal, conforme los antecedentes líneas arriba, en la cual teniendo un pronunciamiento '.$dataSource->getParameter('conclusion').', Informe Técnico de los inmuebles para los tramite urba-No 000070 y 0000472, se puede observar que en posesión en derecho propietario a la valoración de los tramites 472 y 720 en la cual los interesados deberán regularizar el mejor derecho propietario ante la instancia llamada por Ley, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            } else {
                $pdf->MultiCell(180, $h = $hMedium, 'Que, Según la Ley 411 de fecha 26 de octubre de 2004, Capitulo II Reglamento Técnica de Edificaciones en su Artículo 25. (Alcances específico para Regularización Técnica de Edificaciones) podrán acoger de manera voluntaria al proceso de regularización Técnica de edificaciones, aquellos ciudadanos que no cuenten con planos aprobados y/o que teniendo planos aprobados de contrucción estos hayan sido contruidos res´petando las disposiciones Municipales vigentes.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(28);
                $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el PLANUR O.M. 0004/2004 de fecha 13 de febrero de 2004 en su artículo 109, Constrcciones Fuera de Norma.- Las contrucciones que no cumplen son los planos debidamente aprobados y que no cumplan con lo establesido en el presente reglamento serán paralizadas, en su caso demolidas. Por todo lo Expuesto se verifica que la construcción ya está consolidad sin haber tenido un plano de lote aprobada por lo que según reglamento y normas vigentes procede al rechazo de dicho trámite, Aprobación de Plano de Vivienda Multifamiliar, debidamente la misma proceder en primera instancia al Trámite de aprobación de plano de lote.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(4); // Un espacio pequeño y constante entre párrafos
                // --- Control de salto de página inteligente ---
                // Antes de empezar los siguientes artículos, verificamos si caben (ej. 80mm)
                $pdf->checkPageBreak(80); 
                // --- Párrafo 2 ---
                $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el reglamento par Urbanismo y Edificaciones PLANUR de fecha 13 de febrero de 2004 en su Art. 107 Inciso de la construcción.- para iniciar la constrcción de una edificación de cualquier naturaleza es necesario contar con el respectivo Plano arquitectonico aprobado por la alcaldia de Colcapirhua, no siento suficiente que el tramite se encuentra en curso de aprobación.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(4);
                // --- Párrafo 3 ---
                $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el reglamento para Urbanizaciones y Edificaciones PLANUR de fecha 13 de febrero de 2004 en su Art. 112.- Tipos de Infracción.- se considerará infracción los siguientes actos cometidos por el propietario, diseñador y/o contrucción: * Contruir edificaciones sin contar previamente con los planos aprobados por la Alcaldia del lote o del proyecto arquitectónico.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(8);
                // --- Sección de Conclusiones ---
                $pdf->checkPageBreak(50); // Asegura que el título y el inicio de la conclusión no se separen
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Ln(2);
                $pdf->MultiCell(180, $h = $hMedium, 'Realizado el Informe Legal, conforme los antecedentes lineas arriba, quien es propietario: ', 0, 'L', 0, 0, '', '', true);
                $pdf->Ln(5);
                foreach ($dataSource->getDataSet() as $row) {
                    $tipo_persona = $row['tipo_persona'];
                        
                    if ( $tipo_persona == "propietario"){
                        $pdf->SetFont('', 'B');
                        $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                        $pdf->SetFont('', 'N');
                        $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                        $pdf->SetFont('', 'B');
                        $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                        $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                        $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                        $pdf->Ln();
                    }                 
                }
                $pdf->SetFont('', 'N');
                $pdf->MultiCell(180, $h = $hMedium, 'En la cual teniendo un pronunciamiento de la Jefatura de Urbanismo - Arq.'.$dataSource->getParameter('via').', se puede observar que la construcción de vivienda se encuentra infringiendo a la norma vigente e incumpliendo al PLANUR, Resolución Municipal BI-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal BI-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que NO corresponde la prosecución del trámite, para lo cual se'.' RECOMIENDA'.' efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(30);
            }
        } 
        /*APAU*/
        if ($dataSource->getParameter('area_agro') == "si" && $dataSource->getParameter('aprobacion') == 'si') {
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
                
            
            /*
            $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art. 24, Toda persona tiene derecho a la petición, de forma individual o colectiva, oral o escrita. Además, garantiza el derecho a recibir una respuesta formal y pronta sin más requisito que la identificación del peticionario, asi tambien menciona en su art.56 inc. l.- Toda persona tiene derecho a la propiedad privada individual o colectiva, siempre que esta cumpla una función social. ll. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 'J', 0, 0, '', '', true); //
            $pdf->Ln(28); // ⬅️ ¡Aquí está el cambio!
            $pdf->MultiCell(180, $h = $hMedium, 'Que, en virtud a la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
            $pdf->Ln(18); // ⬅️ ¡Aquí está el cambio!
            $pdf->MultiCell(180, 0, 'Que de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los tramites administrativos y técnicos de la Dirección de urbanismo y Catastro.', 0, 'J', 0, 0, '', '', true);
            // $pdf->AddPage();
            $pdf->writeHTMLCell(180, 0, '', '', '<br><br><b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', 'Se concluye que el (los):', 0, 1, 0, true, 'J', true);
            */
            // Cambié el 0 por 1 en el parámetro de 'ln' (el 7mo)
            // Y puse el alto en 0 para que sea automático
            $pdf->MultiCell(180, 0, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art. 24, Toda persona tiene derecho a la petición, de forma individual o colectiva, oral o escrita. Además, garantiza el derecho a recibir una respuesta formal y pronta sin más requisito que la identificación del peticionario, asi tambien menciona en su art.56 inc. l.- Toda persona tiene derecho a la propiedad privada individual o colectiva, siempre que esta cumpla una función social. ll. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 'J', 0, 1, '', '', true); 
            $pdf->Ln(4); // Un pequeño espacio de separación entre párrafos

            $pdf->MultiCell(180, 0, 'Que, en virtud a la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 1, '', '', true);
            $pdf->Ln(4);

            $pdf->MultiCell(180, 0, 'Que de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los tramites administrativos y técnicos de la Dirección de urbanismo y Catastro.', 0, 'J', 0, 1, '', '', true);

            // Para las conclusiones, ya usas writeHTMLCell que suele manejar mejor el flujo
            $pdf->writeHTMLCell(180, 0, '', '', '<br><br><b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
            $pdf->writeHTMLCell(180, 0, '', '', 'Se concluye que el (los):', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', '<b>'.$propName.' expedicion</b> legitimo(s) propietario(s) de un predio con una extensión superficial de '.$dataSource->getParameter('superficie_leg').' m2.; debidamente registrado en oficinas de Derechos Reales; Conforme Testimonio W de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgado por la Notaria de Fe Pública N° '.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').', (Escritura Pública de transferencia de un lote de terreno), dando cumplimientoa los que se establece el Decreto Supremo W 5056 de fecha 22 de noviembre de 2023; decreta en su Artículo Único que: A fin de efectivizar los mecanismos de resguardo de las areas productivas para garantizar la seguridad alimentaria con soberania, se modifica el párrafo I del Artículo 3 del Decreto Supremo W 1809 de fecha 27 de noviembre de 2013 con el siguiente texto:', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', '<b>"1.- Las áreas productivas agropecuarias urbanas (A.P.A.U.)no podrán ser cambio de uso y de suelo. ni urbanizables en un plazo de (15) años a partir de la publicación del presente Decreto Supremo"</b>; por lo que se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado a ser aprobado.', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
            $pdf->writeHTMLCell(180, 0, '', '', '<b>El presente informe Legal no define el Derecho Propietario, Si existiera doble titularidad de derecho propietario será quien alegue ser probada por la via llamada por ley, el mismo será de entera y total responsabilidad del interesado y se aplicara según Normativa Vigente. Los Planos a ser aprobados, no contravienen a las normas legales en vigencia y cumple con todos los requisitos, faltando que la parte técnica remita los informes técnicos de topografía y Normas urbanas y/o presenten observaciones al trámite a ser aprobado.</b>', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        } else {
            foreach ($dataSource->getDataSet() as $row) {
                $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ( $tipo_persona == "propietario"){
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->SetFont('', 'N');
                    $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                    $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                }                 
            }

            if( $dataSource->getParameter('id_tipo_tramite') == 20 && $dataSource->getParameter('aprobacion') == 'si'){
                $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art. 24, Toda persona tiene derecho a la petición, de forma individual o colectiva, oral o escrita. Además, garantiza el derecho a recibir una respuesta formal y pronta sin más requisito que la identificación del peticionario, asi tambien menciona en su art.56 inc. l.- Toda persona tiene derecho a la propiedad privada individual o colectiva, siempre que esta cumpla una función social. ll. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(28);
                $pdf->MultiCell(180, $h = $hMedium, 'Que, en virtud a la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(28);
                $pdf->MultiCell(180, $h = $hMedium, 'Que de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los tramites administrativos y técnicos de la Dirección de urbanismo y Catastro.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(5);
                
                // --- Párrafo de Decreto Supremo ---
                // Antes de este párrafo largo, verificamos si caben al menos 60mm
                $pdf->checkPageBreak(60);
                $pdf->MultiCell(180, 0, 'Que, en virtud al Decreto Supremo N° 5056 de fecha 22 de noviembre de 2023; decreta en su Articulo Unico que: A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberania, se modifica el parrafo l del Articulo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto; "l.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo, ni urbanizables en un plazo de (15) años a partir de la publicación del ´presente Decreto Supremo".', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(8); // Espacio antes de la sección final
                
                // --- Gestión de Conclusiones ---
                // Verificamos que quepan el título Y el primer párrafo de la conclusión juntos (aprox 50mm)
                $pdf->checkPageBreak(50);
                $pdf->SetFont('', 'B');
                $pdf->Cell(180, 0, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Ln(2);
                $pdf->MultiCell(180, $h = $hMedium, 'Se concluye que el o los Sr.: ', 0, 'L', 0, 0, '', '', true);
                $pdf->Ln(5);
                foreach ($dataSource->getDataSet() as $row) {
                    $tipo_persona = $row['tipo_persona'];
                    //var_dump("tipo: ",$tipo_persona); 
                    if ( $tipo_persona == "propietario"){
                        $pdf->SetFont('', 'B');
                        $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                        $pdf->SetFont('', 'N');
                        $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                        $pdf->SetFont('', 'B');
                        $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                        $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                        $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                        $pdf->Ln();
                    }           
                }
                $pdf->SetFont('', 'N');
                $pdf->MultiCell(180, $h = $hMedium, ' es legitimo propietario de un predio con una extensión superficial de '.$dataSource->getParameter('superficie').' m2; debidamente registrado en oficinas de Derechos Reales; Conforme Testimonio N° '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgsdo por la Notaria de Fe Publica N°'.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').'. (Escritura Pública de transferencia de un lote de terreno), dando cumplimiento a lo que se establece el Decreto SupremoN° 5056 de fecha 22 de noviembre de 2023; decreta en su Articulo Unico que ; A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la sesguridad alimentaria con soberanía, se modifica el parrafo l del Artículo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto: "l.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo, ni urbanizables en un plazo de (15) años a partir de la publicación del ´presente Decreto Supremo"; por lo que se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(45);        
                $pdf->MultiCell(180, $h = $hMedium, '   El presente Informe Legal no define el Derecho Propietario, Si existiera doble titularidad de derecho propietario será quien alegue ser probada por la vía llamada por ley, el mismo será de entera y total responsabilidad del interesado y se aplicara según Normativa Vigente. Los planos a ser aprobados, no contravienen a las normas legales en vigencia y cumple con todos los requisitos, faltando que la parte técnica remita los informes técnicos de topografía y Normas Urbanas y/o presentenobservaciones al trámite a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(40);        

            } else{
                $tramites_id = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19];
                if (in_array($dataSource->getParameter('id_tipo_tramite'),$tramites_id ) && $dataSource->getParameter('aprobacion') == 'si') {          
                    $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional. Toda persona tiene derecho a la Petición de manera individual o colectiva, sea oral o escrita, y a la obtención de respuesta formal y pronta. Para el ejercicio de este derecho no exigirá mas requisito que la identificación del peticionante, así tembién menciona en su art. 56 inc I.- Toda persona tiene derecho a la pro´piedad privada individual o colectiva, siempre que esta cumpla una función social. II. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo. ', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, 0, 'Que, la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(4); // Espacio pequeño y constante entre párrafos
                    $pdf->MultiCell(180, 0, 'Que de acuerdo a la resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(8);
                    // --- Gestión Inteligente de Salto de Página ---
                    // Si quedan menos de 50mm, el sistema saltará de hoja solo (respetando Header/Footer)
                    $pdf->checkPageBreak(50);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell(180, 0, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->SetFont('', 'N');
                    $pdf->Ln(2);
                    $pdf->MultiCell(180, 0, 'Realizado el informe legal, conforme los antecedentes lineas arriba, quien es (son) propietario(s):', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(2);
                    foreach ($dataSource->getDataSet() as $row) {
                        $tipo_persona = $row['tipo_persona'];
                        //var_dump("tipo: ",$tipo_persona); 
                        if ( $tipo_persona == "propietario"){
                            $pdf->SetFont('', 'B');
                            $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                            $pdf->SetFont('', 'N');
                            $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                            $pdf->SetFont('', 'B');
                            $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                            $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                            $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                            $pdf->Ln();
                        }            
                    }
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'conforme la escritura Privada de fecha '. $dataSource->getParameter('fecha_testimonio').', otorgado por la Notaria de Fe Pública '.$dataSource->getParameter('nombre_notario').'cumple con los requisitos de la R.M. Bi-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal Bi-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que se recomienda la prosecución del tramite administrativo, faltando la aprobacion de la parte técnica topográfica y normas urbanas del plano a ser aprobado. El presente informe Legal no define derecho propietario, Si existiera doble titularidad de derecho propietario será quien alegue deberá demostrarla mediante la Via judicial, siendo de responsabilidaddel interesado y se aplicará según normativa vigente.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);        
                            
                    $pdf->Ln(8);
                        
                }
            }
        }
            
        if($dataSource->getParameter('aprobacion') != 'no' &&  ($dataSource->getParameter('tipo_rechazo') != "FRU" && $dataSource->getParameter('tipo_rechazo') != "APAU" && $dataSource->getParameter('tipo_rechazo') != "Doble" && $dataSource->getParameter('tipo_rechazo') != "Innova")){
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 180, $h = $hMedium, $txt = 'Es cuanto informo de la inspección realizada.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	    
        }
            
        $pdf->Ln(20);
        $pdf->Cell($w = 180, $h = $hMedium, $txt = $dataSource->getParameter('de'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
        $pdf->SetFont('', 'B');
        $pdf->Ln(5);
        $pdf->Cell($w = 180, $h = $hMedium, $txt = $dataSource->getParameter('cargode'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            
		$pdf->SetFontSize(7.5);
		$pdf->SetFont('', '');
	    $wMargin = 15;
	    $wNro = 10;
	    $wCodigo = 15;
	    $wDetalle = 25;
	    $wTotal = 20;
		$totalVaca = 0;
	
	    $pdf->Ln();
	    $pdf->Ln();
	    $pdf->Ln();
               
        $pdf->Output($fileName, 'F');
    }

    function writeClasificacionDetalle($pdf, $dataSource,$mostrar_costos) {
        $hGlobal = 5;
        
        $wNro = 10;
        $wCodigo = 15;
        $wDescripcionItem = 80;
        $wUnidad = 15;
        $wCantidad = 15;
		$wCantidadAlerta = 15;
        $wCostoUnitario = 15;
        $wCostoTotal = 20;
        $pdf->Ln();

        $pdf->SetFontSize(7);
        $pdf->SetFont('', 'B');

        $pdf->Cell($w = $wDescripcionItem, $h = $hGlobal, $txt = '* ' . $dataSource->getParameter('nombreClasificacion'), $border = 0, $ln = 1, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');

        $pdf->SetFontSize(6.5);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = 'Nro.', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = 'Código', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Cell($w = $wDescripcionItem, $h = $hGlobal, $txt = 'Descripcion del Material', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Cell($w = $wUnidad, $h = $hGlobal, $txt = 'Unidad', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Cell($w = $wCantidad, $h = $hGlobal, $txt = 'Cantidad', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Cell($w = $wCantidad, $h = $hGlobal, $txt = 'Cant. Min.', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        if ($mostrar_costos != 'no') {
	        $pdf->Cell($w = $wCostoUnitario, $h = $hGlobal, $txt = 'C/Unit.', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wCostoTotal, $h = $hGlobal, $txt = 'C/Total', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		}
        $pdf->Ln();

        $count = 1;
        $pdf->SetFont('', '');
        foreach ($dataSource->getDataset() as $datarow) {

            $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = $count, $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = $datarow['codigo'], $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Cell($w = $wDescripcionItem, $h = $hGlobal, $txt = $datarow['nombre'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Cell($w = $wUnidad, $h = $hGlobal, $txt = $datarow['unidad_medida'], $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Cell($w = $wCantidad, $h = $hGlobal, $txt = number_format($datarow['cantidad'], 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Cell($w = $wCantidadAlerta, $h = $hGlobal, $txt = number_format($datarow['cantidad_min'], 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $costoUnitario = 0;
            if ($datarow['cantidad'] != 0) {
                $costoUnitario = $datarow['costo']/$datarow['cantidad'];
            }

			if ($mostrar_costos != 'no') {
	            $pdf->Cell($w = $wCostoUnitario, $h = $hGlobal, $txt = number_format($costoUnitario, 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            $pdf->Cell($w = $wCostoTotal, $h = $hGlobal, $txt = number_format($datarow['costo'], 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			}
            $pdf->Ln();
            $count++;
        }
		if ($mostrar_costos != 'no') {
	        $pdf->SetFont('', 'B');
	        $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wDescripcionItem, $h = $hGlobal, $txt = 'Total', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wUnidad, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wCantidad, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wCantidadAlerta, $h = $hGlobal, $txt = '' , $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        
	        $pdf->Cell($w = $wCostoUnitario, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wCostoTotal, $h = $hGlobal, $txt = number_format($dataSource->getParameter('totalCosto'), 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		}
        $pdf->Ln();
    }
}

?>