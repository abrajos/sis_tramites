<?php
/**
*@package pXP
*@file gen-BoletaLiquida.php
*@author  (admin)
*@date 23-09-2025 02:24:49
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.BoletaLiquida=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.BoletaLiquida.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
		this.bloquearMenus();
        if(Phx.CP.getPagina(this.idContenedorPadre)){
         var dataMaestro=Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
         if(dataMaestro){ 
            this.onEnablePanel(this,dataMaestro)
            }
         };
		 this.addButton('imprimirBole', {
				text: 'Imprimir Boleta',
				iconCls: 'bprint',
				disabled: false,
				handler: this.BImpBoleta,
				tooltip: '<b>Imprimir Boleta Liquidación</b><br/>Impresión Boleta'
			});		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_boleta_liquida'
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
				name: 'nro_boleta',
				fieldLabel: 'Nro. Boleta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.nro_boleta',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'cite_tramite',
				fieldLabel: 'Tramite',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'bolliq.cite_tramite',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'plano_cons_m',
				fieldLabel: 'Aprob. Plano Constrcción m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_cons_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_cons_bs',
				fieldLabel: 'Aprob. Plano Constrcción Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_cons_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_cons_tot',
				fieldLabel: 'Total Plano Constrcción',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_cons_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'plano_m',
				fieldLabel: 'Aprob. Plano m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_bs',
				fieldLabel: 'Aprob. Plano Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_tot',
				fieldLabel: 'Total Plano',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'plano_verja_m',
				fieldLabel: 'Aprob. Plano de Verja m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_verja_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_verja_bs',
				fieldLabel: 'Aprob. Plano de Verja Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_verja_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'plano_verja_tot',
				fieldLabel: 'Total Plano Verja',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.plano_verja_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'linea_nivel_m',
				fieldLabel: 'Fijación de lineas y nivel m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.linea_nivel_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'linea_nivel_bs',
				fieldLabel: 'Fijación de lineas y nivel Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.linea_nivel_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'linea_nivel_tot',
				fieldLabel: 'Total Linea Nivel',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.linea_nivel_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'anexion_m',
				fieldLabel: 'Anexión m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.anexion_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'anexion_bs',
				fieldLabel: 'Anexión Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.anexion_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'anexion_tot',
				fieldLabel: 'Total Anexión',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.anexion_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'division_m',
				fieldLabel: 'División m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.division_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'division_bs',
				fieldLabel: 'División Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.division_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'division_tot',
				fieldLabel: 'Total División',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.division_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'avance_m',
				fieldLabel: 'Avance sobre Prop. Municipal m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.avance_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'avance_bs',
				fieldLabel: 'Avance sobre Prop. Municipal Bs./m2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.avance_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'avance_tot',
				fieldLabel: 'Total Avance',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.avance_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'nombre_concepto_a',
				fieldLabel: 'Nombre Concepto Cobro',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'bolliq.nombre_concepto_a',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'concepto_a_m',
				fieldLabel: 'm2 de concepto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concepto_a_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'concepto_a_bs',
				fieldLabel: 'Bs./m2 del concepto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concepto_a_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'concep_a_tot',
				fieldLabel: 'Total A',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concep_a_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'nombre_concepto_b',
				fieldLabel: 'nombre Concepto 2',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'bolliq.nombre_concepto_b',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'concepto_b_m',
				fieldLabel: 'm2 del concepto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concepto_b_m',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'concepto_b_bs',
				fieldLabel: 'Bs./m2 del concepto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concepto_b_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'concep_b_tot',
				fieldLabel: 'Total B',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.concep_b_tot',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		
		{
			config:{
				name: 'total_bs',
				fieldLabel: 'Total',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.total_bs',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'total_redon',
				fieldLabel: 'Total Verificado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:655360
			},
				type:'NumberField',
				filters:{pfiltro:'bolliq.total_redon',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'monto_literal',
				fieldLabel: 'Monto Literal',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'bolliq.monto_literal',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_emision',
				fieldLabel: 'Fecha Emisión',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'bolliq.fecha_emision',type:'date'},
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
				filters:{pfiltro:'bolliq.estado_reg',type:'string'},
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
				filters:{pfiltro:'bolliq.fecha_reg',type:'date'},
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
				filters:{pfiltro:'bolliq.usuario_ai',type:'string'},
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
				filters:{pfiltro:'bolliq.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'bolliq.fecha_mod',type:'date'},
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
	title:'Boleta Liquidacion',
	ActSave:'../../sis_tramites/control/BoletaLiquida/insertarBoletaLiquida',
	ActDel:'../../sis_tramites/control/BoletaLiquida/eliminarBoletaLiquida',
	ActList:'../../sis_tramites/control/BoletaLiquida/listarBoletaLiquida',
	id_store:'id_boleta_liquida',
	fields: [
		{name:'id_boleta_liquida', type: 'numeric'},
		{name:'plano_bs', type: 'numeric'},
		{name:'division_m', type: 'numeric'},
		{name:'fecha_emision', type: 'date',dateFormat:'Y-m-d'},
		{name:'anexion_bs', type: 'numeric'},
		{name:'monto_literal', type: 'string'},
		{name:'plano_cons_bs', type: 'numeric'},
		{name:'id_tramite', type: 'numeric'},
		{name:'concepto_a_m', type: 'numeric'},
		{name:'nombre_concepto_b', type: 'string'},
		{name:'concepto_a_bs', type: 'numeric'},
		{name:'plano_m', type: 'numeric'},
		{name:'plano_cons_m', type: 'numeric'},
		{name:'anexion_m', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'linea_nivel_m', type: 'numeric'},
		{name:'division_bs', type: 'numeric'},
		{name:'concepto_b_bs', type: 'numeric'},
		{name:'linea_nivel_bs', type: 'numeric'},
		{name:'avance_m', type: 'numeric'},
		{name:'avance_bs', type: 'numeric'},
		{name:'nombre_concepto_a', type: 'string'},
		{name:'cite_tramite', type: 'string'},
		{name:'concepto_b_m', type: 'numeric'},
		{name:'plano_verja_m', type: 'numeric'},
		{name:'total_bs', type: 'numeric'},
		{name:'total_redon', type: 'numeric'},
		{name:'nro_boleta', type: 'numeric'},
		{name:'id_tramite_detalle', type: 'numeric'},
		{name:'plano_verja_bs', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'plano_cons_tot', type: 'numeric'},
		{name:'plano_tot', type: 'numeric'},
		{name:'plano_verja_tot', type: 'numeric'},
		{name:'linea_nivel_tot', type: 'numeric'},
		{name:'anexion_tot', type: 'numeric'},
		{name:'division_tot', type: 'numeric'},
		{name:'avance_tot', type: 'numeric'},
		{name:'concep_a_tot', type: 'numeric'},
		{name:'concep_b_tot', type: 'numeric'},
		
	],
	sortInfo:{
		field: 'id_boleta_liquida',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	onButtonNew: function () {
        Phx.vista.BoletaLiquida.superclass.onButtonNew.call(this);
        this.getComponente('id_tramite_detalle').setValue(this.maestro.id_tramite_detalle);
    },
    onReloadPage: function (m) {
        this.maestro = m;
        console.log(this.maestro);
        this.store.baseParams = {id_tramite_detalle: this.maestro.id_tramite_detalle};
        this.load({params: {start: 0, limit: 50}})
    },
	loadValoresIniciales:function(){
        Phx.vista.BoletaLiquida.superclass.loadValoresIniciales.call(this);
        this.Cmp.id_tramite_detalle.setValue(this.maestro.id_tramite_detalle);
    },
	
	BImpBoleta:function () {
			var rec = this.getSelectedData();
			Phx.CP.loadingShow();
			console.log(rec);
			console.log("despues");
			Ext.Ajax.request({
				url: '../../sis_tramites/control/ReporteFormularioBoleta/emitirBoleta',
				params: {
					id_boleta_liquida:rec.id_boleta_liquida,
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
		
		