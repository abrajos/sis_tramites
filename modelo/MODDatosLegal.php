<?php
/**
*@package pXP
*@file gen-MODDatosLegal.php
*@author  (admin)
*@date 15-09-2025 18:37:32
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDatosLegal extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarDatosLegal(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_datos_legal_sel';
		$this->transaccion='SISTRA_datleg_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_datos_legal','int4');
		$this->captura('aprobacion','varchar');
		$this->captura('aux','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('area_agro','varchar');
		$this->captura('cod_catastral','varchar');
		$this->captura('kami','varchar');
		$this->captura('ddrr_registro','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('id_tramite_detalle','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDatosLegal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_datos_legal_ime';
		$this->transaccion='SISTRA_datleg_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('aprobacion','aprobacion','varchar');
		$this->setParametro('aux','aux','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('area_agro','area_agro','varchar');
		$this->setParametro('cod_catastral','cod_catastral','varchar');
		$this->setParametro('kami','kami','varchar');
		$this->setParametro('ddrr_registro','ddrr_registro','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarDatosLegal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_datos_legal_ime';
		$this->transaccion='SISTRA_datleg_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_datos_legal','id_datos_legal','int4');
		$this->setParametro('aprobacion','aprobacion','varchar');
		$this->setParametro('aux','aux','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('area_agro','area_agro','varchar');
		$this->setParametro('cod_catastral','cod_catastral','varchar');
		$this->setParametro('kami','kami','varchar');
		$this->setParametro('ddrr_registro','ddrr_registro','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDatosLegal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_datos_legal_ime';
		$this->transaccion='SISTRA_datleg_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_datos_legal','id_datos_legal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>