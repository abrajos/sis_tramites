<?php
/**
*@package pXP
*@file gen-MODTramite.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTramite extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTramite(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_tramite_sel';
		$this->transaccion='SISTRA_trami_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_tramite','int4');
		$this->captura('id_funcionario','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_documento','int4');
		$this->captura('cite_tramite','varchar');
		$this->captura('estado_tramite','varchar');
		$this->captura('id_tipo_tramite','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_tramite','varchar');
		$this->captura('desc_funcionario1','text');
		$this->captura('ubicacion','varchar');
		$this->captura('fojas','int4');
		$this->captura('num_resolucion','int4');
		$this->captura('fecha_resolucion','date');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_ime';
		$this->transaccion='SISTRA_trami_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_documento','id_documento','int4');
		$this->setParametro('cite_tramite','cite_tramite','varchar');
		$this->setParametro('estado_tramite','estado_tramite','varchar');
		$this->setParametro('id_tipo_tramite','id_tipo_tramite','int4');
		$this->setParametro('ubicacion','ubicacion','varchar');
		$this->setParametro('fojas','fojas','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_ime';
		$this->transaccion='SISTRA_trami_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_documento','id_documento','int4');
		$this->setParametro('cite_tramite','cite_tramite','varchar');
		$this->setParametro('estado_tramite','estado_tramite','varchar');
		$this->setParametro('id_tipo_tramite','id_tipo_tramite','int4');
		$this->setParametro('ubicacion','ubicacion','varchar');
		$this->setParametro('fojas','fojas','int4');
		$this->setParametro('num_resolucion','num_resolucion','int4');
		$this->setParametro('fecha_resolucion','fecha_resolucion','date');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTramite(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_ime';
		$this->transaccion='SISTRA_trami_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function derivarTramite()
	{
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_tramite_ime';
		$this->transaccion='TR_DERTRA_UPD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_tramite','id_tramite','int4');
        $this->setParametro('id_funcionario','id_funcionario','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
		
		
	}
}
?>