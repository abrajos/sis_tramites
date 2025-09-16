<?php
/**
*@package pXP
*@file gen-MODTramiteDetalle.php
*@author  (admin)
*@date 26-03-2025 01:17:21
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTramiteDetalle extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTramiteDetalle(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_tramite_detalle_sel';
		$this->transaccion='SISTRA_tradet_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tramite_detalle','int4');
		$this->captura('id_tramite','int4');
		$this->captura('referencia_informe','varchar');
		$this->captura('estado_tramite','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('id_documento','int4');
		$this->captura('num_informe','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_funcionario1','text');
		$this->captura('cite_tramite','varchar');
		$this->captura('id_funcionario_deriv','int4');
		$this->captura('funcio_deriv','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarTramiteDetalle(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_detalle_ime';
		$this->transaccion='SISTRA_tradet_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('referencia_informe','referencia_informe','varchar');
		$this->setParametro('estado_tramite','estado_tramite','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_documento','id_documento','int4');
		$this->setParametro('num_informe','num_informe','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTramiteDetalle(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_detalle_ime';
		$this->transaccion='SISTRA_tradet_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('referencia_informe','referencia_informe','varchar');
		$this->setParametro('estado_tramite','estado_tramite','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('id_documento','id_documento','int4');
		$this->setParametro('num_informe','num_informe','varchar');
		$this->setParametro('id_funcionario_deriv','id_funcionario_deriv','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTramiteDetalle(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_detalle_ime';
		$this->transaccion='SISTRA_tradet_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
		
	function derivarTramiteDetalle()
	{
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_detalle_ime';
		$this->transaccion='TR_DETRDE_UPD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
        $this->setParametro('id_funcionario_deriv','id_funcionario_deriv','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
		
		
	}
}
?>