<?php
/**
*@package pXP
*@file gen-Tramite.php
*@author  (admin)
*@date 26-03-2025 01:17:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Tramite=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Tramite.superclass.constructor.call(this,config);
		this.init();
   
   console.log("load::", this);
   
		this.load({params:{start:0, limit:this.tam_pag}});

		this.addButton('tramitePersona', {
                argument: {imprimir: 'Registro Personas'},
                text: ' Registro Personas', /*iconCls:'' ,*/
                iconCls: 'task',
				disabled: false,
                handler: this.tramitePersona
            });
		
		this.addButton('imprimirFor', {
				text: 'Imprimir Formulario',
				iconCls: 'bavion',
				disabled: false,
				handler: this.BFormularioSolicitud,
				tooltip: '<b>Imprimir Formulario</b><br/>Impresión del formulario'
			});	

		this.addButton('Derivar', {
				text : 'Derivar',
				iconCls : 'badelante',
				disabled : false,
				handler : this.BDerivar,
				tooltip : '<b>Derivar</b><br/>Deriva al funcionario asignado'
			});
			 console.log(config);
		
		/*this.addButton('imprimirRes', {
				text: 'Imprimir Resolucion',
				iconCls: 'bprint',
				disabled: false,
				handler: this.BResolucion,
				tooltip: '<b>Imprimir Resolucion</b><br/>Impresión de Resolución'
			});	
*/
	},
			
	Atributos:[
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
				name: 'cite_tramite',
				fieldLabel: 'Nro Tramite',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'trami.cite_tramite',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'num_resolucion',
				fieldLabel: 'Nro Resolución',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'trami.num_resolucion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'id_tipo_tramite',
				fieldLabel: 'Tipo Tramite',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_tramites/control/TipoTramite/listarTipoTramite',
					id: 'id_tipo_tramite',
					root: 'datos',
					sortInfo: {
						field: 'nombre_tramite',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_tramite', 'nombre_tramite', 'codigo_tramite'],
					remoteSort: true,
					baseParams: {par_filtro: 'tiptra.nombre_tramite#tiptra.codigo_tramite'}
				}),
				valueField: 'id_tipo_tramite',
				displayField: 'nombre_tramite',
				gdisplayField: 'nombre_tramite',
				hiddenName: 'id_tipo_tramite',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 300,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['nombre_tramite']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'tiptra.nombre_tramite',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'ubicacion',
				fieldLabel: 'Inmueble Situado en',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'trami.ubicacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fojas',
				fieldLabel: 'Fojas',
				allowBlank: false,
				anchor: '80%',
				gwidth: 90,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'trami.fojas',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'id_documento',
				fieldLabel: 'id_documento',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_/control/Clase/Metodo',
					id: 'id_',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'movtip.nombre#movtip.codigo'}
				}),
				valueField: 'id_',
				displayField: 'nombre',
				gdisplayField: 'desc_',
				hiddenName: 'id_documento',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'movtip.nombre',type: 'string'},
			grid: false,
			form: false
		},
		
		{
			config:{
				name: 'estado_tramite',
				fieldLabel: 'Estado Tramite',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'trami.estado_tramite',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config: {
				name: 'id_funcionario',
				fieldLabel: 'Funcionario Asignado',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_organigrama/control/Funcionario/listarFuncionario',
					id: 'id_funcionario',
					root: 'datos',
					sortInfo: {
						field: 'PERSON.nombre_completo2',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_funcionario', 'desc_person', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'PERSON.nombre_completo2'}
				}),
				valueField: 'id_funcionario',
				displayField: 'desc_person',
				gdisplayField: 'desc_funcionario1',
				hiddenName: 'id_funcionario',
				forceSelection: false,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 250,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_funcionario1']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'PERSON.nombre_completo2',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'trami.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'observacion',
				fieldLabel: 'Observación',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'trami.observacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_resolucion',
				fieldLabel: 'Fecha Resolución',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'trami.fecha_resolucion',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'trami.fecha_reg',type:'date'},
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
				filters:{pfiltro:'trami.usuario_ai',type:'string'},
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
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'trami.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'trami.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Tramites',
	ActSave:'../../sis_tramites/control/Tramite/insertarTramite',
	ActDel:'../../sis_tramites/control/Tramite/eliminarTramite',
	ActList:'../../sis_tramites/control/Tramite/listarTramite',
	id_store:'id_tramite',
	fields: [
		{name:'id_tramite', type: 'numeric'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_documento', type: 'numeric'},
		{name:'cite_tramite', type: 'string'},
		{name:'estado_tramite', type: 'string'},
		{name:'id_tipo_tramite', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_tramite', type: 'string'},
		{name:'desc_funcionario1', type: 'string'},
		{name:'ubicacion', type: 'string'},
		{name:'fojas', type: 'numeric'},
		{name:'num_resolucion', type: 'numeric'},
		{name:'fecha_resolucion', type: 'date',dateFormat:'Y-m-d'},
		{name:'observacion', type: 'string'},
	],
	sortInfo:{
		field: 'id_tramite',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	south:{
		url:'../../../sis_tramites/vista/tramite_detalle/TramiteDetalle.php',
        title:'Detalle Tramite',
        height:'50%',
        cls:'TramiteDetalle'
   		},
	/*tabsouth:[{
        url:'../../../sis_tramites/vista/tramite_detalle/TramiteDetalle.php',
        title:'Detalle Tramite',
        height:'50%',
        cls:'TramiteDetalle'
   		},{
		url:'../../../sis_tramites/vista/lote/Lote.php',
        title:'Lotes',
        height:'50%',
        cls:'Lote'
		},{
		url:'../../../sis_tramites/vista/matricula/Matricula.php',
        title:'Matricula-Testimonio',
        height:'50%',
        cls:'Matricula'
		},{
		url:'../../../sis_tramites/vista/trmta/Trmta.php',
        title:'R.M.T.A.',
        height:'50%',
        cls:'Trmta'
		},{
		url:'../../../sis_tramites/vista/boleta/Boleta.php',
        title:'Boleta Pago',
        height:'50%',
        cls:'Boleta'
		}
	],*/

   preparaMenu:function(n){
      	Phx.vista.Tramite.superclass.preparaMenu.call(this,n);
      	  var data = this.getSelectedData();
		  var tb =this.tbar;
        console.log(data);

		    //if(data.estado_tramite=='Inicio' || data.estado_tramite=='RECEPCION' ){
    /*if(data.id_usuario_mod==57 || data.id_usuario_reg==57 ){
				this.getBoton('edit').enable();
			  	this.getBoton('del').enable();
			  	this.getBoton('new').enable();
			  	this.getBoton('save').enable();
			  	this.getBoton('Derivar').enable();
          this.getBoton('imprimirFor').enable();                                  
          this.getBoton('tramitePersona').enable();
		  } else {		
			  		this.getBoton('edit').disable();
			  		this.getBoton('del').disable();
			  		this.getBoton('new').disable();
			  		this.getBoton('save').disable();
			  		this.getBoton('Derivar').disable();
		  	    this.getBoton('imprimirFor').disable();
            this.getBoton('tramitePersona').disable();
		  };
        
    if(data.estado_tramite=='ABOGADO'  ){ 
				
          this.getBoton('tramitePersona').enable();                                  
		  } 
      */
		  	
		  return tb
		
	},

BDerivar : function() {

var rec = this.sm.getSelected();
var id_tramite = this.sm.getSelected().data.id_tramite;
var id_funcionario = this.sm.getSelected().data.id_funcionario;
if (confirm('Esta seguro de DERIVAR el tramite?')){
 Phx.CP.loadingShow();
Ext.Ajax.request({
	url : '../../sis_tramites/control/Tramite/derivarTramite',
	params : {
		id_tramite : id_tramite,
		id_funcionario  : id_funcionario
		/*id_correspondencia : id_correspondencia,
		id_origen          : this.maestro.id_origen*/
		},
		success : this.successDerivar,
		failure : this.conexionFailure,
		timeout : this.timeout,
		scope : this
		});
		}
	},
successDerivar : function(resp) {

	Phx.CP.loadingHide();
	var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
	if (!reg.ROOT.error) {
		alert(reg.ROOT.detalle.mensaje)
	}
	this.reload();

	},

	tramitePersona: function () {
		var rec = this.getSelectedData();
		this.getComponente('id_tramite').setValue(rec.id_tramite);
		//enviamos el id seleccionado para cual el archivo se deba subir
		/*rec.datos_extras_id = rec.id_tramite_detalle;
		rec.datos_extras_id = rec.id_tramite;
		//enviamos el nombre de la tabla
		rec.datos_extras_tabla = 'tdato_tecnico';
		//enviamos el codigo ya que una tabla puede tener varios archivos diferentes como ci,pasaporte,contrato,slider,fotos,etc
		rec.datos_extras_codigo = 'dato tecnico';*/

		//esto es cuando queremos darle una ruta personalizada
		//rec.datos_extras_ruta_personalizada = './../../../uploaded_files/favioVideos/videos/';
			console.log(rec.id_tramite);
		Phx.CP.loadWindows('../../../sis_tramites/vista/tramite_persona/TramitePersona.php',
			'TramitePersona',
			{
				width: 900,
				height: 400
			}, rec, this.idContenedor, 'TramitePersona');

	},

	BFormularioSolicitud:function () {
			var rec = this.sm.getSelected();
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				url: '../../sis_tramites/control/Tramite/formularioSolicitud',
				params: {
					id_tramite: rec.data.id_tramite,
					id_usuario_reg: rec.data.id_usuario_reg
				},
				success: this.successExport,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});
	
		},
/*
		BResolucion:function () {
			var rec = this.sm.getSelected();
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				url: '../../sis_tramites/control/ReporteResolucion/emitirResolucion',
				params: {
					id_tramite: rec.data.id_tramite,
					id_usuario_reg: rec.data.id_usuario_reg
				},
				success: this.successExport,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});
	
		},*/

		onButtonNew: function () {
        
		//console.log(Phx.CP.config_ini.id_funcionario)
		Phx.vista.Tramite.superclass.onButtonNew.call(this);
		this.getComponente('fecha_resolucion').setVisible(false);
		this.getComponente('num_resolucion').setVisible(false);
		this.getComponente('observacion').setValue('El lugar debe estar limpio y estaqueado');
		this.getComponente('ubicacion').setValue('COLCAPIRHUA');
    
    	},
		onButtonEdit: function () {
        
		//console.log(Phx.CP.config_ini.id_funcionario)
		Phx.vista.Tramite.superclass.onButtonEdit.call(this);
		this.getComponente('fecha_resolucion').setVisible(true);
		this.getComponente('num_resolucion').setVisible(true);
    
    	},
	}
)
</script>
		
		