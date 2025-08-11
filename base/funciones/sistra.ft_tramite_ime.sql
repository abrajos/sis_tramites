CREATE OR REPLACE FUNCTION "sistra"."ft_tramite_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tramite_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:18
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:18								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tramite	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_tramite_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_trami_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:18
	***********************************/

	if(p_transaccion='SISTRA_trami_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.ttramite(
			id_funcionario,
			estado_reg,
			id_documento,
			cite_tramite,
			estado_tramite,
			id_tipo_tramite,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_funcionario,
			'activo',
			v_parametros.id_documento,
			v_parametros.cite_tramite,
			v_parametros.estado_tramite,
			v_parametros.id_tipo_tramite,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tramite into v_id_tramite;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramites almacenado(a) con exito (id_tramite'||v_id_tramite||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite',v_id_tramite::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_trami_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:18
	***********************************/

	elsif(p_transaccion='SISTRA_trami_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.ttramite set
			id_funcionario = v_parametros.id_funcionario,
			id_documento = v_parametros.id_documento,
			cite_tramite = v_parametros.cite_tramite,
			estado_tramite = v_parametros.estado_tramite,
			id_tipo_tramite = v_parametros.id_tipo_tramite,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tramite=v_parametros.id_tramite;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramites modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite',v_parametros.id_tramite::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_trami_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:18
	***********************************/

	elsif(p_transaccion='SISTRA_trami_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.ttramite
            where id_tramite=v_parametros.id_tramite;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramites eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite',v_parametros.id_tramite::varchar);
              
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
ALTER FUNCTION "sistra"."ft_tramite_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
