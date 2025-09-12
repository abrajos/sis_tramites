CREATE OR REPLACE FUNCTION "sistra"."ft_informe_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_informe_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tinforme'
 AUTOR: 		 (admin)
 FECHA:	        27-08-2025 15:45:44
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				27-08-2025 15:45:44								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tinforme'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_informe	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_informe_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_INFOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-08-2025 15:45:44
	***********************************/

	if(p_transaccion='SISTRA_INFOR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tinforme(
			id_funcionario_a,
			conclusion,
			id_funcionario,
			id_funcionario_via,
			referencia,
			num:informe,
			id_tramite_detalle,
			fecha_informe,
			estado_reg,
			observacion,
			path_pdf,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_funcionario_a,
			v_parametros.conclusion,
			v_parametros.id_funcionario,
			v_parametros.id_funcionario_via,
			v_parametros.referencia,
			v_parametros.num:informe,
			v_parametros.id_tramite_detalle,
			v_parametros.fecha_informe,
			'activo',
			v_parametros.observacion,
			v_parametros.path_pdf,
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_informe into v_id_informe;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Informe almacenado(a) con exito (id_informe'||v_id_informe||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_informe',v_id_informe::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_INFOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-08-2025 15:45:44
	***********************************/

	elsif(p_transaccion='SISTRA_INFOR_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tinforme set
			id_funcionario_a = v_parametros.id_funcionario_a,
			conclusion = v_parametros.conclusion,
			id_funcionario = v_parametros.id_funcionario,
			id_funcionario_via = v_parametros.id_funcionario_via,
			referencia = v_parametros.referencia,
			num:informe = v_parametros.num:informe,
			id_tramite_detalle = v_parametros.id_tramite_detalle,
			fecha_informe = v_parametros.fecha_informe,
			observacion = v_parametros.observacion,
			path_pdf = v_parametros.path_pdf,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_informe=v_parametros.id_informe;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Informe modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_informe',v_parametros.id_informe::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_INFOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-08-2025 15:45:44
	***********************************/

	elsif(p_transaccion='SISTRA_INFOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tinforme
            where id_informe=v_parametros.id_informe;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Informe eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_informe',v_parametros.id_informe::varchar);
              
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
ALTER FUNCTION "sistra"."ft_informe_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
