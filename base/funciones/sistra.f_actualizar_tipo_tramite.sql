--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sistra.f_actualizar_tipo_tramite (
)
RETURNS boolean AS
$body$
DECLARE
 
v_registros record;
v_id_nivel_organizacional	integer;
v_id_uo	integer;
v_id_uo_padre	integer;
v_id_persona 	integer;
v_genero				varchar;
v_reg_cargo				record; 
v_id_tipo_tramite				integer;
v_estado_civil			varchar;
v_id_tramite_detalle		integer;
v_id_tramite	integer;
v_password				varchar;
v_id_clasificador		integer;
_SEMILLA				varchar;
v_cuenta_usuario		varchar;
v_aux1			varchar;
v_aux2			varchar;
v_pass varchar;	
BEGIN
 
    --recuperar clasificador
        
    _SEMILLA = '+_)(*&^%$#@!@TERPODO';
   
   --listar funcionarios 
   
   FOR v_registros in  (
                         select tradet.id_tramite, tradet.id_tramite_detalle from sistra.ttramite_detalle tradet where tradet.id_tramite_detalle != 1) LOOP
                             
               SELECT trami.id_tramite, trami.id_tipo_tramite, tradet.id_tramite_detalle into v_id_tramite, v_id_tipo_tramite, v_id_tramite_detalle
                from sistra.ttramite trami
                inner join sistra.ttramite_detalle tradet on tradet.id_tramite=trami.id_tramite
                where trami.id_tramite =  v_registros.id_tramite;                         
                 --si el usuario existe no hacemos nada
                 update sistra.ttramite_detalle SET
                 id_tipo_tramite=v_id_tipo_tramite
                 where id_tramite_detalle = v_registros.id_tramite_detalle;
                         
    
   END LOOP;
   
    
  
  

RETURN TRUE;
  

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;