<?php

class reportesController extends Controller {

//put your code here
    public function __construct() {
        parent::__construct("reportes");
    }

//PAGINA PRINCIPAL REPORTES PAGOS 
    public function inicioreportepagos() {
        Session::accesoEstricto(array('Citas', 'General'), true);

        $data = $this->loadModel('reportes');
        $this->_view->title = "Recaudos - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "Bienvenida";

           $this->_view->datosperiodos = $data->consulta_periodos_select();
        $this->_view->datospagos = $data->consulta_consolidado_ventas();
        $this->_view->datospagos1 = $data->consulta_consolidado_vencida();
        $this->_view->datospagos2 = $data->consulta_consolidado_PORPAGAR();


        $this->_view->renderizar('iniciorecaudo', 'cangrejo');
    }
    public function consultarecaudos() {
        Session::accesoEstricto(array('Citas', 'General'), true);

        $data = $this->loadModel('reportes');
        $this->_view->title = "Recaudos - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "Bienvenida";

           $this->_view->datosperiodos = $data->consulta_periodos_select();
        $this->_view->datospagos = $data->consulta_consolidado_ventas1();
        $this->_view->datospagos1 = $data->consulta_consolidado_vencida1();
        $this->_view->datospagos2 = $data->consulta_consolidado_PORPAGAR1();


        $this->_view->renderizar('iniciorecaudo', 'cangrejo');
    }
    
    public function consultaperiodosboton($argum = false) {
        Session::accesoEstricto(array('Citas', 'General'), true);

        $data = $this->loadModel('reportes');
        $this->_view->title = "Recaudos - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->datosperiodos = $data->consulta_periodos_select();
         $this->_view->datosrecaudo = $data->consulta_tabla_recaudos($argum);
        $this->_view->datospagos = $data->consulta_consolidado_ventas();
        $this->_view->datospagos1 = $data->consulta_consolidado_vencida();
        $this->_view->datospagos2 = $data->consulta_consolidado_PORPAGAR();


        $this->_view->renderizar('reportebotonconsulta', 'blank');
    }

    ///// PAGINA PRINCIPAL DE SUSPENDIDOS
    public function iniciosuspendidos() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
        $this->_view->accion = 'Ordenes por Ejecutar';
        $this->_view->title = "Ordenes por Ejecutar";
        $this->_view->modulo = "ordenes";
        $this->_view->metodo = "Ordenes por Ejecutar";
        $this->_view->datos = $data->Consultatablasuspendidos();
        $this->_view->cantidadSuspendidos = $data->consulta_cantidad_suspendidos();
        $this->_view->renderizar('iniciosuspendido', 'cangrejo');
    }

    //reporte SUSPENDIDOS PDF
    public function reportesuspendidospdf() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->Consultatablasuspendidos();
        $this->_view->datosbarrio = $data->consulta_barrios();

        $this->_view->renderizar('suspendidospdf', 'blank');
    }

    public function accionactivar($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('reportes');

        $sql = $data->ordenactivarcontrato($argum);
        ;
//        $sql = $data->generarfacturacion2();
        $consulta = print_r($sql);
        if ($sql) {
            Session::set('mensaje', 'Orden Generada con Exito ');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', print_r($sql));
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('reportes/iniciosuspendidos');
    }

//reporte morosos
    public function reportemorosos() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->ConsultaMorosos();
        $this->_view->datosbarrio = $data->consulta_barrios();

        $this->_view->renderizar('morosospdf', 'blank');
    }

    public function iniciomorosos() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->ConsultaMorosos();
        $this->_view->cantidadmorosos = $data->consulta_cantidad_morosos();

        $this->_view->renderizar('inicioMorosos', 'cangrejo');
    }
 public function iniciomorosotabla() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
     
        $this->_view->datos = $data->ConsultaMorosostabla();

        $this->_view->renderizar('tablatodosusuarios', 'blank');
    }
    public function corte($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('reportes');

        if ($argum) {
            $this->_view->accion = 'Generar Orden de Corte';
            $this->_view->datos = $data->ConsultaInfCorte($argum);
            $this->_view->datosServicios = $data->ConsultaServicioDesconexion();
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos1 = array();
        }

        $this->_view->renderizar('corte', 'blank');
    }

    public function GuardarOrdenCorte() {
        Session::acceso("General");
        $data = $this->loadModel('reportes');
        $sql = $data->guardarordencorte();
//        $sql = $data->generarfacturacion2();

        if ($sql) {
            Session::set('mensaje', 'Orden Generada con Exito ');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar ');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('reportes/iniciomorosos');
    }

}
