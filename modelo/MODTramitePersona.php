<?php
/**
*@package pXP
*@file gen-MODTramitePersona.php
*@author  (admin)
*@date 01-04-2025 15:44:33
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTramitePersona extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTramitePersona(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_tramite_persona_sel';
		$this->transaccion='SISTRA_traper_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tramite_persona','int4');
		$this->captura('id_tramite','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo_persona','varchar');
		$this->captura('id_persona','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('domicilio','varchar');
		$this->captura('nro_poder','varchar');
		$this->captura('fecha_poder','date');
		$this->captura('nro_notaria','int4');
		$this->captura('notario','varchar');
		$this->captura('desc_person','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarTramitePersona(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_persona_ime';
		$this->transaccion='SISTRA_traper_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_persona','tipo_persona','varchar');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('domicilio','domicilio','varchar');
		$this->setParametro('nro_poder','nro_poder','varchar');
		$this->setParametro('fecha_poder','fecha_poder','date');
		$this->setParametro('nro_notaria','nro_notaria','int4');
		$this->setParametro('notario','notario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTramitePersona(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_persona_ime';
		$this->transaccion='SISTRA_traper_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite_persona','id_tramite_persona','int4');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo_persona','tipo_persona','varchar');
		$this->setParametro('id_persona','id_persona','int4');
		$this->setParametro('domicilio','domicilio','varchar');
		$this->setParametro('nro_poder','nro_poder','varchar');
		$this->setParametro('fecha_poder','fecha_poder','date');
		$this->setParametro('nro_notaria','nro_notaria','int4');
		$this->setParametro('notario','notario','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTramitePersona(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_persona_ime';
		$this->transaccion='SISTRA_traper_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite_persona','id_tramite_persona','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>