CREATE OR REPLACE FUNCTION "sistra"."ft_dato_tecnico_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_dato_tecnico_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tdato_tecnico'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:12
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:12								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sistra.tdato_tecnico'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_dato_tecnico	integer;
			    
BEGIN

    v_nombre_funcion = 'sistra.ft_dato_tecnico_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_dattec_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:12
	***********************************/

	if(p_transaccion='SISTRA_dattec_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sistra.tdato_tecnico(
			super_escritura,
			tipo_calle,
			super_mensura,
			id_tramite,
			avenida,
			alcantarillado,
			telefonia,
			alumbrado_publico,
			lote,
			colindante_oeste,
			estado_reg,
			calle,
			super_total,
			transporte,
			colindante_sur,
			long_rasante,
			vias,
			agua_potable,
			colindante_este,
			manzana,
			distrito,
			colindante_norte varchar,
			zona,
			equipamiento,
			rasante_municipal,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.super_escritura,
			v_parametros.tipo_calle,
			v_parametros.super_mensura,
			v_parametros.id_tramite,
			v_parametros.avenida,
			v_parametros.alcantarillado,
			v_parametros.telefonia,
			v_parametros.alumbrado_publico,
			v_parametros.lote,
			v_parametros.colindante_oeste,
			'activo',
			v_parametros.calle,
			v_parametros.super_total,
			v_parametros.transporte,
			v_parametros.colindante_sur,
			v_parametros.long_rasante,
			v_parametros.vias,
			v_parametros.agua_potable,
			v_parametros.colindante_este,
			v_parametros.manzana,
			v_parametros.distrito,
			v_parametros.colindante_norte varchar,
			v_parametros.zona,
			v_parametros.equipamiento,
			v_parametros.rasante_municipal,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_dato_tecnico into v_id_dato_tecnico;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Tecnicos almacenado(a) con exito (id_dato_tecnico'||v_id_dato_tecnico||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_dato_tecnico',v_id_dato_tecnico::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_dattec_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:12
	***********************************/

	elsif(p_transaccion='SISTRA_dattec_MOD')then

		begin
			--Sentencia de la modificacion
			update sistra.tdato_tecnico set
			super_escritura = v_parametros.super_escritura,
			tipo_calle = v_parametros.tipo_calle,
			super_mensura = v_parametros.super_mensura,
			id_tramite = v_parametros.id_tramite,
			avenida = v_parametros.avenida,
			alcantarillado = v_parametros.alcantarillado,
			telefonia = v_parametros.telefonia,
			alumbrado_publico = v_parametros.alumbrado_publico,
			lote = v_parametros.lote,
			colindante_oeste = v_parametros.colindante_oeste,
			calle = v_parametros.calle,
			super_total = v_parametros.super_total,
			transporte = v_parametros.transporte,
			colindante_sur = v_parametros.colindante_sur,
			long_rasante = v_parametros.long_rasante,
			vias = v_parametros.vias,
			agua_potable = v_parametros.agua_potable,
			colindante_este = v_parametros.colindante_este,
			manzana = v_parametros.manzana,
			distrito = v_parametros.distrito,
			colindante_norte varchar = v_parametros.colindante_norte varchar,
			zona = v_parametros.zona,
			equipamiento = v_parametros.equipamiento,
			rasante_municipal = v_parametros.rasante_municipal,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_dato_tecnico=v_parametros.id_dato_tecnico;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Tecnicos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_dato_tecnico',v_parametros.id_dato_tecnico::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_dattec_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:12
	***********************************/

	elsif(p_transaccion='SISTRA_dattec_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sistra.tdato_tecnico
            where id_dato_tecnico=v_parametros.id_dato_tecnico;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Datos Tecnicos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_dato_tecnico',v_parametros.id_dato_tecnico::varchar);
              
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
ALTER FUNCTION "sistra"."ft_dato_tecnico_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
