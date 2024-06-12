<?php

class parametrosModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    //FUNCION CONSULTA BARRIOS INICIO  --------------------------------------------------------------------------------------------------------------------------------------------
    function Consulta_Barrios() {
        $sql = $this->_db->query("SELECT barrios.baid,barrios.banombre,barrios.badetalle,barrios.baestado FROM barrios WHERE barrios.baestado='activo'");
        return $sql->fetchall();
    }

    //FUNCION  CONSULTA EL ULTIMO BARRIO REGISTRADO--------------------------------------------------------------------------------------------------------------------------------------------
    function Consulta_ultimoBarrios() {
        $sql = $this->_db->query("SELECT * FROM barrios WHERE baid = (SELECT MAX(baid) FROM barrios) ORDER BY baid");
        return $sql->fetchall();
    }

    //FUNCION CONSULTA BARRIO POR ID --------------------------------------------------------------------------------------------------------------------------------------------
    function ConsultaBarrio($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT barrios.baid, barrios.banombre, barrios.badetalle FROM barrios WHERE barrios.baid='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    //FUNCION ACTUALIZA / MODIFICA BARRIO --------------------------------------------------------------------------------------------------------------------------------------------
    function ActualizarBarrio1() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE barrios SET banombre='" . $_POST['txtnombrebarrio'] . "', badetalle='" . $_POST['txtdetallebarrio'] . "', baestado='activo' WHERE baid='" . $_POST['IDbARRIO'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION GUARDA / REGISTRA LOS DATOS DEL BARRIO --------------------------------------------------------------------------------------------------------------------------------------------
    function GuardarBarrios() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO barrios(baid, banombre, badetalle, baestado) VALUES ('" . $_POST['codigobarrio'] . "','" . $_POST['txtnombrebarrio'] . "','" . $_POST['txtdetallebarrio'] . "','activo')ON DUPLICATE KEY UPDATE banombre='" . $_POST['txtnombrebarrio'] . "', badetalle='" . $_POST['txtdetallebarrio'] . "', baestado='activo'");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION ELIMINA BARRIO REGISTRADO --------------------------------------------------------------------------------------------------------------------------------------------
    function EliminarBarrio($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE barrios SET baestado='inactivo' WHERE baid='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION CONSULTA SERVICIOS INICIO --------------------------------------------------------------------------------------------------------------------------------------------

    function Consulta_Servicios() {
        $sql = $this->_db->query("SELECT servicios.sosId,servicios.sosNombre,servicios.sosDescripcion,servicios.sosValor,servicios.sosFechaActualizacion FROM servicios WHERE servicios.sosEstado='activo'");
        return $sql->fetchall();
    }

    //FUNCION CONSULTA ULTIMO SERVICIO REGISTRADO --------------------------------------------------------------------------------------------------------------------------------------------
    function Consulta_ultimoServicio() {
        $sql = $this->_db->query("SELECT * FROM servicios WHERE sosId = (SELECT MAX(sosId) FROM servicios) ORDER BY sosId");
        return $sql->fetchall();
    }

    //FUNCION GUARDA LOS DATOS DEL SERVICIO REGISTRADO--------------------------------------------------------------------------------------------------------------------------------------------
    function GuardarServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO servicios(sosId,sosNombre,sosDescripcion,sosValor,sosFechaActualizacion,sosEstado) VALUES ('" . $_POST['codigoServicio'] . "','" . $_POST['txtnombreservicio'] . "','" . $_POST['txtdetalleservicio'] . "','" . $_POST['txtvalorservicio'] . "','" . $_POST['txteFecha'] . "','activo')");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION  CONSULTA EL REGISTRO DEL SERVICIO A EDITAR POR ID--------------------------------------------------------------------------------------------------------------------------------------------
    function ConsultaServicioEditar($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT servicios.sosId, servicios.sosNombre,servicios.sosDescripcion,servicios.sosValor,servicios.sosFechaActualizacion,servicios.sosEstado FROM servicios WHERE servicios.sosId='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    //FUNCION  ACTUALIZA / MODIFICA LOS DATOS DEL SERVICIO A EDITAR --------------------------------------------------------------------------------------------------------------------------------------------
    function ActualizarServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE servicios SET sosNombre='" . $_POST['txtnombreservicio'] . "',sosDescripcion='" . $_POST['txtdetalleservicio'] . "',sosValor='" . $_POST['txtvalorservicio'] . "',sosFechaActualizacion= CURDATE(),sosEstado='activo' WHERE sosId='" . $_POST['txtsosId'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION ELIMINA EL REGISTRO DE UN SERVICIO INSTALADO--------------------------------------------------------------------------------------------------------------------------------------------
    function EliminarServicio($arg = false) {
        if ($arg) {
            $sql = $this->_db->query(" UPDATE servicios SET sosEstado='inactivo' WHERE sosId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION REGISTRA LAS NOVEDADES REALIZADAS A LOS SERVICIOS--------------------------------------------------------------------------------------------------------------------------------------------
    function MOVEDITServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO historial_novedades (codserv,tipomodificacion,objeto,fecha) VALUES ('" . $_POST['txtsosId'] . "','MODIFICACION DE DATOS','" . $_POST['txtModificacion'] . "',CURRENT_TIME())");
            return $sql;
        } else {
            return 0;
        }
    }

    //FUNCION  CONSULTA LAS NOVEDADES REGISTRADAS--------------------------------------------------------------------------------------------------------------------------------------------
    function ConsultaNovedades($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT codserv,sosNombre,tipomodificacion,objeto,fecha FROM historial_novedades INNER JOIN servicios ON historial_novedades.codserv=servicios.sosId WHERE historial_novedades.codserv='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

//    function listacategorias() {
//        $sql = $this->_db->query(" SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasEstado='a' ORDER BY categorias.iasNombre");
//        return $sql->fetchall();
//    }
//
//    function consultauncategoria($arg = false) {
//        if ($arg) {
//            $sql = $this->_db->query("SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasId='" . $arg . "'");
//            return $sql->fetchall();
//        } else {
//            return 0;
//        }
//    }
//
//    function bajacategoria($arg = false) {
//        if ($arg) {
//            $sql = $this->_db->query("UPDATE categorias SET categorias.iasEstado='I' WHERE categorias.iasId='" . $arg . "'");
//            return $sql;
//        } else {
//            return 0;
//        }
//    }
}
