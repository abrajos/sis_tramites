/**
*@package pXP
*@file gen-Plantilla.php
*@author  (admin)
*@date 25-09-2026 20:16:21
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Plantilla=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Plantilla.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_plantilla'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'nombre',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:2000
			},
				type:'TextField',
				filters:{pfiltro:'planti.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'auxiliar',
				fieldLabel: 'auxiliar',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:2000
			},
				type:'TextField',
				filters:{pfiltro:'planti.auxiliar',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'parrafos',
				fieldLabel: 'Párrafos Dinámicos (HTML)',
				allowBlank: false,
				anchor: '100%',
				gwidth: 200,
				renderer: function(value, p, record) {
					if (value) {
						var arr = Array.isArray(value) ? value : [value];
						return '<div style="white-space:normal; max-height:60px; overflow:hidden;">' + arr.join('<br><br>') + '</div>';
					}
					return '';
				}
			},
				type: 'HtmlEditor',
				filters:{pfiltro:'planti.parrafos',type:'string'},
				id_grupo: 1,
				grid: true,
				form: true
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
				filters:{pfiltro:'planti.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'planti.id_usuario_ai',type:'numeric'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'planti.fecha_reg',type:'date'},
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
				filters:{pfiltro:'planti.usuario_ai',type:'string'},
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
				filters:{pfiltro:'planti.fecha_mod',type:'date'},
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

	onNew: function() {
		Phx.vista.Plantilla.superclass.onNew.call(this);
		this.configurarHtmlEditorsDinamicos([]);
	},

	onEdit: function(rec) {
		Phx.vista.Plantilla.superclass.onEdit.call(this, rec);
		var parrafosVal = rec.data.parrafos || [];
		if (typeof parrafosVal === 'string') {
			try { parrafosVal = JSON.parse(parrafosVal); } catch(e) { parrafosVal = [parrafosVal]; }
		}
		this.configurarHtmlEditorsDinamicos(parrafosVal);
	},

	configurarHtmlEditorsDinamicos: function(valoresIniciales) {
		var me = this;
		var campoHtml = me.form.getForm().findField('parrafos');
		if (!campoHtml) return;

		// Ocultamos el campo HtmlEditor individual original del framework
		if (campoHtml.ownerCt) {
			campoHtml.ownerCt.hide();
		}

		if (me.panelHtmlDinamico) {
			me.form.remove(me.panelHtmlDinamico, true);
		}

		// Creamos un contenedor interactivo con el botón (+) para añadir múltiples HtmlEditor
		me.panelHtmlDinamico = new Ext.form.FieldSet({
			title: 'Gestión de Párrafos Múltiples (HTML)',
			autoHeight: true,
			layout: 'form',
			style: 'margin-top:10px;',
			items: [
				{
					xtype: 'button',
					text: 'Añadir Otro Párrafo (+)',
					iconCls: 'badd',
					style: 'margin-bottom:10px;',
					handler: function() {
						me.agregarHtmlEditorItem('');
					}
				},
				{
					xtype: 'panel',
					id: 'cont-dinamico-html-editors',
					border: false,
					layout: 'form',
					items: []
				}
			]
		});

		me.form.add(me.panelHtmlDinamico);
		me.form.doLayout();

		if (valoresIniciales && valoresIniciales.length > 0) {
			for (var i = 0; i < valoresIniciales.length; i++) {
				me.agregarHtmlEditorItem(valoresIniciales[i]);
			}
		} else {
			me.agregarHtmlEditorItem('');
		}
	},

	agregarHtmlEditorItem: function(contenido) {
		var contenedor = Ext.getCmp('cont-dinamico-html-editors');
		if (!contenedor) return;

		var editorHtml = new Ext.form.HtmlEditor({
			fieldLabel: 'Párrafo HTML',
			height: 150,
			anchor: '98%',
			value: contenido || ''
		});

		var wrapperItem = new Ext.Panel({
			layout: 'form',
			border: true,
			style: 'padding:8px; margin-bottom:10px; background:#fcfcfc; border-color:#d0d0d0;',
			items: [
				{
					xtype: 'button',
					text: 'Quitar este párrafo (-)',
					iconCls: 'bdel',
					style: 'margin-bottom:5px;',
					handler: function() {
						contenedor.remove(wrapperItem, true);
						contenedor.doLayout();
					}
				},
				editorHtml
			]
		});

		contenedor.add(wrapperItem);
		contenedor.doLayout();
	},

	onSubmit: function(o) {
		var me = this;
		var contenedor = Ext.getCmp('cont-dinamico-html-editors');
		if (contenedor) {
			var vectorFinal = [];
			contenedor.items.each(function(panelWrapper) {
				var htmlComp = panelWrapper.items.itemAt(1);
				if (htmlComp && htmlComp.getValue) {
					vectorFinal.push(htmlComp.getValue());
				}
			});

			var campoParrafos = me.form.getForm().findField('parrafos');
			if (campoParrafos) {
				campoParrafos.setValue(JSON.stringify(vectorFinal));
			}
		}

		Phx.vista.Plantilla.superclass.onSubmit.call(this, o);
	},

	tam_pag:50,	
	title:'Plantilla',
	ActSave:'../../sis_tramites/control/Plantilla/insertarPlantilla',
	ActDel:'../../sis_tramites/control/Plantilla/eliminarPlantilla',
	ActList:'../../sis_tramites/control/Plantilla/listarPlantilla',
	id_store:'id_plantilla',
	fields: [
		{name:'id_plantilla', type: 'numeric'},
		{name:'nombre', type: 'string'},
		{name:'auxiliar', type: 'string'},
		{name:'parrafos'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'}
	],
	sortInfo:{
		field: 'id_plantilla',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
})
</script>