CREATE OR REPLACE FUNCTION "sistra"."ft_informe_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_informe_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tinforme'
 AUTOR: 		 (admin)
 FECHA:	        27-08-2025 15:45:44
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				27-08-2025 15:45:44								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tinforme'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_informe_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_INFOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		27-08-2025 15:45:44
	***********************************/

	if(p_transaccion='SISTRA_INFOR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						infor.id_informe,
						infor.id_funcionario_a,
						infor.conclusion,
						infor.id_funcionario,
						infor.id_funcionario_via,
						infor.referencia,
						infor.num:informe,
						infor.id_tramite_detalle,
						infor.fecha_informe,
						infor.estado_reg,
						infor.observacion,
						infor.path_pdf,
						infor.id_usuario_ai,
						infor.usuario_ai,
						infor.fecha_reg,
						infor.id_usuario_reg,
						infor.fecha_mod,
						infor.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tinforme infor
						inner join segu.tusuario usu1 on usu1.id_usuario = infor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = infor.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_INFOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		27-08-2025 15:45:44
	***********************************/

	elsif(p_transaccion='SISTRA_INFOR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_informe)
					    from sistra.tinforme infor
					    inner join segu.tusuario usu1 on usu1.id_usuario = infor.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = infor.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_informe_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
