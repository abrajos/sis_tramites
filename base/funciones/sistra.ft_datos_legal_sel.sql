CREATE OR REPLACE FUNCTION "sistra"."ft_datos_legal_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_datos_legal_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tdatos_legal'
 AUTOR: 		 (admin)
 FECHA:	        15-09-2025 18:37:32
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				15-09-2025 18:37:32								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tdatos_legal'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_datos_legal_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_datleg_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-09-2025 18:37:32
	***********************************/

	if(p_transaccion='SISTRA_datleg_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						datleg.id_datos_legal,
						datleg.aprobacion,
						datleg.aux,
						datleg.estado_reg,
						datleg.area_agro,
						datleg.cod_catastral,
						datleg.kami,
						datleg.ddrr_registro,
						datleg.id_usuario_reg,
						datleg.usuario_ai,
						datleg.fecha_reg,
						datleg.id_usuario_ai,
						datleg.fecha_mod,
						datleg.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tdatos_legal datleg
						inner join segu.tusuario usu1 on usu1.id_usuario = datleg.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = datleg.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_datleg_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-09-2025 18:37:32
	***********************************/

	elsif(p_transaccion='SISTRA_datleg_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_datos_legal)
					    from sistra.tdatos_legal datleg
					    inner join segu.tusuario usu1 on usu1.id_usuario = datleg.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = datleg.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_datos_legal_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
