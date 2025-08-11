/***********************************I-DEP-JRR-SIAT-0-16/01/2019******************************************/

select pxp.f_insert_testructura_gui ('SIAT', 'SISTEMA');
select pxp.f_insert_testructura_gui ('SIASINC', 'SIAT');
select pxp.f_insert_testructura_gui ('SIAPROD', 'SIASINC');

/***********************************F-DEP-JRR-SIAT-0-16/01/2019******************************************/

/***********************************I-DEP-AVQ-SIAT-0-21/01/2019******************************************/

select pxp.f_insert_testructura_gui ('SERSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('EVESIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('PAISIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('MONSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('MODSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('MEPSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('TIDSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('MESSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('AMBSIA', 'SIASINC');
select pxp.f_insert_testructura_gui ('TIPEMSIA', 'SIASINC');

/***********************************F-DEP-AVQ-SIAT-0-21/01/2019******************************************/


/***********************************I-DEP-JMH-SIAT-0-05/02/2019******************************************/
select pxp.f_insert_testructura_gui ('CUF', 'SIAT');
select pxp.f_insert_testructura_gui ('CUIS', 'SIAT');
select pxp.f_insert_testructura_gui ('SIAT', 'SISTEMA');
select pxp.f_insert_testructura_gui ('SIASINC', 'SIAT');
select pxp.f_insert_testructura_gui ('SIAPROD', 'SIASINC');
/***********************************F-DEP-JMH-SIAT-0-05/02/2019******************************************/


/***********************************I-DEP-AVQ-SIAT-0-25/02/2019******************************************/
select pxp.f_insert_testructura_gui ('MOTANU', 'SIASINC');
/***********************************F-DEP-AVQ-SIAT-0-25/02/2019******************************************/


/***********************************I-DEP-HPG-SIAT-0-14/03/2019******************************************/
select pxp.f_insert_testructura_gui ('DIRSIATREP', 'SIAT');
select pxp.f_insert_testructura_gui ('SIATREP', 'DIRSIATREP');
/***********************************F-DEP-HPG-SIAT-0-14/03/2019******************************************/

/***********************************I-DEP-FPT-SIAT-0-14/03/2019******************************************/

select pxp.f_insert_testructura_gui ('SIAREP', 'SIAT');
select pxp.f_insert_testructura_gui ('SIAEVESIG', 'SIAREP');
select pxp.f_insert_testructura_gui ('SADSIS', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIADFISEMI', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIADFISANU', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIAESENDOCFIS', 'SIAREP');
/***********************************F-DEP-FPT-SIAT-0-14/03/2019******************************************/
/***********************************I-DEP-FPT-SIAT-0-20/05/2019******************************************/

select pxp.f_insert_testructura_gui ('SIAREP', 'SIAT');
select pxp.f_insert_testructura_gui ('SIAEVESIG', 'SIAREP');
select pxp.f_insert_testructura_gui ('SADSIS', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIADFISEMI', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIADFISANU', 'SIAREP');
select pxp.f_insert_testructura_gui ('SIAESENDOCFIS', 'SIAREP');
/***********************************F-DEP-FPT-SIAT-0-20/05/2019******************************************/
