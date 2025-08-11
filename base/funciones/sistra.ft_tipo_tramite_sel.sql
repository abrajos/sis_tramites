CREATE OR REPLACE FUNCTION "sistra"."ft_tipo_tramite_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tipo_tramite_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.ttipo_tramite'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:15
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:15								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.ttipo_tramite'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_tipo_tramite_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_tiptra_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:15
	***********************************/

	if(p_transaccion='SISTRA_tiptra_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tiptra.id_tipo_tramite,
						tiptra.codigo_tramite,
						tiptra.descripcion,
						tiptra.estado_reg,
						tiptra.nombre_tramite,
						tiptra.id_usuario_ai,
						tiptra.id_usuario_reg,
						tiptra.usuario_ai,
						tiptra.fecha_reg,
						tiptra.id_usuario_mod,
						tiptra.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.ttipo_tramite tiptra
						inner join segu.tusuario usu1 on usu1.id_usuario = tiptra.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tiptra.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_tiptra_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:15
	***********************************/

	elsif(p_transaccion='SISTRA_tiptra_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_tramite)
					    from sistra.ttipo_tramite tiptra
					    inner join segu.tusuario usu1 on usu1.id_usuario = tiptra.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tiptra.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_tipo_tramite_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
