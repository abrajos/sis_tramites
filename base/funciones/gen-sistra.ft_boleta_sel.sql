CREATE OR REPLACE FUNCTION "sistra"."ft_boleta_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_boleta_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tboleta'
 AUTOR: 		 (admin)
 FECHA:	        22-04-2025 06:17:41
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				22-04-2025 06:17:41								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tboleta'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_boleta_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_boleta_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		22-04-2025 06:17:41
	***********************************/

	if(p_transaccion='SISTRA_boleta_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						boleta.id_boleta,
						boleta.fecha_pago,
						boleta.estado_reg,
						boleta.nro_liquidacion,
						boleta.monto,
						boleta.comp_pago,
						boleta.id_tramite,
						boleta.expediente,
						boleta.id_usuario_reg,
						boleta.usuario_ai,
						boleta.fecha_reg,
						boleta.id_usuario_ai,
						boleta.id_usuario_mod,
						boleta.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tboleta boleta
						inner join segu.tusuario usu1 on usu1.id_usuario = boleta.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = boleta.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_boleta_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		22-04-2025 06:17:41
	***********************************/

	elsif(p_transaccion='SISTRA_boleta_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_boleta)
					    from sistra.tboleta boleta
					    inner join segu.tusuario usu1 on usu1.id_usuario = boleta.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = boleta.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_boleta_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
