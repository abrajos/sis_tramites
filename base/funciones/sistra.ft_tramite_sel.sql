CREATE OR REPLACE FUNCTION "sistra"."ft_tramite_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_tramite_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.ttramite'
 AUTOR: 		 (admin)
 FECHA:	        26-03-2025 01:17:18
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-03-2025 01:17:18								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.ttramite'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_tramite_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_trami_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:18
	***********************************/

	if(p_transaccion='SISTRA_trami_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						trami.id_tramite,
						trami.id_funcionario,
						trami.estado_reg,
						trami.id_documento,
						trami.cite_tramite,
						trami.estado_tramite,
						trami.id_tipo_tramite,
						trami.fecha_reg,
						trami.usuario_ai,
						trami.id_usuario_reg,
						trami.id_usuario_ai,
						trami.id_usuario_mod,
						trami.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.ttramite trami
						inner join segu.tusuario usu1 on usu1.id_usuario = trami.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = trami.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_trami_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		26-03-2025 01:17:18
	***********************************/

	elsif(p_transaccion='SISTRA_trami_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tramite)
					    from sistra.ttramite trami
					    inner join segu.tusuario usu1 on usu1.id_usuario = trami.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = trami.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_tramite_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
