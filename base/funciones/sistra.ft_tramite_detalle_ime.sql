CREATE OR REPLACE FUNCTION "sistra"."ft_tramite_detalle_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tramite_detalle_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite_detalle'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:21
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:21								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.ttramite_detalle'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_tramite_detalle	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_tramite_detalle_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_tradet_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:21
	***********************************/

	if(p_transaccion='SISTRA_tradet_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.ttramite_detalle(
			id_tramite,
			referencia_informe,
			estado_tramite,
			estado_reg,
			descripcion,
			id_funcionario,
			id_documento,
			num_informe,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_tramite,
			v_parametros.referencia_informe,
			v_parametros.estado_tramite,
			'activo',
			v_parametros.descripcion,
			v_parametros.id_funcionario,
			v_parametros.id_documento,
			v_parametros.num_informe,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tramite_detalle into v_id_tramite_detalle;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Detalle almacenado(a) con exito (id_tramite_detalle'||v_id_tramite_detalle||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_detalle',v_id_tramite_detalle::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_tradet_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:21
	***********************************/

	elsif(p_transaccion='SISTRA_tradet_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.ttramite_detalle set
			id_tramite = v_parametros.id_tramite,
			referencia_informe = v_parametros.referencia_informe,
			estado_tramite = v_parametros.estado_tramite,
			descripcion = v_parametros.descripcion,
			id_funcionario = v_parametros.id_funcionario,
			id_documento = v_parametros.id_documento,
			num_informe = v_parametros.num_informe,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tramite_detalle=v_parametros.id_tramite_detalle;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Detalle modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_detalle',v_parametros.id_tramite_detalle::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_tradet_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:21
	***********************************/

	elsif(p_transaccion='SISTRA_tradet_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.ttramite_detalle
            where id_tramite_detalle=v_parametros.id_tramite_detalle;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tramite Detalle eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tramite_detalle',v_parametros.id_tramite_detalle::varchar);
              
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
ALTER FUNCTION "sistra"."ft_tramite_detalle_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
