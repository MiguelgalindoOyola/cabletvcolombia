<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of humanosController
 *
 * @author MIGUEL ANGEL
 */
class humanosController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("humanos");
    }

    public function inicioclientes() {
        Session::acceso("General");
        $data = $this->loadModel('humanos');
        $this->_view->accion = 'Clientes';
        $this->_view->title = "humanos - clientes";
        $this->_view->modulo = "humanos";
        $this->_view->metodo = "inicio";
        $this->_view->ConsultaClientesTab = $data->ConsultaClientesActivos();


        $this->_view->renderizar('inicioclientes', 'cangrejo');
    }

    public function consultahistorial($argum = false) {
//        Session::accesoEstricto(array('Citas', 'General'), true);
        $data = $this->loadModel('humanos');
        $this->_view->accion = 'Consulta Historial de Usuario';
        $this->_view->title = "Recaudos - Inicio";
        $this->_view->modulo = "reportes";
        $this->_view->datosCliente = $data->consultadatosclienteparaeditar($argum);
        $this->_view->datosordenes = $data->consultadatosordenes($argum);
        $this->_view->datosfacturas = $data-> consultafacturas($argum);
        $this->_view->renderizar('historial', 'blank');
    }

    public function Formulariousuario($argum = false) {
        Session::acceso("General");
        $data = $this->loadModel('humanos');
        if ($argum) {
            $this->_view->accion = 'Editar Cliente';
            $this->_view->title = "Editar Clientes";
            $this->_view->modulo = "humanos";
            $this->_view->ConsultaDatosBarrio = $data->consultaBarrios();
            $this->_view->datosCliente = $data->consultadatosclienteparaeditar($argum);
        } else {
            $this->_view->accion = 'Agregar Proveedores';
            $this->_view->datosCliente = array();
            $this->_view->ConsultaDatosBarrio = array();
        }

        $this->_view->renderizar('fromeditarclientes', 'blank');
    }

    public function GuardarCliente1() {
        Session::acceso("General");
        $data = $this->loadModel('humanos');
        $sql = $data->Registrar_Clientes1();

        if ($sql) {
            Session::set('mensaje', 'Cliente actualizado Satisfactoriamente');
            Session::set('tipomensaje', 'alert-success');
        } else {

            Session::set('mensaje', 'error al guardar - Cliente ya ha sido Registrado');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('humanos/inicioclientes');
    }

}
