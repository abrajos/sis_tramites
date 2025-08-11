CREATE OR REPLACE FUNCTION "sistra"."ft_tipo_tramite_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tipo_tramite_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttipo_tramite'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:15
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:15								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttipo_tramite'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tipo_tramite	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_tipo_tramite_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_tiptra_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:15
	***********************************/

	if(p_transaccion='SISTRA_tiptra_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.ttipo_tramite(
			codigo_tramite,
			descripcion,
			estado_reg,
			nombre_tramite,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.codigo_tramite,
			v_parametros.descripcion,
			'activo',
			v_parametros.nombre_tramite,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_tipo_tramite into v_id_tipo_tramite;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Tramites almacenado(a) con exito (id_tipo_tramite'||v_id_tipo_tramite||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_tramite',v_id_tipo_tramite::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_tiptra_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:15
	***********************************/

	elsif(p_transaccion='SISTRA_tiptra_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.ttipo_tramite set
			codigo_tramite = v_parametros.codigo_tramite,
			descripcion = v_parametros.descripcion,
			nombre_tramite = v_parametros.nombre_tramite,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_tramite=v_parametros.id_tipo_tramite;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Tramites modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_tramite',v_parametros.id_tipo_tramite::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_tiptra_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:15
	***********************************/

	elsif(p_transaccion='SISTRA_tiptra_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.ttipo_tramite
            where id_tipo_tramite=v_parametros.id_tipo_tramite;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Tramites eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_tramite',v_parametros.id_tipo_tramite::varchar);
              
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
ALTER FUNCTION "sistra"."ft_tipo_tramite_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
