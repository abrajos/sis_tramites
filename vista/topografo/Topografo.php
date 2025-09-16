<?php
/**
*@package pXP
*@file Topografo.php
*@author  jmita
*@date 26-03-2025 01:17:21
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Topografo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Topografo.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
		//this.iniciarEventos();
		this.addButton('Derivar', {
				text : 'Derivar',
				iconCls : 'badelante',
				disabled : true,
				handler : this.BDerivar,
				tooltip : '<b>Derivar</b><br/>Deriva al funcionario asignado'
			});
		this.addButton('datosTecnicos', {
                argument: {imprimir: 'datosTecnicos'},
                text: '<i class="fa fa-thumbs-o-up fa-2x"></i> Datos Tecnicos', /*iconCls:'' ,*/
                disabled: false,
                handler: this.datosTecnicos
            });
		this.addButton('lote', {
                argument: {imprimir: 'lote'},
                text: '<i class="fa fa-thumbs-o-up fa-2x"></i> Lotes ', /*iconCls:'' ,*/
                disabled: false,
                handler: this.lote
            });

		this.addButton('imprimirInfor', {
				text: 'Imprimir Informe',
				iconCls: 'bprint',
				disabled: false,
				handler: this.BInforme,
				tooltip: '<b>Imprimir Informe</b><br/>Impresión del Informe'
			});		
			 console.log(config);
	},
			
	Atributos:[
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
				fieldLabel: 'Num. Tramite',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'trami.cite_tramite',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},

		{
			config:{
				name: 'num_informe',
				fieldLabel: 'Cite Informe',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'tradet.num_informe',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'referencia_informe',
				fieldLabel: 'Referencia Informe',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'tradet.referencia_informe',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'estado_tramite',
				fieldLabel: 'Estado Tramite',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'tradet.estado_tramite',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'tradet.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Para Resolución',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:800
			},
				type:'TextArea',
				filters:{pfiltro:'tradet.descripcion',type:'string'},
				id_grupo:1,
				grid:false,
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
			form: false
		},
		{
			config: {
				name: 'id_funcionario_deriv',
				fieldLabel: 'Funcionario Derivado',
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
				gdisplayField: 'funcio_deriv',
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
					return String.format('{0}', record.data['funcio_deriv']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'PERSON.nombre_completo2',type: 'string'},
			grid: true,
			form: true
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
				filters:{pfiltro:'tradet.usuario_ai',type:'string'},
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
				filters:{pfiltro:'tradet.fecha_reg',type:'date'},
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
				filters:{pfiltro:'tradet.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'tradet.fecha_mod',type:'date'},
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
	title:'Topografo',
	ActSave:'../../sis_tramites/control/TramiteDetalle/insertarTramiteDetalle',
	ActDel:'../../sis_tramites/control/TramiteDetalle/eliminarTramiteDetalle',
	ActList:'../../sis_tramites/control/TramiteDetalle/listarTopografo',
	id_store:'id_tramite_detalle',
	fields: [
		{name:'id_tramite_detalle', type: 'numeric'},
		{name:'id_tramite', type: 'numeric'},
		{name:'referencia_informe', type: 'string'},
		{name:'estado_tramite', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'id_documento', type: 'numeric'},
		{name:'num_informe', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_funcionario1', type: 'string'},
		{name:'cite_tramite', type: 'string'},
		{name:'id_funcionario_deriv', type: 'numeric'},
		{name:'funcio_deriv', type: 'string'},
	],
	sortInfo:{
		field: 'id_tramite_detalle',
		direction: 'ASC'
	},
	bdel:false,
	bsave:false,
	bnew:false,
	east:{
        url:'../../../sis_tramites/vista/informe/Informe.php',
        title:'Informe',
        height:'50%',
        cls:'Informe'
   		},
	preparaMenu: function (tb) {
        // llamada funcion clace padre
        Phx.vista.Topografo.superclass.preparaMenu.call(this, tb)
		
		var data = this.getSelectedData();
		  var tb =this.tbar;
        
       /* if(data.estado_tramite=="TOPOGRAFO" ){
              
				      this.getBoton('datosTecnicos').enable();
		          }
        else{
              
              this.getBoton('datosTecnicos').disable();
          };
        
             */           
		/*    if(data.id_funcionario>0 ){
				
			   	this.getBoton('Derivar').enable();
		  } else {		
			  		this.getBoton('edit').enable();
			  		this.getBoton('Derivar').disable();
		  	
		  };
		  	*/
         if(data.estado_reg=="inactivo"){
         
			this.getBoton('edit').disable();
			this.getBoton('Derivar').disable();
            this.getBoton('datosTecnicos').disable();
			this.getBoton('lote').disable();
		    }
          else {
          
            this.getBoton('edit').enable();
			this.getBoton('Derivar').enable();
			this.getBoton('datosTecnicos').enable();
			this.getBoton('lote').enable();
          };
		  	
		  
           
           
		  return tb
    },
    onButtonNew: function () {
        Phx.vista.Topografo.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite').setValue(this.maestro.id_tramite);
    },
   /* onReloadPage: function (m) {
        this.maestro = m;
        console.log(this.maestro);

        this.store.baseParams = {id_tramite: this.maestro.id_tramite};


        this.load({params: {start: 0, limit: 50}})
    },*/

	BDerivar : function() {

		var rec = this.sm.getSelected();
		var id_tramite_detalle = this.sm.getSelected().data.id_tramite_detalle;
		var id_funcionario = this.sm.getSelected().data.id_funcionario;
		var id_funcionario_deriv = this.sm.getSelected().data.id_funcionario_deriv;
		if (confirm('Esta seguro de DERIVAR el tramite?')){
		Phx.CP.loadingShow();
		Ext.Ajax.request({
			url : '../../sis_tramites/control/TramiteDetalle/derivarTramiteDetalle',
			params : {
				id_tramite_detalle : id_tramite_detalle,
				id_funcionario  : id_funcionario,
				id_funcionario_deriv  : id_funcionario_deriv
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
	  Phx.vista.Topografo.superclass.onReloadPage.call();	
   
    this.reload();
    
	},

	datosTecnicos: function () {
		var rec = this.getSelectedData();
		//jos168this.getComponente('id_tramite_detalle').setValue(this.id_tramite_detalle);
		//enviamos el id seleccionado para cual el archivo se deba subir
		rec.datos_extras_id = rec.id_tramite_detalle;
		rec.datos_extras_id = rec.id_tramite;
		//enviamos el nombre de la tabla
		rec.datos_extras_tabla = 'tdato_tecnico';
		//enviamos el codigo ya que una tabla puede tener varios archivos diferentes como ci,pasaporte,contrato,slider,fotos,etc
		rec.datos_extras_codigo = 'dato tecnico';

		//esto es cuando queremos darle una ruta personalizada
		//rec.datos_extras_ruta_personalizada = './../../../uploaded_files/favioVideos/videos/';

		Phx.CP.loadWindows('../../../sis_tramites/vista/dato_tecnico/DatoTecnico.php',
			'DatoTecnico',
			{
				width: 900,
				height: 400
			}, rec, this.idContenedor, 'DatoTecnico');

	},

	lote: function () {
		var rec = this.getSelectedData();
		//enviamos el id seleccionado para cual el archivo se deba subir
		rec.datos_extras_id = rec.id_tramite_detalle;
		rec.datos_extras_id = rec.id_tramite;
		//enviamos el nombre de la tabla
		rec.datos_extras_tabla = 'tlote';
		//enviamos el codigo ya que una tabla puede tener varios archivos diferentes como ci,pasaporte,contrato,slider,fotos,etc
		rec.datos_extras_codigo = 'lote';

		//esto es cuando queremos darle una ruta personalizada
		//rec.datos_extras_ruta_personalizada = './../../../uploaded_files/favioVideos/videos/';

		Phx.CP.loadWindows('../../../sis_tramites/vista/lote/Lote.php',
			'Lote',
			{
				width: 900,
				height: 400
			}, rec, this.idContenedor, 'Lote');

	},

	BInforme:function () {
			var rec = this.getSelectedData();
			Phx.CP.loadingShow();
			console.log(rec);
			console.log("despues");
			Ext.Ajax.request({
				url: '../../sis_tramites/control/ReporteInforme/emitirInformeTopo',
				params: {

					id_tramite_detalle: rec.id_tramite_detalle,
					id_usuario_reg: rec.id_usuario_reg
				},
				success: this.successExport,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
			});
	
		},

	}
)
</script>
		
		