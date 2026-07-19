CREATE OR REPLACE FUNCTION "sistra"."ft_boleta_liquida_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Tramites
 FUNCION: 		sistra.ft_boleta_liquida_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tboleta_liquida'
 AUTOR: 		 (admin)
 FECHA:	        23-09-2025 02:24:49
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				23-09-2025 02:24:49								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sistra.tboleta_liquida'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sistra.ft_boleta_liquida_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SISTRA_bolliq_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		23-09-2025 02:24:49
	***********************************/

	if(p_transaccion='SISTRA_bolliq_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						bolliq.id_boleta_liquida,
						bolliq.plano_bs,
						bolliq.division_m,
						bolliq.fecha_emision,
						bolliq.anexion_bs,
						bolliq.monto_literal,
						bolliq.plano_cons_bs,
						bolliq.id_tramite,
						bolliq.concepto_a_m,
						bolliq.nombre_concepto_b,
						bolliq.concepto_a_bs,
						bolliq.plano_m,
						bolliq.plano_cons_m,
						bolliq.anexion_m,
						bolliq.estado_reg,
						bolliq.linea_nivel_m,
						bolliq.division_bs,
						bolliq.concepto_b_bs,
						bolliq.linea_nivel_bs,
						bolliq.avance_m,
						bolliq.avance_bs,
						bolliq.nombre_concepto_a,
						bolliq.cite_tramite,
						bolliq.concepto_b_m,
						bolliq.plano_verja_m,
						bolliq.total_bs,
						bolliq.total_redon,
						bolliq.nro_boleta,
						bolliq.id_tramite_detalle,
						bolliq.plano_verja_bs,
						bolliq.id_usuario_reg,
						bolliq.fecha_reg,
						bolliq.usuario_ai,
						bolliq.id_usuario_ai,
						bolliq.fecha_mod,
						bolliq.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sistra.tboleta_liquida bolliq
						inner join segu.tusuario usu1 on usu1.id_usuario = bolliq.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = bolliq.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SISTRA_bolliq_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		23-09-2025 02:24:49
	***********************************/

	elsif(p_transaccion='SISTRA_bolliq_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_boleta_liquida)
					    from sistra.tboleta_liquida bolliq
					    inner join segu.tusuario usu1 on usu1.id_usuario = bolliq.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = bolliq.id_usuario_mod
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
ALTER FUNCTION "sistra"."ft_boleta_liquida_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
