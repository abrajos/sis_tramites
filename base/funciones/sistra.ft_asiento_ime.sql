CREATE OR REPLACE FUNCTION "sistra"."ft_asiento_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_asiento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tasiento'
 AUTOR: 		 (admin)
 FECHA:	        20-06-2026 10:56:00
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				20-06-2026 10:56:00								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tasiento'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_asiento	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_asiento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_ASIEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-06-2026 10:56:00
	***********************************/

	if(p_transaccion='SISTRA_ASIEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tasiento(
			nro_asiento,
			fecha_asiento,
			id_matricula,
			motivo,
			estado_reg,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.nro_asiento,
			v_parametros.fecha_asiento,
			v_parametros.id_matricula,
			v_parametros.motivo,
			'activo',
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_asiento into v_id_asiento;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asientos almacenado(a) con exito (id_asiento'||v_id_asiento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_asiento',v_id_asiento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_ASIEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-06-2026 10:56:00
	***********************************/

	elsif(p_transaccion='SISTRA_ASIEN_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tasiento set
			nro_asiento = v_parametros.nro_asiento,
			fecha_asiento = v_parametros.fecha_asiento,
			id_matricula = v_parametros.id_matricula,
			motivo = v_parametros.motivo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_asiento=v_parametros.id_asiento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asientos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_asiento',v_parametros.id_asiento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_ASIEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-06-2026 10:56:00
	***********************************/

	elsif(p_transaccion='SISTRA_ASIEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tasiento
            where id_asiento=v_parametros.id_asiento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Asientos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_asiento',v_parametros.id_asiento::varchar);
              
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
ALTER FUNCTION "sistra"."ft_asiento_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
