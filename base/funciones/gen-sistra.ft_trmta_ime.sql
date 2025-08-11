CREATE OR REPLACE FUNCTION "sistra"."ft_trmta_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_trmta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttrmta'
 AUTOR: 		 (admin)
 FECHA:	        17-04-2025 00:18:12
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-04-2025 00:18:12								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttrmta'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_rmta	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_trmta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_rmta_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:12
	***********************************/

	if(p_transaccion='SISTRA_rmta_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.ttrmta(
			fecha_rmta,
			tipo_aprobacion,
			estado_reg,
			nro_rmta,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.fecha_rmta,
			v_parametros.tipo_aprobacion,
			'activo',
			v_parametros.nro_rmta,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_rmta into v_id_rmta;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','RMTA almacenado(a) con exito (id_rmta'||v_id_rmta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_rmta',v_id_rmta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_rmta_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:12
	***********************************/

	elsif(p_transaccion='SISTRA_rmta_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.ttrmta set
			fecha_rmta = v_parametros.fecha_rmta,
			tipo_aprobacion = v_parametros.tipo_aprobacion,
			nro_rmta = v_parametros.nro_rmta,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_rmta=v_parametros.id_rmta;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','RMTA modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_rmta',v_parametros.id_rmta::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_rmta_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:12
	***********************************/

	elsif(p_transaccion='SISTRA_rmta_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.ttrmta
            where id_rmta=v_parametros.id_rmta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','RMTA eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_rmta',v_parametros.id_rmta::varchar);
              
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
ALTER FUNCTION "sistra"."ft_trmta_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
