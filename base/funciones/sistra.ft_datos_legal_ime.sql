CREATE OR REPLACE FUNCTION "sistra"."ft_datos_legal_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_datos_legal_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tdatos_legal'
 AUTOR: 		 (admin)
 FECHA:	        15-09-2025 18:37:32
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				15-09-2025 18:37:32								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tdatos_legal'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_datos_legal	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_datos_legal_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_datleg_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-09-2025 18:37:32
	***********************************/

	if(p_transaccion='SISTRA_datleg_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tdatos_legal(
			aprobacion,
			aux,
			estado_reg,
			area_agro,
			cod_catastral,
			kami,
			ddrr_registro,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.aprobacion,
			v_parametros.aux,
			'activo',
			v_parametros.area_agro,
			v_parametros.cod_catastral,
			v_parametros.kami,
			v_parametros.ddrr_registro,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_datos_legal into v_id_datos_legal;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Legal almacenado(a) con exito (id_datos_legal'||v_id_datos_legal||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_datos_legal',v_id_datos_legal::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_datleg_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-09-2025 18:37:32
	***********************************/

	elsif(p_transaccion='SISTRA_datleg_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tdatos_legal set
			aprobacion = v_parametros.aprobacion,
			aux = v_parametros.aux,
			area_agro = v_parametros.area_agro,
			cod_catastral = v_parametros.cod_catastral,
			kami = v_parametros.kami,
			ddrr_registro = v_parametros.ddrr_registro,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_datos_legal=v_parametros.id_datos_legal;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Legal modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_datos_legal',v_parametros.id_datos_legal::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_datleg_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-09-2025 18:37:32
	***********************************/

	elsif(p_transaccion='SISTRA_datleg_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tdatos_legal
            where id_datos_legal=v_parametros.id_datos_legal;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Legal eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_datos_legal',v_parametros.id_datos_legal::varchar);
              
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
ALTER FUNCTION "sistra"."ft_datos_legal_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
