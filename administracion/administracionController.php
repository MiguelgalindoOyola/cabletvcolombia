
<?php

class administracionController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("administracion");
    }

    public function bienvenido() {
        Session::accesoEstricto(array('Citas', 'General'), true);
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Inicio";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Bienvenida";
        $this->_view->CAJAMES = $data->CONSULTAVENTASMES();
        $this->_view->CAJAGENERAL = $data->CONSULTA_CAJAGENERAL();
        $this->_view->datosMoroso = $data->Consulta_Morosos();
        $this->_view->datosSuspendidos = $data->CONSULTA_SUSPENDIDOS();
        $this->_view->datospagos = $data->consulta_consolidado_ventas();
        $this->_view->datospagos1 = $data->consulta_consolidado_vencida();
        $this->_view->datospagos2 = $data->consulta_consolidado_PORPAGAR();
        $this->_view->datosActivos = $data->Consulta_Activos();
        $this->_view->ordenespendiente = $data->Consulta_Oden_Pendientes();
        
        $this->_view->datostotal = $data->Consulta_total();
        $this->_view->datosPendiente = $data->Consulta_pendiente();

        $this->_view->renderizar('bienvenido', 'cangrejo');
    }

    public function index() {
        $this->redireccionar('error/access/404');
    }

    public function proveedores() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Proveedores";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Proveedores";
        $this->_view->datosproveedores = $data->listaProveedores();
        $this->_view->renderizar('proveedores', 'cangrejo');
    }

    public function clientes() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Clientes";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Clientes";
        $this->_view->datosproveedores = $data->listaclientes();
        $this->_view->renderizar('listaclientes', 'cangrejo');
    }

    public function formularioproveedores($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        if ($argum) {
            $this->_view->accion = 'Editar Proveedores';
            $this->_view->datos = $data->consultaunproveedor($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formularioproveedores', 'blank');
    }

    public function formularioclientes($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        if ($argum) {
            $this->_view->accion = 'Editar Clientes';
            $this->_view->datos = $data->consultauncliente($argum);
        } else {
            $this->_view->accion = 'Agregar Clientes';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formularioclientes', 'blank');
    }

    public function guardarcliente() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');

        $sql = $data->setclientes();
        echo $sql;

        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/clientes');
    }

    public function guardarproveedor() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');

        $sql = $data->setproveedores();
        echo $sql;

        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        if (isset($_FILES['txtCertificado'])) {
            for ($i = 0; $i < count($_FILES['txtCertificado']['name']); $i++) {
                if ($_FILES['txtCertificado']['error'][$i] != 4) {
                    $nombrearchivo = htmlentities($_FILES['txtCertificado']['name'][$i]);
                    $destino = ROOT . 'public' . DS . 'citasLayout' . DS . 'files' . DS . html_entity_decode($nombrearchivo);
                    move_uploaded_file($_FILES['txtCertificado']['tmp_name'][$i], $destino);
                }
            }
        }
        $this->redireccionar('administracion/proveedores');
    }

    function bajacliente($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajaproveedor($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/clientes');
    }

    public function bajaproveedor($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajaproveedor($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/proveedores');
    }

    ///////////////////////////////////////////////////////////////////////
    public function categorias() {
        Session::acceso("General");
        $this->_view->accion = 'Agregar Categorias';
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Proveedores";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Categorias";
        $this->_view->datoscategorias = $data->listacategorias();
        $this->_view->renderizar('categorias', 'cangrejo');
        $this->_view->datos = array();
    }

    public function guardarcategoria() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->setcategorias();
        echo $sql;
        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'error al guardar');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/categorias');
    }

    public function formulariocategorias($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        if ($argum) {
            $this->_view->datoscategorias = $data->listacategorias();
            $this->_view->accion = 'Editar Categorias';
            $this->_view->datos = $data->consultauncategoria($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('categorias', 'blank');
    }

    public function bajacategoria($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajacategoria($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/categorias');
    }

    ///productos

    public function productos() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Productos";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Productos";
        $this->_view->datosproducto = $data->listaproductos();
        $this->_view->renderizar('listaproductos', 'cangrejo');
    }

    public function formularioproductos($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->datoscatedorias = $data->listacategorias();
        if ($argum) {
            $this->_view->accion = 'Editar Productos';
            $this->_view->datos = $data->consultauncliente($argum);
        } else {
            $this->_view->accion = 'Agregar Productos';
            $this->_view->datoscatedorias = $data->listacategorias();
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formularioproductos', 'blank');
    }

    public function guardarProducto() {
        Session::acceso("General");
        if ($_POST) {
            $data = $this->loadModel('administracion');
            $count = $data->insertarProductos();
            if ($count > 0) {
                Session::set('mensaje', 'Registros guardados exitosamente');
                Session::set('tipomensaje', 'alert-success');
            } else {
                Session::set('mensaje', print_r($count));
                Session::set('tipomensaje', 'alert-danger');
            }
            $this->redireccionar('administracion/productos');
            exit();
        } else {
            Session::set('mensaje', 'No hay datos a guardar');
            Session::set('tipomensaje', 'alert-danger');
            $this->redireccionar('administracion/productos');
            exit();
        }
    }

    public function bajaproducto($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajaproducto($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/productos');
    }

    public function vercertificados() {
        $data = $this->loadModel('administracion');
        $this->_view->datos = $data->vercertificados();
        $this->_view->renderizar('vercertificados', 'blank');
    }

    public function vistaarchivos() {
        $this->_view->renderizar('certificados', 'blank');
    }

    public function generarreporte() {
        $data = $this->loadModel('administracion');
        $this->_view->citas = $data->listarcitasusuariosreporte();
        $this->_view->estado = $data->estadocitas();
        $this->_view->renderizar('genreporte', 'blank');
    }

    public function reportes() {
        Session::acceso("General");
        $this->_view->title = "Administracion - Reportes";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Reportes";
        $this->_view->renderizar('reportes', 'cangrejo');
    }

    public function setroles() {
        $data = $this->loadModel('administracion');
        $sql = $data->setrol();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/appusuarios');
    }

    public function formularioroles() {
        $data = $this->loadModel('administracion');
        $this->_view->select = false;
        if (isset($_POST['id'])) {
            $this->_view->datos = $data->onerol();
            $this->_view->accion = 'Editar Usuarios';
            $this->_view->select = true;
        } else {
            $this->_view->datos = array();
            $this->_view->accion = 'Agregar Usuarios';
        }
        $this->_view->renderizar('formularioroles', 'blank');
    }

    public function buscarcitas() {
        $data = $this->loadModel('administracion');
        $this->_view->citas = $data->filtracitas();
        $this->_view->renderizar('cargacitas', 'blank');
    }

    public function cancelarcita() {
        $data = $this->loadModel('administracion');
        $sql = $data->cancelarcita();
        if ($sql) {
            $response['response'] = 'Success';
            $response['mensaje'] = 'Cita cancelada correctamente';
            /* $token = $data->onetoken();
              $mensaje = 'Su cita ha sido cancelada';
              $res = $this->sendnotification($token, $mensaje); */
        } else {
            $response['response'] = 'Error';
            $response['mensaje'] = 'Error al cancelar la cita';
        }
        echo json_encode($response);
    }

    public function usuarios() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Usuarios";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Usuarios";
        $this->_view->usuarios = $data->listausuarios();
        $this->_view->renderizar('usuarios', 'cangrejo');
    }

    public function pqrsf() {
        if (Session::get('autenticado')) {
            $data = $this->loadModel('administracion');
            $this->_view->title = "Administracion - Pqrsf";
            $this->_view->modulo = "Administracion";
            $this->_view->metodo = "Pqrsf";
            $this->_view->pqrsf = $data->pqrsf();
            $this->_view->renderizar('pqrsf', 'cangrejo');
        } else {
            Session::acceso('');
        }
    }

    public function bajaespe($argum = false) {
        Session::acceso('General');
        $data = $this->loadModel('administracion');
        $sql = $data->bajasede($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/especialidades');
    }

    public function appusuarios() {
        Session::acceso('General');
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Usuarios App";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Usuarios Administracion";
        $this->_view->usuarios = $data->roles();
        $this->_view->renderizar('roles', 'cangrejo');
    }

    public function setespe() {
        Session::acceso('General');
        $data = $this->loadModel('administracion');
        $sql = $data->setespecialidad();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosas');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/especialidades');
    }

    public function formularioespe($argum = false) {
        Session::acceso('General');
        $data = $this->loadModel('administracion');
        if ($argum) {
            $this->_view->datos = $data->oneespecialidad($argum);
            $this->_view->accion = 'Editar Especialidades';
        } else {
            $this->_view->datos = array();
            $this->_view->accion = 'Agregar Especialidades';
        }
        $this->_view->renderizar('formularioespecialidades', 'blank');
    }

    public function especialidades() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Especialidades";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Especialidades";
        $this->_view->espe = $data->listarespecialidades();
        $this->_view->renderizar('especialidades', 'cangrejo');
    }

    public function bajasedes($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajasedes($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al eliminar el registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/sedes');
    }

    public function setsedes() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->setsede();
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al eliminar el registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/sedes');
    }

    public function formulariosedes($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        if ($argum) {
            $this->_view->accion = 'Editar Sedes';
            $this->_view->datos = $data->onesedes($argum);
        } else {
            $this->_view->accion = 'Agregar Sedes';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formulariosedes', 'blank');
    }

    public function sedes() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Sedes";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Sedes";
        $this->_view->sedes = $data->listasedes();
        $this->_view->renderizar('sedes', 'cangrejo');
    }

    public function bajamedicos($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->bajamedico($argum);
        if ($sql) {
            Session::set('mensaje', 'Registro eliminado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('administracion/medicos');
    }

    public function setmedico() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $sql = $data->setmedico();
        if ($sql) {
            Session::set('mensaje', 'Registro guardado exitosamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error al guardar registro');
            Session::set('tipomensaje', 'alert-danger');
        }
        if (isset($_FILES['txtCertificado'])) {
            for ($i = 0; $i < count($_FILES['txtCertificado']['name']); $i++) {
                if ($_FILES['txtCertificado']['error'][$i] != 4) {
                    $nombrearchivo = htmlentities($_FILES['txtCertificado']['name'][$i]);
                    $destino = ROOT . 'public' . DS . 'citasLayout' . DS . 'files' . DS . html_entity_decode($nombrearchivo);
                    move_uploaded_file($_FILES['txtCertificado']['tmp_name'][$i], $destino);
                }
            }
        }
        $this->redireccionar('administracion/medicos');
    }

    public function formulariomedicos($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->especialidad = $data->listarespecialidades();
        if ($argum) {
            $this->_view->accion = 'Editar Medicos';
            $this->_view->datos = $data->onemedico($argum);
        } else {
            $this->_view->accion = 'Agregar Medicos';
            $this->_view->datos = array();
        }
        $this->_view->renderizar('formulariomedicos', 'blank');
    }

    public function programarCita() {
        $data = $this->loadModel('administracion');
        $sql = $data->guardarProgramacion();
        if ($sql['response'] == 'Success') {
            /* $token = $data->onetoken();
              $mensaje = 'Su cita ha sido programada exitosamente';
              $res = $this->sendnotification($token, $mensaje); */
        }
        echo json_encode($sql);
    }

    public function medicos() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Administracion - Medicos";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Medicos";
        $this->_view->medicos = $data->listadoctores();
        $this->_view->renderizar('medicos', 'cangrejo');
    }

    public function cargamedicos($argum = false) {
        $data = $this->loadModel('administracion');
        $this->_view->doctores = $data->listardoctores($argum);
        $this->_view->renderizar('doctores', 'blank');
    }

    public function programarcitas($argum = false) {
        Session::accesoEstricto(array('Citas', 'General'), true);
        $data = $this->loadModel('administracion');
        $sql = $data->listarprogramado($argum);
        if (count($sql) > 0) {
            $this->_view->datos = $data->listarprogramado($argum);
            $this->_view->doctor = $data->onedoctor($sql[0]['pdoDoctor']);
        } else {
            $this->_view->datos = array(6);
        }
        $this->_view->codigo = $argum;
        $this->_view->especialidad = $data->listarespecialidades();
        $this->_view->sedes = $data->listarsedes();
        $this->_view->renderizar('programarcitas', 'blank');
    }

    public function citas() {
        Session::accesoEstricto(array('Citas', 'General'), true);
        $data = $this->loadModel('administracion');
        $this->_view->citas = $data->listarcitas();
        $this->_view->medicos = $data->listadoctores();
        $this->_view->usuarios = $data->usuarioscitas();
        $this->_view->title = "Administracion - Citas";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Citas";
        $this->_view->renderizar('citas', 'cangrejo');
    }

    public function cargarcitas() {
        Session::accesoEstricto(array('Citas', 'General'), true);
        $data = $this->loadModel('administracion');
        $this->_view->citas = $data->listarcitas();
        $this->_view->title = "Administracion - Citas";
        $this->_view->modulo = "Administracion";
        $this->_view->metodo = "Citas";
        $this->_view->renderizar('cargacitas', 'blank');
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

//    PARAMETROS ____________________________________________________________________________________________________________________________________________________________

    public function Parametrosbarrios() {
        Session::acceso("General");
        $data = $this->loadModel('administracion');
        $this->_view->title = "Parametros - Barrios";
        $this->_view->modulo = "administracion";
        $this->_view->metodo = "iniciobarrios";
        $this->_view->ConsultaBarrios = $data->listaproductos2();
        $this->_view->renderizar('iniciobarrios', 'cangrejo');
    }

}
