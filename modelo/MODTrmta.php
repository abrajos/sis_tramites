<?php
/**
*@package pXP
*@file gen-MODTrmta.php
*@author  (admin)
*@date 17-04-2025 00:18:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTrmta extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTrmta(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_trmta_sel';
		$this->transaccion='SISTRA_rmta_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_rmta','int4');
		$this->captura('id_tramite','int4');
		$this->captura('fecha_rmta','date');
		$this->captura('tipo_aprobacion','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('nro_rmta','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
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
			
	function insertarTrmta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_trmta_ime';
		$this->transaccion='SISTRA_rmta_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('fecha_rmta','fecha_rmta','date');
		$this->setParametro('tipo_aprobacion','tipo_aprobacion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_rmta','nro_rmta','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTrmta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_trmta_ime';
		$this->transaccion='SISTRA_rmta_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_rmta','id_rmta','int4');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('fecha_rmta','fecha_rmta','date');
		$this->setParametro('tipo_aprobacion','tipo_aprobacion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nro_rmta','nro_rmta','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTrmta(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_trmta_ime';
		$this->transaccion='SISTRA_rmta_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_rmta','id_rmta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>