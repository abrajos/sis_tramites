<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';
//require_once dirname(__FILE__) . '/../../lib/tcpdf/tcpdf.php';
//ini_set('display_errors', 'On');
class CustomReport extends TCPDF
{

    private $dataSource;

    public function setDataSource(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getDataSource()
    {
        return $this->dataSource;
    }

    // --- AÑADE ESTO AQUÍ ---
    public function verificarEspacio($h)
    {
        return $this->checkPageBreak($h);
    }

    public function Header()
    {
        $dataSource = $this->getDataSource();

        // 1. Dibujar el Logo
        $logo = dirname(__FILE__) . '/../../lib' . $_SESSION['_DIR_LOGO'];
        if (file_exists($logo)) {
            $this->Image($logo, 15, 10, 35); // Posición fija solo para la imagen
        }

        // 2. Título del Informe
        $this->SetY(10); // Iniciamos en la parte superior
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'INFORME TECNICO', 0, 1, 'R');

        // 3. Número de Informe con línea inferior
        $this->SetFont('helvetica', 'B', 12);
        // El '1' al final del Cell es VITAL para el salto de línea automático
        $this->Cell(0, 8, $dataSource->getParameter('num_informe'), 'B', 1, 'R');

        // NO poner SetXY aquí. El margen superior hará el trabajo.
    }


    public function Footer()
    {
        $dataSource = $this->getDataSource();

        // Posicionarse a 15mm del final
        $this->SetY(-25);
        $this->SetFont('helvetica', 'I', 8);

        // Imprime los datos alineados a la izquierda
        $this->Cell(180, 4, 'Usuario: ' . $dataSource->getParameter('de'), 0, 1, 'L');
        $this->Cell(180, 4, 'SISTEMA DE TRAMITES - G.A.M.C.', 0, 1, 'L');

        // Imprime la página centrada (dejando el salto de línea al final)
        $this->Cell(180, 4, 'Página: ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 1, 'C');

        // Configuración del QR
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1
        );

        // QR fijo a la derecha, cerca del margen inferior
        $this->write2DBarcode($dataSource->getParameter('num_informe'), 'QRCODE,M', 170, $this->getPageHeight() - 35, 25, 25, $style, 'N');
    }
}

class RInformeTopo extends Report
{

    function write($fileName)
    {
        // 1. Instancia con configuración de márgenes estrictos
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();

        // Márgenes: Izquierdo=15, Superior=45 (espacio para Header), Derecho=15
        $pdf->SetMargins(15, 40, 15);
        $pdf->SetAutoPageBreak(TRUE, 40); // 40mm de margen inferior para el QR/Footer
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        $pdf->AddPage('P', array(215.9, 330)); // Tamaño Oficio
        $pdf->SetFontSize(10);

        //var_dump($dataSource); exit();

        $dataset = $dataSource->getDataset(); 
        // 2. Apuntamos a la posición [0] (Tanto personas como matrículas están aquí adentro)
        //var_dump($dataset); exit();


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
        $pdf->Cell($w = 10, $h = $hMedium, $txt = 'Colcapirhua, ' . $dataSource->getParameter('dia') . ' de ' . $dataSource->getParameter('mes') . ' de ' . $dataSource->getParameter('anio'), $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
        $pdf->Ln(5);
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 180, $h = $hMedium, $txt = 'REF:       ' . strtoupper($dataSource->getParameter('referencia')), 'B', $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln(8);
        $pdf->SetFont('', 'N');
        $pdf->writeHTMLCell(180, 0, '', '', 'Señor Arquitecto', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', 'Se procede a la inspección y verificación técnica del expediente del trámite administrativo N°  ' . $dataSource->getParameter('cite_tramite') . ', Con referencia a la aprobación de: ' . strtoupper($dataSource->getParameter('nombre_tramite')), 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', 'Corresponde informar que el predio se encuentra dentro de la jurisdicción de Colcapirhua ubicado en:', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

        /////////////////////////////////////////////////////////////
        // Nuevo data set agrupado
        /////////////////////////////////////////////////////////////
        // 1. Obtener el array del dataset original
        $tablaDatos = $dataSource->getDataset();

        // 2. Inicializar los contenedores para tus nuevos grupos independientes
        $grupo_datos_tecnicos = [];
        $grupo_cesion_lote    = [];
        $grupo_vias           = [];
        $grupo_construccion   = [];

        // 3. Procesar y agrupar el dataset
        if (!empty($tablaDatos) && is_array($tablaDatos)) {
            foreach ($tablaDatos as $fila) {
                
                // --- GRUPO 1: Datos Técnicos (Se excluye manzana == 'VIAS') ---
                if (strtoupper($fila['manzana']) !== 'VIAS') {
                    $llaveTecnica = $fila['distrito'] . '|' . $fila['zona'] . '|' . $fila['manzana'] . '|' . $fila['super_total'];
                    
                    if (!isset($grupo_datos_tecnicos[$llaveTecnica])) {
                        $grupo_datos_tecnicos[$llaveTecnica] = [
                            "distrito"           => $fila['distrito'],
                            "zona"               => $fila['zona'],
                            "manzana"            => $fila['manzana'],
                            "lote"               => $fila['lote'],
                            "calle"              => $fila['calle'],
                            "avenida"            => $fila['avenida'],
                            "tipo_calle"         => $fila['tipo_calle'],
                            "rasante_municipal"  => $fila['rasante_municipal'],
                            "colindante_norte"   => $fila['colindante_norte'],
                            "colindante_sur"     => $fila['colindante_sur'],
                            "colindante_oeste"   => $fila['colindante_oeste'],
                            "colindante_este"    => $fila['colindante_este'],
                            "super_escritura"    => $fila['super_escritura'],
                            "super_mensura"      => $fila['super_mensura'],
                            "super_excedente"    => $fila['super_excedente'],
                            "super_inexistente"  => $fila['super_inexistente'],
                            "super_total"        => $fila['super_total'],
                            "long_rasante"       => $fila['long_rasante'],
                            "vias"               => $fila['vias'],
                            "agua_potable"       => $fila['agua_potable'],
                            "alcantarillado"     => $fila['alcantarillado'],
                            "alumbrado_publico"  => $fila['alumbrado_publico'],
                            "telefonia"          => $fila['telefonia'],
                            "equipamiento"       => $fila['equipamiento'],
                            "transporte"         => $fila['transporte']
                        ];
                    }
                }

                // --- ESTRUCTURA FILTRADA PARA LOS SUBGRUPOS ---
                // Construimos un array limpio que solo contiene los 9 campos solicitados
                $datosReducidos = [
                    "manzana"         => $fila['manzana'],
                    "tipo_cesion"     => $fila['tipo_cesion'],
                    "nombre_lote"     => $fila['nombre_lote'],
                    "superficie_lote" => $fila['superficie_lote'],
                    "porcentaje"      => $fila['porcentaje'],
                    "co_norte"        => $fila['co_norte'],
                    "co_sud"          => $fila['co_sud'],
                    "co_este"         => $fila['co_este'],
                    "co_oeste"        => $fila['co_oeste']
                ];

                // --- GRUPO 2: Cesión Lote ---
                if ($fila['tipo_cesion'] === 'lote' && strtoupper($fila['manzana']) !== 'VIAS') {
                    $grupo_cesion_lote[$fila['manzana']][] = $datosReducidos;
                }

                // --- GRUPO 3: Vías ---
                if (strtoupper($fila['manzana']) === 'VIAS' && ($fila['tipo_cesion'] === 'via' || $fila['tipo_cesion'] === 'area_verde')) {
                    $grupo_vias[] = $datosReducidos;
                }

                // --- GRUPO 4: Construcción ---
                if ($fila['tipo_cesion'] === 'construccion') {
                    $grupo_construccion[$fila['manzana']][] = $datosReducidos;
                }
            }
            
            // Limpiar índices string del grupo técnico
            $grupo_datos_tecnicos = array_values($grupo_datos_tecnicos);
        }

        // 4. Estructura final unificada
        $resultadoFinal = [
            "parameters" => $dataSource->getParameters(),
            "dataset_grupos" => [
                "datos_tecnicos" => $grupo_datos_tecnicos,
                "cesion_lotes"   => $grupo_cesion_lote,
                "vias"           => $grupo_vias,
                "construccion"   => $grupo_construccion
            ]
        ];

        $datosTecnicos = $resultadoFinal['dataset_grupos']['datos_tecnicos'];
        //var_dump($resultadoFinal); exit();

        $table0 = '<table border="1" style="width: 100%; border-collapse: collapse;">
                <tbody>
                    ';
        $num = 1;    
        if (!empty($datosTecnicos) && is_array($datosTecnicos)) {
            foreach ($datosTecnicos as $fila){
                $table01 = '';
                $numberRow = 14;
                if ($fila['rasante_municipal'] == 'SI') {
                    $numberRow = 17;
                    $table01 .=  '<tr>
                                    <td colspan="2" style="text-align: center;"><b>COLINDANTES</b></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><b>Colindante Oeste: </b>' . $fila['colindante_oeste'] . '</td>
                                    <td style="text-align: left;"><b>Colindante Sur: </b>' . $fila['colindante_sur'] . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><b>Colindante Este: </b>' . $fila['colindante_este'] . '</td>
                                    <td style="text-align: left;"><b>Colindante Norte: </b>' . $fila['colindante_norte'] . '</td>
                                </tr>';
                }
                $table0 .= '<tr>
                                <td colspan="3" style="text-align: left;"><b>DATOS TECNICOS</b></td>
                            </tr>
                            <tr>
                                <td rowspan="'.$numberRow.'" style="vertical-align: middle;" width="10%"><br><br><br>'.$num.'</td> 
                                <td style="text-align: left;" width="45%"><b>Distrito: </b>' . $fila['distrito'] . '</td>
                                <td style="text-align: left;" width="45%"><b>Zona: </b>' . $fila['zona'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Manzano: </b>' . $fila['manzana'] . '</td>
                                <td style="text-align: left;"><b>Tipo de Calle: </b>' . $fila['tipo_calle'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Rasante Municipal: </b>' . $fila['rasante_municipal'] . '</td>
                                <td style="text-align: left;"><b>Longitud Rasante: </b>' . $fila['long_rasante'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>Calle: </b>' . $fila['calle'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>Avenida: </b>' . $fila['avenida'] . '</td>
                            </tr>';
                $table0 .= $table01;
                $table0 .=  '<tr>
                                <td colspan="2" style="text-align: center;"><b>SUPERFICIES</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Sup. Escritura: </b>' . $fila['super_escritura'] . '</td>
                                <td style="text-align: left;"><b>Sup. Mensura: </b>' . $fila['super_mensura'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Sup. Excedente: </b>' . $fila['super_excedente'] . '</td>
                                <td style="text-align: left;"><b>Sup. Inexistente: </b>' . $fila['super_inexistente'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>Sup. Total: </b>' . $fila['super_total'] . '</td>
                            </tr>';
                $table0 .= '<tr>
                                <td colspan="2" style="text-align: center;"><b>SERVICIOS BÁSICOS</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Agua Potable: </b>' . $fila['agua_potable'] . '</td>
                                <td style="text-align: left;"><b>Alcantarillado: </b>' . $fila['alcantarillado'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Alumbrado Publ.: </b>' . $fila['alumbrado_publico'] . '</td>
                                <td style="text-align: left;"><b>Telefonía: </b>' . $fila['telefonia'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>Vias: </b>' . $fila['vias'] . '</td>
                                <td style="text-align: left;"><b>Transporte: </b>' . $fila['transporte'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>Equipamiento: </b>' . $fila['equipamiento'] . '</td>
                            </tr>';
                $num++;
            }
        }
        $table0 .= '</tbody>
                    </table>';

        $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        
        
        $pdf->writeHTMLCell(180, 0, '', '', '<b>OBSERVACIONES.- </b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        //$pdf->writeHTMLCell(180, 0, '', '', 'El plano de lote tiene una aprobacion con rmta:nº445/2014 en fecha 11/06/2014, el predio se encuentra delimitado con muro consolidado, existe construccion dentro del inmueble a la fecha, se controlo la medicion,  la inspeccion y mensura  en presencia e indicacion del interesado, segun el estatuto del funcionario publico y reglamento art. 4 - inciso e) "principio de buena fe", es cuanto informo respecto a la relacion de superficies, limites, rasantes y tipo de servicio para consideracion y visto bueno de su jefatura.', 0, 1, 0, true, 'J', true);
        //$pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!

        $pdf->writeHTMLCell(160, 0, 25, '', $table3, 0, 1, 0, true, 'R', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES.- </b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('conclusion'), 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        

        $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo de la inspección realizada.', 0, 1, 0, true, 'J', true);
        $pdf->Ln(18.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('de') . '<br>' . $dataSource->getParameter('cargode'), 0, 1, 0, true, 'C', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!




        $datasetiNICIAL = $dataset[0]["lote"];
        if ($datasetiNICIAL == "si") {
            $pdf->AddPage();
            $pdf->SetFont('', 'B');
            $pdf->SetFontSize(16);
            $pdf->Cell($w = 180, $h = $hMedium, $txt = 'ANEXOS', $border = 0, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Ln(8);
            $pdf->SetFontSize(10);
            $pdf->Cell($w = 180, $h = $hMedium, $txt = 'RELACION Y DIVISION DE LOTES', $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Ln(7);
            ////////////////////////////////////////////////////////////////////
            // Adecuacion anexos por grupo de manzano, lote, via y construccion
            ////////////////////////////////////////////////////////////////////
            $datosLote = $resultadoFinal['dataset_grupos']['cesion_lotes'];

            $tableCesion = '<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="4">
                                <tbody>
                                <tr>
                                    <td colspan="3" style="text-align: left; background-color: #f2f2f2; font-weight: bold;">DATOS TECNICOS: LOTES VINCULADAS</td>
                                </tr>';

            if (!empty($datosLote) && is_array($datosLote)) {
                foreach ($datosLote as $nombreManzana => $lotes) {
                    
                    // Cabecera de la manzana
                    $tableCesion .= '<tr>
                                        <td colspan="3" style="text-align: left; background-color: #f2f2f2;"><b>MANZANA: </b>'.htmlspecialchars($nombreManzana) .'</td>
                                    </tr>';
                    
                    $totalPercent = 0;
                    $totalSuperficie = 0; // Agregada para que sume real en el total del bloque

                    foreach ($lotes as $lote) {
                        // Corregido el <tr"> y el <td> style=
                        $tableCesion .= '<tr>
                                            <td style="text-align: left;" width="40%"><b>'.$lote['nombre_lote'].'</b></td>
                                            <td style="text-align: right;" width="30%">'.$lote['superficie_lote'].' M2</td>
                                            <td style="text-align: right;" width="30%">'.$lote['porcentaje'].'%</td>
                                        </tr>';
                        
                        $totalPercent += floatval($lote['porcentaje']);
                        $totalSuperficie += floatval($lote['superficie_lote']);
                    }
                    
                    // Fila de Totales por Manzana (Corregida sintaxis)
                    $tableCesion .= '<tr>
                                        <td style="text-align: right;"><b>TOTAL:</b></td>
                                        <td style="text-align: right; font-weight: bold;">'.$totalSuperficie.' M2</td>
                                        <td style="text-align: right; font-weight: bold;">'.$totalPercent.'%</td>
                                    </tr>';
                }
                
                // El cierre del tbody y table debe ir FUERA del bucle principal si es una sola tabla
                $tableCesion .= '</tbody>
                            </table>';

                // Imprimir la tabla en el PDF
                $pdf->SetFont('helvetica', '', 10);
                $pdf->writeHTMLCell(180, 0, '', '', $tableCesion, 0, 1, 0, true, 'J', true);
            }
        
            $pdf->Ln(2.5);
            $datosVias = $resultadoFinal['dataset_grupos']['vias'];

            if (!empty($datosVias) && is_array($datosVias)) {
                
                // 1. SOLUCIÓN AL ERROR: Inicializar siempre la tabla antes de concatenar filas
                $tableVias = '<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="4">
                                <tbody>
                                <tr>
                                    <td colspan="3" style="text-align: left; background-color: #f2f2f2; font-weight: bold;">DATOS TECNICOS: VIAS Y AREAS VERDES VINCULADAS</td>
                                </tr>';

                foreach ($datosVias as $via) { // Cambiado a $via para que coincida abajo
                    
                    // Obtener el nombre de la manzana real ("manzana" según tu var_dump)
                    $nombreManzana = !empty($via['manzana']) ? $via['manzana'] : 'VIAS';
                    
                    // Si el lote viene vacío, le ponemos un texto genérico descriptivo
                    $nombreVia = !empty($via['nombre_lote']) ? $via['nombre_lote'] : 'Uso de Vía Pública';

                    // Cabecera de la sección
                    $tableVias .= '<tr>
                                        <td colspan="3" style="text-align: left; background-color: #f2f2f2; font-weight: bold;">REFERENCIA: ' . htmlspecialchars($nombreManzana) . '</td>
                                </tr>';
                    
                    $totalPercent = floatval($via['porcentaje']);
                    $totalSuperficie = floatval($via['superficie_lote']);
                    
                    // Fila de Datos de la vía
                    $tableVias .= '<tr>
                                        <td style="text-align: left;" width="40%"><b>' . $via['tipo_cesion'] . '</b></td>
                                        <td style="text-align: right;" width="30%">' . $via['superficie_lote'] . ' M2</td>
                                        <td style="text-align: right;" width="30%">' . $via['porcentaje'] . '%</td>
                                </tr>';
                    
                    // Fila de Totales
                    $tableVias .= '<tr>
                                        <td style="text-align: right;"><b>TOTAL:</b></td>
                                        <td style="text-align: right; font-weight: bold;">' . $totalSuperficie . ' M2</td>
                                        <td style="text-align: right; font-weight: bold;">' . $totalPercent . '%</td>
                                </tr>';
                }
                
                // Cierre estructurado del HTML
                $tableVias .= '</tbody>
                            </table>';

                // Imprimir la tabla de manera segura en el PDF
                $pdf->SetFont('helvetica', '', 10);
                $pdf->writeHTMLCell(180, 0, '', '', $tableVias, 0, 1, 0, true, 'J', true);
            }

            $pdf->Ln(2.5);
            //$pdf->Ln();
            $datosConstruccion = $resultadoFinal['dataset_grupos']['construccion'];

            if (!empty($datosConstruccion) && is_array($datosConstruccion)) {
                
                // --- NORMALIZACIÓN DE ESTRUCTURA ---
                // Detectamos si el array viene SIN manzanas (es decir, el primer índice es 0)
                if (isset($datosConstruccion[0])) {
                    // Lo transformamos al formato agrupado asignándole una cabecera genérica
                    $datosNormalizados = array("INFORMACIÓN GENERAL" => $datosConstruccion);
                } else {
                    // Si ya viene con nombres de manzana, lo dejamos tal cual
                    $datosNormalizados = $datosConstruccion;
                }
                // -------------------------------------

                $tableConstruccion = '<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="4">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="text-align: left; background-color: #f2f2f2; font-weight: bold;">DATOS TECNICOS: CONSTRUCCIONES VINCULADAS</td>
                                            </tr>';

                // Ahora iteramos siempre sobre el array normalizado
                foreach ($datosNormalizados as $nombreManzana => $listaLotes) { 
                    
                    // Cabecera de la sección o manzana
                    $tableConstruccion .= '<tr>
                                                <td colspan="3" style="text-align: left; background-color: #f2f2f2; font-weight: bold;">MANZANA: ' . htmlspecialchars($nombreManzana) . '</td>
                                        </tr>';
                    
                    $totalPercent = 0;
                    $totalSuperficie = 0;

                    foreach ($listaLotes as $item) {
                        // Validamos por si acaso que el item interno realmente sea un array
                        if (!is_array($item)) {
                            continue;
                        }

                        $totalPercent += floatval($item['porcentaje']);
                        $totalSuperficie += floatval($item['superficie_lote']);
                        
                        $nombreLote = !empty($item['nombre_lote']) ? $item['nombre_lote'] : 'Ítem';
                        $tipoCesion = !empty($item['tipo_cesion']) ? ' (' . $item['tipo_cesion'] . ')' : '';

                        // Fila de Datos
                        $tableConstruccion .= '<tr>
                                                    <td style="text-align: left;" width="40%"><b>' . htmlspecialchars($nombreLote . $tipoCesion) . '</b></td>
                                                    <td style="text-align: right;" width="30%">' . $item['superficie_lote'] . ' M2</td>
                                                    <td style="text-align: right;" width="30%">' . $item['porcentaje'] . '%</td>
                                            </tr>';
                    }
                    
                    // Fila de Totales
                    $tableConstruccion .= '<tr>
                                                <td style="text-align: right;"><b>TOTAL:</b></td>
                                                <td style="text-align: right; font-weight: bold;">' . $totalSuperficie . ' M2</td>
                                                <td style="text-align: right; font-weight: bold;">' . $totalPercent . '%</td>
                                        </tr>';
                }
                
                $tableConstruccion .= '</tbody>
                                    </table>';

                // Imprimir en el PDF sin errores de TCPDF
                $pdf->SetFont('helvetica', '', 10);
                $pdf->writeHTMLCell(180, 0, '', '', $tableConstruccion, 0, 1, 0, true, 'J', true);
            }








            /*
            foreach ($dataSource->getDataSet() as $row) {
                $pdf->SetFontSize(10);
                $pdf->SetFont('', 'N');
                $total_area;
                $total_via;
                $total_lote;

                $total_area_p;
                $total_via_p;
                $total_lote_p;
                // $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ($row['tipo_cesion'] == "lote") {
                    $total_lote = $total_lote + floatval($row['superficie']);
                    $total_lote_p = $total_lote_p + $row['porcentaje'];
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = $row['tipo_cesion'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 50, $h = $hMedium, $txt = $row['nombre'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['superficie'] . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['porcentaje'] . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Ln();
                };
            };
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 80, $h = $hMedium, $txt = 'SUP. TOTAL UTIL ', $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt =  $total_lote . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = $total_lote_p . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');

            $pdf->Ln();

            foreach ($dataSource->getDataSet() as $row) {
                $pdf->SetFontSize(10);
                $pdf->SetFont('', 'N');
                $total_area;
                $total_via;
                $total_lote;

                $total_area_p;
                $total_via_p;
                $total_lote_p;
                // $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ($row['tipo_cesion'] == "area_verde") {
                    $total_area = $total_area + floatval($row['superficie']);
                    $total_area_p = $total_area_p + $row['porcentaje'];
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = $row['tipo_cesion'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 50, $h = $hMedium, $txt = $row['nombre'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['superficie'] . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['porcentaje'] . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Ln();
                };
            };
            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 80, $h = $hMedium, $txt = 'SUP. TOTAL AREA VERDE', $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt =  $total_area . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = $total_area_p . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');

            $pdf->Ln();
            foreach ($dataSource->getDataSet() as $row) {
                $pdf->SetFontSize(10);
                $pdf->SetFont('', 'N');
                $total_area;
                $total_via;
                $total_lote;

                $total_area_p;
                $total_via_p;
                $total_lote_p;
                // $tipo_persona = $row['tipo_persona'];
                //var_dump("tipo: ",$tipo_persona); 
                if ($row['tipo_cesion'] == "via") {
                    $total_via = $total_via + floatval($row['superficie']);
                    $total_via_p = $total_via_p + $row['porcentaje'];
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 30, $h = $hMedium, $txt = $row['tipo_cesion'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 50, $h = $hMedium, $txt = $row['nombre'], $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['superficie'] . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Cell($w = 20, $h = $hMedium, $txt = $row['porcentaje'] . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
                    $pdf->Ln();
                };
            };

            $pdf->SetFont('', 'B');
            $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 80, $h = $hMedium, $txt = 'SUP. TOTAL VIA ', $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt =  $total_via . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = $total_via_p . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Ln();
            $pdf->Cell($w = 30, $h = $hMedium, $txt = ' ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 80, $h = $hMedium, $txt = 'SUP. LOTE - S/MENSURA ', $border = 1, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt =  ($total_via + $total_area + $total_lote) . ' m2', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Cell($w = 20, $h = $hMedium, $txt = ($total_via_p + $total_area_p + $total_lote_p) . ' %', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'L');
            $pdf->Ln();
            */
        };
        
        $pdf->Output($fileName, 'F');
    }

    function writeClasificacionDetalle($pdf, $dataSource, $mostrar_costos)
    {
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
                $costoUnitario = $datarow['costo'] / $datarow['cantidad'];
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
            $pdf->Cell($w = $wCantidadAlerta, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');

            $pdf->Cell($w = $wCostoUnitario, $h = $hGlobal, $txt = '', $border = 1, $ln = 0, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->Cell($w = $wCostoTotal, $h = $hGlobal, $txt = number_format($dataSource->getParameter('totalCosto'), 2), $border = 1, $ln = 0, $align = 'R', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        }
        $pdf->Ln();
    }
}
