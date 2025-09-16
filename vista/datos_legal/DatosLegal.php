<?php
/**
*@package pXP
*@file DatosLegal.php
*@author  (admin)
*@date 15-09-2025 18:37:32
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.DatosLegal=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.DatosLegal.superclass.constructor.call(this,config);
		this.init();
		this.getComponente('id_tramite_detalle').setValue(this.id_tramite_detalle);
		this.store.baseParams = {id_tramite_detalle: this.id_tramite_detalle};
		this.load({params:{start:0, limit:this.tam_pag}})
		this.iniciarEventos();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_datos_legal'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_tramite_detalle'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'aprobacion',
				fieldLabel: 'Aprobación',
				allowBlank: false,
                anchor: '40%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: ['si','no']
            },
            type:'ComboBox',
            id_grupo:3,
            filters:{   pfiltro:'datleg.aprobacion',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'aux',
				fieldLabel: 'aux',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'datleg.aux',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
		},
		
	
		{
			config:{
				name: 'area_agro',
				fieldLabel: 'Area Agropecuaria',
				allowBlank: false,
                anchor: '40%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: ['si','no']
            },
            type:'ComboBox',
            id_grupo:3,
            filters:{   pfiltro:'datleg.area_agro',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cod_catastral',
				fieldLabel: 'Código Catastral',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'datleg.cod_catastral',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'kami',
				fieldLabel: 'Kami?',
				allowBlank: false,
                anchor: '40%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: ['si','no']
            },
            type:'ComboBox',
            id_grupo:3,
            filters:{   pfiltro:'datleg.kami',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ddrr_registro',
				fieldLabel: 'Registro DDRR',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'datleg.ddrr_registro',type:'string'},
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
				filters:{pfiltro:'datleg.estado_reg',type:'string'},
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'datleg.usuario_ai',type:'string'},
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
				filters:{pfiltro:'datleg.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'datleg.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'datleg.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
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
		}
	],
	tam_pag:50,	
	title:'Datos Legal',
	ActSave:'../../sis_tramites/control/DatosLegal/insertarDatosLegal',
	ActDel:'../../sis_tramites/control/DatosLegal/eliminarDatosLegal',
	ActList:'../../sis_tramites/control/DatosLegal/listarDatosLegal',
	id_store:'id_datos_legal',
	fields: [
		{name:'id_datos_legal', type: 'numeric'},
		{name:'aprobacion', type: 'string'},
		{name:'aux', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'area_agro', type: 'string'},
		{name:'cod_catastral', type: 'string'},
		{name:'kami', type: 'string'},
		{name:'ddrr_registro', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'id_tramite_detalle', type: 'numeric'},
	],
	sortInfo:{
		field: 'id_datos_legal',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	preparaMenu: function (tb) {
        // llamada funcion clace padre
        Phx.vista.DatosLegal.superclass.preparaMenu.call(this, tb)
		
		var data = this.getSelectedData();
		  var tb =this.tbar;
		  return tb
    },
	onButtonNew: function () {
        Phx.vista.DatosLegal.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite_detalle').setValue(this.id_tramite_detalle);
        this.mostrarGrupo(0);
        this.mostrarGrupo(1);
        this.mostrarGrupo(2);
        this.mostrarGrupo(3);
		console.log(this.id_tramite_detalle);
    },
	onReloadPage: function (m) {
        this.maestro = m;
        console.log(m);

        this.store.baseParams = {id_tramite_detalle: this.id_tramite_detalle};


        this.load({params: {start: 0, limit: 50}})
    },
	}
)
</script>
		
		