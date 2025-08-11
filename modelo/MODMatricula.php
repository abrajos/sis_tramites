<?php
/**
*@package pXP
*@file gen-MODMatricula.php
*@author  (admin)
*@date 17-04-2025 00:18:08
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODMatricula extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarMatricula(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_matricula_sel';
		$this->transaccion='SISTRA_matri_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_matricula','int4');
		$this->captura('superficie','numeric');
		$this->captura('asiento','varchar');
		$this->captura('decreto_registrador','varchar');
		$this->captura('fecha_testimonio','date');
		$this->captura('nro_matricula','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_asiento','date');
		$this->captura('nro_notario','varchar');
		$this->captura('fecha_decreto','date');
		$this->captura('nombre_notario','varchar');
		$this->captura('id_tramite','int4');
		$this->captura('nro_testimonio','varchar');
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
			
	function insertarMatricula(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_matricula_ime';
		$this->transaccion='SISTRA_matri_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('superficie','superficie','numeric');
		$this->setParametro('asiento','asiento','varchar');
		$this->setParametro('decreto_registrador','decreto_registrador','varchar');
		$this->setParametro('fecha_testimonio','fecha_testimonio','date');
		$this->setParametro('nro_matricula','nro_matricula','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_asiento','fecha_asiento','date');
		$this->setParametro('nro_notario','nro_notario','varchar');
		$this->setParametro('fecha_decreto','fecha_decreto','date');
		$this->setParametro('nombre_notario','nombre_notario','varchar');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('nro_testimonio','nro_testimonio','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMatricula(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_matricula_ime';
		$this->transaccion='SISTRA_matri_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_matricula','id_matricula','int4');
		$this->setParametro('superficie','superficie','numeric');
		$this->setParametro('asiento','asiento','varchar');
		$this->setParametro('decreto_registrador','decreto_registrador','varchar');
		$this->setParametro('fecha_testimonio','fecha_testimonio','date');
		$this->setParametro('nro_matricula','nro_matricula','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_asiento','fecha_asiento','date');
		$this->setParametro('nro_notario','nro_notario','varchar');
		$this->setParametro('fecha_decreto','fecha_decreto','date');
		$this->setParametro('nombre_notario','nombre_notario','varchar');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('nro_testimonio','nro_testimonio','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarMatricula(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_matricula_ime';
		$this->transaccion='SISTRA_matri_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_matricula','id_matricula','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>