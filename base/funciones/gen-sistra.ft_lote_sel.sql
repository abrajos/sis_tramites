CREATE OR REPLACE FUNCTION "sistra"."ft_lote_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_lote_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tlote'
 AUTOR: 		 (admin)
 FECHA:	        17-04-2025 00:18:04
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-04-2025 00:18:04								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tlote'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_lote_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_lotes_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:04
	***********************************/

	if(p_transaccion='SISTRA_lotes_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						lotes.id_lote,
						lotes.tipo_cesion,
						lotes.superficie,
						lotes.nombre,
						lotes.id_tramite,
						lotes.estado_reg,
						lotes.lote,
						lotes.id_usuario_ai,
						lotes.usuario_ai,
						lotes.fecha_reg,
						lotes.id_usuario_reg,
						lotes.id_usuario_mod,
						lotes.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tlote lotes
						inner join segu.tusuario usu1 on usu1.id_usuario = lotes.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = lotes.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_lotes_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:04
	***********************************/

	elsif(p_transaccion='SISTRA_lotes_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_lote)
					    from sistra.tlote lotes
					    inner join segu.tusuario usu1 on usu1.id_usuario = lotes.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = lotes.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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
ALTER FUNCTION "sistra"."ft_lote_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
