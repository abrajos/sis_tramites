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
