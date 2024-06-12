<?php

class reportesModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    function consulta_periodos_select($argum = false) {
        $sql = $this->_db->query("SELECT perId, CONCAT_WS('/', perMes, perAno) AS periodo FROM `tbperiodos` WHERE perEstado = 'a'");
        return $sql->fetchall();
    }

    function consulta_tabla_recaudos1($argum = false) {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION, cosId,froFechaPago, cosEstado, cosFechainici, froNomFctura,froFecha, froTotalVenta, froEstadoFactura, froPeriodo FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato WHERE froPeriodo='" . $argum . "'  ORDER BY froEstadoFactura ASC
");
        return $sql->fetchall();
    }

    function consulta_consolidado_ventas1() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE froPeriodo BETWEEN '" . $_POST['FechaInicio'] . "' AND '" . $_POST['FechaFinal'] . "'  AND froEstadoFactura='PAGADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_PORPAGAR1() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE froPeriodo BETWEEN '" . $_POST['FechaInicio'] . "' AND '" . $_POST['FechaFinal'] . "'  AND froEstadoFactura='PORPAGAR' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_vencida1() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE froPeriodo BETWEEN '" . $_POST['FechaInicio'] . "' AND '" . $_POST['FechaFinal'] . "'  AND froEstadoFactura='VENCIDA_ASIGNADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_tabla_recaudos($argum = false) {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION, cosId,froFechaPago, cosEstado, cosFechainici, froNomFctura,froFecha, froTotalVenta, froEstadoFactura, froPeriodo FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato WHERE froPeriodo='" . $argum . "'  ORDER BY froEstadoFactura ASC
");
        return $sql->fetchall();
    }

    function consulta_consolidado_ventas() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='PAGADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_PORPAGAR() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='PORPAGAR' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_vencida() {
        $sql = $this->_db->query("SELECT perMes,perId, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='VENCIDA_ASIGNADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function ordenactivarcontrato($argum = false) {
        if ($argum) {
            $UltimaFacturaMestro = $this->_db->query("SELECT * FROM facturacion_maestro WHERE froNomFctura = (SELECT MAX(froNomFctura) FROM facturacion_maestro) ORDER BY froNomFctura");
            $numerouno = 1;
            $ResultadoUltimafacturamaestroo = $UltimaFacturaMestro->fetchall();
//          asigno el valor a una variable              
            $numeroantiguo = $ResultadoUltimafacturamaestroo[0]['froNomFctura'];
            $ultimoperiodo = $ResultadoUltimafacturamaestroo[0]['froPeriodo'];
            $nuevonumfactura = $numeroantiguo + $numerouno;

            $consultafacturavencida = $this->_db->query("SELECT froContrato, froTotalVenta, froEstadoFactura FROM facturacion_maestro WHERE froNomFctura='" . $argum . "'");
            $resultado1 = $consultafacturavencida->fetchall();
            $contrato = $resultado1[0]['froContrato'];
            $valorfactura = $resultado1[0]['froTotalVenta'];
            $estadofacturaanterior = $resultado1[0]['froEstadoFactura'];
            if ($estadofacturaanterior == 'PAGADASUSPENDIDO') {
                $sqL4 = $this->_db->exec("INSERT INTO ordendeservicios(IdContrato, FechaGenerada, Estado, usuario, IdServicio, orsestilo, orsTipoServicio,orsNumFactura) "
                        . "VALUES ('" . $contrato . "', NOW(), 'PENDIENTE', 'Miguel', '4', 'alert-danger', 'RECONEXION', '$nuevonumfactura')");
                return $sqL4;
            } else {
                $sql1 = $this->_db->exec("INSERT INTO facturacion_maestro (froNomFctura, froPeriodo, froContrato, froFecha, froFechaVencimiento, froTotalVenta, froEstadoFactura) "
                        . "VALUES ($nuevonumfactura, $ultimoperiodo, $contrato, NOW(),NOW(),$valorfactura,'PORPAGAR')");

                $sql2 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura,fleCodigoServicio,flePrecioVenta,fleNombreServicio)"
                        . "VALUES($nuevonumfactura,'" . $argum . "',$valorfactura,'DEUDA ANTERIOR FACTURA SUSPENDIDA')");

                $sql3 = $this->_db->exec("UPDATE facturacion_maestro SET froEstadoFactura='VENCIDA_ASIGNADA' WHERE froNomFctura=$argum");
                $sqL4 = $this->_db->exec("INSERT INTO ordendeservicios(IdContrato, FechaGenerada, Estado, usuario, IdServicio, orsestilo, orsTipoServicio,orsNumFactura) "
                        . "VALUES ('" . $contrato . "', NOW(), 'PENDIENTE', 'Miguel', '4', 'alert-danger', 'RECONEXION', '$nuevonumfactura')");
                return $sqL4;
            }
        } else {
            return 0;
        }
    }

    function Consultatablasuspendidos() {
        $sql = $this->_db->query("SELECT uosDocumento, cosEstado, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES, CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION, banombre, froContrato, froNomFctura, DATE_FORMAT(cosFechainici,'%m/%e/%Y') AS cosFechainici,DATE_FORMAT(cosFechafinal,'%m/%e/%Y') AS cosFechafinal,froEstadoFactura, (CASE WHEN froEstadoFactura='PAGADASUSPENDIDO' THEN '0' ELSE froTotalVenta END)AS VALORDEUDA FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE cosEstado='SUSPENDIDO' AND froEstadoFactura='SUSPENDIDO' OR froEstadoFactura='PAGADASUSPENDIDO' ORDER BY froTotalVenta DESC;");
        return $sql->fetchall();
    }

    function consulta_cantidad_suspendidos() {
        $sql = $this->_db->query("SELECT cosEstado, COUNT(cosEstado) AS Cantidad FROM contrartos WHERE cosEstado='SUSPENDIDO'");
        return $sql->fetchall();
    }

    function ConsultaUsuariosSuspendidos() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();
        $ULTP = $RESULT[0]['ULTIMOPERIODO'];

        $sql = $this->_db->query("SELECT uosDocumento, cosEstado, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, froContrato, froNomFctura, cosFechainici, froTotalVenta FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' AND froTotalVenta>'20000' AND froPeriodo=$ULTP ORDER BY froTotalVenta DESC");
        return $sql->fetchall();
    }

    function ConsultaMorosos() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();
        $ULTP = $RESULT[0]['ULTIMOPERIODO'];

        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, froContrato, froNomFctura, cosFechainici, froTotalVenta FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' AND froTotalVenta>'20000' AND froPeriodo=$ULTP ORDER BY froTotalVenta DESC");
        return $sql->fetchall();
    }

    function ConsultaMorosostabla() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();
        $ULTP = $RESULT[0]['ULTIMOPERIODO'];

        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, froContrato, froNomFctura, cosEstado, cosFechainici, froTotalVenta, froEstadoFactura FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' OR froEstadoFactura='PAGADA' AND froPeriodo=$ULTP ORDER BY froTotalVenta DESC");
        return $sql->fetchall();
    }

    function consulta_barrios() {
        $sql = $this->_db->query("SELECT baid, banombre FROM barrios WHERE baestado='activo'");
        return $sql->fetchall();
    }

    function consulta_cantidad_morosos() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();

        $ULTP = $RESULT[0]['ULTIMOPERIODO'];
        $sql = $this->_db->query("SELECT COUNT(froNomFctura) AS MOROSOS FROM facturacion_maestro WHERE froEstadoFactura='PORPAGAR' AND froTotalVenta>'20000' AND froPeriodo=$ULTP");
        return $sql->fetchall();
    }

    function ConsultaInfCorte($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION, uosTelefono, froContrato, froNomFctura, cosFechainici, froTotalVenta FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froNomFctura = '" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function ConsultaServicioDesconexion() {

        $sql = $this->_db->query("SELECT sosId, sosNombre, sosDescripcion FROM  servicios WHERE sosId='3' OR sosId='16'");
        return $sql->fetchall();
    }

    function guardarordencorte() {
        if ($_POST) {
            $Idservicio = $_POST['SelectServicio'];
            $consultavalorservicio = $this->_db->query("SELECT sosId, sosNombre, sosDescripcion FROM  servicios WHERE sosId='" . $Idservicio . "'");
            $RESULT = $consultavalorservicio->fetchall();
            $ULTP = $RESULT[0]['sosNombre'];


            $sql = $this->_db->exec("INSERT INTO ordendeservicios(IdContrato, FechaGenerada, Estado, usuario, IdServicio, orsestilo, orsTipoServicio,orsNumFactura) "
                    . "VALUES ('" . $_POST['txtNumContrato'] . "', '" . $_POST['dateFechaFacturacion'] . "', 'PENDIENTE', 'Miguel', '" . $_POST['SelectServicio'] . "', 'alert-danger', '" . $ULTP . "', '" . $_POST['txtNumeroFactura'] . "')");
            return $sql;
        } else {
            return 0;
        }
    }

    function AsignarEstadoCliente() {
        if ($_POST) {
            $sql2 = $this->_db->exec("UPDATE clientes SET uosEstadoContrato = 'ASIGNADO' WHERE uosDocumento = '" . $_POST['txtCedula'] . "'");
            return $sql2;
        } else {
            return 0;
        }
    }

}
