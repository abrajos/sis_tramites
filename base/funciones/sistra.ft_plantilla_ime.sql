CREATE OR REPLACE FUNCTION "sistra"."ft_plantilla_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_plantilla_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tplantilla'
 AUTOR: 		 (admin)
 FECHA:	        25-09-2026 20:16:21
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				25-09-2026 20:16:21								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tplantilla'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_plantilla	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_plantilla_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_planti_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-09-2026 20:16:21
	***********************************/

	if(p_transaccion='SISTRA_planti_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tplantilla(
			nombre,
			auxiliar,
			parrafos,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.nombre,
			v_parametros.auxiliar,
			v_parametros.parrafos,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_plantilla into v_id_plantilla;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla almacenado(a) con exito (id_plantilla'||v_id_plantilla||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla',v_id_plantilla::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_planti_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-09-2026 20:16:21
	***********************************/

	elsif(p_transaccion='SISTRA_planti_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tplantilla set
			nombre = v_parametros.nombre,
			auxiliar = v_parametros.auxiliar,
			parrafos = v_parametros.parrafos,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_plantilla=v_parametros.id_plantilla;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla',v_parametros.id_plantilla::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_planti_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-09-2026 20:16:21
	***********************************/

	elsif(p_transaccion='SISTRA_planti_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tplantilla
            where id_plantilla=v_parametros.id_plantilla;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Plantilla eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_plantilla',v_parametros.id_plantilla::varchar);
              
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
ALTER FUNCTION "sistra"."ft_plantilla_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
