CREATE OR REPLACE FUNCTION "sistra"."ft_matricula_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_matricula_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tmatricula'
 AUTOR: 		 (admin)
 FECHA:	        17-04-2025 00:18:08
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				17-04-2025 00:18:08								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tmatricula'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_matricula_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_matri_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:08
	***********************************/

	if(p_transaccion='SISTRA_matri_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						matri.id_matricula,
						matri.superficie,
						matri.asiento,
						matri.decreto_registrador,
						matri.fecha_testimonio,
						matri.nro_matricula,
						matri.estado_reg,
						matri.fecha_asiento,
						matri.nro_notario,
						matri.fecha_decreto,
						matri.nombre_notario,
						matri.id_tramite,
						matri.nro_testimonio,
						matri.id_usuario_ai,
						matri.id_usuario_reg,
						matri.usuario_ai,
						matri.fecha_reg,
						matri.id_usuario_mod,
						matri.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tmatricula matri
						inner join segu.tusuario usu1 on usu1.id_usuario = matri.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = matri.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_matri_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		17-04-2025 00:18:08
	***********************************/

	elsif(p_transaccion='SISTRA_matri_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_matricula)
					    from sistra.tmatricula matri
					    inner join segu.tusuario usu1 on usu1.id_usuario = matri.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = matri.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_matricula_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
