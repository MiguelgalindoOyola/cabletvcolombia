<?php

class ordenesController extends Controller {

    public function __construct() {
        parent::__construct("ordenes");
    }

    /// actualiza los estados de las ordenes a finalizadas 
    public function Actualizaestadosreconexion() {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');

        $sql1 = $data->RECONEXIONCONTRATO();
        $sql2 = $data->Guardar_valor_tipo_servicio_factura_RECONECION();
        if ($sql1) {
            Session::set('mensaje', 'Reconexion Exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('ordenes/ordenes');
    }

    /// actualiza los estados de las ordenes a finalizadas 
//    public function UPDATEFINALIZARORDENVARIAS() {
//        Session::acceso("General");
//        $data = $this->loadModel('ordenes');
//        $sql2 = $data->SUSPENDER_CONTRATO_FINALIZAR_ORDEN();
//        IF ($_POST['TXTNUMFACTURASUSPENDIDA'] > 0) {
//            $sql1 = $data->MODIFIRAR_ESTADO_FACTURA_SUSPENDIDA();
//        }
//
//
//
//        if ($sql) {
//            Session::set('mensaje', 'Factura En Pausa');
//            Session::set('tipomensaje', 'alert-success');
//        }if ($sql2) {
//            Session::set('mensaje', 'Contrato Suspendido Correctamente');
//            Session::set('tipomensaje', 'alert-success');
//        } else {
//
//            Session::set('mensaje', 'error al guardar');
//            Session::set('tipomensaje', 'alert-danger');
//        }
//        $this->redireccionar('ordenes/ordenes');
//    }
    public function UPDATEFINALIZARORDENVARIAS() {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');

        // Se ejecuta la función para suspender el contrato y finalizar la orden
        $sql2 = $data->SUSPENDER_CONTRATO_FINALIZAR_ORDEN();

        // Se verifica si se envió el campo TXTNUMFACTURASUSPENDIDA y se modifica el estado de la factura si es necesario
        if (!empty($_POST['TXTNUMFACTURASUSPENDIDA'])) {
            $sql1 = $data->MODIFICAR_ESTADO_FACTURA_SUSPENDIDA();
        }

        if ($sql1) {
            Session::set('mensaje', 'Factura En Pausa');
            Session::set('tipomensaje', 'alert-success');
        }

        if ($sql2) {
            Session::set('mensaje', 'Contrato Suspendido Correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }

        $this->redireccionar('ordenes/ordenes');
    }

///// PAGINA PRINCIPAL DE ORDENES
    public function ordenes() {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        $this->_view->accion = 'Ordenes por Ejecutar';
        $this->_view->title = "Ordenes por Ejecutar";
        $this->_view->modulo = "ordenes";
        $this->_view->metodo = "Ordenes por Ejecutar";
        $this->_view->ConsultaOrdenesPrincipal = $data->Ordenes_instalaciones();
        $this->_view->consulta_servicio_por_contrato = $data->consulta_servicio_por_contrato();
        $this->_view->renderizar('ordenes', 'cangrejo');
    }

    /// vista del formulario de la orden por ejecutar INSTALACION
    public function FinalizarOrden($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        if ($argum) {
            $this->_view->accion = 'Informacion Detallada Orden de Instalacion';
            $this->_view->datos2 = $data->Consulta_Servicio_Instalacion();
            $this->_view->datos = $data->Consulta_finalizar_orden($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos2 = array();
        }
        $this->_view->renderizar('formFinalizar', 'blank');
    }

    /// vista del formulario de la orden por ejecutar varias
    public function FormFinalizarOrdenesVarias($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        if ($argum) {
            $this->_view->accion = 'Informacion Detallada Orden ha Ejecutar';
            $this->_view->datos2 = $data->Consulta_Servicio_Instalacion();
            $this->_view->datos = $data->Consulta_finalizar_orden($argum);
            $this->_view->fac_mora = $data->Consulta_Fctura_en_mora($argum);
            $this->_view->consulta_servicio_por_contrato = $data->consulta_servicio_por_contrato();
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos2 = array();
        }
        $this->_view->renderizar('fromgeneral', 'blank');
    }

    /// vista del formulario de la orden por RECONEXION
    public function fromreconexion($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        if ($argum) {
            $this->_view->accion = 'Informacion Detallada Orden ha Ejecutar';
            $this->_view->datos2 = $data->Consulta_Servicio_Instalacion();
            $this->_view->datos = $data->Consulta_finalizar_orden($argum);
            $this->_view->fac_mora = $data->Consulta_Fctura_en_mora_reconexion($argum);
            $this->_view->consulta_servicio_por_contrato = $data->consulta_servicio_por_contrato();
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
            $this->_view->datos2 = array();
        }
        $this->_view->renderizar('fromreconexion', 'blank');
    }

    /// PAGINA DE ORDENES EJECUTADAS
    public function ordenesRealizadas() {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        $this->_view->accion = 'Ordenes Ejecutadas';
        $this->_view->title = "Ordenes Ejecutadas";
        $this->_view->modulo = "ordenes";
        $this->_view->metodo = "Ordenes Ejecutadas";
        $this->_view->consulta_servicio_por_contrato = $data->consulta_servicio_por_contrato();
        $this->_view->ConsultaOrdenesPrincipal = $data->Ordenes_Realizadas();
        $this->_view->renderizar('ordenes', 'cangrejo');
    }

    // vista de consulta de las ordenes ya ejecutadas
    public function Consulta_INSTALACION($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        if ($argum) {
            $this->_view->accion = 'Informacion Detallada Orden de Instalacion Ejecutada';
            $this->_view->datos = $data->Consultanovedadesinstalacion($argum);
            $this->_view->datos2 = $data->Consulta_Servicio_Instalacion();
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formConsultaOrden', 'blank');
    }

    public function UPDATEFINALIZARORDEN() {
        Session::acceso("General");
        $data = $this->loadModel('ordenes');
        $sql = $data->Insert_Activar_Contratos();
        $sql25 = $data->Guardar_valor_tipo_servicio_factura();
        echo $sql;

        if ($sql) {
            Session::set('mensaje', 'Contrato Formalizado Correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('ordenes/ordenes');
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
