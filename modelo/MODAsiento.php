<?php
/**
*@package pXP
*@file gen-MODAsiento.php
*@author  (admin)
*@date 20-06-2026 10:56:00
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODAsiento extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarAsiento(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_asiento_sel';
		$this->transaccion='SISTRA_ASIEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_asiento','int4');
		$this->captura('nro_asiento','int4');
		$this->captura('fecha_asiento','date');
		$this->captura('id_matricula','int4');
		$this->captura('motivo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarAsiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_asiento_ime';
		$this->transaccion='SISTRA_ASIEN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nro_asiento','nro_asiento','int4');
		$this->setParametro('fecha_asiento','fecha_asiento','date');
		$this->setParametro('id_matricula','id_matricula','int4');
		$this->setParametro('motivo','motivo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarAsiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_asiento_ime';
		$this->transaccion='SISTRA_ASIEN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_asiento','id_asiento','int4');
		$this->setParametro('nro_asiento','nro_asiento','int4');
		$this->setParametro('fecha_asiento','fecha_asiento','date');
		$this->setParametro('id_matricula','id_matricula','int4');
		$this->setParametro('motivo','motivo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarAsiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_asiento_ime';
		$this->transaccion='SISTRA_ASIEN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_asiento','id_asiento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>