CREATE OR REPLACE FUNCTION "sistra"."ft_matricula_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_matricula_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tmatricula'
 AUTOR: 		 (admin)
 FECHA:	        17-04-2025 00:18:08
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-04-2025 00:18:08								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tmatricula'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_matricula	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_matricula_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_matri_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:08
	***********************************/

	if(p_transaccion='SISTRA_matri_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tmatricula(
			superficie,
			asiento,
			decreto_registrador,
			fecha_testimonio,
			nro_matricula,
			estado_reg,
			fecha_asiento,
			nro_notario,
			fecha_decreto,
			nombre_notario,
			id_tramite,
			nro_testimonio,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.superficie,
			v_parametros.asiento,
			v_parametros.decreto_registrador,
			v_parametros.fecha_testimonio,
			v_parametros.nro_matricula,
			'activo',
			v_parametros.fecha_asiento,
			v_parametros.nro_notario,
			v_parametros.fecha_decreto,
			v_parametros.nombre_notario,
			v_parametros.id_tramite,
			v_parametros.nro_testimonio,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_matricula into v_id_matricula;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Matricula Testimonio almacenado(a) con exito (id_matricula'||v_id_matricula||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_matricula',v_id_matricula::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_matri_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:08
	***********************************/

	elsif(p_transaccion='SISTRA_matri_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tmatricula set
			superficie = v_parametros.superficie,
			asiento = v_parametros.asiento,
			decreto_registrador = v_parametros.decreto_registrador,
			fecha_testimonio = v_parametros.fecha_testimonio,
			nro_matricula = v_parametros.nro_matricula,
			fecha_asiento = v_parametros.fecha_asiento,
			nro_notario = v_parametros.nro_notario,
			fecha_decreto = v_parametros.fecha_decreto,
			nombre_notario = v_parametros.nombre_notario,
			id_tramite = v_parametros.id_tramite,
			nro_testimonio = v_parametros.nro_testimonio,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_matricula=v_parametros.id_matricula;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Matricula Testimonio modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_matricula',v_parametros.id_matricula::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_matri_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:08
	***********************************/

	elsif(p_transaccion='SISTRA_matri_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tmatricula
            where id_matricula=v_parametros.id_matricula;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Matricula Testimonio eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_matricula',v_parametros.id_matricula::varchar);
              
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
ALTER FUNCTION "sistra"."ft_matricula_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
