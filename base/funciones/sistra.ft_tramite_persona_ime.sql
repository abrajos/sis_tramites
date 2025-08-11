CREATE OR REPLACE FUNCTION "sistra"."ft_tramite_persona_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tramite_persona_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite_persona'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:24
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:24								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite_persona'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tramite_persona	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_tramite_persona_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_traper_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:24
	***********************************/

	if(p_transaccion='SISTRA_traper_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.ttramite_persona(
			id_tramite,
			estado_reg,
			tipo_persona,
			id_persona,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_tramite,
			'activo',
			v_parametros.tipo_persona,
			v_parametros.id_persona,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tramite_persona into v_id_tramite_persona;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Persona almacenado(a) con exito (id_tramite_persona'||v_id_tramite_persona||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_persona',v_id_tramite_persona::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_traper_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:24
	***********************************/

	elsif(p_transaccion='SISTRA_traper_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.ttramite_persona set
			id_tramite = v_parametros.id_tramite,
			tipo_persona = v_parametros.tipo_persona,
			id_persona = v_parametros.id_persona,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tramite_persona=v_parametros.id_tramite_persona;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Persona modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_persona',v_parametros.id_tramite_persona::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_traper_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:24
	***********************************/

	elsif(p_transaccion='SISTRA_traper_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.ttramite_persona
            where id_tramite_persona=v_parametros.id_tramite_persona;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Persona eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_persona',v_parametros.id_tramite_persona::varchar);
              
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
ALTER FUNCTION "sistra"."ft_tramite_persona_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
