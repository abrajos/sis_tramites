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

        //$this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], 16, 12, 36);
        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFontSize(12);
        $this->SetFont('', 'B');
        
        //$this->Cell(60, $longHeight, '', '', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(200, $longHeight, ' RESOLUCION MUNICIPAL TECNICO ', ' ', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Ln(5);
        $this->Cell(60, $longHeight, '', '', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(50, $longHeight, ' ADMINISTRATIVA N°  ', ' ', 0, 'J', false, '', 0, false, 'T', 'C');
        $this->Cell(40, $longHeight, $dataSource->getParameter('num_resolucion').' / 2025', ' ', 0, 'L', false, '', 0, false, 'T', 'C');
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
        
      //  $this->write2DBarcode($html, 'PDF417', $x+80, $y-5, 0, 30, $style, 'N');
        //$this->Text(20, 25, 'QRCODE M');
       // $this->Image(dirname(__FILE__) . '/../media/firma.png', 98, 220, 35, 35, '', '', '', false, 300, '', false, false, 0);
        
    } 

}

Class RResolucion extends Report {

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
        $pdf->AddPage('P', 'A4');

        $hGlobal = 5;
        $hMedium = 7.5;
        $hLong = 15;

        //var_dump($dataSource); exit;
		
        //$pdf->Cell($w = 30, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		//$pdf->SetFontSize(12);
		//if ($dataSource->getParameter('mostrar_costos') != 'no') {
				
           

				
			
			$pdf->SetFontSize(10);
			$pdf->SetFont('', 'N');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = 'A, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('dia_resolucion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                        
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('mes_resolucion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	  
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('anio_resolucion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Ln(4);
            $pdf->SetFont('', 'B');
	        $pdf->Cell($w = 7, $h = $hMedium, $txt = 'VISTOS: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->Ln(5);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 63, $h = $hMedium, $txt = 'La solicitud adjunta presentada para la ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 38, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 42, $h = $hMedium, $txt = strtoupper($dataSource->getParameter('nombre_tramite')), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->SetFont('', 'B');
	        $pdf->Cell($w = 7, $h = $hMedium, $txt = 'CONSIDERANDO: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);
            $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 65, $h = $hMedium, $txt = 'mediante memorial presentado en fecha ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	

            $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('dia'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('mes'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
	        $pdf->Cell($w = 8, $h = $hMedium, $txt = '  de  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	  
            $pdf->Cell($w = 10, $h = $hMedium, $txt = $dataSource->getParameter('anio'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = '  adjunta documentación que  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(5);
            $pdf->Cell($w = 65, $h = $hMedium, $txt = 'acredita su derecho propietario presentada por el Sr(a). : ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(4);

            if ( $dataSource->getParameter('tipo_persona') == "tramitador"){
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Cell($w = 70, $h = $hMedium, $txt = $dataSource->getParameter('nombre_completo1'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 12, $h = $hMedium, $txt = $dataSource->getParameter('ci'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('expedicion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->Ln(5);
            } else{
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Cell($w = 70, $h = $hMedium, $txt = $dataSource->getParameter('nombre_completo1'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 12, $h = $hMedium, $txt = $dataSource->getParameter('ci'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('expedicion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                $pdf->Ln(5);
                };

            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 35, $h = $hMedium, $txt = 'por lo que solicita la ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 40, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 45, $h = $hMedium, $txt = strtoupper($dataSource->getParameter('nombre_tramite')), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign= 'T', $valign = 'M');	
            

                                
            if ( $dataSource->getParameter('num_informeOT') != ""){
                                   
                $pdf->Ln(8);
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'según el  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 28, $h = $hMedium, $txt = 'Informe Técnico  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                              
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('num_informeOT'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'de fecha', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('fecha_regOT'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 50, $h = $hMedium, $txt = ', elaborado por el profesional ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario1OT'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ', como responsable de ordanamiento Territorial; refiere  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'que para la prosecución de tramite se debe respetar las proyecciones de la via.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 45, $h = $hMedium, $txt = $dataSource->getParameter('calleOT').' , '. $dataSource->getParameter('avenidaOT'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->Cell($w = 160, $h = $hMedium, $txt = ' de perfil de via que atravieza el predio segun PLANUR, dando cumplimiento a la normativa Urbana vigente para sus  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->Cell($w = 160, $h = $hMedium, $txt = ' respectivas cesiones. ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                          
            };
                       
            if ( $dataSource->getParameter('num_informeTop') != ''){
                                   
                $pdf->Ln(8);
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 12, $h = $hMedium, $txt = 'según  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = 'Informe Técnico Topográfico ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Cell($w = 25, $h = $hMedium, $txt = $dataSource->getParameter('num_informeTop'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'de fecha', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('fecha_regTop'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 60, $h = $hMedium, $txt = ', elaborado por el(la) profesional ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario1Top'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ', como Topografo de la  Dirección de Urbanismo y', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'Catastro; el predio objeto del presente tramite se encuentra ubicado en la Zona', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 45, $h = $hMedium, $txt = 'Zona '.$dataSource->getParameter('zonaTop').', Distrito '.$dataSource->getParameter('distritoTop'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->Cell($w = 85, $h = $hMedium, $txt = ' Manzano '.$dataSource->getParameter('manzanaTop').' , '.$dataSource->getParameter('calleTop').' , '.$dataSource->getParameter('avenidaTop'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 160, $h = $hMedium, $txt = 'Concluye recomendando dar continuidad al trámite ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->Cell($w = 160, $h = $hMedium, $txt = 'administrativo.  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                                    
            };
            //var_dump('legalinf: '.$dataSource->getParameter('num_informeLegal')); exit;
            if ( $dataSource->getParameter('num_informeLegal') != ''){
                                    
                $pdf->Ln(8);

                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 12, $h = $hMedium, $txt = 'según  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 30, $h = $hMedium, $txt = 'Informe Legal N° ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Cell($w = 27, $h = $hMedium, $txt = $dataSource->getParameter('num_informeLegal'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = ' de fecha ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('fecha_regLegal'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ' emitido  por ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 30, $h = $hMedium, $txt = 'el(la) profesional ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario1Legal'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ', como Abogado de la  Dirección de Urbanismo y Catastro quien', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 153, $h = $hMedium, $txt = 'refiere que el tramite ha cumplido con los requisitos legales, por lo que recomienda dar curso a la ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                                                    
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Ln(5);
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('nombre_tramite'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign= 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = 'que de acuerdo a la documentación presentada por:', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                                                    
                $pdf->Ln(5);
                   
                if ( $dataSource->getParameter('tipo_persona') == "propietario"){
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->Cell($w = 70, $h = $hMedium, $txt = $dataSource->getParameter('nombre_completo1'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->SetFont('', 'N');
                    $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $dataSource->getParameter('ci'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                    $pdf->Cell($w = 5, $h = $hMedium, $txt = $dataSource->getParameter('expedicion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln(5);
                };
               
                $pdf->Cell($w = 80, $h = $hMedium, $txt = 'quien es propietario de un predio de Superficie', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 25, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 85, $h = $hMedium, $txt = ' m2, debidamente registrado en Derechos Reales', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = 'bajo Matricula Computarizada N° ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 45, $h = $hMedium, $txt = $dataSource->getParameter('nro_matricula').', con asiento ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 85, $h = $hMedium, $txt = $dataSource->getParameter('asiento').', de'.$dataSource->getParameter('fecha_asiento'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 160, $h = $hMedium, $txt = 'y según Testimonio de Escritura Publica N° '.$dataSource->getParameter('nro_testimonio').' de Fecha escritura '.$dataSource->getParameter('fecha_testimonio').' otorgado por Nataria de Fe Publica N° '.$dataSource->getParameter('nro_notario'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                $pdf->Ln(5);
                $pdf->Cell($w = 160, $h = $hMedium, $txt = 'Nombre Notario '.$dataSource->getParameter('nombre_notario').'.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                                
            };
         
            if ( $dataSource->getParameter('nro_rmtaArq') != ''){
                $pdf->Ln(8);

                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'según el ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = 'Informe Técnico de Urbanismo ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            // $pdf->Cell($w = 25, $h = $hMedium, $txt = 'CITE INFORME', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'de fecha', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('fecha_regArq').', ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 60, $h = $hMedium, $txt = 'suscrito por el(la) profesional ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario1Arq').',', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ' como Arquitecto III de la  Dirección de Urbanismo y', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'Catastro; quien manifiesta  que de acuerdo al informe topográfico e informe Legal', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'correspondiente y previa verificación de los requisitos establecidos en la normativa aplicable ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'al caso, el trámite cumple las disposiciones del Reglamento PLANUR por lo que recomienda dar curso a la', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Ln(5);
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('nombre_tramite'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign= 'T', $valign = 'M');	
                $pdf->Ln(8);
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'presenta ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = 'Plano de Regularizacion y Division anteriormente aprobado con  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            // $pdf->Cell($w = 25, $h = $hMedium, $txt = 'CITE INFORME', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'R.M.T.A. N°', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('nro_rmtaArq').', ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 60, $h = $hMedium, $txt = 'de fecha  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('fecha_rmtaArq').',', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ' y que en virtud al articulo 133 del Reglamento para urbanizaciones y edificaciones', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'PLANUR, en concordancia y aplicacion del inciso b Articulo 48 c del Reglamento General de Urbanizaciones', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'y Subdivisión de propiedades Urbanas aprobado por O.M. 1061/1991 se encuentra exento del pago de cesiones. ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(8);

            } else {
                $pdf->Ln(8);

                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'según el ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = 'Informe Técnico de Urbanismo ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
               // $pdf->Cell($w = 25, $h = $hMedium, $txt = 'CITE INFORME', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 15, $h = $hMedium, $txt = 'de fecha', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('fecha_regArq').', ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 60, $h = $hMedium, $txt = 'suscrito por el(la) profesional ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('desc_funcionario1Arq').',', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'N');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = ' como Arquitecto III de la  Dirección de Urbanismo y', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'Catastro; quien manifiesta  que todas las propiedades que entren en proceso de urbanizacion y regularización tienen la', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'obligacion de ceder un porcentaje de superficie con destino a vias, áreas verdes y/o equipamientos de acuerdo al ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'articulo 3 modifica el articulo 33 del reglamento para Urbanizaciones y Edificaciones PLANUR en relación al porcentaje ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 125, $h = $hMedium, $txt = 'de cesiones obligatorias, por tanto otorga el porcentaje de cesiones obligatorias, por tanto otorga el porcentaje de ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->Ln(5);
                $pdf->Cell($w = 155, $h = $hMedium, $txt = 'cesion en vias de XX,XX m2 cumpliendo con lo establecido, por lo que recomienda dar curso a la ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('', 'B');
                $pdf->Cell($w = 35, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
                $pdf->Ln(5);
                $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('nombre_tramite'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign= 'T', $valign = 'M');	
                $pdf->Ln(8);
            };
           

            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 50, $h = $hMedium, $txt = 'según la boleta de liquidación', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = 'N° '.$dataSource->getParameter('nro_liquidacionBol'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = 'suscrito por ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
           $pdf->Cell($w = 45, $h = $hMedium, $txt = $dataSource->getParameter('nombre_completo1Bol').',', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 35, $h = $hMedium, $txt = ' como Arquitecta III ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Ln(5);
            $pdf->Cell($w = 105, $h = $hMedium, $txt = 'de la  Dirección de Urbanismo y Catastro y comprobante de pago', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = 'N° '.$dataSource->getParameter('comp_pagoBol'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 80, $h = $hMedium, $txt = 'expedido por la Dirección de Finanzas ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(5);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 37, $h = $hMedium, $txt = 'se acredita el pago de', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 22, $h = $hMedium, $txt = 'Bs. '.$dataSource->getParameter('montoBol'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 35, $h = $hMedium, $txt = 'monto literal  bolivianos en () en fecha ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(5);
            $pdf->Cell($w = 90, $h = $hMedium, $txt = $dataSource->getParameter('fecha_pagoBol').' , por concepto de la .  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 35, $h = $hMedium, $txt = 'APROBACION DE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('nombre_tramite'), $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign= 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 50, $h = $hMedium, $txt = '(Expediente N° ) '.$dataSource->getParameter('expedienteBol'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(8);

            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Que, ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 150, $h = $hMedium, $txt = 'en le presente caso, se han cumplido con los requisitos técnicos y administrativos exigidos por el', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 160, $h = $hMedium, $txt = 'Gobierno Autónomo Municipal de Colcapirhua, por lo que corresponde dar curso a lo impetrado.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(15);

            $pdf->SetFont('', 'B');
	        $pdf->Cell($w = 7, $h = $hMedium, $txt = 'POR TANTO: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 10, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Cell($w = 150, $h = $hMedium, $txt = 'El Secretario Municipal de Planificación de Órgano Ejecutivo del Gobierno Autónomo Municipal de Colcapirhua,', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 150, $h = $hMedium, $txt = 'conforme designación por Decreto Edil N° 09/2023 de fecha 04 de Mayo  de 2023 y en uso de las legitimas atribuciones', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 150, $h = $hMedium, $txt = 'que le confiere el Art. 29 numeral 13 de la Ley 482 de Gobiernos Autónomos Municipales.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(8);
            $pdf->SetFont('', 'B');
	        $pdf->Cell($w = 160, $h = $hMedium, $txt = 'RESUELVE ', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);
            $pdf->Cell($w = 180, $h = $hMedium, $txt = 'PRIMERO.- APROBAR PLANO DE  '.strtoupper($dataSource->getParameter('nombre_tramite')). '; del inmueble de', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);
            $pdf->Cell($w = 40, $h = $hMedium, $txt = 'propiedad de: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            
            if ( $dataSource->getParameter('tipo_persona') == "propietario") {
                $pdf->Cell($w = 70, $h = $hMedium, $txt = $dataSource->getParameter('nombre_completo1').' de acuerdo al siguiente detalle:', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            };	

            $pdf->Ln(7);
            $pdf->Cell($w = 160, $h = $hMedium, $txt = 'DATOS DE UBICACION: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);

            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Municipio: Colcapirhua', $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Zona: '.$dataSource->getParameter('zonaOT'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Distrito: '.$dataSource->getParameter('distritoTop'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Lote: '.$dataSource->getParameter('lote'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Manzano: '.$dataSource->getParameter('manzanaTop'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Via: '.$dataSource->getParameter('calleOT'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);

            $pdf->Cell($w = 160, $h = $hMedium, $txt = 'COLINDANCIAS: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);

            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Norte: '.$dataSource->getParameter('norte'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Este: '.$dataSource->getParameter('este'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Sud: '.$dataSource->getParameter('sud'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 90, $h = $hMedium, $txt = 'Oeste: '.$dataSource->getParameter('oeste'), $border = 'LRTB', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 160, $h = $hMedium, $txt = 'RELACION DE SUPERFICIE DE LOTE ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(7);
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 130, $h = $hMedium, $txt = strtoupper($dataSource->getParameter('nombre_tramite')), $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Ln(7);
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'DETALLE ', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = 'CANT. ', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'UNID. ', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Sup. Según Escritura: ', $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'M2', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Sup. Según Mesura: ', $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'M2', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Superficie Cesión en vias: ', $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'M2', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Superficie Total útil: ', $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'M2', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(7);
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 60, $h = $hMedium, $txt = 'Longitud de rasante: ', $border = 'LRTB', $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
            $pdf->Cell($w = 40, $h = $hMedium, $txt = $dataSource->getParameter('superficie'), $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'M2', $border = 'LRTB', $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln(10);
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 19, $h = $hMedium, $txt = 'SEGUNDO.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'Conforme el Art. 71 de la Ley 2492 del Nuevo Código Tributario en su ParágrafoI). Establece: Toda persona', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'natural o juridica de derecho Publico o Privado, sin costo alguno, está obligada a proporcionar a la Administración', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'Tributaria  Toda clase de datos, informes o antecedentes con efectos tributarios, emergentes de sus relaciones', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'económicas, profesionales o financieras con otras personas, cuando fuere requerido expresamente por la Administración', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'Tributaria. ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(10);
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 19, $h = $hMedium, $txt = 'TERCERO.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'de conformidad al articulo 39 del Reglamento para Urbanizaciones y Edificaciones (Planur) en  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'superficies menores a 190 m2 no se requiere la suscripcion de escrituras traslativas de dominio, al ser la superficie ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'de cesión en viasde 6.97 m2 no corresponde efectuar la respectiva escritura traslativa de dominio.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(10);
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 19, $h = $hMedium, $txt = 'CUARTO.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'La presente resolución MinucipalTecnica Administrativa no define, ni declara derecho propietario  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'sobre el predio, solo determina la situación fisica y la ubicación proporcionada por el impetrante, enmarcado en el ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'principio de buena fe de los datos proporcionados por la parte declarante siendo único y exclusivo responsable, deslindando', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'y exonerando de cualquier responsabilidad futura al Gobierno Autónomo Municipal de Colcapirhua.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(10);
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 19, $h = $hMedium, $txt = 'QUINTO.- ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'La Dirección de Urbanismo y Catastro queda encargado de supervigilar el cumplimiento de los ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'Reglamentos y Normas vigentes, aplicar sanciones pecuniarias al propietario en caso que las infrinja o que modifique ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(5);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'el proyecto aprobado con la presente Resolución Municipal Técnico Administrativa.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            $pdf->Ln(10);
            $pdf->Cell($w = 145, $h = $hMedium, $txt = 'Comuniquese a quien corresponda con copia para archivo respectivo.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
            
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