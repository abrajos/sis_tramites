CREATE OR REPLACE FUNCTION "sistra"."ft_boleta_liquida_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_boleta_liquida_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tboleta_liquida'
 AUTOR: 		 (admin)
 FECHA:	        23-09-2025 02:24:49
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				23-09-2025 02:24:49								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tboleta_liquida'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_boleta_liquida	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_boleta_liquida_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_bolliq_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2025 02:24:49
	***********************************/

	if(p_transaccion='SISTRA_bolliq_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tboleta_liquida(
			plano_bs,
			division_m,
			fecha_emision,
			anexion_bs,
			monto_literal,
			plano_cons_bs,
			id_tramite,
			concepto_a_m,
			nombre_concepto_b,
			concepto_a_bs,
			plano_m,
			plano_cons_m,
			anexion_m,
			estado_reg,
			linea_nivel_m,
			division_bs,
			concepto_b_bs,
			linea_nivel_bs,
			avance_m,
			avance_bs,
			nombre_concepto_a,
			cite_tramite,
			concepto_b_m,
			plano_verja_m,
			total_bs,
			total_redon,
			nro_boleta,
			id_tramite_detalle,
			plano_verja_bs,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.plano_bs,
			v_parametros.division_m,
			v_parametros.fecha_emision,
			v_parametros.anexion_bs,
			v_parametros.monto_literal,
			v_parametros.plano_cons_bs,
			v_parametros.id_tramite,
			v_parametros.concepto_a_m,
			v_parametros.nombre_concepto_b,
			v_parametros.concepto_a_bs,
			v_parametros.plano_m,
			v_parametros.plano_cons_m,
			v_parametros.anexion_m,
			'activo',
			v_parametros.linea_nivel_m,
			v_parametros.division_bs,
			v_parametros.concepto_b_bs,
			v_parametros.linea_nivel_bs,
			v_parametros.avance_m,
			v_parametros.avance_bs,
			v_parametros.nombre_concepto_a,
			v_parametros.cite_tramite,
			v_parametros.concepto_b_m,
			v_parametros.plano_verja_m,
			v_parametros.total_bs,
			v_parametros.total_redon,
			v_parametros.nro_boleta,
			v_parametros.id_tramite_detalle,
			v_parametros.plano_verja_bs,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_boleta_liquida into v_id_boleta_liquida;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta Liquidacion almacenado(a) con exito (id_boleta_liquida'||v_id_boleta_liquida||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta_liquida',v_id_boleta_liquida::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_bolliq_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2025 02:24:49
	***********************************/

	elsif(p_transaccion='SISTRA_bolliq_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tboleta_liquida set
			plano_bs = v_parametros.plano_bs,
			division_m = v_parametros.division_m,
			fecha_emision = v_parametros.fecha_emision,
			anexion_bs = v_parametros.anexion_bs,
			monto_literal = v_parametros.monto_literal,
			plano_cons_bs = v_parametros.plano_cons_bs,
			id_tramite = v_parametros.id_tramite,
			concepto_a_m = v_parametros.concepto_a_m,
			nombre_concepto_b = v_parametros.nombre_concepto_b,
			concepto_a_bs = v_parametros.concepto_a_bs,
			plano_m = v_parametros.plano_m,
			plano_cons_m = v_parametros.plano_cons_m,
			anexion_m = v_parametros.anexion_m,
			linea_nivel_m = v_parametros.linea_nivel_m,
			division_bs = v_parametros.division_bs,
			concepto_b_bs = v_parametros.concepto_b_bs,
			linea_nivel_bs = v_parametros.linea_nivel_bs,
			avance_m = v_parametros.avance_m,
			avance_bs = v_parametros.avance_bs,
			nombre_concepto_a = v_parametros.nombre_concepto_a,
			cite_tramite = v_parametros.cite_tramite,
			concepto_b_m = v_parametros.concepto_b_m,
			plano_verja_m = v_parametros.plano_verja_m,
			total_bs = v_parametros.total_bs,
			total_redon = v_parametros.total_redon,
			nro_boleta = v_parametros.nro_boleta,
			id_tramite_detalle = v_parametros.id_tramite_detalle,
			plano_verja_bs = v_parametros.plano_verja_bs,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_boleta_liquida=v_parametros.id_boleta_liquida;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta Liquidacion modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta_liquida',v_parametros.id_boleta_liquida::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_bolliq_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2025 02:24:49
	***********************************/

	elsif(p_transaccion='SISTRA_bolliq_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tboleta_liquida
            where id_boleta_liquida=v_parametros.id_boleta_liquida;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta Liquidacion eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta_liquida',v_parametros.id_boleta_liquida::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "sistra"."ft_boleta_liquida_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
