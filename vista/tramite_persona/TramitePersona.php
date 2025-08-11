<?php
/**
*@package pXP
*@file gen-TramitePersona.php
*@author  (admin)
*@date 01-04-2025 15:44:33
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.TramitePersona=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.TramitePersona.superclass.constructor.call(this,config);
		this.init();
		this.getComponente('id_tramite').setValue(config.id_tramite);
		this.store.baseParams = {id_tramite: config.id_tramite};
		this.load({params:{start:0, limit:this.tam_pag}})
		this.iniciarEventos();
		console.log("config:",config.id_tramite);
	},	
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_tramite_persona'
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
	       				name:'id_persona',
	       				fieldLabel:'Persona',
	       				allowBlank:false,
	       				emptyText:'Persona...',
	       				store: new Ext.data.JsonStore({

	    					url: '../../sis_seguridad/control/Persona/listarPersona',
	    					id: 'id_persona',
	    					root: 'datos',
	    					sortInfo:{
	    						field: 'nombre_completo1',
	    						direction: 'ASC'
	    					},
	    					totalProperty: 'total',
	    					fields: ['id_persona','nombre_completo1','ci'],
	    					// turn on remote sorting
	    					remoteSort: true,
	    					baseParams:{par_filtro:'p.nombre_completo1#p.ci'}
	    				}),
	       				valueField: 'id_persona',
	       				displayField: 'nombre_completo1',
	       				gdisplayField:'desc_person',//mapea al store del grid
	       				tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombre_completo1}</p><p>CI:{ci}</p> </div></tpl>',
	       				hiddenName: 'id_persona',
	       				forceSelection:true,
	       				typeAhead: true,
	           			triggerAction: 'all',
	           			lazyRender:true,
	       				mode:'remote',
	       				pageSize:10,
	       				queryDelay:1000,
	       				width:250,
	       				gwidth:280,
	       				minChars:2,
	       				turl:'../../../sis_seguridad/vista/persona/Persona.php',
	       			    ttitle:'Personas',
	       			   // tconfig:{width:1800,height:500},
	       			    tdata:{},
	       			    tcls:'persona',
	       			    pid:this.idContenedor,
	       			
	       				renderer:function (value, p, record){return String.format('{0}', record.data['desc_person']);}
	       			},
	       			type:'TrigguerCombo',
	       			bottom_filter:true,
	       			id_grupo:0,
	       			filters:{	
	       				        pfiltro:'nombre_completo1',
	       						type:'string'
	       					},
	       		   
	       			grid:true,
	       			form:true
	       	},
		{
			config:{
				name: 'tipo_persona',
				fieldLabel: 'tipo_persona',
				allowBlank: false,
                anchor: '40%',
                gwidth: 80,
                typeAhead: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                store: ['propietario','apoderado']
            },
            type:'ComboBox',
            id_grupo:1,
            filters:{   pfiltro:'dattec.tipo_persona',
                        type: 'list',
                         options: ['propietario','apoderado']  
                    },
            valorInicial: 'propietario',
				grid:true,
				form:true
		},
		{
			config:{
				name: 'domicilio',
				fieldLabel: 'Domicilio',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'traper.domicilio',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_poder',
				fieldLabel: 'Nro. Poder',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'traper.nro_poder',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_poder',
				fieldLabel: 'Fecha Poder',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10,
				gwidth: 100,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'traper.fecha_poder',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_notaria',
				fieldLabel: 'Numero Notaria',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'traper.nro_notaria',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'notario',
				fieldLabel: 'Nombre Notario',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'traper.notario',type:'string'},
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
				filters:{pfiltro:'traper.estado_reg',type:'string'},
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
				filters:{pfiltro:'traper.fecha_reg',type:'date'},
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
				filters:{pfiltro:'traper.usuario_ai',type:'string'},
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
				filters:{pfiltro:'traper.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'traper.fecha_mod',type:'date'},
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
	title:'Tramite Persona',
	ActSave:'../../sis_tramites/control/TramitePersona/insertarTramitePersona',
	ActDel:'../../sis_tramites/control/TramitePersona/eliminarTramitePersona',
	ActList:'../../sis_tramites/control/TramitePersona/listarTramitePersona',
	id_store:'id_tramite_persona',
	fields: [
		{name:'id_tramite_persona', type: 'numeric'},
		{name:'id_tramite', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'tipo_persona', type: 'string'},
		{name:'id_persona', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'domicilio', type: 'string'},
		{name:'nro_poder', type: 'string'},
		{name:'fecha_poder', type: 'date',dateFormat:'Y-m-d'},
		{name:'nro_notaria', type: 'numeric'},
		{name:'notario', type: 'string'},
		{name:'desc_person', type: 'string'},
	],
	sortInfo:{
		field: 'id_tramite_persona',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	preparaMenu: function (tb) {
        // llamada funcion clace padre
        Phx.vista.TramitePersona.superclass.preparaMenu.call(this, tb)
		
		var data = this.getSelectedData();
		  var tb =this.tbar;
		  return tb
    },
	onButtonNew: function () {
        Phx.vista.TramitePersona.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite').setValue(this.id_tramite);
		console.log("idTramite:: ",this.id_tramite);
    },
	onReloadPage: function (m) {
        this.maestro = m;
        console.log(m);

        this.store.baseParams = {id_tramite: this.maestro.id_tramite};


        this.load({params: {start: 0, limit: 50}})
    },
	}
)
</script>
		
		