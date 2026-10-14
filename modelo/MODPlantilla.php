<?php
/**
*@package pXP
*@file gen-MODPlantilla.php
*@author  (admin)
*@date 25-09-2026 20:16:21
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPlantilla extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPlantilla(){
		$this->procedimiento='sistra.ft_plantilla_sel';
		$this->transaccion='SISTRA_planti_SEL';
		$this->tipo_procedimiento='SEL';
				
		$this->captura('id_plantilla','int4');
		$this->captura('nombre','varchar');
		$this->captura('auxiliar','varchar');
		$this->captura('parrafos','text'); // Se mantiene text para recibir el contenido HTML de la BD
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->armarConsulta();
		$this->ejecutarConsulta();
		return $this->respuesta;
	}
			
	function insertarPlantilla(){
		$this->procedimiento='sistra.ft_plantilla_ime';
		$this->transaccion='SISTRA_planti_INS';
		$this->tipo_procedimiento='IME';
				
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('auxiliar','auxiliar','varchar');
		$this->setParametro('parrafos','parrafos','codigo_html'); // <-- CAMBIADO A codigo_html para permitir etiquetas HTML
		$this->setParametro('estado_reg','estado_reg','varchar');

		$this->armarConsulta();
		$this->ejecutarConsulta();
		return $this->respuesta;
	}
			
	function modificarPlantilla(){
		$this->procedimiento='sistra.ft_plantilla_ime';
		$this->transaccion='SISTRA_planti_MOD';
		$this->tipo_procedimiento='IME';
				
		$this->setParametro('id_plantilla','id_plantilla','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('auxiliar','auxiliar','varchar');
		$this->setParametro('parrafos','parrafos','codigo_html'); // <-- CAMBIADO A codigo_html para permitir etiquetas HTML
		$this->setParametro('estado_reg','estado_reg','varchar');

		$this->armarConsulta();
		$this->ejecutarConsulta();
		return $this->respuesta;
	}
			
	function eliminarPlantilla(){
		$this->procedimiento='sistra.ft_plantilla_ime';
		$this->transaccion='SISTRA_planti_ELI';
		$this->tipo_procedimiento='IME';
				
		$this->setParametro('id_plantilla','id_plantilla','int4');

		$this->armarConsulta();
		$this->ejecutarConsulta();
		return $this->respuesta;
	}
}
?>