<?php
/**
*@package pXP
*@file gen-Informe.php
*@author  (admin)
*@date 27-08-2025 15:45:44
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Informe=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Informe.superclass.constructor.call(this,config);
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
					name: 'id_informe'
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
				name: 'num_informe',
				fieldLabel: 'Número informe',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:15
			},
				type:'TextField',
				filters:{pfiltro:'infor.num_informe',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config: {
				name: 'id_funcionario',
				fieldLabel: 'De:',
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
				gdisplayField: 'funcionario',
				hiddenName: 'id_funcionario',
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
					return String.format('{0}', record.data['funcionario']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'movtip.nombre',type: 'string'},
			grid: true,
			form: false
		},
		{
			config: {
				name: 'id_funcionario_via',
				fieldLabel: 'Via ',
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
				gdisplayField: 'funcionariovia',
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
					return String.format('{0}', record.data['funcionariovia']);
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
				name: 'id_funcionario_a',
				fieldLabel: 'A',
				allowBlank: false,
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
				gdisplayField: 'funcionarioa',
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
					return String.format('{0}', record.data['funcionarioa']);
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
				name: 'referencia',
				fieldLabel: 'Referencia',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:500
			},
				type:'TextField',
				filters:{pfiltro:'infor.referencia',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'observacion',
				fieldLabel: 'Observación o Fundamento Legal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:700
			},
				type:'TextArea',
				filters:{pfiltro:'infor.observacion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'conclusion',
				fieldLabel: 'Conclusión y Recomendaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:700
			},
				type:'TextArea',
				filters:{pfiltro:'infor.conclusion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
			
		{
			config:{
				name: 'fecha_informe',
				fieldLabel: 'fecha Informe',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'infor.fecha_informe',type:'date'},
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
				filters:{pfiltro:'infor.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'path_pdf',
				fieldLabel: 'path_pdf',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'infor.path_pdf',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
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
				filters:{pfiltro:'infor.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'infor.usuario_ai',type:'string'},
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
				filters:{pfiltro:'infor.fecha_reg',type:'date'},
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'infor.fecha_mod',type:'date'},
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
	title:'Informe',
	ActSave:'../../sis_tramites/control/Informe/insertarInforme',
	ActDel:'../../sis_tramites/control/Informe/eliminarInforme',
	ActList:'../../sis_tramites/control/Informe/listarInforme',
	id_store:'id_informe',
	fields: [
		{name:'id_informe', type: 'numeric'},
		{name:'id_funcionario_a', type: 'numeric'},
		{name:'conclusion', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'id_funcionario_via', type: 'numeric'},
		{name:'referencia', type: 'string'},
		{name:'num_informe', type: 'string'},
		{name:'id_tramite_detalle', type: 'numeric'},
		{name:'fecha_informe', type: 'date',dateFormat:'Y-m-d'},
		{name:'estado_reg', type: 'string'},
		{name:'observacion', type: 'string'},
		{name:'path_pdf', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'funcionarioa', type: 'string'},
		{name:'funcionario', type: 'string'},
		{name:'funcionariovia', type: 'string'},
	],
	sortInfo:{
		field: 'id_informe',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	onButtonNew: function () {
        Phx.vista.Informe.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite_detalle').setValue(this.maestro.id_tramite_detalle);
    },
	onReloadPage: function (m) {
        this.maestro = m;
        console.log(this.maestro);

        this.store.baseParams = {id_tramite_detalle: this.maestro.id_tramite_detalle};


        this.load({params: {start: 0, limit: 50}})
    },
	}
)
</script>
		
		