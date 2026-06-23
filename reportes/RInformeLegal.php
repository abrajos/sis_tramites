<?php
require_once dirname(__FILE__) . '/pxpReport/Report.php';
require_once dirname(__FILE__) . '/pxpReport/DataSource.php';

class CustomReport extends TCPDF
{
    private $dataSource;

    // --- AÑADE ESTO AQUÍ ---
    public function verificarEspacio($h) {
        return $this->checkPageBreak($h);
    }

    public function setDataSource(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getDataSource()
    {
        return $this->dataSource;
    }

    public function Header() {
        $dataSource = $this->getDataSource();
        
        // 1. Dibujar el Logo
        $logo = dirname(__FILE__) . '/../../lib' . $_SESSION['_DIR_LOGO'];
        if (file_exists($logo)) {
            $this->Image($logo, 15, 10, 35); // Posición fija solo para la imagen
        }

        // 2. Título del Informe
        $this->SetY(10); // Iniciamos en la parte superior
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, 'INFORME LEGAL', 0, 1, 'R');

        // 3. Número de Informe con línea inferior
        $this->SetFont('helvetica', 'B', 12);
        // El '1' al final del Cell es VITAL para el salto de línea automático
        $this->Cell(0, 8, $dataSource->getParameter('num_informe'), 'B', 1, 'R');
        
        // NO poner SetXY aquí. El margen superior hará el trabajo.
    }

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

class RInformeLegal extends Report
{
    function write($fileName)
    {
        // 1. Instancia con configuración de márgenes estrictos
        $pdf = new CustomReport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setDataSource($this->getDataSource());
        $dataSource = $this->getDataSource();
        // Márgenes: Izquierdo=15, Superior=45 (espacio para Header), Derecho=15
        $pdf->SetMargins(15, 45, 15);
        $pdf->SetAutoPageBreak(TRUE, 40); // 40mm de margen inferior para el QR/Footer
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);

        $pdf->AddPage('P', array(215.9, 330)); // Tamaño Oficio
        $pdf->SetFontSize(10);
        // var_dump($dataSource); exit();
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
        $pdf->SetFont('', 'B');
        $pdf->Cell($w = 63, $h = $hMedium, $txt = 'ANTECEDENTES ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln(8);
        $pdf->SetFont('', 'N');
        $pdf->Cell($w = 63, $h = $hMedium, $txt = 'De mi consideración: ', $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->Ln(8);
        $pdf->MultiCell(180, $h = $hMedium, 'Conforme a la documentación presentada por:', 0, 'L', 0, 0, '', '', true);
        $pdf->Ln(5);

        // 1. Obtenemos el dataset (el array principal)
        $dataset = $dataSource->getDataset(); // O el método público que tenga tu clase para retornar 'dataset'
        // 2. Apuntamos a la primera posición [0] que es donde están tus listados
        $listados = $dataset[0];
        // 3. Extraemos el objeto Mensaje de 'listarPersonas'
        $objetoMensaje = $listados['listarPersonas'];
        // 4. Accedemos a la propiedad pública o método de los datos (en tu var_dump dice ["datos"] público)
        $personas = $objetoMensaje->datos;
        // 5. Ahora sí, recorremos las personas con un foreach
        // Inicializamos las variables para evitar errores de PHP Notice
        $count = 0;
        $propietariosList = ""; 
        $nombre_completo = "";

        // 5. Recorremos las personas con un único foreach limpio
        foreach ($personas as $persona) {
            $tipo_persona = $persona['tipo_persona'];
            
            if ($tipo_persona == "propietario") {
                // Lógica para armar el string plano de propietarios
                if ($count == 0) {
                    $nombre_completo = $persona['nombre_completo1'];
                    $propietariosList = $persona['nombre_completo1'];
                } else {
                    $propietariosList .= "|" . $persona['nombre_completo1'];
                }
                
                $count++;

                // 1. Construimos el bloque de texto HTML
                $htmlPropietario = '• <b>' . $persona['nombre_completo1'] . '</b> con C.I. N°: <b>' . $persona['ci'] . ' ' . $persona['expedicion'] . '</b>';

                // 2. Renderizamos en el PDF de manera segura
                $pdf->SetFont('', ''); // 'N' no es válido en TCPDF, se deja vacío para regular/normal
                $pdf->writeHTMLCell(180, 0, '', '', $htmlPropietario, 0, 1, 0, true, 'L', true);
                
                // Espacio de separación entre propietarios
                $pdf->Ln(1); 
            }
        }

        //echo "Lista propietarios: ".$propietariosList;



        

        $pdf->SetFont('', 'N');

        // 1. Párrafo de introducción (Cambiamos el penúltimo parámetro a 1 para salto de línea)
        $pdf->MultiCell(180, 0, 'Es propietario de un lote de terreno ubicado, según FOLIO REAL (Registrado en Derechos Reales, SEGÚN LOS SIGUIENTES DATOS: ', 0, 'J', 0, 1);
        $pdf->Ln(2);

        // 2. Tabla de datos (Usamos ln=0 para la izquierda y ln=1 para la derecha)
        $pdf->Cell(90, $hMedium, 'Provincia: Quillacollo', 1, 0, 'L');
        $pdf->Cell(90, $hMedium, 'Sección: Quinta', 1, 1, 'L'); // ln=1 para bajar

        $pdf->Cell(90, $hMedium, 'Municipio: Colcapirhua ', 1, 0, 'L');
        $pdf->Cell(90, $hMedium, 'Zona: ' . $dataSource->getParameter('zona'), 1, 1, 'L');

        $pdf->Cell(90, $hMedium, 'Distrito: ' . $dataSource->getParameter('distrito'), 1, 0, 'L');
        $pdf->Cell(90, $hMedium, 'Manzano: ' . $dataSource->getParameter('manzana'), 1, 1, 'L');

        // 3. Registro Derechos Reales
        $pdf->Cell(180, $hMedium, 'Registrado en Derechos Reales de: ' . $dataSource->getParameter('ddrr_registro'), 1, 1, 'L');

        // 1. Obtenemos el dataset (el array principal)
        $dataset = $dataSource->getDataset(); 

        // 2. Apuntamos a la posición [0] (Tanto personas como matrículas están aquí adentro)
        $listados = $dataset[0]; 

        // 3. Extraemos el objeto Mensaje de 'listarMatriculas' usando la posición 0 correcta
        $objetoMensaje2 = $listados['listarMatriculas'];

        // 4. Accedemos a los datos
        $matriculaList = $objetoMensaje2->datos;

        // --- CONTROL DE SEGURIDAD (Opcional pero recomendado) ---
        // Si por alguna razón la consulta de la BD falló o vino vacía, 
        // convertimos la variable en un array vacío para que el foreach no rompa el sistema.
        if (!is_array($matriculaList)) {
            $matriculaList = array();
        }

        $pdf->Ln(2);
        // 5. Estructura de la Tabla HTML
        $pdf->Cell(180, $hMedium, 'Datos matricula (s): ', 0, 1, 'L');

        // Asumiendo que $matriculaList contiene tus 4 registros originales...
        $resultadoAgrupado = array();
        foreach ($matriculaList as $item) {
            $idMatricula = $item['nro_matricula'];

            // Si es la primera vez que vemos esta matrícula, creamos su estructura base
            if (!isset($resultadoAgrupado[$idMatricula])) {
                $resultadoAgrupado[$idMatricula] = array(
                    'nro_matricula'       => $item['nro_matricula'],
                    'superficie_matri'    => $item['superficie_matri'],
                    'nro_testimonio'      => $item['nro_testimonio'],
                    'nro_notario'         => $item['nro_notario'],
                    'nombre_notario'      => $item['nombre_notario'],
                    'fecha_testimonio'    => $item['fecha_testimonio'],
                    'decreto_registrador' => $item['decreto_registrador'],
                    'fecha_decreto'       => $item['fecha_decreto'],
                    'complemento_matri'   => $item['complemento_matri'],
                        
                    // Inicializamos como sub-arreglos para acumular los datos variables
                    'asientos'            => array(),
                    'rmtas'               => array(),
                    'contador'            => 0
                );
            }

            // 1. Agrupamos los datos del Asiento si existen
            if (!empty($item['nro_asiento'])) {
                // Estructuramos el sub-objeto/arreglo del asiento
                $nuevoAsiento = array(
                    'nro_asiento'   => $item['nro_asiento'],
                    'fecha_asiento' => $item['fecha_asiento'],
                    'motivo'        => $item['motivo']
                );
                    
                // Evitamos meter exactamente el mismo asiento si está repetido en la data
                if (!in_array($nuevoAsiento, $resultadoAgrupado[$idMatricula]['asientos'])) {
                    $resultadoAgrupado[$idMatricula]['asientos'][] = $nuevoAsiento;
                }
            }

            // 2. Agrupamos los datos de la RMTA si existen
            if (!empty($item['nro_rmta'])) {
                // Estructuramos el sub-objeto/arreglo de la RMTA
                $nuevaRmta = array(
                    'tipo_rmta'        => $item['tipo_rmta'],
                    'nro_rmta'         => $item['nro_rmta'],
                    'fecha_rmta'       => $item['fecha_rmta'],
                    'tipo_aprobacion'  => $item['tipo_aprobacion'],
                    'complemento_rmta' => $item['complemento_rmta']
                );

                    // Evitamos meter exactamente la misma RMTA si está repetida en la data
                if (!in_array($nuevaRmta, $resultadoAgrupado[$idMatricula]['rmtas'])) {
                        $resultadoAgrupado[$idMatricula]['rmtas'][] = $nuevaRmta;
                }
            }
        }
        // Al final, reindexamos el array con array_values() para que vuelva a ser una lista continua [0, 1, 2...]
        $matriculaNewList = array_values($resultadoAgrupado);
        $counMatricula = $matriculaNewList;
        $auxiliar = 0;
        foreach ($counMatricula as $matricula) {
            $nro_matricula = $matricula['nro_matricula'];
           
            $totalDatosLlenos = 0;
            // 1. Contar campos "sueltos" del nivel superior (los datos generales)
            // Definimos la lista de atributos individuales a evaluar
            $camposGenerales = array(
                'nro_matricula', 'superficie_matri', 'nro_testimonio', 'nro_notario', 'nombre_notario', 
                'fecha_testimonio', 'decreto_registrador', 'fecha_decreto', 'complemento_matri'
            );
            
            $datosSueltosCompletos = 0;
            foreach ($camposGenerales as $campo) {
                if (isset($matricula[$campo]) && trim($matricula[$campo]) !== "") {
                    $datosSueltosCompletos++;
                }
            }
            $totalDatosLlenos += $datosSueltosCompletos;
            // 2. Conteo de Campos Internos de los Asientos
            $camposAsiento = array('nro_asiento', 'fecha_asiento', 'motivo');
            $conteoAsientosCampos = 0;
            $aux = 0;
            if (isset($matricula['asientos']) && is_array($matricula['asientos'])) {
                foreach ($matricula['asientos'] as $asiento) {
                    foreach ($camposAsiento as $cAsiento) {
                        if (isset($asiento[$cAsiento]) && trim($asiento[$cAsiento]) !== "") {
                            $conteoAsientosCampos++;
                        }
                    }
                }
            }
            $totalDatosLlenos += $conteoAsientosCampos;
            
            // 3. Conteo de Campos Internos de las RMTAs
            $camposRMTA = array('tipo_rmta', 'nro_rmta', 'fecha_rmta', 'tipo_aprobacion', 'complemento_rmta');
            $conteoRmtasCampos = 0;
            
            if (isset($matricula['rmtas']) && is_array($matricula['rmtas'])) {
                foreach ($matricula['rmtas'] as $rmta) {
                    foreach ($camposRMTA as $cRmta) {
                        if (isset($rmta[$cRmta]) && trim($rmta[$cRmta]) !== "") {
                            $conteoRmtasCampos++;
                        }
                    }
                }
            }
            $totalDatosLlenos += $conteoRmtasCampos;

            // 4. Calcular el Gran Total de información válida en este bloque
            $totalDatosRegistro = $datosSueltosCompletos + $conteoAsientosCampos + $conteoRmtasCampos;
            $matriculaNewList[$auxiliar]["contador"] = $totalDatosLlenos; 
            $auxiliar++;
        }

        $table0 = '<table border="1" style="border-collapse: collapse; width: 100%; text-align: center;">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th width="40%">Detalle</th>
                            <th width="50%">Referencia</th>
                        </tr>
                    </thead>
                    <tbody>';

        $num = 1; // Contador para enumerar las matrículas
        //var_dump($matriculaNewList); exit();
        foreach ($matriculaNewList as $matricula) {
            $table0 .= '<tr>
                            <td rowspan="'.$matricula["contador"].'" style="vertical-align: middle;" width="10%"><br><br><br>'.$num.'</td> 
                            <td width="40%" style="text-align: right;"> Bajo matricula N°: </td> 
                            <td width="50%" style="text-align: left;">'.$matricula['nro_matricula'].'</td>
                        </tr>';
            $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Superficie:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['superficie_matri'].'</td>
                        </tr>';
            if ($matricula['complemento_matri'] != '' && $matricula['complemento_matri'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Complemento Matricula:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['complemento_matri'].'</td>
                        </tr>';
            }
            if ($matricula['nro_notario'] != '' && $matricula['nro_notario'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">N° Notario:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['nro_notario'].'</td>
                        </tr>';
            }
            if ($matricula['nombre_notario'] != '' && $matricula['nombre_notario'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Nombre Notario:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['nombre_notario'].'</td>
                        </tr>';
            }
            
            if ($matricula['nro_testimonio'] != '' && $matricula['nro_testimonio'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">N° Testimonio:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['nro_testimonio'].'</td>
                        </tr>';
            }
            if ($matricula['fecha_testimonio'] != '' && $matricula['fecha_testimonio'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Fecha Testimonio:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['fecha_testimonio'].'</td>
                        </tr>';
            }

            if ($matricula['decreto_registrador'] != '' && $matricula['decreto_registrador'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Decreto registrador:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['decreto_registrador'].'</td>
                        </tr>';
            }
            if ($matricula['fecha_decreto'] != '' && $matricula['fecha_decreto'] != NULL) {
                $table0 .= '<tr>
                            <td width="40%" style="text-align: right;">Fecha Decreto:</td>
                            <td width="50%" style="text-align: left;">'.$matricula['fecha_decreto'].'</td>
                        </tr>';
            }
            $countAsieto = 1;
            if (isset($matricula['asientos']) && is_array($matricula['asientos']) && !empty($matricula['asientos'])) {
                foreach ($matricula['asientos'] as $asientos) {
                    if ($asientos['nro_asiento'] != '' && $asientos['nro_asiento'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">N° Asiento'.$countAsieto.':</td>
                                    <td width="50%" style="text-align: left;">'.$asientos['nro_asiento'].'</td>
                                </tr>';
                    }  
                    if ($asientos['fecha_asiento'] != '' && $asientos['fecha_asiento'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Fecha Asiento'.$countAsieto.':</td>
                                    <td width="50%" style="text-align: left;">'.$asientos['fecha_asiento'].'</td>
                                </tr>';
                    }
                    if ($asientos['motivo'] != '' && $asientos['motivo'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Motivo Asiento'.$countAsieto.':</td>
                                    <td width="50%" style="text-align: left;">'.$asientos['motivo'].'</td>
                                </tr>';
                    }
                    $countAsieto++;
                }
            }
            

            $countMRTA = 1;
            if (isset($matricula['rmtas']) && is_array($matricula['rmtas']) && !empty($matricula['rmtas'])) {
                foreach ($matricula['rmtas'] as $rmtasList) {
                    if ($rmtasList['tipo_rmta'] != '' && $rmtasList['tipo_rmta'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Tipo RMTA'.$countMRTA.':</td>
                                    <td width="50%" style="text-align: left;">'.$rmtasList['tipo_rmta'].'</td>
                                </tr>';
                    } 
                    if ($rmtasList['nro_rmta'] != '' && $rmtasList['nro_rmta'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">N° RMTA'.$countMRTA.':</td>
                                    <td width="50%" style="text-align: left;">'.$rmtasList['nro_rmta'].'</td>
                                </tr>';
                    }  
                    if ($rmtasList['fecha_rmta'] != '' && $rmtasList['fecha_rmta'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Fecha RMTA'.$countMRTA.':</td>
                                    <td width="50%" style="text-align: left;">'.$rmtasList['fecha_rmta'].'</td>
                                </tr>';
                    }
                    if ($rmtasList['tipo_aprobacion'] != '' && $rmtasList['tipo_aprobacion'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Motivo RMTA'.$countMRTA.':</td>
                                    <td width="50%" style="text-align: left;">'.$rmtasList['tipo_aprobacion'].'</td>
                                </tr>';
                    }
                    if ($rmtasList['complemento_rmta'] != '' && $rmtasList['complemento_rmta'] != NULL) {
                        $table0 .= '<tr>
                                    <td width="40%" style="text-align: right;">Cmplemento RMTA'.$countMRTA.':</td>
                                    <td width="50%" style="text-align: left;">'.$rmtasList['complemento_rmta'].'</td>
                                </tr>';
                    }
                    $countMRTA++;
                }
            }
            

            $num++;
        }
        $table0 .= '</tbody>
                    </table>';
        $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'L', true);

/*
            foreach ($matriculaList as $matricula) {
                // Matricula
                $superficie_matri = $matricula['superficie_matri'];
                $nro_matricula = $matricula['superficie_matri'];
                $countaux = 2;
                $complemento_matri = '';
                if ($matricula['superficie_matri'] != '' && $matricula['superficie_matri'] != NULL) {
                    $complemento_matri = $matricula['superficie_matri'];
                    $countaux++;
                }
                // Notario
                $nro_notario = '';
                if ($matricula['superficie_matri'] != '' && $matricula['superficie_matri'] != NULL) {
                    $complemento_matri = $matricula['superficie_matri'];
                    $countaux++;
                }
                $nombre_notario = '';
                if ($matricula['nombre_notario'] != '' && $matricula['nombre_notario'] != NULL) {
                    $complemento_matri = $matricula['nombre_notario'];
                    $table0 .= '<td width="40%"><b>Matricula</b></td>
                                <td width="50%">'.$matricula['nro_matricula'].'</td>';
                    $countaux++;
                }
                // Testimonio
                $nro_testimonio = '';
                if ($matricula['nro_testimonio'] != '' && $matricula['nro_testimonio'] != NULL) {
                    $complemento_matri = $matricula['nombre_notario'];
                    $countaux++;
                }
                $fecha_testimonio = '';
                // Decreto
                $decreto_registrador = '';
                $fecha_decreto = '';
                // Asiento (Puede ser multiple)
                $nro_asiento = '';
                $fecha_asiento = '';
                $motivo = '';
                // RMTA (Puede ser multiple)
                $tipo_rmta = '';
                $nro_rmta = '';
                $complemento_matri = '';
                $tipo_aprobacion = '';
                $complemento_rmta = '';
                
                $table0 .= '<tr>
                                <td rowspan="4" style="vertical-align: middle;"  width="10%"><br><br><br>'.$num.'</td>
                                <td width="40%"><b>Matricula</b></td>
                                <td width="50%">'.$matricula['nro_matricula'].'</td>
                            </tr>
                            <tr>
                                <td><b>Asiento</b></td>
                                <td>'.$matricula['nro_asiento'].'</td>
                            </tr>
                            <tr>
                                <td><b>RMTA</b></td>
                                <td>'.$matricula['nro_rmta'].'</td>
                            </tr>
                            <tr>
                                <td><b>Complemento</b></td>
                                <td>'.$matricula['complemento_matri'].'</td>
                            </tr>';
                $num++;
            }

            $table0 .= '</tbody>
                        </table>';

            // Renderizado seguro en el PDF
            $pdf->writeHTMLCell(180, 0, '', '', $table0, 0, 1, 0, true, 'L', true);
*/
        // Espacio de separación entre propietarios
        $pdf->Ln(2);
        // Aqui es solo matricula
        
        // $pdf->Cell(180, $hMedium, 'Bajo Matricula N°: ' . $dataSource->getParameter('nro_matricula'), 1, 1, 'L');
        // $pdf->MultiCell(180, 0, 'Complemento: ' . $dataSource->getParameter('complemento_matri'), 1, 'L', false, 1);

        // 4. Celdas de ancho completo (Ancho 180, ln=1)
        //$pdf->Cell(180, $hMedium, 'Complemento: ' . $dataSource->getParameter('complemento_matri'), 1, 1, 'L');
        // --- CELDA DE ANCHO COMPLETO CON ALTO DINÁMICO ---
        // Parámetros: Ancho (180), Alto inicial (0 para que sea dinámico), Texto, Borde (1), Alineación ('L'), Fondo (false), Salto de línea (1)
        

        $pdf->Ln(2);
        $pdf->Cell(180, $hMedium, 'Aprobado mediante: ', 0, 1, 'L');

        $pdf->Cell(90, $hMedium, $dataSource->getParameter('tipo') . ' N°: ' . $dataSource->getParameter('nro_rmta'), 1, 0, 'L');
        $pdf->Cell(90, $hMedium, 'De Fecha: ' . $dataSource->getParameter('fecha_rmta'), 1, 1, 'L');

        $pdf->Cell(180, $hMedium, 'Tipo aprobación: ' . $dataSource->getParameter('tipo_aprobacion'), 1, 1, 'L');
        $pdf->Cell(180, $hMedium, 'Complementaria: ' . $dataSource->getParameter('complemento'), 1, 1, 'L');

        $pdf->Cell(90, $hMedium, 'Código Catastral N°: ' . $dataSource->getParameter('cod_catastral'), 1, 1, 'L');

        $pdf->Ln(4);

        // 5. Segundo párrafo largo (ln=1 al final para que el Fundamento Legal no se encime)
        // $pdf->MultiCell(180, 0, 'Conforme el testimonio N° ' . $dataSource->getParameter('nro_testimonio') . ' de fecha ' . $dataSource->getParameter('fecha_testimonio') . ', otorgado por la Notaria de Fe Pública N° ' . $dataSource->getParameter('nro_notario') . ', ' . $dataSource->getParameter('nombre_notario') . ', (Escritura Pública de transferencia de un lote de terreno).', 0, 'J', 0, 1);

        //$pdf->Ln(5);

        // 6. Título de Fundamento Legal
        $pdf->SetFont('', 'B');
        $pdf->Cell(180, $hMedium, 'FUNDAMENTO LEGAL.- ', 0, 1, 'L');
        $pdf->SetFont('', 'N');

        if ($dataSource->getParameter('aprobacion') == 'no') {
            $propietarios = explode("|", $propietariosList);
            $propName = '';
            if (count($propietarios) ==  1) {
                $propName = $propietariosList;
            } elseif (count($propietarios) <  3) {
                $propName = $propietarios[0] . " y " . $propietarios[1];
            } else {
                for ($i = 0; $i < count($propietarios); $i++) {
                    if ($i == 0) {
                        $propName = $propietarios[0];
                    } elseif ($i > 0 && $i < count($propietarios) - 2) {
                        $propName .= ", " . $propietarios[$i];
                    } else {
                        $propName .= " y " . $propietarios[$i];
                    }
                }
            }

            if ($dataSource->getParameter('tipo_rechazo') == "FRU") {
                // --- PÁRRAFOS LEGALES ---
                // Usamos verificarEspacio antes de cada bloque para asegurar fluidez
                $pdf->verificarEspacio(20);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, la Ley N° 2341 de Procedimiento Administrativo, en el inc. K) del Art. 4 establece que los procedimientos administrativos, deben responder a los principios de economía, simplicidad y celeridad, evitando la realización de trámites, formalismos o diligencias innecesarias.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, de acuerdo a la Resolución Municipal Bi-Secretarial N° 1/2020 de fecha 11 de diciembre de 2020 emitida por Secretaria Municipal Técnica del Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                $pdf->verificarEspacio(20);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, según el límite de homologación 100/2018 de fecha 12 de abril de 2018, emitido por el ministerio de la presidencia, el predio se encuentra fuera del radio urbano (FRU) del municipio de Colcapirhua.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->verificarEspacio(20);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5);
                }

                // --- SECCIÓN DE CONCLUSIONES ---
                // Aquí es crítico verificar espacio para que el título y al menos 2 líneas del párrafo quepan juntos
                $pdf->verificarEspacio(25); 
                $pdf->Ln(5); 
                
                // Quitamos los <br> manuales del HTML porque ya usamos Ln() y verificarEspacio
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                $conclusionHTML = 'Realizado el Informe legal, conforme los antecedentes líneas arriba, quien es propietario <b>' . $propName . '</b>, en la cual teniendo un ' . $dataSource->getParameter('conclusion') . ', se puede observar que se encuentra la Ubicado el predio Fuera del Área Urbano (FRU), la Resolución Municipal BI-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal BI-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.';
                
                $pdf->writeHTMLCell(180, 0, '', '', $conclusionHTML, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
            } elseif ($dataSource->getParameter('tipo_rechazo') == "Innova") {
                /** * Caso: Innova 
                 * */

                // Primer párrafo legal
                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según el <b>Código de Procedimiento Civil en su Art. 9. (Obligatoriedad).-</b> Las decisiones de las autoridades judiciales deben ser acatadas por todas las autoridades y personas individuales o colectivas. Las autoridades en general están en la obligación de prestar asistencia para el cumplimiento de las resoluciones judiciales.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                // Segundo párrafo legal
                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, De acuerdo el <b>Código de Procedimiento Civil en su Art. 5. (Normas Procesales).-</b> Las normas procesales son de orden público y en consecuencia, de obligado acatamiento, tanto por la autoridad judicial como por las partes y eventuales terceros. Se exceptúan de estas reglas, las normas que, aunque procesales, sean de carácter facultativo, por referirse a intereses privados de las partes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                // Observación dinámica
                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->verificarEspacio(20);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5);
                }

                // --- BLOQUE DE CIERRE (CONCLUSIONES) ---
                // Verificamos un espacio considerable para que el bloque de conclusión no se parta feo
                $pdf->verificarEspacio(55); 
                $pdf->Ln(5); 

                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                $htmlConclusion = 'Realizado el Informe legal, conforme los antecedentes líneas arriba, quien es propietario <b>' . $propName . '</b>, en la cual teniendo un pronunciamiento de la Ene. En Sistemas de Información Geográfica Catastral, ' . $dataSource->getParameter('conclusion') . ' <b>Prohibición de Innovar</b>, emitido por autoridad competente; por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.';

                $pdf->writeHTMLCell(180, 0, '', '', $htmlConclusion, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);
            } elseif ($dataSource->getParameter('tipo_rechazo') == "APAU") {
                /** * Caso: APAU - Área Productiva Agropecuaria Urbana
                 * */
                
                // 1. Primera Ley (Ley 715)
                $htmlAPAU1 = '<b>LA LEY 715 DE SERVICIO DE REFORMA AGRARIA</b> establece en su <b>Artículo 48. (Indivisibilidad)</b>.';
                $htmlViñetas0 = '<ul><li style="text-align: justify">' . $htmlAPAU1 . '</li></ul>';
                
                $pdf->verificarEspacio(20);
                // IMPORTANTE: Cambiamos el '7' por '' para mantener el margen izquierdo del documento
                $pdf->writeHTMLCell(180, 0, '', '', $htmlViñetas0, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2);

                $htmlAPAU2 = '"La propiedad agraria, bajo ningún título podrá dividirse en superficies menores a las establecidas para la pequeña propiedad. Las sucesiones hereditarias se mantendrán bajo régimen de indivisión forzosa. Con excepción del solar campesino, la propiedad agraria tampoco podrá titularse en superficies menores a la pequeña propiedad"';
                
                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU2, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                // 2. Ley 442 y DS 5065
                $htmlAPAU3 = '<b>La Ley 442 LEY ESPECIAL DE CONSOLIDACIÓN, PLANIFICACIÓN, REGULARIZACIÓN TECNICA Y ADMINISTRATIVA Y TRATAMIENTO ESPECIAL DE ZONAS LIMITROFES DE LA JURISDICCIÓN DEL GOBIERNO AUTÓNOMO MUNICIPAL DE COLCAPIRHUA"</b> refiere en el numeral 5, articulo 7 (definiciones). <br><b>Área productiva Agropecuaria Urbana;</b> Porción de territorio urbano con uso de suelo agropecuario, forestal, piscicola, que mantendrá este uso por al menos diez (10) años.';
                $htmlAPAU4 = '<b>EL DECRETO SUPREMO 5065 establece en su artículo único.</b>';
                
                $htmlViñetas1 = '<ul>';
                $htmlViñetas1 .= '<li style="text-align: justify">' . $htmlAPAU3 . '</li>';
                $htmlViñetas1 .= '<li style="text-align: justify">' . $htmlAPAU4 . '</li>';
                $htmlViñetas1 .= '</ul>';

                $pdf->verificarEspacio(45);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlViñetas1, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2);

                $htmlAPAU5 = 'A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberanía, se modifica el Parágrafo I del Artículo 3 del Decreto Supremo N° 1809, de 27 de noviembre de 2013, con el siguiente texto:';
                $htmlAPAU6 = '<b>"I. Las áreas productivas agropecuarias urbanas no podrán ser objeto de cambio de uso de suelo ni urbanizadas en un plazo de quince (15) años, a partir de la publicación del presente Decreto Supremo."</b>';

                $pdf->verificarEspacio(40);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU5, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU6, 0, 1, 0, true, 'J', true);

                // 3. Observaciones
                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->Ln(2.5);
                    $pdf->verificarEspacio(20);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                }

                // --- SECCIÓN CONCLUSIONES (BLOQUE UNIFICADO) ---
                $pdf->verificarEspacio(70); // Espacio mayor para el título y el primer párrafo largo
                $pdf->Ln(8);
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(3);

                $htmlAPAU8 = 'En virtud a los antecedentes descritos y la normativa vigente, se establecen los siguientes aspectos:';
                $pdf->writeHTMLCell(180, 0, '', '', $htmlAPAU8, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2);

                $htmlAPAU9 = 'De acuerdo a documentación presentada se puede observar un fraccionamiento del predio y el registro en derechos reales de la parte fraccionada, el cual al ser un terreno ubicado en <b>área productiva agropecuaria NO es susceptible a ser fraccionado</b>, toda vez que la regularización del predio se debe realizar sobre la totalidad de la superficie y no así sobre una parte fraccionada, pudiendo efectuarse la urbanización y fraccionamiento una vez se efectúe el cambio de uso de suelo.';
                $htmlAPAU10 = 'En cumplimiento a la normativa vigente al encontrarse el terreno en <b>área productiva agropecuaria</b> y al no ser objeto de cambio de uso de suelo ni urbanizable en el plazo de 15 años a partir de la publicación del Decreto Supremo N° 1809, de 27 de noviembre de 2013, solamente se podrá efectuar la aprobación del predio en Area Productiva Agropecuaria sobre la totalidad de la superficie, ' . $dataSource->getParameter('conclusion') . ', por lo que NO corresponde la prosecución del trámite, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis y emisión de un informe, de la parte técnica, asimismo se deberá remitir el trámite a la <b>Dirección de Asesoría Legal del Gobierno Autónomo Municipal de Colcapirhua</b>, para que en coordinación con las Oficinas de Derechos Reales se pueda corroborar la legalidad y veracidad de la documentación técnica - legal bajo el principio de buena fe que solicito el propietario derivando el mismo al fraccionamiento y posterior inscripción del predio que se encuentra ubicado actualmente en <b>Área Productiva (A.P.A.U.)</b>, sin contar con alguna Resolución de tipo Municipal, Agraria o Nacional para este efecto';

                $htmlViñetas2 = '<ul>';
                $htmlViñetas2 .= '<li style="text-align: justify">' . $htmlAPAU9 . '</li>';
                $htmlViñetas2 .= '<li style="text-align: justify">' . $htmlAPAU10 . '</li>';
                $htmlViñetas2 .= '</ul>';

                $pdf->writeHTMLCell(180, 0, '', '', $htmlViñetas2, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto se informa y se pone en conocimiento para fines consiguientes.', 0, 1, 0, true, 'J', true);
            } elseif ($dataSource->getParameter('tipo_rechazo') == "Doble") {
                /** * Caso: Doble - Duplicidad o conflicto de trámites
                 * */

                // 1. Primer Párrafo Legal (Ley 2341)
                // Corregido: Se cambió el cierre <b> por </b> y se arregló el typo "T1ramite"
                $htmlDoble1 = '<b>Que, De acuerdo al Art. 86 de la Ley 2341 (Conocimiento del Trámite).-</b> "Los administrados que intervengan en un procedimiento, sus representantes o abogados, tendrán derecho a conocer en cualquier momento el estado del trámite y a tomar vista de las actuaciones".';
                
                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlDoble1, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                // 2. Segundo Párrafo Legal (Res. Municipal)
                // Corregido: Se cambió el cierre <b> por </b>
                $htmlDoble2 = '<b>Que, de acuerdo a la Resolución Municipal BI - Secretarial N° 1/2020 de fecha 11 de diciembre de 2020</b> emitida por Secretaria Municipal Técnica de Gobierno Autónomo Municipal de Colcapirhua, los contribuyentes deben cumplir con los procedimientos y requisitos para los trámites administrativos y técnicos de la Dirección de Urbanismo y Catastro.';
                
                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', $htmlDoble2, 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                // 3. Observación dinámica
                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->verificarEspacio(20);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(2.5);
                }

                // --- SECCIÓN CONCLUSIONES ---
                // Usamos verificarEspacio(50) para evitar que el título se separe de su contenido
                $pdf->verificarEspacio(50);
                $pdf->Ln(5); 

                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACION.-</b>', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);

                $htmlConclDoble = 'Realizado el Informe legal, conforme los antecedentes líneas arriba, en la cual teniendo un pronunciamiento ' . $dataSource->getParameter('conclusion') . ', Informe Técnico de los inmuebles para los tramite urba-No 000070 y 0000472, se puede observar que en posesión en derecho propietario a la valoración de los tramites 472 y 720 en la cual los interesados deberán regularizar el mejor derecho propietario ante la instancia llamada por Ley, para lo cual se <b>RECOMIENDA</b> efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe.';

                $pdf->writeHTMLCell(180, 0, '', '', $htmlConclDoble, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(2.5);
            } else {
                // --- Párrafo 1: Ley 411 ---
                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según la Ley 411 de fecha 26 de octubre de 2004, Capitulo II Reglamento Técnica de Edificaciones en su Artículo 25. (Alcances específico para Regularización Técnica de Edificaciones) podrán acoger de manera voluntaria al proceso de regularización Técnica de edificaciones, aquellos ciudadanos que no cuenten con planos aprobados y/o que teniendo planos aprobados de contrucción estos hayan sido contruidos res´petando las disposiciones Municipales vigentes.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                // --- Párrafo 2: PLANUR Art. 109 ---
                $pdf->verificarEspacio(40);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según el PLANUR O.M. 0004/2004 de fecha 13 de febrero de 2004 en su artículo 109, Constrcciones Fuera de Norma.- Las contrucciones que no cumplen son los planos debidamente aprobados y que no cumplan con lo establesido en el presente reglamento serán paralizadas, en su caso demolidas. Por todo lo Expuesto se verifica que la construcción ya está consolidad sin haber tenido un plano de lote aprobada por lo que según reglamento y normas vigentes procede al rechazo de dicho trámite, Aprobación de Plano de Vivienda Multifamiliar, debidamente la misma proceder en primera instancia al Trámite de aprobación de plano de lote.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                // --- Párrafo 3: PLANUR Art. 107 ---
                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según el reglamento par Urbanismo y Edificaciones PLANUR de fecha 13 de febrero de 2004 en su Art. 107 Inciso de la construcción.- para iniciar la constrcción de una edificación de cualquier naturaleza es necesario contar con el respectivo Plano arquitectonico aprobado por la alcaldia de Colcapirhua, no siento suficiente que el tramite se encuentra en curso de aprobación.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);

                // --- Párrafo 4: PLANUR Art. 112 ---
                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, Según el reglamento <b>PLANUR</b> en su <b>Art. 112.- Tipos de Infracción</b>.- se considerará infracción: Construir edificaciones sin contar previamente con los planos aprobados por la Alcaldía del lote o del proyecto arquitectónico.', 0, 1, 0, true, 'J', true);
                
                // --- SECCIÓN DE CONCLUSIONES ---
                $pdf->verificarEspacio(60); 
                $pdf->Ln(8);
                $pdf->SetFont('', 'B');
                $pdf->Cell(180, 7, 'CONCLUSIONES y RECOMENDACION.- ', 0, 1, 'L');
                $pdf->SetFont('', 'N');
                $pdf->Ln(2);

                $pdf->writeHTMLCell(180, 0, '', '', 'Realizado el Informe Legal, conforme los antecedentes líneas arriba, quien es propietario: ', 0, 1, 0, true, 'L', true);
                $pdf->Ln(2);

                // --- LISTA DE PROPIETARIOS ---
                foreach ($dataSource->getDataSet() as $row) {
                    /*
                    if ($row['tipo_persona'] == "propietario") {
                        $pdf->verificarEspacio(7);
                        $pdf->SetFont('', 'B');
                        $pdf->Cell(70, 7, $row['nombre_completo1'], 0, 0, 'L');
                        $pdf->SetFont('', 'N');
                        $pdf->Cell(20, 7, ' con C.I. N°: ', 0, 0, 'L');
                        $pdf->SetFont('', 'B');
                        $pdf->Cell(30, 7, $row['ci'] . ' ' . $row['expedicion'], 0, 1, 'L');
                    }*/
                    if ($row['tipo_persona'] == "propietario") {
                        // 1. Construimos la cadena HTML unificada manejando las negritas internamente
                        $htmlPropietario = '• <b>' . $row['nombre_completo1'] . '</b> con C.I. N°: <b>' . $row['ci'] . ' ' . $row['expedicion'] . '</b>';

                        // 2. Quitamos la tipografía Bold global para que respete las etiquetas <b> del HTML
                        $pdf->SetFont('', 'N'); 

                        // 3. Renderizamos en una sola fila continua y elástica de 180mm de ancho
                        // El '0' en el alto (segundo parámetro) calcula el alto dinámicamente según el contenido
                        // El '1' en el parámetro ln (sexto parámetro) indica que el siguiente elemento se dibuje abajo
                        $pdf->writeHTMLCell(180, 0, '', '', $htmlPropietario, 0, 1, 0, true, 'L', true);
                        
                        // Añadimos un pequeño espacio de separación controlado de 1mm para que no se pegue al siguiente registro
                        $pdf->Ln(1); 
                    }
                }

                // --- PÁRRAFO FINAL DE CONCLUSIÓN ---
                $pdf->SetFont('', 'N');
                $pdf->Ln(4);
                $conclusionFinal = 'En la cual teniendo un pronunciamiento de la Jefatura de Urbanismo - Arq.' . $dataSource->getParameter('via') . ', se puede observar que la construcción de vivienda se encuentra infringiendo a la norma vigente e incumpliendo al PLANUR, Resolución Municipal BI-Secretarial N° 01/2020 de 11/12/2020 de la resolución Municipal BI-Secretarial y con lo establecido en el Decreto Municipal 007/2016 de fecha 16/09/2016; por lo que NO corresponde la prosecución del trámite, para lo cual se' . ' RECOMIENDA' . ' efectuar la Resolución de Rechazo del trámite previo análisis, bajo el principio de buena fe que solicito el propietario.';
                
                $pdf->writeHTMLCell(180, 0, '', '', $conclusionFinal, 0, 1, 0, true, 'J', true);
                $pdf->Ln(5);
                $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
            } 
        }


        /* --- CASO: APAU PROSECUCIÓN (SI/SI) --- */
        if ($dataSource->getParameter('area_agro') == "si" && $dataSource->getParameter('aprobacion') == 'si') {
            
            // 1. Lógica de nombres de propietarios (Saneada)
            $propietarios = explode("|", $propietariosList);
            $propName = '';
            $numProp = count($propietarios);

            if ($numProp == 1) {
                $propName = trim($propietariosList);
            } elseif ($numProp == 2) {
                $propName = trim($propietarios[0]) . " y " . trim($propietarios[1]);
            } else {
                $ultimo = array_pop($propietarios);
                $propName = implode(", ", $propietarios) . " y " . $ultimo;
            }

            // 2. Fundamentos Legales (Correlativos)
            $pdf->verificarEspacio(35);
            //$pdf->writeHTMLCell(180, 0, '', '', 'De conformidad al <b>Art. 24 de la C.P.E.</b>, toda persona tiene derecho a la petición... así también menciona en su <b>art. 56</b> que se garantiza la propiedad privada siempre que cumpla una función social.', 0, 1, 0, true, 'J', true);
            $pdf->writeHTMLCell(180, 0, '', '', 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional. Toda persona tiene derecho a la Petición de manera individual o colectiva, sea oral o escrita, y a la obtención de respuesta formal y pronta. Para el ejercicio de este derecho no exigirá mas requisito que la identificación del peticionante, así tembién menciona en su art. 56 inc I.- Toda persona tiene derecho a la pro´piedad privada individual o colectiva, siempre que esta cumpla una función social. II. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 1, 0, true, 'J', true);
            $pdf->Ln(3);

            $pdf->verificarEspacio(25);
            $pdf->writeHTMLCell(180, 0, '', '', 'Que, la Ley N° 2341 de Procedimiento Administrativo, en el inc. K) del Art. 4 establece que los procedimientos administrativos, deben responder a los principios de economía, simplicidad y celeridad, evitando la realización de trámites, formalismos o diligencias innecesarias.', 0, 1, 0, true, 'J', true);
            $pdf->Ln(3);

            $pdf->verificarEspacio(25);
            $pdf->writeHTMLCell(180, 0, '', '', 'Que de acuerdo a la <b>Resolución Municipal Bi-Secretarial N° 1/2020</b>, los contribuyentes deben cumplir con los requisitos para los trámites administrativos ante la Dirección de Urbanismo.', 0, 1, 0, true, 'J', true);
            
            
            //////////////////////////////////////////////////////////    
            // AUMENTAR CONTENIDO 
            if ($dataSource->getParameter('observacion') != '') {
                $pdf->Ln(3);
                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                //var_dump($dataSource); exit();
            }
            
            
            // 3. SECCIÓN CONCLUSIONES (Salto de página inteligente)
            $pdf->verificarEspacio(25); 
            $pdf->Ln(8);
            $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACIÓN.-</b>', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2);
            $pdf->writeHTMLCell(180, 0, '', '', 'Se concluye que el (los):', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2);

            // 4. Cuerpo de la Conclusión (Uso intensivo de negritas)
            $cuerpoConcl = '<b>' . $propName . '</b>, legítimo(s) propietario(s) de un predio con una extensión de <b>' . $dataSource->getParameter('superficie_leg') . ' m2</b>; registrado en Derechos Reales conforme Testimonio de fecha <b>' . $dataSource->getParameter('fecha_testimonio') . '</b>, ante la Notaría N° ' . $dataSource->getParameter('nro_notario') . ' (' . $dataSource->getParameter('nombre_notario') . ').';
            
            $pdf->writeHTMLCell(180, 0, '', '', $cuerpoConcl, 0, 1, 0, true, 'J', true);
            $pdf->Ln(3);

            // 5. Advertencia sobre el Decreto Supremo 5056
            $pdf->verificarEspacio(20);
            $pdf->writeHTMLCell(180, 0, '', '', 'Dando cumplimiento al <b>Decreto Supremo N° 5056</b> de fecha 22 de noviembre de 2023, que modifica el párrafo I del Art. 3 del DS 1809, se establece que:', 0, 1, 0, true, 'J', true);
            $pdf->Ln(2);
            
            $pdf->SetFillColor(245, 245, 245); // Un ligero gris para resaltar el texto del decreto
            $pdf->writeHTMLCell(180, 0, '', '', '<b>"1.- Las áreas productivas agropecuarias urbanas (A.P.A.U.)no podrán ser cambio de uso y de suelo. ni urbanizables en un plazo de (15) años a partir de la publicación del presente Decreto Supremo"</b>; por lo que se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado a ser aprobado.', 0, 1, 1, true, 'C', true);
            $pdf->Ln(3);

            // 6. Recomendación Final
            $pdf->verificarEspacio(30);
            $pdf->writeHTMLCell(180, 0, '', '', 'Por lo que se <b>RECOMIENDA</b> la prosecución del expediente administrativo, quedando pendiente la aprobación técnica del plano solicitado.', 0, 1, 0, true, 'J', true);
            $pdf->Ln(3);
            ///////////////////////////////////
            // AUMENTAR CONCLUSION QUE ELLOS INDIQUEN
            if ($dataSource->getParameter('conclusion') != '') {
                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('conclusion'), 0, 1, 0, true, 'J', true);
                $pdf->Ln(3);
            }

            $finalMsg = '<b>El presente informe Legal no define el Derecho Propietario. Si existiera doble titularidad, será la vía llamada por ley quien lo defina. Los planos no contravienen normas legales, siempre que la parte técnica remita los informes correspondientes.</b>';
            $pdf->writeHTMLCell(180, 0, '', '', $finalMsg, 0, 1, 0, true, 'J', true);
            $pdf->Ln(5);
            
            $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
        } else {
            // 1. GENERACIÓN DE NOMBRE DINÁMICO (Para evitar repetir el foreach)
            $propietarios = [];
            foreach ($dataSource->getDataSet() as $row) {
                if ($row['tipo_persona'] == "propietario") {
                    $propietarios[] = '<b>' . $row['nombre_completo1'] . '</b> con C.I. N°: <b>' . $row['ci'] . ' ' . $row['expedicion'] . '</b>';
                }
            }
            $propNameList = implode(", ", $propietarios);

            // --- CASO A: Trámite ID 20 (APAU / Especial) ---
            if ($dataSource->getParameter('id_tipo_tramite') == 20 && $dataSource->getParameter('aprobacion') == 'si') {
                
                $pdf->verificarEspacio(35);
                $pdf->writeHTMLCell(180, 0, '', '', 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional, art. 24, Toda persona tiene derecho a la petición, de forma individual o colectiva, oral o escrita. Además, garantiza el derecho a recibir una respuesta formal y pronta sin más requisito que la identificación del peticionario, asi tambien menciona en su art.56 inc. l.- Toda persona tiene derecho a la propiedad privada individual o colectiva, siempre que esta cumpla una función social. ll. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(3);

                $pdf->verificarEspacio(25);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, en virtud a la Ley N° 2341 de procedimiento Administrativo, en inc. k) del art. 4 establece que los procedimientos administrativos, deben responder a los principios de economia, simplicidad y celeridad, evitando la realizacion de tramites, formalismos o diligencias innecesarias.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(3);

                $pdf->verificarEspacio(45);
                $htmlDS = 'Que, en virtud al Decreto Supremo N° 5056 de fecha 22 de noviembre de 2023; decreta en su Articulo Unico que: A fin de efectivizar los mecanismos de resguardo de las áreas productivas para garantizar la seguridad alimentaria con soberania, se modifica el parrafo l del Articulo 3 del Decreto Supremo N° 1809 de fecha 27 de noviembre de 2013 con el siguiente texto; "l.- Las áreas productivas agropecuarias urbanas (A.P.A.U.) no podrán ser cambio de uso y de suelo, ni urbanizables en un plazo de (15) años a partir de la publicación del presente Decreto Supremo".';
                $pdf->writeHTMLCell(180, 0, '', '', $htmlDS, 0, 1, 0, true, 'J', true);

                // AUMENTAR CONTENIDO 
                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->Ln(3);
                    $pdf->verificarEspacio(25);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                }
                
                // --- CONCLUSIONES CASO 20 ---
                $pdf->verificarEspacio(25);
                $pdf->Ln(8);
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACIÓN.-</b>', 0, 1, 0, true, 'L', true);
                $pdf->Ln(2);
                
                $htmlConcl20 = 'Se concluye que el (los) Sr(es): ' . $propNameList . ' es legítimo propietario de un predio de ' . $dataSource->getParameter('superficie') . ' m2; registrado en Derechos Reales conforme Testimonio N° ' . $dataSource->getParameter('nro_testimonio') . ' de fecha ' . $dataSource->getParameter('fecha_testimonio') . ' ante la Notaría N° ' . $dataSource->getParameter('nro_notario') . ' (' . $dataSource->getParameter('nombre_notario') . ').';
                
                $pdf->writeHTMLCell(180, 0, '', '', $htmlConcl20, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);
                
                $pdf->writeHTMLCell(180, 0, '', '', '<b>RECOMENDACIÓN:</b> Se recomienda la prosecución del expediente administrativo, faltando la aprobación de la parte técnica del plano solicitado. El presente informe no define derecho propietario...', 0, 1, 0, true, 'J', true);

                ///////////////////////////////////
                // AUMENTAR CONCLUSION QUE ELLOS INDIQUEN
                if ($dataSource->getParameter('conclusion') != '') {
                    $pdf->Ln(3);
                    $pdf->verificarEspacio(25);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('conclusion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(3);
                }


            // --- CASO B: Trámites Generales (1-19) ---
            } elseif (in_array($dataSource->getParameter('id_tipo_tramite'), range(1, 19)) && $dataSource->getParameter('aprobacion') == 'si') {
                
                $pdf->verificarEspacio(35);

                /// Se corrigio texto
                //$pdf->writeHTMLCell(180, 0, '', '', 'De conformidad al <b>Art. 24 de la C.P.E.</b> y el <b>Art. 56</b> sobre el derecho a la propiedad privada individual o colectiva...', 0, 1, 0, true, 'J', true);
                $pdf->writeHTMLCell(180, 0, '', '', 'De conformidad al Art. 24 Constitución Politica del Estado Plurinacional. Toda persona tiene derecho a la Petición de manera individual o colectiva, sea oral o escrita, y a la obtención de respuesta formal y pronta. Para el ejercicio de este derecho no exigirá mas requisito que la identificación del peticionante, así tembién menciona en su art. 56 inc I.- Toda persona tiene derecho a la pro´piedad privada individual o colectiva, siempre que esta cumpla una función social. II. Se garantiza la propiedad privada siempre que el uso que se haga de ella no sea perjudicial al interes colectivo.', 0, 1, 0, true, 'J', true);
                $pdf->Ln(3);

                $pdf->verificarEspacio(30);
                $pdf->writeHTMLCell(180, 0, '', '', 'Que, la <b>Ley N° 2341</b> y la <b>Resolución Municipal Bi-Secretarial N° 1/2020</b> establecen que los contribuyentes deben cumplir con los requisitos técnicos de la Dirección de Urbanismo.', 0, 1, 0, true, 'J', true);

                // AUMENTAR CONTENIDO 
                if ($dataSource->getParameter('observacion') != '') {
                    $pdf->Ln(3);
                    $pdf->verificarEspacio(25);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('observacion'), 0, 1, 0, true, 'J', true);
                    //var_dump($dataSource); exit();
                }
                

                // --- CONCLUSIONES TRÁMITES GENERALES ---
                $pdf->verificarEspacio(25);
                $pdf->Ln(8);
                $pdf->writeHTMLCell(180, 0, '', '', '<b>CONCLUSIONES Y RECOMENDACIÓN.-</b>', 0, 1, 0, true, 'L', true);
                $pdf->Ln(2);
                
                $htmlConclGen = 'Realizado el informe legal, quien(es) es(son) propietario(s): ' . $propNameList . ' conforme la Escritura Pública de fecha ' . $dataSource->getParameter('fecha_testimonio') . ', cumple con los requisitos de la normativa vigente.';
                
                $pdf->writeHTMLCell(180, 0, '', '', $htmlConclGen, 0, 1, 0, true, 'J', true);
                $pdf->Ln(4);
                
                $pdf->writeHTMLCell(180, 0, '', '', 'Por lo que se <b>RECOMIENDA</b> la prosecución del trámite administrativo, faltando la aprobación técnica topográfica. El presente informe legal no define derecho propietario...', 0, 1, 0, true, 'J', true);

                ///////////////////////////////////
                // AUMENTAR CONCLUSION QUE ELLOS INDIQUEN
                if ($dataSource->getParameter('conclusion') != '') {
                    $pdf->Ln(3);
                    $pdf->verificarEspacio(25);
                    $pdf->writeHTMLCell(180, 0, '', '', $dataSource->getParameter('conclusion'), 0, 1, 0, true, 'J', true);
                    $pdf->Ln(3);
                }
            }
            
            // Cierre común para ambos casos de aprobación
            $pdf->Ln(5);
            $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo para fines consiguientes.', 0, 1, 0, true, 'J', true);
        }

        // 1. Mensaje de cierre condicional
        // Solo si no es un rechazo específico y la aprobación está en curso
        ////////////////////////////////////////////////
        // cOMENTADO POR CONSULTA
        /*
        if ($dataSource->getParameter('aprobacion') != 'no' && 
            !in_array($dataSource->getParameter('tipo_rechazo'), ["FRU", "APAU", "Doble", "Innova"])) {
            
            $pdf->verificarEspacio(10);
            $pdf->SetFont('', 'N');
            $pdf->writeHTMLCell(180, 0, '', '', 'Es cuanto informo de la inspección realizada.', 0, 1, 0, true, 'L', true);
        }
            */
        // 2. BLOQUE DE FIRMA (Indivisible)
        // Verificamos 40mm para asegurar espacio para el nombre, cargo y el sello/firma física
        $pdf->verificarEspacio(40);
        
        $pdf->Ln(25); // Espacio para que la persona firme físicamente
        
        // Nombre del responsable
        $pdf->SetFont('', '');
        $pdf->Cell(180, 5, $dataSource->getParameter('de'), 0, 1, 'C');
        
        // Cargo del responsable
        $pdf->SetFont('', 'B');
        $pdf->Cell(180, 5, $dataSource->getParameter('cargode'), 0, 1, 'C');

        // 3. Finalización del archivo
        // Eliminamos los Ln() innecesarios al final para evitar hojas en blanco accidentales
        $pdf->Output($fileName, 'F');
    }

    function writeClasificacionDetalle($pdf, $dataSource, $mostrar_costos)
    {
        $hGlobal = 5;
        // Anchos de columna
        $wNro = 10;
        $wCodigo = 15;
        $wDescripcionItem = 80;
        $wUnidad = 15;
        $wCantidad = 15;
        $wCantidadAlerta = 15;
        $wCostoUnitario = 15;
        $wCostoTotal = 20;

        // --- SEGURIDAD: Verificar si cabe al menos el título y el encabezado ---
        // Si quedan menos de 20mm, saltar de página automáticamente
        if ($pdf->GetY() > ($pdf->getPageHeight() - 25)) {
            $pdf->AddPage();
        }

        $pdf->Ln(2);
        $pdf->SetFontSize(7);
        $pdf->SetFont('', 'B');

        // Título de Clasificación
        $pdf->Cell(0, $hGlobal, '* ' . $dataSource->getParameter('nombreClasificacion'), 0, 1, 'L');

        // --- ENCABEZADOS ---
        $pdf->SetFontSize(6.5);
        $pdf->SetFillColor(240, 240, 240); // Un gris muy claro para el encabezado
        
        $pdf->Cell($wNro, $hGlobal, 'Nro.', 1, 0, 'C', true);
        $pdf->Cell($wCodigo, $hGlobal, 'Código', 1, 0, 'C', true);
        $pdf->Cell($wDescripcionItem, $hGlobal, 'Descripción del Material', 1, 0, 'C', true);
        $pdf->Cell($wUnidad, $hGlobal, 'Unidad', 1, 0, 'C', true);
        $pdf->Cell($wCantidad, $hGlobal, 'Cantidad', 1, 0, 'C', true);
        $pdf->Cell($wCantidadAlerta, $hGlobal, 'Cant. Min.', 1, 0, 'C', true);
        
        if ($mostrar_costos != 'no') {
            $pdf->Cell($wCostoUnitario, $hGlobal, 'C/Unit.', 1, 0, 'C', true);
            $pdf->Cell($wCostoTotal, $hGlobal, 'C/Total', 1, 0, 'C', true);
        }
        $pdf->Ln();

        // --- DETALLE ---
        $count = 1;
        $pdf->SetFont('', '');
        foreach ($dataSource->getDataset() as $datarow) {
            
            // Verificar espacio para la fila (evita filas cortadas a la mitad)
            if ($pdf->GetY() > ($pdf->getPageHeight() - 15)) {
                $pdf->AddPage();
                // (Opcional: podrías repetir el encabezado aquí si lo deseas)
            }

            $costoUnitario = ($datarow['cantidad'] > 0) ? ($datarow['costo'] / $datarow['cantidad']) : 0;

            $pdf->Cell($wNro, $hGlobal, $count, 1, 0, 'R');
            $pdf->Cell($wCodigo, $hGlobal, $datarow['codigo'], 1, 0, 'C');
            
            // DESCRIPCIÓN con control de texto largo (max-stretch)
            // Usamos stretch=1 para que el texto se comprima si no cabe
            $pdf->Cell($wDescripcionItem, $hGlobal, $datarow['nombre'], 1, 0, 'L', false, '', 1);
            
            $pdf->Cell($wUnidad, $hGlobal, $datarow['unidad_medida'], 1, 0, 'C');
            $pdf->Cell($wCantidad, $hGlobal, number_format($datarow['cantidad'], 2), 1, 0, 'R');
            $pdf->Cell($wCantidadAlerta, $hGlobal, number_format($datarow['cantidad_min'], 2), 1, 0, 'R');

            if ($mostrar_costos != 'no') {
                $pdf->Cell($wCostoUnitario, $hGlobal, number_format($costoUnitario, 2), 1, 0, 'R');
                $pdf->Cell($wCostoTotal, $hGlobal, number_format($datarow['costo'], 2), 1, 0, 'R');
            }
            $pdf->Ln();
            $count++;
        }

        // --- TOTALES ---
        if ($mostrar_costos != 'no') {
            $pdf->SetFont('', 'B');
            // Sumamos todos los anchos previos para la celda de "Total"
            $wSalto = $wNro + $wCodigo; 
            $pdf->Cell($wSalto, $hGlobal, '', 1, 0, 'C');
            $pdf->Cell($wDescripcionItem, $hGlobal, 'TOTAL ' . $dataSource->getParameter('nombreClasificacion'), 1, 0, 'R');
            $pdf->Cell($wUnidad + $wCantidad + $wCantidadAlerta + $wCostoUnitario, $hGlobal, '', 1, 0, 'R');
            $pdf->Cell($wCostoTotal, $hGlobal, number_format($dataSource->getParameter('totalCosto'), 2), 1, 1, 'R');
        }
    }

    private function renderHeaderInfo($pdf, $dataSource, $h) {
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, 'A: ', 0, 0, 'L');
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $h, $dataSource->getParameter('nombrea'), 0, 1, 'L');
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, '', 0, 0, 'L');
        $pdf->Cell(165, $h, $dataSource->getParameter('cargoa'), 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, 'Via: ', 0, 0, 'L');
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $h, $dataSource->getParameter('via'), 0, 1, 'L');
        
        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, '', 0, 0, 'L');
        $pdf->Cell(165, $h, $dataSource->getParameter('cargovia'), 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, 'De: ', 0, 0, 'L');
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $h, $dataSource->getParameter('de'), 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('', 'B');
        $pdf->Cell(15, $h, 'Fecha: ', 0, 0, 'L');
        $pdf->SetFont('', 'N');
        $pdf->Cell(165, $h, 'Colcapirhua, ' . $dataSource->getParameter('dia') . ' de ' . $dataSource->getParameter('mes') . ' de ' . $dataSource->getParameter('anio'), 0, 1, 'L');
        $pdf->Ln(3);
    }

    private function renderPropietarios($pdf, $dataSource, $h) {
        $list = [];
        foreach ($dataSource->getDataSet() as $row) {
            /*
            if ($row['tipo_persona'] == "propietario") {
                $list[] = $row['nombre_completo1'];
                $pdf->SetFont('', 'B');
                $pdf->Cell(70, $h, $row['nombre_completo1'], 0, 0, 'L');
                $pdf->SetFont('', 'N');
                $pdf->Cell(20, $h, 'con C.I. N°: ', 0, 0, 'L');
                $pdf->SetFont('', 'B');
                $pdf->Cell(20, $h, $row['ci'] . ' ' . $row['expedicion'], 0, 1, 'L');
            }
                */
            if ($row['tipo_persona'] == "propietario") {
                // 1. Conservamos tu lógica de datos (llenar el array histórico)
                $list[] = $row['nombre_completo1'];

                // 2. Construimos la cadena HTML unificada con el formato de negritas correcto
                $htmlPropietario = '• <b>' . $row['nombre_completo1'] . '</b> con C.I. N°: <b>' . $row['ci'] . ' ' . $row['expedicion'] . '</b>';

                // 3. Reseteamos la fuente a Normal para que las etiquetas <b> funcionen nativamente
                $pdf->SetFont('', 'N');

                // 4. Renderizamos en una sola fila elástica de 180mm de ancho
                // El segundo parámetro en '0' calcula el alto dinámicamente según el contenido
                // El sexto parámetro en '1' fuerza el salto de línea al finalizar este bloque HTML
                $pdf->writeHTMLCell(180, 0, '', '', $htmlPropietario, 0, 1, 0, true, 'L', true);
                
                // Pequeña separación controlada de 1mm para que los registros no queden totalmente pegados
                $pdf->Ln(1);
            }
        }
        return implode("|", $list);
    }

    private function renderTablaPredio($pdf, $dataSource, $h) {
        $pdf->Cell(90, $h, 'Provincia: Quillacollo', 1, 0, 'L');
        $pdf->Cell(90, $h, 'Sección: Quinta', 1, 1, 'L');
        $pdf->Cell(90, $h, 'Municipio: Colcapirhua', 1, 0, 'L');
        $pdf->Cell(90, $h, 'Zona: ' . $dataSource->getParameter('zona'), 1, 1, 'L');
        $pdf->Cell(90, $h, 'Distrito: ' . $dataSource->getParameter('distrito'), 1, 0, 'L');
        $pdf->Cell(90, $h, 'Manzano: ' . $dataSource->getParameter('manzana'), 1, 1, 'L');
        $pdf->Cell(90, $h, 'Lote: ' . $dataSource->getParameter('lote'), 1, 0, 'L');
        $pdf->Cell(90, $h, 'Superficie: ' . $dataSource->getParameter('superficie') . ' m2', 1, 1, 'L');
    }

    // Nota: He simplificado la lógica de renderRechazos para asegurar el flujo de MultiCell.
    private function renderRechazos($pdf, $dataSource, $propietariosList) {
        $tipo = $dataSource->getParameter('tipo_rechazo');
        $pdf->verificarEspacio(30);
        
        if ($tipo == "FRU") {
            $pdf->writeHTMLCell(180, 0, '', '', 'Que, según el límite de homologación 100/2018, el predio se encuentra fuera del radio urbano (FRU)...', 0, 1, 0, true, 'J');
        }
        // ... (resto de tipos de rechazo siguiendo el mismo patrón de writeHTMLCell con ln=1)
    }

    private function renderAprobaciones($pdf, $dataSource, $propietariosList) {
        $pdf->verificarEspacio(40);
        $pdf->MultiCell(180, 0, 'De conformidad al Art. 24 de la C.P.E., se procede a la revisión...', 0, 'J', 0, 1);
    }

}

?>
