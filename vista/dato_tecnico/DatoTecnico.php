<?php
/**
*@package pXP
*@file gen-DatoTecnico.php
*@author  (admin)
*@date 26-03-2025 01:17:12
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.DatoTecnico=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.DatoTecnico.superclass.constructor.call(this,config);
		console.log("id:" + this.id_tramite);
		this.init();
		this.getComponente('id_tramite').setValue(this.id_tramite);
		this.store.baseParams = {id_tramite: this.id_tramite};
		this.load({params:{start:0, limit:this.tam_pag}})
		this.iniciarEventos();
		
	},
    register:'',
    tipo: '',
    fheight: '95%',
    fwidth: '95%',
    Grupos: [
        {
            layout: 'column',
            border: false,
            defaults: {
                border: true
            },
            items: [{
                bodyStyle: 'padding-right:5px;',
                items: [{
                    xtype: 'fieldset',
                    columnWidth: 1.0,
                    title: 'Ubicación',
                    autoHeight: true,
                    defaults: {
                          anchor: '-20' // leave room for error icon
                      },
                    items: [],
                    id_grupo:0
                }]
            }, {
                bodyStyle: 'padding-left:5px;',
                items: [{
                    xtype: 'fieldset',
                    columnWidth: 1.0,
                    defaults: {
                          anchor: '10' // leave room for error icon
                      },
                    title: 'Colindantes',
                    autoHeight: false,
                    items: [],
                    id_grupo:1
                }]
            },{
                bodyStyle: 'padding-left:5px;',
                items: [{
                    xtype: 'fieldset',
                    defaults: {
                          anchor: '-20' // leave room for error icon
                      },
                    title: 'Superficies',
                    autoHeight: true,
                    items: [],
                    id_grupo:2
                }]
            },{
                bodyStyle: 'padding-left:5px;',
                items: [{
                    xtype: 'fieldset',
                    defaults: {
                          anchor: '-30' // leave room for error icon
                      },
                    title: 'Servicio Básico',
                    autoHeight: true,
                    items: [],
                    id_grupo:3
                }]
            }]
        }
    ],
    Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_dato_tecnico'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_tramite'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'super_escritura',
				fieldLabel: 'Superficie Escritura',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'NumberField',
				filters:{pfiltro:'dattec.super_escritura',type:'numeric'},
				id_grupo:2,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'tipo_calle',
				fieldLabel: 'Tipo Calle',
				allowBlank: false,
				anchor: '80%',
				origen: 'CATALOGO',
					gdisplayField: 'tipo_calle',
					gwidth: 100,
					baseParams:{
						cod_subsistema:'SISTRA',
						catalogo_tipo:'tdato_tecnico_tipo_calle'
					},
					renderer:function (value, p, record){return String.format('{0}', record.data['tipo_calle']);}
	       		},
	       		type:'ComboRec',
				filters:{pfiltro:'dattec.tipo_calle',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'super_mensura',
				fieldLabel: 'Superficie Mensura',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'NumberField',
				filters:{pfiltro:'dattec.super_mensura',type:'numeric'},
				id_grupo:2,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'avenida',
				fieldLabel: 'Avenida',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'dattec.avenida',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'calle',
				fieldLabel: 'Calle',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'dattec.calle',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'alcantarillado',
				fieldLabel: 'Alcantarillado',
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
            filters:{   pfiltro:'dattec.alcantarillado',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',        
				grid:true,
				form:true
		},
		{
			config:{
				name: 'telefonia',
				fieldLabel: 'telefonia',
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
            filters:{   pfiltro:'dattec.telefonia',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',  
				grid:true,
				form:true
		},
		{
			config:{
				name: 'alumbrado_publico',
				fieldLabel: 'Alumbrado Publico',
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
            filters:{   pfiltro:'dattec.alumbrado_publico',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'lote',
				fieldLabel: 'Lote',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.lote',type:'string'},
				id_grupo:2,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'colindante_oeste',
				fieldLabel: 'Colindante Oeste',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.colindante_oeste',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		
		{
			config:{
				name: 'super_total',
				fieldLabel: 'Superficie Total',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'NumberField',
				filters:{pfiltro:'dattec.super_total',type:'numeric'},
				id_grupo:2,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'transporte',
				fieldLabel: 'Transporte',
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
            filters:{   pfiltro:'dattec.transporte',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'colindante_sur',
				fieldLabel: 'Colindante Sur',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.colindante_sur',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'long_rasante',
				fieldLabel: 'Longitud Rasante',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'NumberField',
				filters:{pfiltro:'dattec.long_rasante',type:'numeric'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'vias',
				fieldLabel: 'Vias',
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
            filters:{   pfiltro:'dattec.vias',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'agua_potable',
				fieldLabel: 'Agua Potable',
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
            filters:{   pfiltro:'dattec.agua_potable',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'colindante_este',
				fieldLabel: 'Colindante Este',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.colindante_este',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'manzana',
				fieldLabel: 'Manzano',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.manzana',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'distrito',
				fieldLabel: 'Distrito',
				allowBlank: false,
				anchor: '80%',
				origen: 'CATALOGO',
					gdisplayField: 'distrito',
					gwidth: 100,
					baseParams:{
						cod_subsistema:'SISTRA',
						catalogo_tipo:'tdato_tecnico_distrito'
					},
					renderer:function (value, p, record){return String.format('{0}', record.data['distrito']);}
	       		},
	       		type:'ComboRec',
				filters:{pfiltro:'dattec.distrito',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'colindante_norte',
				fieldLabel: 'Colindante Norte',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.colindante_norte',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'zona',
				fieldLabel: 'Zona',
				allowBlank: false,
				anchor: '80%',
				origen: 'CATALOGO',
					gdisplayField: 'zona',
					gwidth: 100,
					baseParams:{
						cod_subsistema:'SISTRA',
						catalogo_tipo:'tdato_tecnico_zona'
					},
					renderer:function (value, p, record){return String.format('{0}', record.data['zona']);}
	       		},
	       		type:'ComboRec',
				filters:{pfiltro:'dattec.zona',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'equipamiento',
				fieldLabel: 'Equipamiento',
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
            filters:{   pfiltro:'dattec.equipamiento',
                        type: 'list',
                         options: ['si','no']  
                    },
            valorInicial: 'si',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'rasante_municipal',
				fieldLabel: 'Rasante Municipal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'dattec.rasante_municipal',type:'string'},
				id_grupo:0,
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
				filters:{pfiltro:'dattec.estado_reg',type:'string'},
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
				filters:{pfiltro:'dattec.usuario_ai',type:'string'},
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
				filters:{pfiltro:'dattec.fecha_reg',type:'date'},
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
				filters:{pfiltro:'dattec.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'dattec.fecha_mod',type:'date'},
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
	title:'Datos Tecnicos',
	ActSave:'../../sis_tramites/control/DatoTecnico/insertarDatoTecnico',
	ActDel:'../../sis_tramites/control/DatoTecnico/eliminarDatoTecnico',
	ActList:'../../sis_tramites/control/DatoTecnico/listarDatoTecnico',
	id_store:'id_dato_tecnico',
	fields: [
		{name:'id_dato_tecnico', type: 'numeric'},
		{name:'super_escritura', type: 'numeric'},
		{name:'tipo_calle', type: 'string'},
		{name:'super_mensura', type: 'numeric'},
		{name:'id_tramite', type: 'numeric'},
		{name:'avenida', type: 'string'},
		{name:'alcantarillado', type: 'string'},
		{name:'telefonia', type: 'string'},
		{name:'alumbrado_publico', type: 'string'},
		{name:'lote', type: 'string'},
		{name:'colindante_oeste', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'calle', type: 'string'},
		{name:'super_total', type: 'numeric'},
		{name:'transporte', type: 'string'},
		{name:'colindante_sur', type: 'string'},
		{name:'long_rasante', type: 'numeric'},
		{name:'vias', type: 'string'},
		{name:'agua_potable', type: 'string'},
		{name:'colindante_este', type: 'string'},
		{name:'manzana', type: 'string'},
		{name:'distrito', type: 'string'},
		{name:'colindante_norte', type: 'string'},
		{name:'zona', type: 'string'},
		{name:'equipamiento', type: 'string'},
		{name:'rasante_municipal', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_dato_tecnico',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	preparaMenu: function (tb) {
        // llamada funcion clace padre
        Phx.vista.DatoTecnico.superclass.preparaMenu.call(this, tb)
		
		var data = this.getSelectedData();
		  var tb =this.tbar;
		  return tb
    },
	onButtonNew: function () {
        Phx.vista.DatoTecnico.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite').setValue(this.id_tramite);
        this.mostrarGrupo(0);
        this.mostrarGrupo(1);
        this.mostrarGrupo(2);
        this.mostrarGrupo(3);
		console.log(this.id_tramite);
    },
	onReloadPage: function (m) {
        this.maestro = m;
        console.log(m);

        this.store.baseParams = {id_tramite: this.id_tramite};


        this.load({params: {start: 0, limit: 50}})
    },
	}
)
</script>
		
		