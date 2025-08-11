CREATE OR REPLACE FUNCTION "sistra"."ft_boleta_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_boleta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tboleta'
 AUTOR: 		 (admin)
 FECHA:	        22-04-2025 06:17:41
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-04-2025 06:17:41								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tboleta'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_boleta	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_boleta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_boleta_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-04-2025 06:17:41
	***********************************/

	if(p_transaccion='SISTRA_boleta_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tboleta(
			fecha_pago,
			estado_reg,
			nro_liquidacion,
			monto,
			comp_pago,
			id_tramite,
			expediente,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.fecha_pago,
			'activo',
			v_parametros.nro_liquidacion,
			v_parametros.monto,
			v_parametros.comp_pago,
			v_parametros.id_tramite,
			v_parametros.expediente,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_boleta into v_id_boleta;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta almacenado(a) con exito (id_boleta'||v_id_boleta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta',v_id_boleta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_boleta_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-04-2025 06:17:41
	***********************************/

	elsif(p_transaccion='SISTRA_boleta_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tboleta set
			fecha_pago = v_parametros.fecha_pago,
			nro_liquidacion = v_parametros.nro_liquidacion,
			monto = v_parametros.monto,
			comp_pago = v_parametros.comp_pago,
			id_tramite = v_parametros.id_tramite,
			expediente = v_parametros.expediente,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_boleta=v_parametros.id_boleta;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta',v_parametros.id_boleta::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_boleta_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-04-2025 06:17:41
	***********************************/

	elsif(p_transaccion='SISTRA_boleta_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tboleta
            where id_boleta=v_parametros.id_boleta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Boleta eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_boleta',v_parametros.id_boleta::varchar);
              
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
ALTER FUNCTION "sistra"."ft_boleta_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
