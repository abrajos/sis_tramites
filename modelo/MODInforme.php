<?php
/**
*@package pXP
*@file gen-MODInforme.php
*@author  (admin)
*@date 27-08-2025 15:45:44
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODInforme extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarInforme(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_informe_sel';
		$this->transaccion='SISTRA_INFOR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_informe','int4');
		$this->captura('id_funcionario_a','int4');
		$this->captura('conclusion','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('id_funcionario_via','int4');
		$this->captura('referencia','varchar');
		$this->captura('num_informe','varchar');
		$this->captura('id_tramite_detalle','int4');
		$this->captura('fecha_informe','date');
		$this->captura('estado_reg','varchar');
		$this->captura('observacion','varchar');
		$this->captura('path_pdf','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('funcionarioa','text');
		$this->captura('funcionario','text');
		$this->captura('funcionariovia','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarInforme(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_informe_ime';
		$this->transaccion='SISTRA_INFOR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario_a','id_funcionario_a','int4');
		$this->setParametro('conclusion','conclusion','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_funcionario_via','id_funcionario_via','int4');
		$this->setParametro('referencia','referencia','varchar');
		$this->setParametro('num_informe','num_informe','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('fecha_informe','fecha_informe','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('observacion','observacion','varchar');
		$this->setParametro('path_pdf','path_pdf','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarInforme(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_informe_ime';
		$this->transaccion='SISTRA_INFOR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_informe','id_informe','int4');
		$this->setParametro('id_funcionario_a','id_funcionario_a','int4');
		$this->setParametro('conclusion','conclusion','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_funcionario_via','id_funcionario_via','int4');
		$this->setParametro('referencia','referencia','varchar');
		$this->setParametro('num_informe','num_informe','varchar');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('fecha_informe','fecha_informe','date');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('observacion','observacion','varchar');
		$this->setParametro('path_pdf','path_pdf','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarInforme(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_informe_ime';
		$this->transaccion='SISTRA_INFOR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_informe','id_informe','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>