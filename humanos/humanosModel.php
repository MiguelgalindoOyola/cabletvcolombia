<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of humanosModel
 *
 * @author MIGUEL ANGEL
 */
class humanosModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    //    CONSULTA FACTURA POR PAGAR TABLA
    function ConsultaClientesActivos() {
        $sql = $this->_db->query("SELECT  uosDocumento, CONCAT_WS(' ', uosNombres,uosApellidos) AS Nombresyapellidos, uosTelefono, uosCorreo,  CONCAT_WS  ('',uosDireccion,' ', banombre) AS direccion FROM barrios INNER JOIN clientes ON barrios.baid=clientes.uosIdBarrio WHERE uosEstado='activo' ");
        return $sql->fetchall();
    }

    function consultadatosclienteparaeditar($argu = false) {
        if ($argu) {
            $sql8 = $this->_db->query("SELECT  uosDocumento,uosMunicipio,uosNombres,uosApellidos, uosTelefono, uosCorreo, uosDireccion, banombre, baid, cosId, cosIdusuario, cosIdservicio,sosNombre,sosValor, cosFechaRegistro, cosFechainici, cosFechafinal FROM clientes  INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid   INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN servicios ON contrartos.cosIdservicio=servicios.sosId WHERE uosDocumento='" . $argu . "'");

            return $sql8->fetchall();
        } else {
            return 0;
        }
    }

    function consultadatosordenes($argu = false) {
        if ($argu) {
            $sql47 = $this->_db->query("SELECT ordendeservicios.Codigo,ordendeservicios.orsestilo,ordendeservicios.orsTipoServicio,IdContrato,FechaGenerada,fechaFinalizada,Estado,usuario,uosDocumento,uosNombres,uosApellidos,uosDireccion,IdServicio,sosnombre,baid,banombre   FROM ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId   INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento   INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid   INNER JOIN servicios ON ordendeservicios.IdServicio=servicios.sosId   WHERE uosDocumento='" . $argu . "'");

            return $sql47->fetchall();
        } else {
            return 0;
        }
    }

    function consultafacturas($argu = false) {
        if ($argu) {
            $sql48 = $this->_db->query("SELECT perId, CONCAT_WS('/',perMes,perAno) AS periodo,uosDocumento, cosId, froNomFctura,froFechaVencimiento,froFecha,froFechaPago,froDescuento, froTotalVenta , froEstadoFactura, froObservaciones FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento WHERE uosDocumento='" . $argu . "'");

            return $sql48->fetchall();
        } else {
            return 0;
        }
    }

    function consultaBarrios() {
        $sql = $this->_db->query("SELECT baid, banombre FROM barrios WHERE baestado = 'activo'");
        return $sql->fetchall();
    }

    function Registrar_Clientes1() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE clientes SET uosDocumento='" . $_POST['TXTDOC'] . "', uosNombres='" . $_POST['TXTNOMCLIENTE'] . "', uosApellidos='" . $_POST['TXTAPELLIDO'] . "', uosTelefono='" . $_POST['TXTTELEFONO'] . "', uosCorreo='" . $_POST['TXTCORREO'] . "', uosMunicipio='" . $_POST['TXTMUNICIPIO'] . "', uosIdBarrio='" . $_POST['CBBarrio'] . "', uosDireccion='" . $_POST['TXTDIRECCION'] . "'  WHERE uosDocumento = '" . $_POST['TXTDOCantiguo'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

}
