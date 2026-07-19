CREATE OR REPLACE FUNCTION "sistra"."ft_lote_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_lote_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tlote'
 AUTOR: 		 (admin)
 FECHA:	        17-04-2025 00:18:04
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-04-2025 00:18:04								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tlote'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_lote	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_lote_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_lotes_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:04
	***********************************/

	if(p_transaccion='SISTRA_lotes_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tlote(
			tipo_cesion,
			superficie,
			nombre,
			id_tramite,
			estado_reg,
			lote,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.tipo_cesion,
			v_parametros.superficie,
			v_parametros.nombre,
			v_parametros.id_tramite,
			'activo',
			v_parametros.lote,
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_lote into v_id_lote;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Lotes almacenado(a) con exito (id_lote'||v_id_lote||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_lote',v_id_lote::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_lotes_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:04
	***********************************/

	elsif(p_transaccion='SISTRA_lotes_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tlote set
			tipo_cesion = v_parametros.tipo_cesion,
			superficie = v_parametros.superficie,
			nombre = v_parametros.nombre,
			id_tramite = v_parametros.id_tramite,
			lote = v_parametros.lote,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_lote=v_parametros.id_lote;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Lotes modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_lote',v_parametros.id_lote::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_lotes_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:04
	***********************************/

	elsif(p_transaccion='SISTRA_lotes_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tlote
            where id_lote=v_parametros.id_lote;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Lotes eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_lote',v_parametros.id_lote::varchar);
              
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
ALTER FUNCTION "sistra"."ft_lote_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
