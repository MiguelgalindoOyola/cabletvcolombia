
<?php

class parametrosController extends Controller {

//put your code here
    public function __construct() {
        parent::__construct("parametros");
    }

//FUNCIONES PARAMETROS -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//INICIO BARRIOS--------------------------------------------------------------------------------------------------------------------------------------------
    public function barrios() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $this->_view->accion = 'Agregar Barrio';
        $this->_view->title = "Parametros - Barrios";
        $this->_view->modulo = "Parametros";
        $this->_view->metodo = "Barrios";
        $this->_view->ConsultaulBarrios = $data->Consulta_ultimoBarrios();
        $this->_view->ConsultaBarrios = $data->Consulta_Barrios();
        $this->_view->renderizar('iniciobarrios', 'cangrejo');
    }

//GUARDAR BARRIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function GuardarBarrio() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $sql = $data->GuardarBarrios();

        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/barrios');
    }

//FUNCION CARGA FORMULARIO EDITAR BARRIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function FormularioBarrio($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        if ($argum) {
            $this->_view->accion = 'Editar Barrios';
            $this->_view->datos = $data->ConsultaBarrio($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('fromBarrios', 'blank');
    }

//FUNCION ACTUALIZAR / MODIFICAR BARRIOS  --------------------------------------------------------------------------------------------------------------------------------------------
    public function ActualizarBarrio() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $sql = $data->ActualizarBarrio1();
        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', print $a);

            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/barrios');
    }

//FUNCION ELIMINAR BARRIOS  --------------------------------------------------------------------------------------------------------------------------------------------
    function EliminarBarrio($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $sql = $data->EliminarBarrio($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al Eliminar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/barrios');
    }

//FUNCIONES SERVICIOS   --------------------------------------------------------------------------------------------------------------------------------------------  
//FUNCION CARGA INICIO SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function Servicios() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $this->_view->accion = 'Agregar Servicio';
        $this->_view->title = "Parametros - Servicios";
        $this->_view->modulo = "Parametros";
        $this->_view->metodo = "Servicios";
        $this->_view->ConsultaulServicio = $data->Consulta_ultimoServicio();
        $this->_view->ConsultaServicio = $data->Consulta_Servicios();
        $this->_view->renderizar('inicioservicios', 'cangrejo');
    }

//FUNCION GUARDA SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function GuardarServicios() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $sql = $data->GuardarServicios();

        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/servicios');
    }

    //FUNCION CARGA FORMULARIO EDITAR SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function FormularioServicios($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        if ($argum) {
            $this->_view->accion = 'Editar Servicios';
            $this->_view->datos = $data->ConsultaServicioEditar($argum);
        } else {
            $this->_view->accion = 'AGREGAR';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('fromservicios', 'blank');
    }

    //FUNCION ACTUALIZA /EDITA  SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function ActualizarServicio() {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $SQL1 = $data->MOVEDITServicios();
        $sql = $data->ActualizarServicios();

        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', print $sql);

            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/servicios');
    }

    //FUNCION ELIMINA UN SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    function EliminarServicios($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        $sql = $data->EliminarServicio($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al Eliminar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/Servicios');
    }

    //FUNCION CARGA FORMULARIO CONSULTA NOVEDADES SERVICIOS --------------------------------------------------------------------------------------------------------------------------------------------
    public function FormularioNovedades($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('parametros');
        if ($argum) {
            $this->_view->accion = 'Editar Servicios';
            $this->_view->datos2 = $data->ConsultaNovedades($argum);
        } else {
            $this->_view->accion = 'AGREGAR';
            $this->_view->datos2 = array();
        }
        $this->_view->renderizar('novedadess', 'blank');
    }

//    public function formularioBarrios($argum = false) {
//        Session::acceso("General");
//        $data = $this->loadModel('parametros');
//        if ($argum) {
//            $this->_view->ConsultaBarrios = $data->Consulta_Barrios();
//            $this->_view->accion = 'Editar Barrios';
//            $this->_view->datos = $data->ConsultaBarrio($argum);
//        } else {
//            $this->_view->accion = 'Agregar Barrios';
//            $this->_view->datos = array();
//        }
//        $this->_view->renderizar('iniciobarrios', 'blank');
//    }
//    public function bajacategoria($argum = false) {
//        Session::acceso("General");
//        $data = $this->loadModel('administracion');
//        $sql = $data->bajacategoria($argum);
//        if ($sql) {
//            Session::set('mensaje', 'Registro eliminado correctamente');
//            Session::set('tipomensaje', 'alert-success');
//        } else {
//            Session::set('mensaje', 'Error al guardar registro');
//            Session::set('tipomensaje', 'alert-danger');
//        }
//        $this->redireccionar('administracion/categorias');
//    }
//
//    public function provee1dores() {
//        Session::acceso("General");
//        $data = $this->loadModel('administracion');
//        $this->_view->title = "Administracion - Proveedores";
//        $this->_view->modulo = "Administracion";
//        $this->_view->metodo = "Proveedores";
//        $this->_view->datosproveedores = $data->listaProveedores();
//        $this->_view->renderizar('proveedores', 'cangrejo');
//    }

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
