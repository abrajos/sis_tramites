<?php
/**
*@package pXP
*@file gen-MODBoleta.php
*@author  (admin)
*@date 22-04-2025 06:17:41
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODBoleta extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarBoleta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_boleta_sel';
		$this->transaccion='SISTRA_boleta_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_boleta','int4');
		$this->captura('fecha_pago','date');
		$this->captura('estado_reg','varchar');
		$this->captura('nro_liquidacion','int4');
		$this->captura('monto','numeric');
		$this->captura('comp_pago','int4');
		$this->captura('id_tramite','int4');
		$this->captura('expediente','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
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
			
	function insertarBoleta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_ime';
		$this->transaccion='SISTRA_boleta_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('fecha_pago','fecha_pago','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_liquidacion','nro_liquidacion','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('comp_pago','comp_pago','int4');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('expediente','expediente','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarBoleta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_ime';
		$this->transaccion='SISTRA_boleta_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_boleta','id_boleta','int4');
		$this->setParametro('fecha_pago','fecha_pago','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_liquidacion','nro_liquidacion','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('comp_pago','comp_pago','int4');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('expediente','expediente','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarBoleta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_boleta_ime';
		$this->transaccion='SISTRA_boleta_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_boleta','id_boleta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>