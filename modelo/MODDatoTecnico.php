<?php
/**
*@package pXP
*@file gen-MODDatoTecnico.php
*@author  (admin)
*@date 26-03-2025 01:17:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDatoTecnico extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarDatoTecnico(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sistra.ft_dato_tecnico_sel';
		$this->transaccion='SISTRA_dattec_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_dato_tecnico','int4');
		$this->captura('super_escritura','numeric');
		$this->captura('tipo_calle','varchar');
		$this->captura('super_mensura','numeric');
		$this->captura('id_tramite_detalle','int4');
		$this->captura('avenida','varchar');
		$this->captura('alcantarillado','varchar');
		$this->captura('telefonia','varchar');
		$this->captura('alumbrado_publico','varchar');
		$this->captura('lote','varchar');
		$this->captura('colindante_oeste','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('calle','varchar');
		$this->captura('super_total','numeric');
		$this->captura('transporte','varchar');
		$this->captura('colindante_sur','varchar');
		$this->captura('long_rasante','numeric');
		$this->captura('vias','varchar');
		$this->captura('agua_potable','varchar');
		$this->captura('colindante_este','varchar');
		$this->captura('manzana','varchar');
		$this->captura('distrito','varchar');
		$this->captura('colindante_norte','varchar');
		$this->captura('zona','varchar');
		$this->captura('equipamiento','varchar');
		$this->captura('rasante_municipal','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('super_excedente','numeric');
		$this->captura('super_inexistente','numeric');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDatoTecnico(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_dato_tecnico_ime';
		$this->transaccion='SISTRA_dattec_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('super_escritura','super_escritura','numeric');
		$this->setParametro('tipo_calle','tipo_calle','varchar');
		$this->setParametro('super_mensura','super_mensura','numeric');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('avenida','avenida','varchar');
		$this->setParametro('alcantarillado','alcantarillado','varchar');
		$this->setParametro('telefonia','telefonia','varchar');
		$this->setParametro('alumbrado_publico','alumbrado_publico','varchar');
		$this->setParametro('lote','lote','varchar');
		$this->setParametro('colindante_oeste','colindante_oeste','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('calle','calle','varchar');
		$this->setParametro('super_total','super_total','numeric');
		$this->setParametro('transporte','transporte','varchar');
		$this->setParametro('colindante_sur','colindante_sur','varchar');
		$this->setParametro('long_rasante','long_rasante','numeric');
		$this->setParametro('vias','vias','varchar');
		$this->setParametro('agua_potable','agua_potable','varchar');
		$this->setParametro('colindante_este','colindante_este','varchar');
		$this->setParametro('manzana','manzana','varchar');
		$this->setParametro('distrito','distrito','varchar');
		$this->setParametro('colindante_norte','colindante_norte','varchar');
		$this->setParametro('zona','zona','varchar');
		$this->setParametro('equipamiento','equipamiento','varchar');
		$this->setParametro('rasante_municipal','rasante_municipal','varchar');
		$this->setParametro('super_excedente','super_excedente','numeric');
		$this->setParametro('super_inexistente','super_inexistente','numeric');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarDatoTecnico(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_dato_tecnico_ime';
		$this->transaccion='SISTRA_dattec_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_dato_tecnico','id_dato_tecnico','int4');
		$this->setParametro('super_escritura','super_escritura','numeric');
		$this->setParametro('tipo_calle','tipo_calle','varchar');
		$this->setParametro('super_mensura','super_mensura','numeric');
		$this->setParametro('id_tramite_detalle','id_tramite_detalle','int4');
		$this->setParametro('avenida','avenida','varchar');
		$this->setParametro('alcantarillado','alcantarillado','varchar');
		$this->setParametro('telefonia','telefonia','varchar');
		$this->setParametro('alumbrado_publico','alumbrado_publico','varchar');
		$this->setParametro('lote','lote','varchar');
		$this->setParametro('colindante_oeste','colindante_oeste','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('calle','calle','varchar');
		$this->setParametro('super_total','super_total','numeric');
		$this->setParametro('transporte','transporte','varchar');
		$this->setParametro('colindante_sur','colindante_sur','varchar');
		$this->setParametro('long_rasante','long_rasante','numeric');
		$this->setParametro('vias','vias','varchar');
		$this->setParametro('agua_potable','agua_potable','varchar');
		$this->setParametro('colindante_este','colindante_este','varchar');
		$this->setParametro('manzana','manzana','varchar');
		$this->setParametro('distrito','distrito','varchar');
		$this->setParametro('colindante_norte','colindante_norte','varchar');
		$this->setParametro('zona','zona','varchar');
		$this->setParametro('equipamiento','equipamiento','varchar');
		$this->setParametro('rasante_municipal','rasante_municipal','varchar');
		$this->setParametro('super_excedente','super_excedente','numeric');
		$this->setParametro('super_inexistente','super_inexistente','numeric');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDatoTecnico(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sistra.ft_dato_tecnico_ime';
		$this->transaccion='SISTRA_dattec_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_dato_tecnico','id_dato_tecnico','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>