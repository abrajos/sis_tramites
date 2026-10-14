CREATE OR REPLACE FUNCTION "sistra"."ft_plantilla_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_plantilla_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tplantilla'
 AUTOR: 		 (admin)
 FECHA:	        25-09-2026 20:16:21
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				25-09-2026 20:16:21								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tplantilla'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_plantilla_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_planti_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		25-09-2026 20:16:21
	***********************************/

	if(p_transaccion='SISTRA_planti_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						planti.id_plantilla,
						planti.nombre,
						planti.auxiliar,
						planti.parrafos,
						planti.estado_reg,
						planti.id_usuario_ai,
						planti.id_usuario_reg,
						planti.fecha_reg,
						planti.usuario_ai,
						planti.fecha_mod,
						planti.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tplantilla planti
						inner join segu.tusuario usu1 on usu1.id_usuario = planti.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = planti.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_planti_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		25-09-2026 20:16:21
	***********************************/

	elsif(p_transaccion='SISTRA_planti_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_plantilla)
					    from sistra.tplantilla planti
					    inner join segu.tusuario usu1 on usu1.id_usuario = planti.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = planti.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_plantilla_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
