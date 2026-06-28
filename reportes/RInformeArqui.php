<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';

class CustomReport extends TCPDF {
    private $dataSource;

    // --- AÑADE ESTO AQUÍ ---
    public function verificarEspacio($h) {
        return $this->checkPageBreak($h);
    }

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
        
        // Posicionarse a 15mm del final
        $this->SetY(-25);
        $this->SetFont('helvetica', 'I', 8);
        
        // Imprime los datos alineados a la izquierda
        $this->Cell(180, 4, 'Usuario: '.$dataSource->getParameter('de'), 0, 1, 'L');
        $this->Cell(180, 4, 'SISTEMA DE TRAMITES - G.A.M.C.', 0, 1, 'L'); 
        
        // Imprime la página centrada (dejando el salto de línea al final)
        $this->Cell(180, 4, 'Página: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 1, 'C');

        // Configuración del QR
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false,
            'module_width' => 1,
            'module_height' => 1
        );

        // QR fijo a la derecha, cerca del margen inferior
        $this->write2DBarcode($dataSource->getParameter('num_informe'), 'QRCODE,M', 170, $this->getPageHeight() - 35, 25, 25, $style, 'N');
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
        $tablaDatos0 = $dataSource->getDataset();
        //$tablaDatos1 = $tablaDatos0->getL
        $contenedor = $tablaDatos0[0];
        
        //var_dump($dataSource); exit();
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


        /////////////////////////////////////////////////////////////
        // Nuevo data set agrupado
        /////////////////////////////////////////////////////////////
        $objetoCuerpo = $contenedor['listarCuerpoinforme'];
        $tablaDatos = $objetoCuerpo->datos;
        // Obtener personas
        $objetoPersonas = $contenedor['listarPersonas'];
        $tablaPersonas = $objetoPersonas->datos;
        //listarInformes
        $objetoInformes = $contenedor['listarInformes'];
        $tablaInformes = $objetoInformes->datos;

        //var_dump($tablaDatos); exit();
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

        //var_dump($resultadoFinal);


        
        // --- 1. ANTECEDENTES ---
        $pdf->SetFont('', 'N');
        $pdf->writeHTMLCell(180, 0, '', '', '<b>1. ANTECEDENTES</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2);
        
        $names = "";
        $counter = 0;
        foreach ($tablaPersonas as $row) {
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

        // $tablaInformes
        // --- TABLA DE INFORMES TÉCNICOS ---
        $htmlTable0 = '<table border="1" cellpadding="4" style="width: 100%; border-collapse: collapse;">';
        foreach ($tablaInformes as $row) {
            $htmlTable0 .= '<tr>
                            <td style="text-align: right; background-color: #f5f5f5;" width="22%"><b>Inf. Legal N°:</b></td><td style="text-align: left;" width="12%">'.$row['inf_leg'].'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="12%"><b>Fecha:</b></td><td width="12%">'.$row['fecha_leg'].'</td>
                            <td style="text-align: right; background-color: #f5f5f5;" width="15%"><b>A cargo de:</b></td><td width="28%">'.$row['legal'].'</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Inf. Topográfico N°:</b></td><td>'.$row['inf_top'].'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>Fecha:</b></td><td>'.$row['fecha_top'].'</td>
                            <td style="text-align: right; background-color: #f5f5f5;"><b>A cargo de:</b></td><td>'.$row['topo'].'</td>
                        </tr>';  
        }
                        
        $htmlTable0 .= '</table>';
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

        $datosTecnicos = $resultadoFinal['dataset_grupos']['datos_tecnicos'];
        //var_dump($resultadoFinal); exit();

        $tableDT = '<table border="1" style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td colspan="3" style="text-align: left;"><b>DATOS TECNICOS</b></td>
                            </tr>';
        $num = 1;    
        if (!empty($datosTecnicos) && is_array($datosTecnicos)) {
            foreach ($datosTecnicos as $fila){
                $numberRow = 11;
                $tableSuperficie = '';
                $contadorSuperficie = 0;
                if ($fila['super_escritura'] != '' || $fila['super_escritura'] != NULL) {
                    $tableSuperficie .= '<tr>
                                            <td style="text-align: right;"><b>Sup. Escritura: </b></td>
                                            <td style="text-align: left;">' . $fila['super_escritura'] . ' M2</td>
                                        </tr>';
                    $contadorSuperficie++;
                }
                if ($fila['super_mensura'] != '' || $fila['super_mensura'] != NULL) {
                    $tableSuperficie .= '<tr>
                                            <td style="text-align: right;"><b>Sup. Mensura: </b></td>
                                            <td style="text-align: left;">' . $fila['super_mensura'] . 'M2</td>
                                        </tr>';
                    $contadorSuperficie++;
                }
                if ($fila['super_excedente'] != '' || $fila['super_excedente'] != NULL) {
                    $tableSuperficie .= '<tr>
                                            <td style="text-align: right;"><b>Sup. Excedente: </b></td>
                                            <td style="text-align: left;">' . $fila['super_excedente'] . '</td>
                                        </tr>';
                    $contadorSuperficie++;
                }
                if ($fila['super_inexistente'] != '' || $fila['super_inexistente'] != NULL) {
                    $tableSuperficie .= '<tr>
                                            <td style="text-align: right;"><b>Sup. Inexistente: </b></td>
                                            <td style="text-align: left;">'. $fila['super_inexistente'] . '</td>
                                        </tr>';
                    $contadorSuperficie++;
                }
                if ($fila['super_total'] != '' || $fila['super_total'] != NULL) {
                    $tableSuperficie .= '<tr>
                                            <td style="text-align: right;"><b>Sup. Total: : </b></td>
                                            <td colspan="2" style="text-align: left;">' . $fila['super_total'] . '</td>
                                        </tr>';
                    $contadorSuperficie++;
                }
                if ($contadorSuperficie > 0) {
                    $numberRow = $numberRow + $contadorSuperficie + 1;
                    $tableTittleMasSup =  '<tr>
                                <td colspan="2" style="text-align: left;"><b>3.- SUPERFICIES</b></td>
                            </tr>'.$tableSuperficie;
                } else {
                    $tableTittleMasSup =  '<tr>
                                                <td colspan="2" style="text-align: left;"><b>3.- SUPERFICIES</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: left;">No existen datos adjuntos</td>
                                            </tr>';
                    $numberRow = $numberRow + 2;
                }
                
                
                
                $tableDT .= '<tr>
                                <td rowspan="'.$numberRow.'" style="vertical-align: middle;" width="5%"><br><br><br>'.$num.'</td> 
                                <td colspan="2" style="text-align: left;" width="95%"><b>2.- UBICACIÓN</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;" width="45%"><b>&nbsp;&nbsp;&nbsp;&nbsp;Distrito: </b>' . $fila['distrito'] . '</td>
                                <td style="text-align: left;" width="50%"><b>Zona: </b>' . $fila['zona'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Manzano: </b>' . $fila['manzana'] . '</td>
                                <td style="text-align: left;"><b>Tipo de Calle: </b>' . $fila['tipo_calle'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Rasante Municipal: </b>' . $fila['rasante_municipal'] . '</td>
                                <td style="text-align: left;"><b>Longitud Rasante: </b>' . $fila['long_rasante'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Calle: </b>' . $fila['calle'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Avenida: </b>' . $fila['avenida'] . '</td>
                            </tr>';
                //$table0 .= $table01;
                $tableDT .=  $tableTittleMasSup;
                $tableDT .=  '<tr>
                                    <td colspan="2" style="text-align: left;"><b>4.- COLINDANCIAS GENERALES</b></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>Colindante Oeste: </b></td>
                                    <td style="text-align: left;">' . $fila['colindante_oeste'] . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>Colindante Sud: </b></td>
                                    <td style="text-align: left;">' . $fila['colindante_sur'] . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>Colindante Norte: </b></td>
                                    <td style="text-align: left;">' . $fila['colindante_norte'] . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><b>Colindante Este: </b></td>
                                    <td style="text-align: left;">' . $fila['colindante_este'] . '</td>
                                </tr>';
                
                /*$tableDT .= '<tr>
                                <td colspan="2" style="text-align: left;"><b>5.- SERVICIOS BÁSICOS</b></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Agua Potable: </b>' . $fila['agua_potable'] . '</td>
                                <td style="text-align: left;"><b>Alcantarillado: </b>' . $fila['alcantarillado'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Alumbrado Publ.: </b>' . $fila['alumbrado_publico'] . '</td>
                                <td style="text-align: left;"><b>Telefonía: </b>' . $fila['telefonia'] . '</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Vias: </b>' . $fila['vias'] . '</td>
                                <td style="text-align: left;"><b>Transporte: </b>' . $fila['transporte'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Equipamiento: </b>' . $fila['equipamiento'] . '</td>
                            </tr>';
                */
                $num++;
            }
        }
        $tableDT .= '</tbody>
                    </table>';

                    // Envolvemos el contenido HTML existente para darle el ancho del 60% y centrarlo
       
        $pdf->writeHTMLCell(180, 0, '', '', $tableDT, 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5); // ⬅️ ¡Aquí está el cambio!
        $pdf->writeHTMLCell(180, 0, '', '', '<b>5.- COLINDANCIAS ESPECIFICAS<b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(3);
         ////////////////////////////////////////////////////////////////////
        // Adecuacion anexos por grupo de manzano, lote, via y construccion
        ////////////////////////////////////////////////////////////////////
        $datosLote = $resultadoFinal['dataset_grupos']['cesion_lotes'];
        //var_dump($datosLote);
        $tableCesion = '<table border="1" style="width: 100%; border-collapse: collapse;" cellpadding="4">
                                <tbody>';

        if (!empty($datosLote) && is_array($datosLote)) {
            foreach ($datosLote as $nombreManzana => $lotes) {
                    
                // Cabecera de la manzana
                $tableCesion .= '<tr>
                                        <td colspan="3" style="text-align: left; background-color: #f2f2f2;"><b>MANZANA: </b>'.htmlspecialchars($nombreManzana) .'</td>
                                    </tr>';
                    
                $totalPercent = 0;
                $totalSuperficie = 0; // Agregada para que sume real en el total del bloque
                // Corregido el <tr"> y el <td> style=
                $tableCesion .= '<tr>
                                    <td style="text-align: left;" width="50%"><b>PREDIO</b></td>
                                    <td style="text-align: left;" width="50%"><b>COLINDANCIAS</b></td>
                                </tr>';
                
                foreach ($lotes as $lote) {
                    $tableCesion .= '<tr>
                                        <td rowspan="4" style="vertical-align: middle;" width="30%">'.$lote['nombre_lote'].'</td> 
                                        <td style="text-align: left;" width="20%"><b>NORTE</b></td>
                                        <td style="text-align: left;" width="50%"><b>'.$lote['co_norte'].'</b></td>
                                    </tr>';
                    $lotesCount++;
                    $tableCesion .= '<tr>
                                        <td style="text-align: left;"><b>SUD</b></td>
                                        <td style="text-align: left;"><b>'.$lote['co_sud'].'</b></td>
                                    </tr>';
                    $tableCesion .= '<tr>
                                        <td style="text-align: left;"><b>ESTE</b></td>
                                        <td style="text-align: left;"><b>'.$lote['co_este'].'</b></td>
                                    </tr>';
                    $tableCesion .= '<tr>
                                        <td style="text-align: left;"><b>OESTE</b></td>
                                        <td style="text-align: left;"><b>'.$lote['co_oeste'].'</b></td>
                                    </tr>';
                }
                    
            }
                
            // El cierre del tbody y table debe ir FUERA del bucle principal si es una sola tabla
            $tableCesion .= '</tbody>
                        </table>';

            // Imprimir la tabla en el PDF
            $pdf->SetFont('helvetica', '', 10);
            $pdf->writeHTMLCell(180, 0, '', '', $tableCesion, 0, 1, 0, true, 'J', true);
        }
        
        $pdf->Ln(2.5);

        /*    
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
        */
        // --- ACLARACIONES Y CONCLUSIÓN ---
        $pdf->writeHTMLCell(180, 0, '', '', '<b>6.- ACLARACIONES: </b>'.$dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $indexCount = 7;
        
        $pdf->writeHTMLCell(180, 0, '', '', '<b>EL PREDIO CUENTA CON '.$dataSource->getParameter('tipo_aprobacion'). ' CON R.M.T.A. N° '.$dataSource->getParameter('nro_rmta').' DE FECHA '.$dataSource->getParameter('fecha_rmta').'</b>', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'Por tanto:', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);
        $pdf->writeHTMLCell(180, 0, '', '', 'En el Departamento de Normas Urbanas de la Dirección de Urbanismo y Catastro, revisado los informes adjuntos a la carpeta, se efectuó la verificación de los requisitos según reglamentación general de urbanismo y de subdivisión de propiedades urbanas, así como el reglamento de edificaciones en actual vigencia, por lo que se procedió al llenado de la Boleta de Liquidación No. '.$dataSource->getParameter('nro_boleta').' de aprobación de planos relativos a la propiedad citada para la prosecución del trámite administrativo.', 0, 1, 0, true, 'J', true);
        $pdf->Ln(2.5);

        if ($dataSource->getParameter('doc_adjunto') != '' || $dataSource->getParameter('doc_adjunto') != NULL) {
            $pdf->writeHTMLCell(180, 0, '', '', '<b>'.$indexCount.'.- ADJUNTOS: </b>'.$dataSource->getParameter('doc_adjunto'), 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5);
            $indexCount++;
        }
        if ($dataSource->getParameter('norma_aplica') != '' || $dataSource->getParameter('norma_aplica') != NULL) {
            $pdf->writeHTMLCell(180, 0, '', '', '<b>'.$indexCount.'.- NORMA APLICADA: </b>'.$dataSource->getParameter('norma_aplica'), 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5);
            $indexCount++;
        }
        if ($dataSource->getParameter('infor_comple') != '' || $dataSource->getParameter('infor_comple') != NULL) {
            $pdf->writeHTMLCell(180, 0, '', '', '<b>'.$indexCount.'.- INFORME COMPLEMENTARIO: </b>'.$dataSource->getParameter('infor_comple'), 0, 1, 0, true, 'J', true);
            $pdf->Ln(2.5);
        }

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
