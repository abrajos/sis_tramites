<?php
/**
*@package pXP
*@file gen-MODTipoTramite.php
*@author  (admin)
*@date 26-03-2025 01:17:15
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTipoTramite extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTipoTramite(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_tipo_tramite_sel';
		$this->transaccion='SISTRA_tiptra_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tipo_tramite','int4');
		$this->captura('codigo_tramite','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('nombre_tramite','varchar');
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
			
	function insertarTipoTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tipo_tramite_ime';
		$this->transaccion='SISTRA_tiptra_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('codigo_tramite','codigo_tramite','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_tramite','nombre_tramite','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTipoTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tipo_tramite_ime';
		$this->transaccion='SISTRA_tiptra_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_tramite','id_tipo_tramite','int4');
		$this->setParametro('codigo_tramite','codigo_tramite','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('nombre_tramite','nombre_tramite','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTipoTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tipo_tramite_ime';
		$this->transaccion='SISTRA_tiptra_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tipo_tramite','id_tipo_tramite','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>