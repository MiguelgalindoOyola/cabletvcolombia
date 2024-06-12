
<?php

class facturacionController extends Controller {

//put your code here

    public function __construct() {
        parent::__construct("facturacion");
    }
     
      public function usuariosconsaldo() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->Consultausuariosconsaldo();
        $this->_view->datosbarrio = $data->consulta_barrios2();
        $this->_view->datosfacturamaestro = $data->ConsultaFacturaUltimaPorContrato();

        $this->_view->renderizar('listaconsaldos', 'blank');
    }
      public function usuariosconsaldoactivo() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->Consultausuariosconsaldoactivo();
        $this->_view->datosbarrio = $data->consulta_barrios2();
        $this->_view->datosfacturamaestro = $data->ConsultaFacturaUltimaPorContrato();
        $this->_view->renderizar('listaconsaldos', 'blank');
    }

    //reporte usuarios sin saldos 
    public function usuariossinsaldo() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->Consultausuarionsinsado();
        $this->_view->datosbarrio = $data->consulta_barrios2();
        $this->_view->datosfacturamaestro = $data->ConsultaFacturaUltimaPorContrato();
        $this->_view->renderizar('listasinsaldo', 'blank');
    }

    //reporte usuarios sin saldos 
    public function usuariossinsaldoactivo() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->title = "reportes - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->metodo = "reportes";
        $this->_view->datos = $data->Consultausuarionsinsadoactivo();
        $this->_view->datosbarrio = $data->consulta_barrios2();

        $this->_view->renderizar('listasinsaldo', 'blank');
    }
 
    public function pagos() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Listados de Pagos';
        $this->_view->title = "facturacion - Pagos";
        $this->_view->modulo = "facturacion";
        $this->_view->metodo = "Pagos";

        $this->_view->Consulta_Facturas_PorPagar = $data->Consulta_Cantidad_Facturas_PORPAGAR();

        $this->_view->renderizar('iniciofacturasporpagar', 'cangrejo');
    }
    
    //   carga  modal pagar facturas 
    public function pagarfactura($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        
        if ($argum) {
            $this->_view->accion = 'Pagar Factura';
//            $this->_view->title = "facturacion - suscriptores";
//            $this->_view->modulo = "facturacion";
//            $this->_view->metodo = "";
            $this->_view->datos = $data->ConstultaFacturaPorpagar($argum);
            $this->_view->datos1 = $data->ConstultaFacturaDetallePorpagar($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos1 = array();
        }

        $this->_view->renderizar('modalpagafactura', 'blank');
    }
    

    
    // NUEVAS MODIFICACIONES 
    
    //   carga  modal abono a la  facturas 
    public function abonarfactura($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        
        if ($argum) {
            $this->_view->accion = 'Abono Factura';
//            $this->_view->title = "facturacion - suscriptores";
//            $this->_view->modulo = "facturacion";
//            $this->_view->metodo = "";
            $this->_view->datos = $data->ConstultaFacturaPorpagar($argum);
            $this->_view->datos1 = $data->ConstultaFacturaDetallePorpagar($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos1 = array();
        }

        $this->_view->renderizar('modalabonofactura', 'blank');
    }
    //    guarda abono a la factura pagada
    public function GuardarabonoFactura() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');

        $sql = $data->GuardarabonoFacturas();
        $sql2 = $data->GuardarPagoCuentaEfectivo();
        $sql2 = $data->creafacturaabono();


        if ($sql) {
            Session::set('mensaje', 'Abono Registrado');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar ');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('facturacion/pagos');
    }
    
    
    
    
    
    //TERMINAN LAS MODIFICACIONES 

//carga pagina principal pagos
    

//   carga  modal EDITAR FACTURA 
    public function Editarfactura($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        
        if ($argum) {
            $this->_view->accion = 'Editar Factura';
//            $this->_view->title = "facturacion - suscriptores";
//            $this->_view->modulo = "facturacion";
//            $this->_view->metodo = "";
            $this->_view->datos = $data->ConstultaFacturaPorpagar($argum);
            $this->_view->datos1 = $data->ConstultaFacturaDetallePorpagar($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos1 = array();
        }

        $this->_view->renderizar('modaleditafactura', 'blank');
    }
    
    public function generarDomPDF() {

        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Agregar suscriptores';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "suscriptores";
        $this->_view->metodo = "Facturacion";
        $this->_view->ConsultaU = $data->Cconsultadatospersonales();
        $this->_view->ConsultaBarrios = $data->Consulta_Barrios();
        $this->_view->ConsultaClientesTab = $data->ConsultaClientesEstadosPrincipal();
        $this->_view->ConsultaClientesTab1 = $data->ConsultaClientesEstadosPrincipal1();
        $this->_view->renderizar('reportes2', 'blank');
    }

    public function GENERAFACTURAS() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Pagar Factura';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "facturacion";
        $this->_view->metodo = "";
//        $this->_view->datos = $data->ConstultaFacturaPorpagarPDF();
//        $this->_view->datos1 = $data->ConstultaFacturaDetallePorpagarPDF();

        $this->_view->renderizar('factura', 'facturacion');
    }

//    guarda factura pagada
    public function GuardarPagoFactura() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');

        $sql = $data->GuardarPagoFacturas();
        $sql2 = $data->GuardarPagoCuentaEfectivo();


        if ($sql) {
            Session::set('mensaje', 'Pago Registrado');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar - Cliente ya ha sido Registrado');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('facturacion/pagos');
    }

    public function suscriptores() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Agregar suscriptores';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "suscriptores";
        $this->_view->metodo = "Facturacion";
        $this->_view->ConsultaU = $data->Cconsultadatospersonales();
        $this->_view->ConsultaBarrios = $data->Consulta_Barrios();
        $this->_view->ConsultaClientesTab = $data->ConsultaClientesEstadosPrincipal();
        $this->_view->ConsultaClientesTab1 = $data->ConsultaClientesEstadosPrincipal1();

        $this->_view->renderizar('iniciosuscriptores', 'cangrejo');
    }

    public function Formulariousuario($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');

        if ($argum) {
            $this->_view->accion = 'Agregar suscriptores';
            $this->_view->title = "facturacion - suscriptores";
            $this->_view->modulo = "facturacion";
            $this->_view->metodo = "clientes";
            $this->_view->accion = 'Formalizar Contrato';
            $this->_view->UltCONTRATO = $data->Consulta_ultimocontrato();
            $this->_view->Servicio = $data->Consulta_Servicios();
            $this->_view->datos = $data->consultaCliente($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->UltCONTRATO = array();
        }

        $this->_view->renderizar('fromclientes', 'blank');
    }

//   GENERAR FACTURAS PDF

    public function generarPDF($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $dato=$argum;
        if ($argum) {
            $this->_view->datosfacturamaestro = $data->ConstultaFacturaPorpagarPDF($argum);
           $this->_view->datosfacturadetalle = $data->ConstultaFacturaDetallePorpagarPDF($dato);
            
        } else {
            $this->_view->datosfacturamaestro = array();
        }
        $this->_view->renderizar('factura', 'blank');
    }

    //   GENERAR FACTURAS UN USUARIO PDF

    public function generarUNUSUARIOPDF($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $dato=$argum;
        if ($argum) {
            $this->_view->datosfacturamaestro = $data->ConstultaFacturaPorpagarUnUsuarioPDF($argum);
           $this->_view->datosfacturadetalle = $data->ConstultaFacturaDetallePorpagarUnUsuarioPDF($dato);
            
        } else {
            $this->_view->datosfacturamaestro = array();
        }
        $this->_view->renderizar('facturaUnidad', 'blank');
    }

    public function FormularioServicios($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        if ($argum) {
            
        } else {
            $this->_view->accion = 'AGREGAR';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('fromservicios', 'blank');
    }

    public function GuardarContrato() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $sql = $data->Registrar_Contrato();
        $sql2 = $data->AsignarEstadoCliente();
        $sql3 = $data->RegistrarOrdenes();
//           $sql3 = $data->Registrar_Contratos();
        

        if ($sql) {
            Session::set('mensaje', 'Contrato Registrado Satisfactoriamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('facturacion/suscriptores');
    }

//FUNCION HABRE EL FORMULARIO PARA EL REGISTRO DEL CLIENTE
    public function FormularioCliente() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Registrar suscriptores';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "suscriptores";
        $this->_view->metodo = "Facturacion";
        $this->_view->ConsultaDatosBarrio = $data->consultaBarrios();
        $this->_view->ConsultaU = $data->Cconsultadatospersonales();
        $this->_view->renderizar('formDatosCliente', 'blank');
    }

//FUNCION PERMITE GUARDAR LOS DATOS INGRESADOS POR CLIENTES
    public function GuardarCliente() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $sql = $data->Registrar_Clientes();

        if ($sql) {
            Session::set('mensaje', 'Cliente Registrado Satisfactoriamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar - Cliente ya ha sido Registrado');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('facturacion/suscriptores');
    }

    public function FormularioBarrio($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        if ($argum) {
            $this->_view->accion = 'Datos Cliente';
            $this->_view->datos = $data->consultaCliente($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('fromclientes', 'blank');
    }

//FUNCION PERMITE HABRIR LA PAGINA PRINCIPAL DE FACTURACION -------------------------------------------------------------------------------------------------------
    public function facturacion() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Generar Facturacion';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "Facturacion";
        $this->_view->metodo = "Generar Facturacion";
        $this->_view->Conusulta_si_hay_facturas_activas = $data->consultacantidadfacturasactivas();
        $this->_view->Consulta_Facturas_Periodo_Actual = $data->Consulta_Cantidad_Facturas_Periodo_Actual();
        $this->_view->ConsultaPeriodosFacturados = $data->consultaMesFacturado();
        $this->_view->Consulta_Facturas_PorPagar_PorBarrios = $data->Consulta_Cantidad_Facturas_PORPAGAR_PORBARRIOS();
        $this->_view->renderizar('iniciofacturacion', 'cangrejo');
    }

//FUNCION QUE PERMITE CERRAR EL CICLO DE LA FACTURACION PARA INICIAR UN NUEVO PERIODO (actualiza el estado de la facturacion por pagar a vencido)--------------------------
    public function CerrarCiclo() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $this->_view->accion = 'Generar Facturacion';
        $this->_view->title = "facturacion - suscriptores";
        $this->_view->modulo = "Generar Facturacion";
        $this->_view->metodo = "Generar Facturacion";
        $sql = $data->CerrarCiclo();
        $this->_view->Conusulta_si_hay_facturas_activas = $data->consultacantidadfacturasactivas();
        $this->_view->Consulta_Facturas_Periodo_Actual = $data->Consulta_Cantidad_Facturas_Periodo_Actual();
        $this->_view->ConsultaPeriodosFacturados = $data->consultaMesFacturado();
        $this->_view->Consulta_Facturas_PorPagar_PorBarrios = $data->Consulta_Cantidad_Facturas_PORPAGAR_PORBARRIOS();
        $this->_view->renderizar('iniciofacturacion', 'blank');
    }

//FUNCION QUE GENERA LA FACTURACION POR EL PERIODO ESTABLECIDO -------------------------------------------------------------------------------------------------------
    public function GenerarFacturas() {
        Session::acceso("General");
        $data = $this->loadModel('facturacion');
        $sql = $data->generarfacturacion();
//        $sql = $data->generarfacturacion2();

        if ($sql) {
            Session::set('mensaje', 'Se Genero la cantidad ');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar - Cliente ya ha sido Registrado');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('facturacion/facturacion');
    }

    public function index() {
        $this->redireccionar('error/access/404');
    }

    public function sendnotification($tokens, $message) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = "AAAARVJW_-0:APA91bGHO3S2DxCa3Jf9zo8PV0d76lI0Fmq3lgQpsAy0kJMuL6-NmmJLw7ymhfaopYanBuV2X3Pmytexx5rQc9yaouFVYB-bf-rdIr2yW-fGPW63crHI3bgXi5bZie3r2qcReV6xeEi5";

        $title = "CardioApp";

        $notification = array(
            'body' => $message,
            'title' => $title,
            'sound' => "defaultSoundUri",
            'icon' => "ic_notification");

        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $notification);

        $headers = array(
            'Authorization:key=' . $server_key,
            'Content-Type: application/json');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
