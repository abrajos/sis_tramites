CREATE OR REPLACE FUNCTION "sistra"."ft_correlativo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_correlativo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tcorrelativo'
 AUTOR: 		 (admin)
 FECHA:	        26-08-2025 21:14:57
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				26-08-2025 21:14:57								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tcorrelativo'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_correlativo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_CORREL_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		26-08-2025 21:14:57
	***********************************/

	if(p_transaccion='SISTRA_CORREL_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						correl.id_correlativo,
						correl.estado_reg,
						correl.sigla,
						correl.tipo,
						correl.cargo,
						correl.num_siguiente,
						correl.num_actual,
						correl.id_usuario_reg,
						correl.fecha_reg,
						correl.usuario_ai,
						correl.id_usuario_ai,
						correl.id_usuario_mod,
						correl.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tcorrelativo correl
						inner join segu.tusuario usu1 on usu1.id_usuario = correl.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = correl.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_CORREL_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		26-08-2025 21:14:57
	***********************************/

	elsif(p_transaccion='SISTRA_CORREL_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_correlativo)
					    from sistra.tcorrelativo correl
					    inner join segu.tusuario usu1 on usu1.id_usuario = correl.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = correl.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_correlativo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
