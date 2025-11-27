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

    public function Header() {
        $dataSource = $this->getDataSource();
        $height = 6;
        $midHeight = 9;
        $longHeight = 18;

        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetXY($x, $y);

        $this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], 16, 12, 36);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFontSize(16);
        $this->SetFont('', 'B');
        
        //$this->Cell(60, $longHeight, '', '', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(180, $longHeight, ' INFORME LEGAL', ' ', 0, 'R', false, '', 0, false, 'T', 'C');
        $this->Ln(5);
        $this->SetFontSize(12);
        $this->Cell(180, $longHeight, $dataSource->getParameter('num_informe'), 'B', 0, 'R', false, '', 0, false, 'T', 'C');
        $x = $this->GetX();
        $y = $this->GetY();

       
    }

    public function Footer() {
        //TODO: implement the footer manager
        $dataSource = $this->getDataSource();
        //$this->SetFooterMargin(PDF_MARGIN_FOOTER);
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
        
        $this->write2DBarcode($html, 'QRCODE,M', 170, 290, 30, 30, $style, 'N');
        
      //  $this->write2DBarcode($html, 'PDF417', $x+80, $y-5, 0, 30, $style, 'N');
        //$this->Text(20, 25, 'QRCODE M');
       // $this->Image(dirname(__FILE__) . '/../media/firma.png', 98, 220, 35, 35, '', '', '', false, 300, '', false, false, 0);
        
    } 

}

Class RInformeLegal extends Report {

    function write($fileName) {
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        /*$pdf->SetAuthor('Nicola Asuni');
         $pdf->SetTitle('TCPDF Example 006');
         $pdf->SetSubject('TCPDF Tutorial');
         $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
         */

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(8);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        // $pdf->setLanguageArray($l);

        // Crea la pagina para mostrar los totales de los almacenes.
        $pdf->AddPage('P', array(215.9, 330));

        $hGlobal = 5;
        $hMedium = 7.5;
        $hLong = 15;

        //var_dump($dataSource); exit;
		
        //$pdf->Cell($w = 30, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		//$pdf->SetFontSize(12);
		//if ($dataSource->getParameter('mostrar_costos') != 'no') {
				
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
                };                 
            };
            
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

            $pdf->Cell($w = 160, $h = $hMedium, $txt = 'Aprobado mediante: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);

            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'R.M.T.A. N°: '.$dataSource->getParameter('nro_rmta'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'De Fecha: '.$dataSource->getParameter('fecha_rmta'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
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

            if($dataSource->getParameter('aprobacion') == 'no' ){
                if ($dataSource->getParameter('tipo_rechazo') == "FRU"){
                    /*
                    * FRU
                    * */
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, la Ley N° 2341 de Procedimiento Administrativo, en el inc. K) del Art. 4 establece que los procedimientos administrativos, deben responder a los principios de economía, simplicidad y celeridad, evitando la realización de trámites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, según el límite de homologación 100/2018 de fecha 12 de abril de 2018, emitido por el ministerio de la presidencia, el predio se encuentra fuera del radio urbano (FRU) del municipio de Colcapirhua.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, según el límite de homologación 100/2018 de fecha 12 de abril de 2018, emitido por el ministerio de la presidencia, el predio se encuentra fuera del radio urbano (FRU) del municipio de Colcapirhua.', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Es cuanto informo para fines consiguientes.', 0, 'L', 0, 0, '', '', true);
                } elseif ($dataSource->getParameter('tipo_rechazo') == "INOVAR"){
                    /*
                    * INNOVAR
                    * */
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el <b>Código de Procedimiento Civil en su Art. 9. (Obligatoriedad).-</b> Las decisiones de las autoridades judiciales deben ser acatadas por todas las autoridades y personas individuales o colectivas. Las autoridades en general están en la obligación de prestar asistencia para el cumplimiento de las resoluciones judiciales.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, De acuerdo el <b>Código de Procedimiento Civil en su Art. 5. (Normas Procesales).-</b> Las  normas procesales son de orden público y en consecuencia, de obligado acatamiento, tanto por la autoridad judicial como por las partes y eventuales terceros. Se exceptúan de estas reglas, las normas que, aunque procesales, sean de carácter facultativo, por referirse a intereses privados de las partes.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Realizado el Informe legal, conforme los antecedentes líneas arriba, quien es propietario Osvaldo Mercado Arias, en la cual teniendo un pronunciamiento de la Ene. En Sistemas de Información Geográfica Catastral, Informe CITE GOP 118/2025 de fecha 11 de julio de 2025, emitido por la Lic. Greny Olgueza Ponce, y en virtud a 10 determinado por Auto de fecha 02/05/2025 <b>Prohibición de  Innovar</b>, emitido por autoridad competente; por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Es cuanto informo para fines consiguientes.', 0, 'L', 0, 0, '', '', true);
                } elseif ($dataSource->getParameter('tipo_rechazo') == "APAU"){
                    /*
                    * APAU
                    * */
                    $pdf->MultiCell(180, $h = $hMedium, '<b>LA LEY 715 DE SERVICIO DE REFORMA AGRARIA</b> establece en su <b>Artículo 48. (Indivisibilidad)</b>.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, '"La propiedad agraria, bajo ningún título podrá dividirse en superficies menores a las establecidas para la pequeña propiedad. Las sucesiones hereditarias se mantendrán bajo régimen de indivisión forzosa. Con excepción del solar campesino, la propiedad agraria tampoco podrá titularse en superficies menores a la pequeña propiedad".', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, '<b>La Ley 442 LEY ESPECIAL DE CONSOLIDACIÓN, PLANIFICACIÓN, REGULARIZACIÓN TECNICA Y ADMINISTRATIVA Y TRATAMIENTO ESPECIAL DE ZONAS LIMITROFES DE LA JURISDICCIÓN DEL GOBIERNO AUTÓNOMO MUNICIPAL DE COLCAPIRHUA"</b> refiere en el numeral 5, articulo 7 (definiciones).', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, '<b>Área productiva Agropecuaria Urbana;</b> Porción de territorio urbano con uso de suelo agropecuario, forestal, piscicola, que mantendrá este uso por al menos diez (10) anos.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->SetFont('', 'B');
                    $pdf->MultiCell(180, $h = $hMedium, '<>EL DECRETO SUPREMO 5065 establece en su artículo único', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberanía, se modifica el Parágrafo I del Artículo 3 del Decreto Supremo N° 1809, de 27 de noviembre de 2013, con el siguiente texto:', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->SetFont('', 'B');
                    $pdf->MultiCell(180, $h = $hMedium, '"l. Las áreas productivas agropecuarias urbanas no podrán ser objeto de cambio de uso de suelo ni urbanizadas en un plazo de quince (15) años, a partir de la publicación del presente Decreto  Supremo."', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'En virtud a los antecedentes  descritos y la normativa  vigente,  se establecen  los siguientes aspectos:', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'De acuerdo a documentación presentada se puede observar un fraccionamiento del predio y el registro en derechos reales de la parte fraccionada, el cual al ser un terreno ubicado en <b>área productiva agropecuaria NO es susceptible a ser fraccionado</b>, toda vez que la regularización del predio se debe realizar sobre la totalidad de la superficie y no así sobre una parte fraccionada, pudiendo efectuarse la urbanización y fraccionamiento una vez se efectúe el cambio de uso de suelo.', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'En cumplimiento a la normativa vigente al encontrarse el terreno en <b>área   productiva agropecuaria</b> y al no ser objeto de cambio de uso de suelo ni urbanizable en el plazo de 15 años a partir de la publicación del Decreto Supremo N° 1809, de 27 de noviembre de 2013, solamente se podrá efectuar la aprobación del predio en Area Productiva Agropecuaria sobre la totalidad de la superficie, es decir la <b>extensión superficial de 6.187,02  m2</b> y no así sobre los 3.093,65 m2, por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis y emisión de un informe, de la parte técnica, asimismo se deberá remitir el trámite a la <b>Dirección de Asesoría Legal del Gobierno Autónomo Municipal de Colcapirhua</b>, para que en coordinación con las Oficinas de Derechos Reales se pueda corroborar la legalidad y veracidad de la documentación técnica - legal bajo el principio de buena fe que solicito el propietario derivando el mismo al fraccionamiento y posterior inscripción del predio que se encuentra ubicado actualmente en <b>Área Productiva (A.P.A.U.)</b>, sin contar con alguna Resolución de tipo Municipal, Agraria o Nacional para este efecto', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'En virtud a los antecedentes  descritos y la normativa  vigente,  se establecen  los siguientes aspectos:', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Es cuanto se informa y se pone en conocimiento para fines consiguientes.', 0, 'L', 0, 0, '', '', true);
                } elseif ($dataSource->getParameter('tipo_rechazo') == "DOBLE"){
                    /*
                    * Doble
                    * */
                    $pdf->MultiCell(180, $h = $hMedium, '<b>Que, De acuerdo al Art. 86 de la Ley 2341 (Conocimiento del T1ramite).-<b> "Los administrados que intervengan en un procedimiento, sus representantes o abogados, tendrá derecho a conocer en cualquier momento el estado del trámite ya tomar vista de las actuaciones".', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, '<b>Que, de acuerdo a la Resolución Municipal BI - Secretarial N° 1/2020 de fecha 11 de diciembre de 2020<b> emitida por Secretaria Municipal Técnica de Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Realizado el Informe legal, conforme los antecedentes líneas arriba, en la cual teniendo un pronunciamiento Informe de Jefatura de Catastro CITE/CAT/T-IS,ClNo 0005/2025, de fecha 24/03/2025, emitido por el Ar. Richard Franco Condori Rocha, Arquitecto Técnico 1 servicios catastrales, Informe Técnico de los inmuebles para los tramite urba-No 000070 y 0000472, se puede observar que en posesión en derecho propietario a la valoración de los tramites 472 y 720 en la cual los interesados deberán regularizar el mejor derecho propietario ante la instancia llamada por Ley, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe.', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Es cuanto informo para fines consiguientes.', 0, 'L', 0, 0, '', '', true);
                } else {
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, Según la Ley 411 de fecha 26 de octubre de 2004, Capitulo II Reglamento Técnica de Edificaciones en su Artículo 25. (Alcances específico para Regularización Técnica de Edificaciones) podrán acoger de manera voluntaria al proceso de regularización Técnica de edificaciones, aquellos ciudadanos que no cuenten con planos aprobados y/o que teniendo planos aprobados de contrucción estos hayan sido contruidos res´petando las disposiciones Municipales vigentes.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el PLANUR O.M. 0004/2004 de fecha 13 de febrero de 2004 en su artículo 109, Constrcciones Fuera de Norma.- Las contrucciones que no cumplen son los planos debidamente aprobados y que no cumplan con lo establesido en el presente reglamento serán paralizadas, en su caso demolidas. Por todo lo Expuesto se verifica que la construcción ya está consolidad sin haber tenido un plano de lote aprobada por lo que según reglamento y normas vigentes procede al rechazo de dicho trámite, Aprobación de Plano de Vivienda Multifamiliar, debidamente la misma proceder en primera instancia al Trámite de aprobación de plano de lote.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    //$pdf->addPage();
                    $pdf->AddPage();
                    $pdf->Ln(2);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el reglamento par Urbanismo y Edificaciones PLANUR de fecha 13 de febrero de 2004 en su Art. 107 Inciso de la construcción.- para iniciar la constrcción de una edificación de cualquier naturaleza es necesario contar con el respectivo Plano arquitectonico aprobado por la alcaldia de Colcapirhua, no siento suficiente que el tramite se encuentra en curso de aprobación.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(20);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, Según el reglamento para Urbanizaciones y Edificaciones PLANUR de fecha 13 de febrero de 2004 en su Art. 112.- Tipos de Infracción.- se considerará infracción los siguientes actos cometidos por el propietario, diseñador y/o contrucción: * Contruir edificaciones sin contar previamente con los planos aprobados por la Alcaldia del lote o del proyecto arquitectónico.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(15);

                    $pdf->Ln(8);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Realizado el Informe Legal, conforme los antecedentes lineas arriba, quien es propietario: ', 0, 'L', 0, 0, '', '', true);
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
                        };                 
                    };
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'En la cual teniendo un pronunciamiento de la Jefatura de Urbanismo - Arq.'.$dataSource->getParameter('via').', se puede observar que la construcción de vivienda se encuentra infringiendo a la norma vigente e incumpliendo al PLANUR, Resolución Municipal BI-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal BI-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que NO corresponde la prosecución del trámite, para lo cual se'.' RECOMIENDA'.' efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                }
            } 

                /*APAU*/
            if( $dataSource->getParameter('id_tipo_tramite') == 20 && $dataSource->getParameter('aprobacion') == 'si'){
                $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art. 24, Toda persona tiene derecho a la petición, de forma individual o colectiva, oral o escrita. Además, garantiza el derecho a recibir una respuesta formal y pronta sin más requisito que la identificación del peticionario, asi tambien menciona en su art.56 inc. l.- Toda persona tiene derecho a la propiedad privada individual o colectiva, siempre que esta cumpla una función social. ll. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(28);
                $pdf->MultiCell(180, $h = $hMedium, 'Que, en virtud a la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(22);
                $pdf->MultiCell(180, $h = $hMedium, 'Que de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los tramites administrativos y técnicos de la Dirección de urbanismo y Catastro.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(30);
                //$pdf->addPage();
                $pdf->AddPage();
                $pdf->Ln(2);
                $pdf->MultiCell(180, $h = $hMedium, 'Que, en virtud al Decreto Supremo N° 5056 de fecha 22 de noviembre de 2023; decreta en su Articulo Unico que: A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberania, se modifica el parrafo l del Articulo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto; "l.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo, ni urbanizables en un plazo de (15) años a partir de la publicación del ´presente Decreto Supremo".', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(20);
              
                $pdf->Ln(8);
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Ln(8);
                $pdf->SetFont('', 'N');
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
                    };                 
                };
                $pdf->SetFont('', 'N');
                $pdf->MultiCell(180, $h = $hMedium, ' es legitimo propietario de un predio con una extensión superficial de '.$dataSource->getParameter('superficie').' m2; debidamente registrado en oficinas de Derechos Reales; Conforme Testimonio N° '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgsdo por la Notaria de Fe Publica N°'.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').'. (Escritura Pública de transferencia de un lote de terreno), dando cumplimiento a lo que se establece el Decreto SupremoN° 5056 de fecha 22 de noviembre de 2023; decreta en su Articulo Unico que ; A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la sesguridad alimentaria con soberanía, se modifica el parrafo l del Artículo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto: "l.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo, ni urbanizables en un plazo de (15) años a partir de la publicación del ´presente Decreto Supremo"; por lo que se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(45);        
                $pdf->MultiCell(180, $h = $hMedium, '   El presente Informe Legal no define el Derecho Propietario, Si existiera doble titularidad de derecho propietario será quien alegue ser probada por la vía llamada por ley, el mismo será de entera y total responsabilidad del interesado y se aplicara según Normativa Vigente. Los planos a ser aprobados, no contravienen a las normas legales en vigencia y cumple con todos los requisitos, faltando que la parte técnica remita los informes técnicos de topografía y Normas Urbanas y/o presentenobservaciones al trámite a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                $pdf->Ln(40);        

            } else{
                /*if (  $dataSource->getParameter('id_tipo_tramite') == 20 && $dataSource->getParameter('aprobacion') == 'si'){
                        
                    $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art 24, Toda persona tiene derecho a la Petición de manera individual o colectiva, sea oral o escrita, y a la obtención de respuesta formal y pronta. Para el ejercicio de este derecho no exigirá mas requisito que la identificación del peticionante, así tembién menciona en su art. 56 inc I.- Toda persona tiene derecho a la pro´piedad privada individual o colectiva, siempre que esta cumpla una función social. II. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo. ', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, en virtud a la Ley 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(15);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que de acuerdo a la resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->AddPage();
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Se concluye que el (los):', 0, 'L', 0, 0, '', '', true);
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
                        };                 
                    };
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'legitimo(s) propietario de un predio con una extensión superficial de '.$dataSource->getParameter('superficie').' m2.; debidamente registrado en oficinas de Derechos Reales; Conforme Testimonio N° '.$dataSource->getParameter('nro_testimonio').' de fecha '.$dataSource->getParameter('fecha_testimonio').', otorgado por la Notaria de Fe Pública N° '.$dataSource->getParameter('nro_notario').', '.$dataSource->getParameter('nombre_notario').', (Escritura Pública de transferencia de un lote de terreno), dando cumplimientoa los que se establece el Decreto Supremo N° 5056 de fecha 22 de noviembre de 2023; decreta en su Artículo Único que: A fin de efectivizar los mecanismos de resguardo de las areas productivas para garantizar la seguridad alimentaria con soberania, se modifica el párrafo I del Artículo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto: ', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);        
                    $pdf->SetFont('', 'B');
                    $pdf->MultiCell(180, $h = $hMedium, '"I.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo. ni urbanizables en un plazo de (15) años a partir de la publicación del presente Decreto Supremo";', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(10);        
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'por lo que se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(10);        
                    $pdf->SetFont('', 'B');
                    $pdf->MultiCell(180, $h = $hMedium, '         El presente informe Legal no define el Derecho Propietario, Si existiera doble titularidad de derecho propietario será quien alegue ser probada por la via llamada por ley, el mismo será de entera y total responsabilidad del interesado y se aplicara según Normativa Vigente. Los Planos a ser aprobados, no contravienen a las normas legales en vigencia y cumple con todos los requisitos, faltando que la parte técnica remita los informes técnicos de topografía y Normas urbanas y/o presenten observaciones al trámite a ser aprobado.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(20);        
                    $pdf->Ln(8);
                    
                };  */
                $tramites_id = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19];
                if (in_array($dataSource->getParameter('id_tipo_tramite'),$tramites_id ) && $dataSource->getParameter('aprobacion') == 'si'){
                        
                    $pdf->MultiCell(180, $h = $hMedium, 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional. Toda persona tiene derecho a la Petición de manera individual o colectiva, sea oral o escrita, y a la obtención de respuesta formal y pronta. Para el ejercicio de este derecho no exigirá mas requisito que la identificación del peticionante, así tembién menciona en su art. 56 inc I.- Toda persona tiene derecho a la pro´piedad privada individual o colectiva, siempre que esta cumpla una función social. II. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo. ', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(28);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que, la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(15);
                    $pdf->MultiCell(180, $h = $hMedium, 'Que de acuerdo a la resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);
                    $pdf->AddPage();
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CONCLUSIONES y RECOMENDACION.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                    $pdf->Ln(8);
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'Realizado el informe legal, conforme los antecedentes lineas arriba, quien es (son) propietario(s):', 0, 'L', 0, 0, '', '', true);
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
                        };                 
                    };
                    $pdf->SetFont('', 'N');
                    $pdf->MultiCell(180, $h = $hMedium, 'conforme la escritura Privada de fecha '. $dataSource->getParameter('fecha_testimonio').', otorgado por la Notaria de Fe Pública '.$dataSource->getParameter('nombre_notario').'cumple con los requisitos de la R.M. Bi-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal Bi-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que se recomienda la prosecución del tramite administrativo, faltando la aprobacion de la parte técnica topográfica y normas urbanas del plano a ser aprobado. El presente informe Legal no define derecho propietario, Si existiera doble titularidad de derecho propietario será quien alegue deberá demostrarla mediante la Via judicial, siendo de responsabilidaddel interesado y se aplicará según normativa vigente.', 0, 'J', 0, 0, '', '', true);
                    $pdf->Ln(30);        
                           
                    $pdf->Ln(8);
                    
                };  
            };
            
            
           
            
            
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 180, $h = $hMedium, $txt = 'Es cuanto informo de la inspección realizada.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(20);
            $pdf->Cell($w = 180, $h = $hMedium, $txt = $dataSource->getParameter('de'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'B');
            $pdf->Ln(5);
            $pdf->Cell($w = 180, $h = $hMedium, $txt = $dataSource->getParameter('cargode'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            
            
            
            /* foreach ($dataSource->getDataSet() as $row) {
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
                };                 
            };
            foreach ($dataSource->getDataSet() as $row) {
                $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                
            /*
                if ( $tipo_persona == "propietario"){
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['tipo_persona'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                };    */
              /*  if ( $tipo_persona == "apoderado"){
                    $pdf->SetFont('', 'N');
                    $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Solicitud que se realizó en calidad de : ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['tipo_persona'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 33, $h = $hMedium, $txt = 'Mediante Poder n°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 15, $h = $hMedium, $txt = $row['nro_poder'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 30, $h = $hMedium, $txt = 'otorgado en fecha: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['fecha_poder'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'Notaria N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['nro_notaria'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Ln();
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'Notario: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['notario'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                };             
            };
            $pdf->Ln();
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 100, $h = $hMedium, $txt = 'A tal efecto acompaño los documentos exigidos, en fs.: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('fojas'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Ln();
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 45, $h = $hMedium, $txt = 'señalo Teléfono y/o correo: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            foreach ($dataSource->getDataSet() as $row) {
                
                $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ( $tipo_persona == "tramitador"){
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['celular1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 5, $h = $hMedium, $txt = ' , ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['correo'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Ln();
                   
                };                 
            };
            
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 30, $h = $hMedium, $txt = ' Colcapirhua  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('dia'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('mes'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('anio'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 12, $h = $hMedium, $txt = '  Hras:  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 3, $h = $hMedium, $txt = $dataSource->getParameter('hora'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 2, $h = $hMedium, $txt = ':', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('minuto'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
	       /* $pdf->Cell($w = 65, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = 'Fecha Ingreso: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 30, $h = $hMedium, $txt = date_format($fecha_ingre, 'd/m/Y'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Ln();
			
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Cargo: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 25, $h = $hMedium, $txt = $dataSource->getParameter('nombre'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = 'Centro de Responsabilidad: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 60, $h = $hMedium, $txt = $dataSource->getParameter('nombre_unidad'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = 'Tipo Contrato: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = $dataSource->getParameter('tipo_contrato'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = 'Tipo Empleado: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = $dataSource->getParameter('tipo_funcionario'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Ln();
			
			$pdf->SetFont('', 'N');
	        $pdf->Cell($w = 145, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');	       
	        $pdf->Cell($w = 30, $h = $hMedium, $txt = 'Saldo Vacación: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Cell($w = 20, $h = $hMedium, $txt = $dataSource->getParameter('total_vacacion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Ln();*/
			
			$pdf->SetFontSize(7.5);
			$pdf->SetFont('', '');
	        $wMargin = 15;
	        $wNro = 10;
	        $wCodigo = 15;
	        $wDetalle = 25;
	        $wTotal = 20;
			$totalVaca = 0;
	
	/*
	
	        //TODO: Se tiene que adicionar un bucle para mostrar las tablas totales por cada almacen.
	        $pdf->SetFontSize(7);
	        $pdf->SetFont('', 'B');
	        $pdf->Cell($w = $wMargin, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wNro+$wCodigo+$wDetalle+$wTotal, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Ln();
	        
	        $pdf->SetFontSize(7);
	        $pdf->SetFont('', 'B');
	        $pdf->Cell($w = $wMargin, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = 'Nro.', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        //$pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = 'Codigo', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wDetalle, $h = $hGlobal, $txt = 'Desde el', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Cell($w = $wDetalle, $h = $hGlobal, $txt = 'Hasta el', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wTotal, $h = $hGlobal, $txt = 'Periodo', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Cell($w = $wTotal, $h = $hGlobal, $txt = 'Total días', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Ln();
	        $count = 1;
	        $pdf->SetFont('', '');
			//var_dump($dataSource); exit;
	        foreach ($dataSource->getDataSet() as $row) {
	        	//var_dump($row); exit;
	        	$fecha_ini = date_create($row['fecha_inicio']);
				$fecha_fin = date_create($row['fecha_fin']);
	            $pdf->Cell($w = $wMargin, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = $count, $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            //$pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = "1.2.1.5", $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            $pdf->Cell($w = $wDetalle, $h = $hGlobal, $txt = date_format($fecha_ini, 'd/m/Y'), $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            $pdf->Cell($w = $wDetalle, $h = $hGlobal, $txt = date_format($fecha_fin, 'd/m/Y'), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
				$pdf->Cell($w = $wTotal, $h = $hGlobal, $txt = $row['periodo'], $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
				$pdf->Cell($w = $wTotal, $h = $hGlobal, $txt = $row['cantidad_dias'], $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	            $pdf->Ln();
	            $count++;
				$totalVaca = $totalVaca + $row['cantidad_dias'];  
	        }
	        $pdf->SetFont('', 'B');
	        $pdf->Cell($w = $wMargin, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wNro, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        //$pdf->Cell($w = $wCodigo, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wDetalle+$wDetalle+$wTotal, $h = $hGlobal, $txt = 'VACACION TOTAL', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	        $pdf->Cell($w = $wTotal, $h = $hGlobal, $txt = number_format($totalVaca, 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	*/
	        $pdf->Ln();
	        $pdf->Ln();
	        $pdf->Ln();
               
	        //$pdf->AddPage();
	    //}
/*
        $pdf->SetFontSize(8);
        $pdf->SetFont('', 'B');
		
		$pdf->Cell($w = 46, $h = $hGlobal, $txt = 'FIRMA INTERESADO Y/O APODERADO', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Cell($w = 20, $h = $hGlobal, $txt = '   ', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	    $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'SELLO FIRMA FUNCIONARIO RESPONSABLE', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Cell($w = 20, $h = $hGlobal, $txt = '   ', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	    $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'DE VENTANILLA UNICA', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Ln();
        $pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'El presente formulario sirve para el encaminamiento y seguimiento de tramite, asi mismo ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = ' concluido el tramite sera entregado al propietario.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        *//*$pdf->Cell($w = 0, $h = $hMedium, $txt = 'DETALLE DE MATERIALES', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln();
       /* foreach ($dataSource->getParameter('clasificacionDataSources') as $clasificacionDataSource) {
            $this->writeClasificacionDetalle($pdf, $clasificacionDataSource,$dataSource->getParameter('mostrar_costos'));
        }
		*/
		/*if ($dataSource->getParameter('mostrar_costos') != 'no') {
			$pdf->Cell($w = $wDetalle+$wCodigo+40, $h = $hGlobal, $txt = 'COSTO TOTAL', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        	$pdf->Cell($w = 20, $h = $hGlobal, $txt = number_format($dataSource->getParameter('costoTotal'), 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		}*/
		
		//$pdf->copyPage(1);
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