<?php
/**
*@package pXP
*@file gen-Correlativo.php
*@author  (admin)
*@date 26-08-2025 21:14:57
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Correlativo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Correlativo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_correlativo'
			},
			type:'Field',
			form:true 
		},
		
		{
			config:{
				name: 'sigla',
				fieldLabel: 'Sigla',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'correl.sigla',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'tipo',
				fieldLabel: 'Tipo',
				allowBlank: false,
                anchor: '60%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: ['mensual','gestion']
            },
            type:'ComboBox',
            id_grupo:1,
            filters:{   pfiltro:'correl.tipo',
                        type: 'list',
                         options: ['mensual','gestion']
                    },
            valorInicial: 'mensual',        
				grid:true,
				form:true
		},
		
		{
	       		config:{
	       			fieldLabel: "Cargo",
	       			gwidth: 100,
	       			name: 'cargo',
	       			allowBlank:false,	
	       			anchor:'100%',
					origen: 'CATALOGO',
					gdisplayField: 'cargo',
					gwidth: 100,
					baseParams:{
						cod_subsistema:'ORGA',
						catalogo_tipo:'tfuncionario_cargo'
					},
					renderer:function (value, p, record){return String.format('{0}', record.data['cargo']);}
	       		},
	       		type:'ComboRec',
	       		filters:{pfiltro:'correl.cargo',type:'string'},
	       		id_grupo:1,
	       		grid:true,
	       		form:true
	    },
		{
			config:{
				name: 'num_actual',
				fieldLabel: 'Numero Actual',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'correl.num_actual',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'num_siguiente',
				fieldLabel: 'Numero Siguiente',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'correl.num_siguiente',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'correl.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'correl.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'correl.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'correl.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'correl.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Correlativo',
	ActSave:'../../sis_tramites/control/Correlativo/insertarCorrelativo',
	ActDel:'../../sis_tramites/control/Correlativo/eliminarCorrelativo',
	ActList:'../../sis_tramites/control/Correlativo/listarCorrelativo',
	id_store:'id_correlativo',
	fields: [
		{name:'id_correlativo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'sigla', type: 'string'},
		{name:'tipo', type: 'string'},
		{name:'cargo', type: 'string'},
		{name:'num_siguiente', type: 'numeric'},
		{name:'num_actual', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_correlativo',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		