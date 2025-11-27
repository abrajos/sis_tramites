<?php
/**
 *@package pXP
 *@file    MODReporte.php
 *@author  Jose Mita >Huanca
 *@date    19-02-2020
 *@description: DAO para los reportes del sistema de vacaciones
 */

class MODReporte extends MODbase {

    function __construct(CTParametro $pParam) {
        parent::__construct($pParam);
    }

    function listarDatosFormulario() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_DATFOR_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('cite_tramite', 'varchar');
        $this->captura('nombre_tramite', 'varchar');
        $this->captura('ubicacion', 'varchar');
        $this->captura('fojas', 'integer');
        $this->captura('cuenta', 'varchar');
		$this->captura('mes', 'text');
		$this->captura('dia', 'double PRECISION');
        $this->captura('anio', 'double PRECISION');
        $this->captura('hora', 'double PRECISION');
        $this->captura('minuto', 'double PRECISION');
        $this->captura('num_resolucion', 'integer');
        $this->captura('mes_resolucion', 'text');
		$this->captura('dia_resolucion', 'double PRECISION');
        $this->captura('anio_resolucion', 'double PRECISION');
        $this->captura('celular1', 'varchar');
        $this->captura('correo', 'varchar');
        $this->captura('observacion', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCabeceraInforme() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISINF_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
		        		
        $this->captura('num_informe', 'varchar');
        $this->captura('nombrea', 'text');
        $this->captura('cargoa', 'varchar');
        $this->captura('via', 'text');
        $this->captura('cargovia', 'varchar');
		$this->captura('de', 'text');
        $this->captura('cargode', 'varchar');
		$this->captura('mes', 'text');
        $this->captura('dia', 'double PRECISION');
        $this->captura('anio', 'double PRECISION');
        $this->captura('referencia', 'varchar');
		;

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCuerpoInforme() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LICUIN_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
	
        $this->captura('cite_tramite', 'varchar');
        $this->captura('nombre_tramite', 'varchar');
        $this->captura('distrito', 'varchar');
        $this->captura('zona', 'varchar');
        $this->captura('manzana', 'varchar');
		$this->captura('lote', 'varchar');
        $this->captura('calle', 'varchar');
		$this->captura('avenida', 'varchar');
        $this->captura('tipo_calle', 'varchar');
        $this->captura('rasante_municipal', 'varchar');
        $this->captura('colindante_norte', 'varchar');
        $this->captura('colindante_sur', 'varchar');
        $this->captura('colindante_oeste', 'varchar');
        $this->captura('colindante_este', 'varchar');
        $this->captura('super_escritura', 'numeric');
        $this->captura('super_mensura', 'numeric');
        $this->captura('super_excedente', 'numeric');
        $this->captura('super_inexistente', 'numeric');
        $this->captura('super_total', 'numeric');
        $this->captura('long_rasante', 'numeric');
        $this->captura('vias', 'varchar');
        $this->captura('agua_potable', 'varchar');
        $this->captura('alcantarillado', 'varchar');
        $this->captura('alumbrado_publico', 'varchar');
        $this->captura('telefonia', 'varchar');
        $this->captura('equipamiento', 'varchar');
        $this->captura('transporte', 'varchar');
        $this->captura('observacion', 'varchar');
        $this->captura('conclusion', 'varchar');
        $this->captura('nombre_lote', 'varchar');
		
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCabeceraInformeLegal() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LICALE_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
	
        $this->captura('num_informe', 'varchar');
        $this->captura('nombrea', 'text');
        $this->captura('cargoa', 'varchar');
        $this->captura('via', 'text');
        $this->captura('cargovia', 'varchar');
		$this->captura('de', 'text');
        $this->captura('cargode', 'varchar');
		$this->captura('mes', 'text');
        $this->captura('dia', 'double PRECISION');
        $this->captura('anio', 'double PRECISION');
        $this->captura('referencia', 'varchar');

        $this->captura('cite_tramite', 'varchar');
        $this->captura('nombre_tramite', 'varchar');
        $this->captura('id_tipo_tramite', 'int4');
        $this->captura('id_tramite', 'int4');
        $this->captura('observacion', 'varchar');
        $this->captura('conclusion', 'varchar');

        $this->captura('nro_matricula', 'varchar');
        $this->captura('superficie', 'numeric');
        $this->captura('asiento', 'varchar');
		$this->captura('fecha_asiento', 'date');
        $this->captura('nro_testimonio', 'varchar');
		$this->captura('fecha_testimonio', 'date');
        $this->captura('nro_notario', 'varchar');
        $this->captura('nombre_notario', 'varchar');
        $this->captura('nro_rmta', 'varchar');
        $this->captura('fecha_rmta', 'date');
        $this->captura('aprobacion', 'varchar');
        $this->captura('area_agro', 'varchar');
        $this->captura('cod_catastral', 'varchar');
        $this->captura('ddrr_registro', 'varchar');
        $this->captura('distrito', 'varchar');
        $this->captura('kami', 'varchar');
        $this->captura('lote', 'varchar');
        $this->captura('manzana', 'varchar');
        $this->captura('superficie_leg', 'numeric');
        $this->captura('zona', 'varchar');
		
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCuerpoInformeLegal() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LICULE_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
	
        $this->captura('distrito', 'varchar');
        $this->captura('zona', 'varchar');
        $this->captura('manzana', 'varchar');
        $this->captura('lote', 'varchar');
        $this->captura('aprobacion', 'varchar');
        $this->captura('area_agro', 'varchar');
        $this->captura('cod_catastral', 'varchar');
        $this->captura('ddrr_registro', 'varchar');
        $this->captura('kami', 'varchar');
        $this->captura('tipo_rechazo', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCabeceraInformeArqui() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LICAAR_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
	
        $this->captura('num_informe', 'varchar');
        $this->captura('nombrea', 'text');
        $this->captura('cargoa', 'varchar');
        $this->captura('via', 'text');
        $this->captura('cargovia', 'varchar');
		$this->captura('de', 'text');
        $this->captura('cargode', 'varchar');
		$this->captura('mes', 'text');
        $this->captura('dia', 'double PRECISION');
        $this->captura('anio', 'double PRECISION');
        $this->captura('referencia', 'varchar');

        $this->captura('cite_tramite', 'varchar');
        $this->captura('nombre_tramite', 'varchar');
        $this->captura('id_tipo_tramite', 'int4');
        $this->captura('id_tramite', 'int4');
        $this->captura('observacion', 'varchar');
        $this->captura('conclusion', 'varchar');

           
		
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarCuerpoInformeArqui() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LICUAR_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
	
        $this->captura('id_tramite', 'int4');
        $this->captura('cite_tramite', 'varchar');
        $this->captura('id_tipo_tramite', 'int4');
        $this->captura('fecha_leg', 'date');
        $this->captura('inf_leg', 'varchar');
        $this->captura('legal', 'text');
        $this->captura('fecha_top', 'date');
        $this->captura('inf_top', 'varchar');
        $this->captura('topo', 'text');
        $this->captura('distrito', 'varchar');
        $this->captura('zona', 'varchar');
        $this->captura('manzana', 'varchar');
        $this->captura('lote', 'varchar');
        $this->captura('calle', 'varchar');
        $this->captura('avenida', 'varchar');
        $this->captura('super_escritura', 'numeric');
        $this->captura('super_mensura', 'numeric');
        $this->captura('super_total', 'numeric');
        $this->captura('long_rasante', 'numeric');
        $this->captura('colindante_este', 'varchar');
        $this->captura('colindante_norte', 'varchar');
        $this->captura('colindante_oeste', 'varchar');
        $this->captura('colindante_sur', 'varchar');
        $this->captura('nro_boleta', 'integer');
        $this->captura('nro_rmta', 'varchar');
        $this->captura('fecha_rmta', 'date');
        $this->captura('tipo_aprobacion', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

	function listarFormularioPersonas() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISPER_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('domicilio', 'varchar');
        $this->captura('tipo_persona', 'varchar');
        $this->captura('fecha_poder', 'date');
		$this->captura('notario', 'varchar');
		$this->captura('nro_notaria', 'integer');
		$this->captura('nombre_completo1', 'text');
		$this->captura('celular1', 'varchar');
		$this->captura('correo', 'varchar');
		$this->captura('ci', 'varchar');
        $this->captura('expedicion', 'varchar');
        $this->captura('nro_poder', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarFormularioPersonasTradet() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LIPETR_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
		        		
        $this->captura('domicilio', 'varchar');
        $this->captura('tipo_persona', 'varchar');
        $this->captura('fecha_poder', 'date');
		$this->captura('notario', 'varchar');
		$this->captura('nro_notaria', 'integer');
		$this->captura('nombre_completo1', 'text');
		$this->captura('celular1', 'varchar');
		$this->captura('correo', 'varchar');
		$this->captura('ci', 'varchar');
        $this->captura('expedicion', 'varchar');
        $this->captura('nro_poder', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }


    function listarOT() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISTOT_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('num_informe', 'varchar');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('desc_funcionario1','text');
		$this->captura('estado_tramite', 'varchar');
		$this->captura('calle', 'varchar');
        $this->captura('avenida', 'varchar');
		$this->captura('zona', 'varchar');
		
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    
    function listarTopografo() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISTOP_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('num_informe', 'varchar');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('desc_funcionario1','text');
		$this->captura('estado_tramite', 'varchar');
		$this->captura('calle', 'varchar');
        $this->captura('avenida', 'varchar');
		$this->captura('zona', 'varchar');
		$this->captura('distrito', 'varchar');
        $this->captura('manzana', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarAbogado() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISLEG_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('asiento', 'varchar');
        $this->captura('decreto_registrador', 'varchar');
        $this->captura('fecha_asiento', 'date');
        $this->captura('fecha_testimonio', 'date');
        $this->captura('nombre_notario', 'varchar');
        $this->captura('nro_matricula', 'varchar');
        $this->captura('nro_notario', 'varchar');
        $this->captura('nro_testimonio', 'varchar');
        $this->captura('superficie', 'numeric');
        $this->captura('descripcion', 'varchar');
        $this->captura('num_informe','varchar');
        $this->captura('fecha_reg', 'timestamp');
		$this->captura('estado_tramite', 'varchar'); 
        $this->captura('desc_funcionario1','text'); 
        
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarArquitecto() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISARQ_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('estado_tramite', 'varchar');  
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('num_informe','varchar');
        $this->captura('fecha_rmta', 'date');
        $this->captura('nro_rmta', 'varchar');
        $this->captura('tipo_aprobacion', 'varchar');
        $this->captura('desc_funcionario1','text');
        
        
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarBoleta() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISBOL_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('comp_pago', 'integer');  
        $this->captura('expediente', 'integer');
        $this->captura('fecha_pago', 'date');
        $this->captura('monto', 'numeric');
        $this->captura('nro_liquidacion', 'integer');
        $this->captura('nombre_completo1','text');
        
        
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    
    function listarLote() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LISLOT_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite', 'id_tramite', 'integer');
		        		
        $this->captura('lote', 'varchar');  
        $this->captura('tipo_cesion', 'varchar');
        $this->captura('nombre', 'varchar');
        $this->captura('superficie', 'numeric');
        
        
        
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarLoteReporte() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LILORE_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_tramite_detalle', 'id_tramite_detalle', 'integer');
		        		
        $this->captura('tipo_cesion', 'varchar');  
        $this->captura('nombre', 'varchar');
        $this->captura('superficie', 'numeric');
        $this->captura('porcentaje', 'numeric');
        
        
        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

    function listarBoletaLiquida(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_boleta_liquida_sel';
		$this->transaccion='SISTRA_bolliq_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_boleta_liquida','int4');
		$this->captura('plano_bs','numeric');
		$this->captura('division_m','numeric');
		$this->captura('fecha_emision','date');
		$this->captura('anexion_bs','numeric');
		$this->captura('monto_literal','varchar');
		$this->captura('plano_cons_bs','numeric');
		$this->captura('id_tramite','int4');
		$this->captura('concepto_a_m','numeric');
		$this->captura('nombre_concepto_b','varchar');
		$this->captura('concepto_a_bs','numeric');
		$this->captura('plano_m','numeric');
		$this->captura('plano_cons_m','numeric');
		$this->captura('anexion_m','numeric');
		$this->captura('estado_reg','varchar');
		$this->captura('linea_nivel_m','numeric');
		$this->captura('division_bs','numeric');
		$this->captura('concepto_b_bs','numeric');
		$this->captura('linea_nivel_bs','numeric');
		$this->captura('avance_m','numeric');
		$this->captura('avance_bs','numeric');
		$this->captura('nombre_concepto_a','varchar');
		$this->captura('cite_tramite','varchar');
		$this->captura('concepto_b_m','numeric');
		$this->captura('plano_verja_m','numeric');
		$this->captura('total_bs','numeric');
		$this->captura('total_redon','numeric');
		$this->captura('nro_boleta','int4');
		$this->captura('id_tramite_detalle','int4');
		$this->captura('plano_verja_bs','numeric');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('plano_cons_tot','numeric');
		$this->captura('plano_tot','numeric');
		$this->captura('plano_verja_tot','numeric');
		$this->captura('linea_nivel_tot','numeric');
		$this->captura('anexion_tot','numeric');
		$this->captura('division_tot','numeric');
		$this->captura('avance_tot','numeric');
		$this->captura('concep_a_tot','numeric');
		$this->captura('concep_b_tot','numeric');

		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarFormularioPersonasBoleta() {
        $this->procedimiento = 'sistra.ft_reporte_sel';
        $this->transaccion = 'TRA_LIPEBO_SEL';
        $this->tipo_procedimiento = 'SEL';

        $this->setParametro('id_boleta_liquida', 'id_boleta_liquida', 'integer');
		        		
        $this->captura('domicilio', 'varchar');
        $this->captura('tipo_persona', 'varchar');
        $this->captura('fecha_poder', 'date');
		$this->captura('notario', 'varchar');
		$this->captura('nro_notaria', 'integer');
		$this->captura('nombre_completo1', 'text');
		$this->captura('celular1', 'varchar');
		$this->captura('correo', 'varchar');
		$this->captura('ci', 'varchar');
        $this->captura('expedicion', 'varchar');
        $this->captura('nro_poder', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

	/*
	function listarKardexItem() {
        $this->procedimiento = 'alm.ft_rep_kardex_item_sel';
        $this->transaccion = 'SAL_RKARIT_SEL';
        $this->tipo_procedimiento = 'SEL';
		$this->tipo_retorno='record';
		$this->count=false;

		$this->setParametro('fecha_ini', 'fecha_ini', 'date');
		$this->setParametro('fecha_fin', 'fecha_fin', 'date');
		$this->setParametro('id_item', 'id_item', 'integer');
        $this->setParametro('id_almacen', 'id_almacen', 'varchar');
        $this->setParametro('all_almacen', 'all_almacen', 'varchar');
		
		//$this->captura('id', 'integer');
        $this->captura('fecha', 'timestamp');
        $this->captura('nro_mov', 'varchar');
        $this->captura('almacen', 'varchar');
        $this->captura('motivo', 'varchar');
        $this->captura('ingreso', 'numeric');
        $this->captura('salida', 'numeric');
        $this->captura('saldo', 'numeric');
        $this->captura('costo_unitario', 'numeric');
        $this->captura('ingreso_val', 'numeric');
        $this->captura('salida_val', 'numeric');
        $this->captura('saldo_val', 'numeric');
		$this->captura('id_movimiento', 'integer');

        $this->armarConsulta();
	//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }

	function listarItemEntRec() {
        $this->procedimiento = 'alm.ft_reporte_sel';
        $this->transaccion = 'SAL_REITEN_SEL';
        $this->tipo_procedimiento = 'SEL';
		//$this->count=false;

		$this->setParametro('fecha_ini', 'fecha_ini', 'date');
		$this->setParametro('fecha_fin', 'fecha_fin', 'date');
		$this->setParametro('tipo_mov', 'tipo_mov', 'varchar');
		$this->setParametro('tipo_sol', 'tipo_sol', 'varchar');
        $this->setParametro('id_funcionario', 'id_funcionario', 'varchar');
		$this->setParametro('id_proveedor', 'id_proveedor', 'integer');
		$this->setParametro('all_items', 'all_items', 'varchar');
		$this->setParametro('id_items', 'id_items', 'varchar');
		$this->setParametro('id_clasificacion', 'id_clasificacion', 'varchar');
        $this->setParametro('all_alm', 'all_alm', 'varchar');
		$this->setParametro('id_almacen', 'id_almacen', 'varchar');
		$this->setParametro('all_funcionario', 'all_funcionario', 'varchar');
		$this->setParametro('id_estructura_uo', 'id_estructura_uo', 'varchar');
		
		$this->captura('id_movimiento_det_valorado', 'integer');
		$this->captura('fecha_mov', 'date');
		$this->captura('codigo', 'varchar');
		$this->captura('nombre', 'varchar');
		$this->captura('cantidad', 'numeric');
        $this->captura('costo_unitario', 'numeric');
        $this->captura('costo_total', 'numeric');
        $this->captura('desc_funcionario1', 'text');
        $this->captura('desc_proveedor', 'varchar');
        $this->captura('mov_codigo', 'varchar');
        $this->captura('tipo_nombre', 'varchar');
        $this->captura('tipo', 'varchar');
		$this->captura('desc_almacen', 'varchar');

        $this->armarConsulta();
		//echo $this->consulta;exit;
        $this->ejecutarConsulta();

        return $this->respuesta;
    }
*/
}
?>
