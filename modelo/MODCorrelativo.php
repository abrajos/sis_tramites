<?php
/**
*@package pXP
*@file gen-MODCorrelativo.php
*@author  (admin)
*@date 26-08-2025 21:14:57
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCorrelativo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCorrelativo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_correlativo_sel';
		$this->transaccion='SISTRA_CORREL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_correlativo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('sigla','varchar');
		$this->captura('tipo','varchar');
		$this->captura('cargo','varchar');
		$this->captura('num_siguiente','int4');
		$this->captura('num_actual','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCorrelativo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_correlativo_ime';
		$this->transaccion='SISTRA_CORREL_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('num_siguiente','num_siguiente','int4');
		$this->setParametro('num_actual','num_actual','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCorrelativo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_correlativo_ime';
		$this->transaccion='SISTRA_CORREL_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_correlativo','id_correlativo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('cargo','cargo','varchar');
		$this->setParametro('num_siguiente','num_siguiente','int4');
		$this->setParametro('num_actual','num_actual','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCorrelativo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_correlativo_ime';
		$this->transaccion='SISTRA_CORREL_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_correlativo','id_correlativo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>