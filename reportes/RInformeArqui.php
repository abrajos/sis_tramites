<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';

class CustomReport extends TCPDF {
    private $dataSource;

    public function setDataSource(DataSource $dataSource) {
        $this->dataSource = $dataSource;
    }

    public function getDataSource() {
        return $this->dataSource;
    }

    // --- CABECERA SEGURA ---
    public function Header() {
        $dataSource = $this->getDataSource();
        $longHeight = 18;

        // Posición inicial fija dentro del área del Header
        $this->SetY(12);

        // Renderizado del Logo institucional
        $this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], 16, 12, 36);
        
        $this->SetFontSize(16);
        $this->SetFont('', 'B');
        $this->Cell(180, $longHeight, ' INFORME TÉCNICO', 0, 0, 'R', false, '', 0, false, 'T', 'C');
        $this->Ln(6);
        
        $this->SetFontSize(12);
        // La 'B' dibuja la línea divisoria inferior de la cabecera
        $this->Cell(180, $longHeight, $dataSource->getParameter('num_informe'), 'B', 0, 'R', false, '', 0, false, 'T', 'C');
        
        // Eliminamos el SetY(32) manual de aquí para que respete el margen general del documento
    }

    // --- PIE DE PÁGINA SEGURO ---
    public function Footer() {
        $dataSource = $this->getDataSource();
        
        // Nos posicionamos a 35mm antes del final de la hoja para asegurar espacio al QR
        $this->SetY(-35);
        $this->SetFont('helvetica', 'I', 7);
        
        // Forzamos saltos de línea naturales pasándole 1 en el parámetro ln
        $this->Cell(180, 4, 'Usuario: '.$dataSource->getParameter('de'), 0, 1, 'L');
        $this->Cell(180, 4, 'Página: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
        $html = 'Número Trámite: '.$dataSource->getParameter('num_informe')."\n"
               .'Trámite: '.$dataSource->getParameter('nombre_tramite')."\n"
               .'Usuario: '.$dataSource->getParameter('de')."\n"
               .'Sistema de Trámites ';
               
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1
        );
        
        // El QR se calcula de forma dinámica restando espacio al alto total real del documento
        $this->write2DBarcode($html, 'QRCODE,M', 170, $this->getPageHeight() - 32, 23, 23, $style, 'N');
    } 
}

class RInformeArqui extends Report {
    function write($fileName) {
        $propietariosList = "";
        
        // Inicialización con el tamaño personalizado (Oficio Boliviano: 215.9mm x 330mm)
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, array(215.9, 330), true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();
        
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // --- ZONAS DE PROTECCIÓN (MÁRGENES CORREGIDOS) ---
        // Incrementamos el margen superior a 42 para que el contenido empiece limpiamente abajo de la línea 'B'
        $pdf->SetMargins(16, 42, 16);
        $pdf->SetHeaderMargin(12);
        $pdf->SetFooterMargin(35);

        // SALTO AUTOMÁTICO CRÍTICO: Rompe la página 45mm antes del fondo físico para proteger el footer extendido
        $pdf->SetAutoPageBreak(TRUE, 45);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage('P', array(215.9, 330));
        $hMedium = 6.5;
        //var_dump($dataSource); exii();
        // --- SECCIÓN ENCABEZADO INTERNO (A:, Vía:, De:) ---
        $pdf->SetFontSize(10);
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, 'A: ', 0, 0, 'L');    
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('nombrea'), 0, 1, 'L');
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, '', 0, 0, 'L');    
        $pdf->SetFont('', 'I');
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('cargoa'), 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('', 'B');          
        $pdf->Cell(15, $hMedium, 'Vía: ', 0, 0, 'L');     
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('via'), 0, 1, 'L');
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, '', 0, 0, 'L');     
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('cargovia'), 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, 'De: ', 0, 0, 'L');      
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('de'), 0, 1, 'L');
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, '', 0, 0, 'L');     
        $pdf->Cell(165, $hMedium, $dataSource->getParameter('cargode'), 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $hMedium, 'Fecha: ', 0, 0, 'L');       
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $hMedium, 'Colcapirhua, '.$dataSource->getParameter('dia').' de '.$dataSource->getParameter('mes').' de '.$dataSource->getParameter('anio'), 0, 1, 'L');
        $pdf->Ln(2);
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(180, $hMedium, 'REF:      '.strtoupper($dataSource->getParameter('referencia')), 'B', 1, 'L');   
        $pdf->Ln(5);
        
        // --- 1. ANTECEDENTES ---
        $pdf->SetFont('', 'N');
        $pdf->writeHTMLCell(180, 0, '', '', '<b>1. ANTECEDENTES</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2);
        
        $names = "";
        $counter = 0;
        foreach ($dataSource->getDataSet() as $row) {
            if ($row['tipo_persona'] == "propietario"){
                if ($counter == 0) {
                    $names .= "<b>".$row['nombre_completo1']."</b> con C.I. N° <b>".$row['ci']." ".$row['expedicion']."</b>";
                } else {
                    $names .= ", <b>".$row['nombre_completo1']."</b> con C.I. N° <b>".$row['ci']." ".$row['expedicion']."</b>";
                }
                $counter++;
            }
        }
        
        $pdf->writeHTMLCell(180, 0, '', '', 'De acuerdo al memorial dirigido a su autoridad y a documentación presentada a esta Jefatura por: '.$names.' quien solicita la aprobación de : <b>'.$dataSource->getParameter('nombre_tramite').'</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'Correspondiente al inmueble ubicado en el Municipio de Colcapirhua; <b>Previo</b>: ', 0, 1, 0, true, 'J', true);
        $pdf->Ln(3);

        // --- TABLA DE INFORMES TÉCNICOS ---
        $htmlTable0 = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;" width="22%"><b>Inf. Legal N°:</b></td><td style="text-align: left;" width="12%">'.$dataSource->getParameter('inf_leg').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="12%"><b>Fecha:</b></td><td width="12%">'.$dataSource->getParameter('fecha_leg').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="15%"><b>A cargo de:</b></td><td width="28%">'.$dataSource->getParameter('legal').'</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Inf. Topográfico N°:</b></td><td>'.$dataSource->getParameter('inf_top').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Fecha:</b></td><td>'.$dataSource->getParameter('fecha_top').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>A cargo de:</b></td><td>'.$dataSource->getParameter('topo').'</td>
                        </tr>
                       </table>';
        $pdf->writeHTMLCell(180, 0, '', '', $htmlTable0, 0, 1, 0, true, 'J', true);
        $pdf->Ln(4);

        // --- CONDICIONALES DE TRÁMITE ANTIGUOS ---
        $array1 = array(10,11,16);
        $array2 = array(3,4,5,6,7,8,9,12,13,14,15,17,18,19,20,21,22,23);
        $idTipoTramite = $dataSource->getParameter('id_tipo_tramite');

        if (in_array($idTipoTramite, $array1) || in_array($idTipoTramite, $array2)) {
            $pdf->writeHTMLCell(180, 0, '', '', 'Quien realizó la inscripción respectiva para la verificación de la relación de superficies, limites, rasantes y otros tipos de servicios con la siguiente relación de superficies, bajo el siguiente detalle: ', 0, 1, 0, true, 'J', true);
            $pdf->Ln(3);
        }

        // --- 2. RELACIÓN DE SUPERFICIES ---
        $pdf->writeHTMLCell(180, 0, '', '', '<b>2. RELACIÓN DE SUPERFICIES</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        
        $htmlTable2 = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">
                        <tr style="background-color: #f5f5f5; font-weight: bold; text-align: center;">
                            <td width="50%">DETALLE</td>
                            <td width="25%">CANT.</td>
                            <td width="25%">UNIDAD</td>
                        </tr>
                        <tr>
                            <td>SUPERFICIE SEGÚN ESCRITURA</td>
                            <td style="text-align: right;">'.$dataSource->getParameter('super_escritura').'</td>
                            <td style="text-align: center;">m2</td>
                        </tr>
                        <tr>
                            <td>SUPERFICIE SEGÚN MENSURA</td>
                            <td style="text-align: right;">'.$dataSource->getParameter('super_mensura').'</td>
                            <td style="text-align: center;">m2</td>
                        </tr>
                        <tr>
                            <td><b>SUPERFICIE TOTAL ÚTIL</b></td>
                            <td style="text-align: right;"><b>'.$dataSource->getParameter('super_total').'</b></td>
                            <td style="text-align: center;">m2</td>
                        </tr>
                        <tr>
                            <td>LONGITUD RASANTE</td>
                            <td style="text-align: right;">'.$dataSource->getParameter('long_rasante').'</td>
                            <td style="text-align: center;">m</td>
                        </tr>
                       </table>';
        $pdf->writeHTMLCell(180, 0, '', '', $htmlTable2, 0, 1, 0, true, 'J', true);
        $pdf->Ln(4);

        // --- 3. UBICACIÓN ---
        $pdf->writeHTMLCell(180, 0, '', '', '<b>3. UBICACIÓN</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $htmlTable1 = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;" width="20%"><b>Zona:</b></td><td width="30%">'.$dataSource->getParameter('zona').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="20%"><b>Lote:</b></td><td width="30%">'.$dataSource->getParameter('lote').'</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Distrito:</b></td><td>'.$dataSource->getParameter('distrito').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Calle:</b></td><td>'.$dataSource->getParameter('calle').'</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Manzana:</b></td><td>'.$dataSource->getParameter('manzana').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Avenida:</b></td><td>'.$dataSource->getParameter('avenida').'</td>
                        </tr>
                       </table>';
        $pdf->writeHTMLCell(180, 0, '', '', $htmlTable1, 0, 1, 0, true, 'J', true);
        $pdf->Ln(4);

        // --- 4. COLINDANCIAS GENERALES ---
        $pdf->writeHTMLCell(180, 0, '', '', '<b>4. COLINDANCIAS GENERALES</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);

        $htmlTable3 = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;" width="20%"><b>NORTE:</b></td><td width="30%">'.$dataSource->getParameter('colindante_norte').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="20%"><b>SUD:</b></td><td width="30%">'.$dataSource->getParameter('colindante_sur').'</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>ESTE:</b></td><td>'.$dataSource->getParameter('colindante_este').'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>OESTE:</b></td><td>'.$dataSource->getParameter('colindante_oeste').'</td>
                        </tr>
                       </table>';
        $pdf->writeHTMLCell(180, 0, '', '', $htmlTable3, 0, 1, 0, true, 'J', true);
        $pdf->Ln(4);

        // --- ACLARACIONES Y CONCLUSIÓN ---
        $pdf->writeHTMLCell(180, 0, '', '', '<b>ACLARACIONES: </b>'.$dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', '<b>EL PREDIO CUENTA CON '.$dataSource->getParameter('tipo_aprobacion'). ' CON R.M.T.A. N° '.$dataSource->getParameter('nro_rmta').' DE FECHA '.$dataSource->getParameter('fecha_rmta').'</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'Por tanto:', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'En el Departamento de Normas Urbanas de la Dirección de Urbanismo y Catastro, revisado los informes adjuntos a la carpeta, se efectuó la verificación de los requisitos según reglamentación general de urbanismo y de subdivisión de propiedades urbanas, así como el reglamento de edificaciones en actual vigencia, por lo que se procedió al llenado de la Boleta de Liquidación No. '.$dataSource->getParameter('nro_boleta').' de aprobación de planos relativos a la propiedad citada para la prosecución del trámite administrativo.', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'Dando cumplimiento al decreto municipal N° 002 de fecha 18 de marzo de 2016', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo de la inspección realizada.', 0, 1, 0, true, 'J', true);
        
        // --- CONTROL DE DESBORDE DE FIRMA ---
        // Si el final del texto está a menos de 55mm del límite de salto de página, forzamos nueva hoja para evitar firmas huérfas
        if ($pdf->GetY() > ($pdf->getPageHeight() - 55)) {
            $pdf->AddPage();
        } else {
            $pdf->Ln(12);
        }

        $pdf->writeHTMLCell(180, 0, '', '', '<b>' . $dataSource->getParameter('de') . '</b><br>' . $dataSource->getParameter('cargode'), 0, 1, 0, true, 'C', true);

        // Renderizado del PDF
        $pdf->Output($fileName, 'F');
    }
}
?>
