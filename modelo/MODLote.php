<?php
/**
*@package pXP
*@file gen-MODLote.php
*@author  (admin)
*@date 17-04-2025 00:18:04
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODLote extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarLote(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_lote_sel';
		$this->transaccion='SISTRA_lotes_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_lote','int4');
		$this->captura('tipo_cesion','varchar');
		$this->captura('superficie','numeric');
		$this->captura('nombre','varchar');
		$this->captura('id_tramite_detalle','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('lote','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('co_norte','varchar');
		$this->captura('co_sud','varchar');
		$this->captura('co_este','varchar');
		$this->captura('co_oeste','varchar');
		$this->captura('porcentaje','numeric');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarLote(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_lote_ime';
		$this->transaccion='SISTRA_lotes_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('tipo_cesion','tipo_cesion','varchar');
		$this->setParametro('superficie','superficie','numeric');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('lote','lote','varchar');
		$this->setParametro('co_norte','co_norte','varchar');
		$this->setParametro('co_sud','co_sud','varchar');
		$this->setParametro('co_este','co_este','varchar');
		$this->setParametro('co_oeste','co_oeste','varchar');
		$this->setParametro('porcentaje','porcentaje','numeric');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarLote(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_lote_ime';
		$this->transaccion='SISTRA_lotes_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_lote','id_lote','int4');
		$this->setParametro('tipo_cesion','tipo_cesion','varchar');
		$this->setParametro('superficie','superficie','numeric');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('lote','lote','varchar');
		$this->setParametro('co_norte','co_norte','varchar');
		$this->setParametro('co_sud','co_sud','varchar');
		$this->setParametro('co_este','co_este','varchar');
		$this->setParametro('co_oeste','co_oeste','varchar');
		$this->setParametro('porcentaje','porcentaje','numeric');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarLote(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_lote_ime';
		$this->transaccion='SISTRA_lotes_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_lote','id_lote','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>