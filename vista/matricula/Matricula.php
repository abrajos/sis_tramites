<?php
/**
*@package pXP
*@file gen-Matricula.php
*@author  (admin)
*@date 17-04-2025 00:18:08
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Matricula=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Matricula.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
		this.bloquearMenus();
        if(Phx.CP.getPagina(this.idContenedorPadre)){
         var dataMaestro=Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
         if(dataMaestro){ 
            this.onEnablePanel(this,dataMaestro)
            }
         }
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_matricula'
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
				name: 'superficie',
				fieldLabel: 'Superficie',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'NumberField',
				filters:{pfiltro:'matri.superficie',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'asiento',
				fieldLabel: 'Asiento',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'matri.asiento',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'decreto_registrador',
				fieldLabel: 'Decreto Registrador',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'matri.decreto_registrador',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_testimonio',
				fieldLabel: 'Fecha Testimonio',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'matri.fecha_testimonio',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_matricula',
				fieldLabel: 'Nro Matricula',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'matri.nro_matricula',type:'string'},
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
				filters:{pfiltro:'matri.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_asiento',
				fieldLabel: 'Fecha Asiento',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'matri.fecha_asiento',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nro_notario',
				fieldLabel: 'Nro Notario',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'matri.nro_notario',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_decreto',
				fieldLabel: 'Fecha Decreto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'matri.fecha_decreto',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre_notario',
				fieldLabel: 'Nombre Notario',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'matri.nombre_notario',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'nro_testimonio',
				fieldLabel: 'Nro Testimonio',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'matri.nro_testimonio',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'matri.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'matri.usuario_ai',type:'string'},
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
				filters:{pfiltro:'matri.fecha_reg',type:'date'},
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
				filters:{pfiltro:'matri.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Matricula Testimonio',
	ActSave:'../../sis_tramites/control/Matricula/insertarMatricula',
	ActDel:'../../sis_tramites/control/Matricula/eliminarMatricula',
	ActList:'../../sis_tramites/control/Matricula/listarMatricula',
	id_store:'id_matricula',
	fields: [
		{name:'id_matricula', type: 'numeric'},
		{name:'superficie', type: 'numeric'},
		{name:'asiento', type: 'string'},
		{name:'decreto_registrador', type: 'string'},
		{name:'fecha_testimonio', type: 'date',dateFormat:'Y-m-d'},
		{name:'nro_matricula', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_asiento', type: 'date',dateFormat:'Y-m-d'},
		{name:'nro_notario', type: 'string'},
		{name:'fecha_decreto', type: 'date',dateFormat:'Y-m-d'},
		{name:'nombre_notario', type: 'string'},
		{name:'id_tramite_detalle', type: 'numeric'},
		{name:'nro_testimonio', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_matricula',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	onButtonNew: function () {
        Phx.vista.Matricula.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite_detalle').setValue(this.maestro.id_tramite_detalle);
    },
    onReloadPage: function (m) {
        this.maestro = m;
        console.log(this.maestro);
        this.store.baseParams = {id_tramite_detalle: this.maestro.id_tramite_detalle};
        this.load({params: {start: 0, limit: 50}})
    },
	loadValoresIniciales:function(){
        Phx.vista.Matricula.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_tramite_detalle.setValue(this.maestro.id_tramite_detalle);
    },
	}
)
</script>
		
		