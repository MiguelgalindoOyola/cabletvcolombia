<?php

class ordenesModel extends Model {

    public function __construct() {
        parent::__construct();
    }

// QUERY (RECONEXION) MODIFICAR ESTADO FACTURA SUSPENDIDA
    function RECONEXIONCONTRATO() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento SET  contrartos.cosEstado='ACTIVO', contrartos.cosEstilo='alert-info', contrartos.cosFechafinal=NULL, ordendeservicios.fechaFinalizada='" . $_POST['TXTFECHAINICIOCONTRATO'] . "', ordendeservicios.Estado='REALIZADO', ordendeservicios.orsestilo='alert-info', ordendeservicios.orsNovedades='" . $_POST['TXTOBSERVACIONSINSTALACION'] . "' WHERE ordendeservicios.Codigo='" . $_POST['TXTIDSERVICIO'] . "'
");

            return $sql;
        } else {
            return 0;
        }
    }

    // QUERY (RECONECION) MODIFICAR ESTADO FACTURA SUSPENDIDA
    function Guardar_valor_tipo_servicio_factura_RECONECION() {
        if ($_POST) {
            $sql26 = $this->_db->exec("INSERT INTO servicios_por_facturar (spfIdContrato,spfIdServicio,spfValor,spfEstado)VALUES('" . $_POST['TXTIDCONTRATO'] . "','" . $_POST['txtidservicioarealziar'] . "','" . $_POST['txtvalordelservicio'] . "','P')");
            return $sql26;
        } else {
            return 0;
        }
    }

//put your code here
// QUERY (SUSPENDER) MODIFICAR ESTADO FACTURA SUSPENDIDA
//    function MODIFIRAR_ESTADO_FACTURA_SUSPENDIDA() {
//        if ($_POST) {
//            
//            
//            $sql = $this->_db->exec("UPDATE  facturacion_maestro SET froEstadoFactura='SUSPENDIDO' WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
//
//            return $sql;
//        } else {
//            return 0;
//        }
//    }
// QUERY (SUSPENDER) MODIFICAR ESTADO FACTURA SUSPENDIDA
//    function MODIFIRAR_ESTADO_FACTURA_SUSPENDIDA() {
//        if ($_POST) {
//            $sql25333 = $this->_db->query("SELECT froEstadoFactura FROM facturacion_maestro WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
//            $RESULTR = $sql25333->fetchall();
//            if ($RESULTR = 'PAGADA') {
//                $sql55 = $this->_db->exec("UPDATE  facturacion_maestro SET froEstadoFactura='PAGADASUSPENDIDO' WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
//                return $sql55;
//            }
//            if ($RESULTR = 'PORPAGAR') {
//                $sql = $this->_db->exec("UPDATE  facturacion_maestro SET froEstadoFactura='SUSPENDIDO' WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
//                return $sql;
//            }
//        } else {
//            return 0;
//        }
//    }
    function MODIFICAR_ESTADO_FACTURA_SUSPENDIDA() {
        if ($_POST) {
            $sql25333 = $this->_db->query("SELECT froEstadoFactura FROM facturacion_maestro WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
            $result = $sql25333->fetchall();

            // Verifica si se obtuvo algún resultado antes de acceder al valor del estado de la factura
            if (!empty($result)) {
                $estadoFactura = $result[0]['froEstadoFactura'];
                if ($estadoFactura == 'PAGADA') {
                    $sql55 = $this->_db->exec("UPDATE facturacion_maestro SET froEstadoFactura='PAGADASUSPENDIDO' WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
                    return $sql55;
                } elseif ($estadoFactura == 'PORPAGAR') {
                    $sql = $this->_db->exec("UPDATE facturacion_maestro SET froEstadoFactura='SUSPENDIDO' WHERE froNomFctura='" . $_POST['TXTNUMFACTURASUSPENDIDA'] . "'");
                    return $sql;
                }
            }
        }
        return 0;
    }

    // QUERY (SUSPENDER) MODIFICAR ESTADO FACTURA SUSPENDIDA
    function SUSPENDER_CONTRATO_FINALIZAR_ORDEN() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId "
                    . "INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento SET  contrartos.cosEstado='SUSPENDIDO', contrartos.cosEstilo='alert-danger', contrartos.cosFechafinal='" . $_POST['TXTFECHAINICIOCONTRATO'] . "', ordendeservicios.fechaFinalizada='" . $_POST['TXTFECHAINICIOCONTRATO'] . "', ordendeservicios.Estado='REALIZADO', ordendeservicios.orsestilo='alert-info', ordendeservicios.orsNovedades='" . $_POST['TXTOBSERVACIONSINSTALACION'] . "' WHERE ordendeservicios.Codigo='" . $_POST['TXTIDSERVICIO'] . "'
");

            return $sql;
        } else {
            return 0;
        }
    }

    function Ordenes_instalaciones() {
        $sql = $this->_db->query("SELECT Codigo,orsestilo,orsTipoServicio,IdContrato,FechaGenerada,fechaFinalizada,Estado,usuario,uosDocumento,uosNombres,uosApellidos,uosDireccion,IdServicio,sosnombre,baid,banombre FROM ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN servicios ON ordendeservicios.IdServicio=servicios.sosId WHERE Estado='PENDIENTE';");
        return $sql->fetchall();
    }

    function consulta_servicio_por_contrato() {
        $sql = $this->_db->query("SELECT sosId,sosNombre,sosValor, cosId, cosFechainici FROM servicios  INNER JOIN contrartos ON servicios.sosId=contrartos.cosIdservicio");
        return $sql->fetchall();
    }

    function Ordenes_Realizadas() {
        $sql = $this->_db->query("SELECT ordendeservicios.Codigo,ordendeservicios.orsestilo,ordendeservicios.orsTipoServicio,IdContrato,FechaGenerada,fechaFinalizada,Estado,usuario,uosDocumento,uosNombres,uosApellidos,uosDireccion,IdServicio,sosnombre,baid,banombre FROM ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN servicios ON ordendeservicios.IdServicio=servicios.sosId WHERE Estado='REALIZADO'");
        if ($sql) {
            return $sql->fetchall();
        }
        return 0;
    }

// funcion consulta detallad orden ha ejecutar 
    function Consulta_finalizar_orden($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT sosId, sosValor, uosnombres, uosTelefono, Codigo, orsNovedades, orsNumFactura, cosFechainici, cosEstado, orsestilo, orsTipoServicio, IdContrato, FechaGenerada, fechaFinalizada, Estado, usuario, uosDocumento, uosNombres, uosApellidos,uosDireccion,IdServicio,sosnombre,sosdescripcion, sosvalor, baid, banombre FROM ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN servicios ON ordendeservicios.IdServicio=servicios.sosId WHERE ordendeservicios.Codigo='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    // funcion consulta factura en mora
    function Consulta_Fctura_en_mora_reconexion($arg1 = false) {
        if ($arg1) {
            $sql2533 = $this->_db->query("SELECT orsNumFactura FROM ordendeservicios WHERE Codigo='" . $arg1 . "'");
            $RESULT = $sql2533->fetchall();
            $valorcons = $RESULT[0]['orsNumFactura'];
            if (($valorcons > 0)) {
                $sql2 = $this->_db->query("SELECT froNomFctura, froPeriodo, CONCAT_WS('/',fleNombreServicio,PerAno) AS Periodo,(CASE WHEN froEstadoFactura='PAGADA' THEN '0' ELSE froTotalVenta END)AS froTotalVenta, froFecha FROM  ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato INNER JOIN facturacion_detalle ON facturacion_maestro.froNomFctura=facturacion_detalle.fleIdFactura INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE orsNumFactura=$valorcons AND froNomFctura=$valorcons");


                return $sql2->fetchall();
            }
            return 0;
        } else {
            return 0;
        }
    }

    // funcion consulta factura en mora
    function Consulta_Fctura_en_mora($arg1 = false) {
        if ($arg1) {
            $sql2533 = $this->_db->query("SELECT orsNumFactura FROM ordendeservicios WHERE Codigo='" . $arg1 . "'");
            $RESULT = $sql2533->fetchall();
            $valorcons = $RESULT[0]['orsNumFactura'];
            if (($valorcons > 0)) {
                $sql2 = $this->_db->query("SELECT froNomFctura, froPeriodo, CONCAT_WS('/',perMes,PerAno) AS Periodo, froTotalVenta, froFecha, froEstadoFactura FROM  ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato  INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId  WHERE orsNumFactura=$valorcons AND froNomFctura=$valorcons");


                return $sql2->fetchall();
            }
            return 0;
        } else {
            return 0;
        }
    }

    function Consulta_Servicio_Instalacion() {
        $sql = $this->_db->query(" SELECT servicios.sosId, servicios.sosNombre,servicios.sosDescripcion,servicios.sosValor FROM servicios WHERE servicios.sosId='2' AND servicios.sosEstado='activo'");
        return $sql->fetchall();
    }

    function Consultanovedadesinstalacion($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT sosValor, uosnombres, uosTelefono, Codigo, orsNovedades, cosFechainici, cosEstado, orsestilo, orsTipoServicio, IdContrato, FechaGenerada, fechaFinalizada, Estado, usuario, uosDocumento, uosNombres, uosApellidos,uosDireccion,IdServicio,sosnombre,sosdescripcion, sosvalor, baid, banombre FROM ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN servicios ON ordendeservicios.IdServicio=servicios.sosId WHERE ordendeservicios.Codigo='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function Insert_Activar_Contratos() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE ordendeservicios INNER JOIN contrartos ON ordendeservicios.IdContrato=contrartos.cosId "
                    . "INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento SET  contrartos.cosEstado='ACTIVO', contrartos.cosEstilo='alert-info', contrartos.cosFechainici='" . $_POST['TXTFECHAINICIOCONTRATO'] . "', ordendeservicios.fechaFinalizada='" . $_POST['TXTFECHAINICIOCONTRATO'] . "', ordendeservicios.Estado='REALIZADO', ordendeservicios.orsestilo='alert-info', ordendeservicios.orsNovedades='" . $_POST['TXTOBSERVACIONSINSTALACION'] . "' WHERE ordendeservicios.Codigo='" . $_POST['TXTIDSERVICIO'] . "'
");

            return $sql;
        } else {
            return 0;
        }
    }

    function Guardar_valor_tipo_servicio_factura() {
        if ($_POST) {
            $sql25 = $this->_db->exec("INSERT INTO servicios_por_facturar (spfIdContrato,spfIdServicio,spfValor,spfEstado)VALUES('" . $_POST['TXTIDCONTRATO'] . "','" . $_POST['txtidservicioarealziar'] . "','" . $_POST['txtvalordelservicio'] . "','P')");
            return $sql25;
        } else {
            return 0;
        }
    }

}
