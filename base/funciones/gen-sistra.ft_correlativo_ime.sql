CREATE OR REPLACE FUNCTION "sistra"."ft_correlativo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_correlativo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tcorrelativo'
 AUTOR: 		 (admin)
 FECHA:	        26-08-2025 21:14:57
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-08-2025 21:14:57								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tcorrelativo'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_correlativo	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_correlativo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_CORREL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-08-2025 21:14:57
	***********************************/

	if(p_transaccion='SISTRA_CORREL_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tcorrelativo(
			estado_reg,
			sigla,
			tipo,
			cargo,
			num_siguiente,
			num_actual,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.sigla,
			v_parametros.tipo,
			v_parametros.cargo,
			v_parametros.num_siguiente,
			v_parametros.num_actual,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_correlativo into v_id_correlativo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Correlativo almacenado(a) con exito (id_correlativo'||v_id_correlativo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_correlativo',v_id_correlativo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_CORREL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-08-2025 21:14:57
	***********************************/

	elsif(p_transaccion='SISTRA_CORREL_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tcorrelativo set
			sigla = v_parametros.sigla,
			tipo = v_parametros.tipo,
			cargo = v_parametros.cargo,
			num_siguiente = v_parametros.num_siguiente,
			num_actual = v_parametros.num_actual,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_correlativo=v_parametros.id_correlativo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Correlativo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_correlativo',v_parametros.id_correlativo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_CORREL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-08-2025 21:14:57
	***********************************/

	elsif(p_transaccion='SISTRA_CORREL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tcorrelativo
            where id_correlativo=v_parametros.id_correlativo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Correlativo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_correlativo',v_parametros.id_correlativo::varchar);
              
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
ALTER FUNCTION "sistra"."ft_correlativo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
