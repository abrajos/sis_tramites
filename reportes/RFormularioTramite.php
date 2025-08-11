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
        $this->SetFontSize(14);
        $this->SetFont('', 'B');
        //$this->Cell(0, $longHeight, '', '', 0, 'C', false, '', 0, false, 'T', 'C');
        $this->Cell(180, $longHeight, ' FORMULARIO DE SOLICITUD DE TRAMITE', ' ', 0, 'C', false, '', 0, false, 'T', 'C');

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
        
        $this->write2DBarcode($html, 'QRCODE,M', 170, 230, 30, 30, $style, 'N');
        
      //  $this->write2DBarcode($html, 'PDF417', $x+80, $y-5, 0, 30, $style, 'N');
        //$this->Text(20, 25, 'QRCODE M');
       // $this->Image(dirname(__FILE__) . '/../media/firma.png', 98, 220, 35, 35, '', '', '', false, 300, '', false, false, 0);
        
    } 

}

Class RFormularioTramite extends Report {

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
        $pdf->AddPage('P', 'LETTER');

        $hGlobal = 5;
        $hMedium = 7.5;
        $hLong = 15;

        //var_dump($dataSource); exit;
		
        //$pdf->Cell($w = 30, $h = $hGlobal, $txt = '', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		//$pdf->SetFontSize(12);
		//if ($dataSource->getParameter('mostrar_costos') != 'no') {
				
           

				
			
			$pdf->SetFontSize(12);
			$pdf->SetFont('', 'N');
            $pdf->Cell($w = 110, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
	        $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Nro. : ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
	        $pdf->Cell($w = 20, $h = $hMedium, $txt = $dataSource->getParameter('cite_tramite'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
			$pdf->Ln();
            $pdf->Ln();
            $pdf->SetFontSize(10);
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 7, $h = $hMedium, $txt = 'Yo: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	
			$pdf->SetFont('', 'B');
            foreach ($dataSource->getDataSet() as $row) {
                
                $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ( $tipo_persona == "tramitador"){
                    $pdf->Cell($w = 60, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                    $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                    $pdf->SetFont('', 'N');
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = 'Domiciliado en : ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['domicilio'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                } else {
                    $pdf->Cell($w = 60, $h = $hMedium, $txt = $row['nombre_completo1'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->SetFont('', 'N');
	                $pdf->Cell($w = 18, $h = $hMedium, $txt = 'con C.I. N°: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 12, $h = $hMedium, $txt = $row['ci'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 7, $h = $hMedium, $txt = '  ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   	
                    $pdf->Cell($w = 5, $h = $hMedium, $txt = $row['expedicion'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                    $pdf->SetFont('', 'N');
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = 'Domiciliado en : ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['domicilio'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                };                 
            };
            $pdf->Ln();
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'Solicito el tramite: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('nombre_tramite'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Ln();
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 48, $h = $hMedium, $txt = 'del bien inmueble situado en: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 50, $h = $hMedium, $txt = $dataSource->getParameter('ubicacion'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Ln();
            $pdf->SetFont('', 'N');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = 'de propiedad de: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
            $pdf->Ln();
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
            foreach ($dataSource->getDataSet() as $row) {
                $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                
            /*
                if ( $tipo_persona == "propietario"){
                    $pdf->SetFont('', 'B');
                    $pdf->Cell($w = 70, $h = $hMedium, $txt = $row['tipo_persona'], $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');	
                    $pdf->Ln();
                };    */
                if ( $tipo_persona == "apoderado"){
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
            $pdf->Ln(15);
            $pdf->SetFont('', 'N');
	        $pdf->Cell($w = 60, $h = $hMedium, $txt = ' Colcapirhua  ', $border = 0, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');	   
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
	   
			
			$pdf->SetFontSize(7.5);
			$pdf->SetFont('', '');
	        $wMargin = 15;
	        $wNro = 10;
	        $wCodigo = 15;
	        $wDetalle = 25;
	        $wTotal = 20;
			$totalVaca = 0;
	

	        $pdf->Ln();
	        $pdf->Ln(30);
	        $pdf->Ln();
               
	        //$pdf->AddPage();
	    //}

        $pdf->SetFontSize(8);
        $pdf->SetFont('', 'B');
		
		$pdf->Cell($w = 46, $h = $hGlobal, $txt = 'FIRMA INTERESADO Y/O APODERADO', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Cell($w = 40, $h = $hGlobal, $txt = '   ', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	    $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'SELLO FIRMA FUNCIONARIO RESPONSABLE', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Cell($w = 40, $h = $hGlobal, $txt = '   ', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
	    $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'DE VENTANILLA UNICA', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
		$pdf->Ln();
        $pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'El presente formulario sirve para el encaminamiento y seguimiento de tramite, asi mismo concluido el tramite sera entregado', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln();
        $pdf->Cell($w = 46, $h = $hGlobal, $txt = 'al propietario.', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        /*$pdf->Cell($w = 0, $h = $hMedium, $txt = 'DETALLE DE MATERIALES', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
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