<?php
/**
*@package pXP
*@file gen-MODBoletaLiquida.php
*@author  (admin)
*@date 23-09-2025 02:24:49
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODBoletaLiquida extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
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
			
	function insertarBoletaLiquida(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_liquida_ime';
		$this->transaccion='SISTRA_bolliq_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('plano_bs','plano_bs','numeric');
		$this->setParametro('division_m','division_m','numeric');
		$this->setParametro('fecha_emision','fecha_emision','date');
		$this->setParametro('anexion_bs','anexion_bs','numeric');
		$this->setParametro('monto_literal','monto_literal','varchar');
		$this->setParametro('plano_cons_bs','plano_cons_bs','numeric');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('concepto_a_m','concepto_a_m','numeric');
		$this->setParametro('nombre_concepto_b','nombre_concepto_b','varchar');
		$this->setParametro('concepto_a_bs','concepto_a_bs','numeric');
		$this->setParametro('plano_m','plano_m','numeric');
		$this->setParametro('plano_cons_m','plano_cons_m','numeric');
		$this->setParametro('anexion_m','anexion_m','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('linea_nivel_m','linea_nivel_m','numeric');
		$this->setParametro('division_bs','division_bs','numeric');
		$this->setParametro('concepto_b_bs','concepto_b_bs','numeric');
		$this->setParametro('linea_nivel_bs','linea_nivel_bs','numeric');
		$this->setParametro('avance_m','avance_m','numeric');
		$this->setParametro('avance_bs','avance_bs','numeric');
		$this->setParametro('nombre_concepto_a','nombre_concepto_a','varchar');
		$this->setParametro('cite_tramite','cite_tramite','varchar');
		$this->setParametro('concepto_b_m','concepto_b_m','numeric');
		$this->setParametro('plano_verja_m','plano_verja_m','numeric');
		$this->setParametro('total_bs','total_bs','numeric');
		$this->setParametro('total_redon','total_redon','numeric');
		$this->setParametro('nro_boleta','nro_boleta','int4');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('plano_verja_bs','plano_verja_bs','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarBoletaLiquida(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_liquida_ime';
		$this->transaccion='SISTRA_bolliq_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_boleta_liquida','id_boleta_liquida','int4');
		$this->setParametro('plano_bs','plano_bs','numeric');
		$this->setParametro('division_m','division_m','numeric');
		$this->setParametro('fecha_emision','fecha_emision','date');
		$this->setParametro('anexion_bs','anexion_bs','numeric');
		$this->setParametro('monto_literal','monto_literal','varchar');
		$this->setParametro('plano_cons_bs','plano_cons_bs','numeric');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('concepto_a_m','concepto_a_m','numeric');
		$this->setParametro('nombre_concepto_b','nombre_concepto_b','varchar');
		$this->setParametro('concepto_a_bs','concepto_a_bs','numeric');
		$this->setParametro('plano_m','plano_m','numeric');
		$this->setParametro('plano_cons_m','plano_cons_m','numeric');
		$this->setParametro('anexion_m','anexion_m','numeric');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('linea_nivel_m','linea_nivel_m','numeric');
		$this->setParametro('division_bs','division_bs','numeric');
		$this->setParametro('concepto_b_bs','concepto_b_bs','numeric');
		$this->setParametro('linea_nivel_bs','linea_nivel_bs','numeric');
		$this->setParametro('avance_m','avance_m','numeric');
		$this->setParametro('avance_bs','avance_bs','numeric');
		$this->setParametro('nombre_concepto_a','nombre_concepto_a','varchar');
		$this->setParametro('cite_tramite','cite_tramite','varchar');
		$this->setParametro('concepto_b_m','concepto_b_m','numeric');
		$this->setParametro('plano_verja_m','plano_verja_m','numeric');
		$this->setParametro('total_bs','total_bs','numeric');
		$this->setParametro('total_redon','total_redon','numeric');
		$this->setParametro('nro_boleta','nro_boleta','int4');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('plano_verja_bs','plano_verja_bs','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarBoletaLiquida(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_liquida_ime';
		$this->transaccion='SISTRA_bolliq_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_boleta_liquida','id_boleta_liquida','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>