<?php

class facturacionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    function consultaultimafactura() {
//         CONSULTA ULTIMA FACTURA PARA FACTURA UNICA --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $UltimaFacturaMestro1 = $this->_db->query("SELECT * FROM facturacion_maestro WHERE froNomFctura = (SELECT MAX(froNomFctura) FROM facturacion_maestro) ORDER BY froNomFctura");
        return $ResultadoUltimafacturamaestro = $UltimaFacturaMestro1->fetchall();
    }

    function consultaselectusuarios() {
//         CONSULTA ULTIMA FACTURA PARA FACTURA UNICA --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, cosId, cosEstado, cosFechainici, cosFechafinal FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario WHERE uosEstado='activo' AND cosEstado='ACTIVO' ORDER BY uosNombres ASC");
        return $datosselec = $sql->fetchall();
    }

    function Consultadatosfacturaunica($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT uosDocumento, froContrato,froNomFctura, froFecha, froFechaVencimiento, froFechaPago, froTotalVenta, froEstadoFactura FROM clientes INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato WHERE uosDocumento='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function consultafacturas1($argu = false) {
        if ($argu) {
            $sql48 = $this->_db->query("SELECT perId, CONCAT_WS('/',perMes,perAno) AS periodo,uosDocumento, cosId, froNomFctura,froFechaVencimiento,froFecha,froFechaPago,froDescuento, froTotalVenta , froEstadoFactura, froObservaciones FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento WHERE uosDocumento='" . $argu . "'");

            return $sql48->fetchall();
        } else {
            return 0;
        }
    }

    function consulta_facturaporguardar($argu = false) {
        if ($argu) {
            $sql49 = $this->_db->query("SELECT spfId, spfIdContrato, spfIdServicio, sosNombre, sosDescripcion,spfEstado, spfValor FROM servicios_por_facturar INNER JOIN contrartos ON servicios_por_facturar.spfIdContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario =clientes.uosDocumento INNER JOIN servicios ON servicios_por_facturar.spfIdServicio=servicios.sosId WHERE uosDocumento='" . $argu . "' AND spfEstado='P'");

            return $sql49->fetchall();
        } else {
            return 0;
        }
    }

    function consultaservicios() {
//         CONSULTA ULTIMA FACTURA PARA FACTURA UNICA --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $sql = $this->_db->query("SELECT sosId, sosNombre, sosDescripcion, sosValor FROM servicios WHERE sosEstado='activo'");
        return $datosservicios = $sql->fetchall();
    }

    function guardardatosfacturaunica() {
        if ($_POST) {
            for ($i = 1; $i < count($_POST['Nombre']); $i++) {
                $count = $this->_db->exec("INSERT INTO clonardatos (ctosFecha, ctosProveedor, ctosRegistro,ctoscodigo,ctosnombre,ctoscantidad,ctosValor)"
                        . "VALUES ('" . $_POST['txtfecharegistro'] . "','" . $_POST['txtproveedor'] . "', '" . $_POST['txtEncargado'] . "','" . $_POST['Codigo'][$i] . "','" . $_POST['Nombre'][$i] . "','" . $_POST['Cantidad'][$i] . "','" . $_POST['Valor'][$i] . "')");
            }
            return $count;
        } else {

            return 0;
        }
    }

    function GuardarUnicaFactura() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO facturacion_maestro (froNomFctura,froPeriodo,froContrato,froFecha,froFechaVencimiento,froTotalVenta,froEstadoFactura,froObservaciones) VALUES"
                    . " ('" . $_POST['txtsosId'] . "','" . $_POST['txtPeriodo'] . "','218','" . $_POST['dateFechaElaboracion'] . "','" . $_POST['FechaVencimiento'] . "','" . $_POST['FechaVencimiento'] . "','" . $_POST['total'] . "','PORPAGAR','')");

            return $sql;
        } else {
            return 0;
        }
    }

//function GuardarUnicaFactura() {
//    if ($_POST) {
//        $sql = "INSERT INTO facturacion_maestro (froNomFctura, froPeriodo, froContrato, froFecha, froFechaVencimiento, froTotalVenta, froEstadoFactura, froObservaciones) VALUES"
//            . " ('9001','9','225','" . $_POST['dateFechaElaboracion'] . "','" . $_POST['dateFechaElaboracion'] . "','" . $_POST['FechaVencimiento'] . "','" . $_POST['total'] . "','PORPAGAR','nada')";
//
//        $result = $this->_db->exec($sql);
//
//        return $result;
//    } else {
//        return false;
//    }
//}
// function Editavalorfactura($arg = false) {
//        if ($arg) {
//            
//            
//            
//            $sql = $this->_db->exec("UPDATE facturacion_maestro SET froFechaPago='" . $_POST['txtFechaPago'] . "', froEstadoFactura='PAGADA', froDescuento='" . $_POST['caja1'] . "', froTotalVenta='" . $_POST['caja3'] . "' WHERE froNomFctura='" . $_POST['txtcodigofactura'] . "'");
//            
//            $sql = $this->_db->exec("UPDATE facturacion_maestro SET froFechaPago='" . $_POST['txtFechaPago'] . "', froEstadoFactura='PAGADA', froDescuento='" . $_POST['caja1'] . "', froTotalVenta='" . $_POST['caja3'] . "' WHERE froNomFctura='" . $_POST['txtcodigofactura'] . "'");
//         
//            
//            return $sql->fetchall();
//        } else {
//            return 0;
//        }
//    }
//    
//    ///consulta usuarios sin saldo
    function Consultausuarionsinsado() {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, cosId, cosEstado, cosFechainici, cosFechafinal FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario WHERE	uosEstado='activo' ORDER BY uosNombres ASC");
        return $sql->fetchall();
    }

    //    ///consulta usuarios sin saldo
    function Consultausuarionsinsadoactivo() {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, cosId, cosEstado, cosFechainici, cosFechafinal FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario WHERE cosEstado='activo' ORDER BY uosNombres ASC");
        return $sql->fetchall();
    }

//    ///consulta usuarios con saldo
    function Consultausuariosconsaldoactivo() {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, cosId, cosEstado, cosFechainici FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario WHERE cosEstado='ACTIVO' ORDER BY uosNombres ASC");
        return $sql->fetchall();
    }

    //    ///consulta usuarios con saldo
    function Consultausuariosconsaldo() {
        $sql = $this->_db->query("SELECT uosDocumento, CONCAT_WS(' ',uosNombres, uosApellidos) AS NOMBRES,  CONCAT_WS(' ',uosDireccion,banombre) AS DIRECCION,  banombre, cosId, cosEstado, cosFechainici FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario WHERE cosEstado='ACTIVO' OR cosEstado='SUSPENDIDO' ORDER BY uosNombres ASC");
        return $sql->fetchall();
    }

    //    ///consulta Facturas ULtimas por cada Contrato
    function ConsultaFacturaUltimaPorContrato() {
        $sql = $this->_db->query("   SELECT fm.froNomFctura, fm.froPeriodo, fm.froFecha, fm.froTotalVenta, fm.froEstadoFactura, fm.froContrato FROM facturacion_maestro fm INNER JOIN (    SELECT froContrato, MAX(froPeriodo) AS UltimoPeriodo    FROM facturacion_maestro    GROUP BY froContrato) ultima_factura ON fm.froContrato = ultima_factura.froContrato AND fm.froPeriodo = ultima_factura.UltimoPeriodo");
        return $sql->fetchall();
    }

    ///consulta barrios
    function consulta_barrios2() {
        $sql = $this->_db->query("SELECT baid, banombre FROM barrios WHERE baestado='activo'");
        return $sql->fetchall();
    }

    //    guarda factura pagada
    function GuardarabonoFacturas() {
        if ($_POST) {

            $sql = $this->_db->exec("UPDATE facturacion_maestro SET  froTotalVenta='" . $_POST['caja3'] . "' WHERE froNomFctura='" . $_POST['txtcodigofactura'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //    guarda factura pagada
    function creafacturaabono() {
        if ($_POST) {
            // Consulta la última factura en la tabla facturacion_maestro
            $UltimaFacturaMestro = $this->_db->query("SELECT * FROM facturacion_maestro WHERE froNomFctura = (SELECT MAX(froNomFctura) FROM facturacion_maestro) ORDER BY froNomFctura");
            $numerouno = 1;
            $ResultadoUltimafacturamaestroo = $UltimaFacturaMestro->fetchall();

            // Obtiene el número de la última factura y le suma uno para generar un nuevo número de factura
            $numeroantiguo = $ResultadoUltimafacturamaestroo[0]['froNomFctura'];
            $nuevonumfactura = $numeroantiguo + $numerouno;

            // Consulta los datos de la factura existente en la tabla facturacion_maestro
            $consultadatos = $this->_db->query("SELECT froNomFctura, froPeriodo, froContrato, froFecha, froFechaVencimiento FROM facturacion_maestro WHERE froNomFctura='" . $_POST['txtcodigofactura'] . "'");
            $Resultadoconsultadatos = $consultadatos->fetchall();

            // Obtiene los valores de la factura existente
            $numfactura = $Resultadoconsultadatos[0]['froNomFctura'];
            $periodo = $Resultadoconsultadatos[0]['froPeriodo'];
            $numcontrato = $Resultadoconsultadatos[0]['froContrato'];
            $fecharegistro = $Resultadoconsultadatos[0]['froFecha'];
            $fechavencimiento = $Resultadoconsultadatos[0]['froFechaVencimiento'];
            $valorfactura = $_POST['caja1'];
            $NUMFACTURASD = $_POST['txtcodigofactura'];
            $nombreservicio = 'ABONO FACTURA No.' . $NUMFACTURASD;

            // Inserta un nuevo registro en la tabla facturacion_maestro con los valores proporcionados
            $sql11 = $this->_db->exec("INSERT INTO facturacion_maestro (froNomFctura, froPeriodo, froContrato, froFecha, froFechaVencimiento, froFechaPago, froTotalVenta, froEstadoFactura, froObservaciones) VALUES"
                    . " ($nuevonumfactura, $periodo, $numcontrato, '" . $Resultadoconsultadatos[0]['froFecha'] . "', '" . $Resultadoconsultadatos[0]['froFechaVencimiento'] . "', '" . $_POST['txtFechaPago'] . "', $valorfactura, 'PAGADA', '$nombreservicio')");

            // Inserta un nuevo registro en la tabla facturacion_detalle con los valores proporcionados
            $sql112 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio) VALUES ('$nuevonumfactura', '17', '$valorfactura', '$nombreservicio')");

            return $sql11l; // No está claro qué es "sq11l", se asume que es un error de escritura y debería ser "sql11"
        } else {
            return 0;
        }
    }

    //    guarda valor a cuenta 
    function GuardarabonoCuentaEfectivo() {
        if ($_POST) {
            $sql2 = $this->_db->exec("UPDATE tb_cuentas SET tasvalor = tasvalor+'" . $_POST['caja1'] . "' WHERE tasId='1'");
            return $sql2;
        } else {
            return 0;
        }
    }

    //    consulta factura un usuario a pagar modal PDF
    function ConstultaFacturaPorpagarUnUsuarioPDF($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT banombre, uosDocumento, CONCAT_WS(' ', uosNombres,uosApellidos) AS Nombresyapellidos, uosDireccion, cosId, froNomFctura, froFecha,froFechaVencimiento,froDescuento, froTotalVenta, CONCAT_WS('/', perMes, PerAno) AS Concepto  FROM barrios INNER JOIN clientes ON barrios.baid=clientes.uosIdBarrio INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato "
                    . "INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId "
                    . "WHERE froEstadoFactura='PORPAGAR' AND froNomFctura='" . $arg . "'");
//            echo $arg;
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    //    consulta detalle  factura un usuario a pagar modal PDF
    function ConstultaFacturaDetallePorpagarUnUsuarioPDF($argu = false) {
        if ($argu) {
            $sql46 = $this->_db->query("SELECT fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio   FROM facturacion_detalle INNER JOIN facturacion_maestro ON facturacion_detalle.fleIdFactura=facturacion_maestro.froNomFctura INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' AND froNomFctura='" . $argu . "'");
            echo $argu;
            return $sql46->fetchall();
        } else {
            return 0;
        }
    }

//    consulta factura a pagar modal PDF
    function ConstultaFacturaPorpagarPDF($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT banombre, uosDocumento, CONCAT_WS(' ', uosNombres,uosApellidos) AS Nombresyapellidos, uosDireccion, cosId, froNomFctura, froFecha,froDescuento,froFechaVencimiento, froTotalVenta, CONCAT_WS('/', perMes, PerAno) AS Concepto  FROM barrios INNER JOIN clientes ON barrios.baid=clientes.uosIdBarrio INNER JOIN contrartos ON clientes.uosDocumento=contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId=facturacion_maestro.froContrato "
                    . "INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId "
                    . "WHERE froEstadoFactura='PORPAGAR' AND baid='" . $arg . "'");
//            echo $arg;
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

//    
    function ConstultaFacturaDetallePorpagarPDF($argu = false) {
        if ($argu) {
            $sql46 = $this->_db->query("SELECT fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio   FROM facturacion_detalle INNER JOIN facturacion_maestro ON facturacion_detalle.fleIdFactura=facturacion_maestro.froNomFctura INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' AND baid='" . $argu . "'");
            echo $argu;
            return $sql46->fetchall();
        } else {
            return 0;
        }
    }

//    CONSULTA FACTURA POR PAGAR TABLA
    function Consulta_Cantidad_Facturas_PORPAGAR() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();

        $ULTP = $RESULT[0]['ULTIMOPERIODO'];

        $sql = $this->_db->query("SELECT uosDocumento, froNomFctura,froContrato,froTotalVenta,froFechaVencimiento, uosNombres,uosApellidos,perMes,froEstadoFactura FROM facturacion_maestro  INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE froEstadoFactura='PORPAGAR' OR froEstadoFactura='PAGADA' AND froPeriodo=$ULTP");
        return $sql->fetchall();
    }

//    guarda factura pagada
    function GuardarPagoFacturas() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE facturacion_maestro SET froFechaPago='" . $_POST['txtFechaPago'] . "', froEstadoFactura='PAGADA', froDescuento='" . $_POST['caja1'] . "', froTotalVenta='" . $_POST['caja3'] . "' WHERE froNomFctura='" . $_POST['txtcodigofactura'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

//    guarda valor a cuenta 
    function GuardarPagoCuentaEfectivo() {
        if ($_POST) {
            $sql2 = $this->_db->exec("UPDATE tb_cuentas SET tasValor = tasValor+'" . $_POST['caja3'] . "' WHERE tasId='1'");
            return $sql2;
        } else {
            return 0;
        }
    }

//    NO UTLIZADO
    function acturalizarDetalleFacturaPago() {
        if ($_POST) {
            $sql2 = $this->_db->exec("UPDATE tb_cuentas SET tasValor = tasValor+'" . $_POST['caja3'] . "' WHERE tasId='1'");
            return $sql2;
        } else {
            return 0;
        }
    }

//    consulta factura a pagar modal
    function ConstultaFacturaPorpagar($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT froNomFctura,froPeriodo,froContrato,froFecha,froFechaVencimiento,froTotalVenta,uosDocumento,uosNombres,uosApellidos,uosTelefono, uosDireccion, banombre FROM facturacion_maestro INNER JOIN contrartos ON facturacion_maestro.froContrato=contrartos.cosId INNER JOIN clientes ON contrartos.cosIdusuario=clientes.uosDocumento INNER JOIN barrios ON clientes.uosIdBarrio=barrios.baid WHERE froEstadoFactura='PORPAGAR' AND froNomFctura='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function ConstultaFacturaDetallePorpagar($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT fleCodigoServicio, fleNombreServicio, flePrecioVenta FROM facturacion_detalle WHERE fleIdFactura='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

//    CIERRA CICLO

    function CerrarCiclo() {

        $sql2 = $this->_db->exec("UPDATE facturacion_maestro SET froEstadoFactura='VENCIDA' WHERE froEstadoFactura='PORPAGAR'");
        return $sql2;
    }

    function consultaMesFacturado() {
        $sql = $this->_db->query("SELECT perId,perMes,perano,perEstado FROM tbperiodos WHERE tbperiodos.PerAno=YEAR(NOW())");
        return $sql->fetchall();
    }

    function Registrar_Contratos() {
        $contratoActivo = $this->_db->query("SELECT uosDocumento FROM clientes WHERE uosEstado='activo' AND uosEstadoContrato='NO ASIGNADO'");
        $RESULTADOSCONTRATOS = $contratoActivo->fetchall();
        $array_j = array();

        for ($j = 0; $j < count($RESULTADOSCONTRATOS); $j++) {
            $CEDULA = $RESULTADOSCONTRATOS[$j]['uosDocumento'];
            $sql66 = $this->_db->exec("UPDATE clientes SET uosEstadoContrato = 'ASIGNADO' WHERE uosDocumento = $CEDULA");

            $sql67 = $this->_db->exec("INSERT INTO contrartos (cosIdusuario, cosIdservicio, cosFechaRegistro, cosPuntos, cosEstado, cosEstilo, cosFechainici) VALUES ($CEDULA, '1', '2022-10-01 17:06:00', '1', 'ACTIVO', 'alert-info', '2022-10-01 17:06:00')");
        }
        return $count;
    }

    function generarfacturacion() {
        if ($_POST) {

            // Consulta contratos activos
            $contratos = $this->_db->query("SELECT cosId, cosIdservicio,cosFechainici FROM contrartos WHERE cosEstado='ACTIVO'");
            $resulcontrato = $contratos->fetchAll();
            $array_j = array();

            // Procedimientos para asignar facturas vencidas
            // Consulta última factura
            $UltimaFacturaMestro = $this->_db->query("SELECT * FROM facturacion_maestro WHERE froNomFctura = (SELECT MAX(froNomFctura) FROM facturacion_maestro) ORDER BY froNomFctura");
            $ResultadoUltimafacturamaestro = $UltimaFacturaMestro->fetchAll();

            // Obtener el número de la última factura maestro
            $numero_ultima_factura_maestro = $ResultadoUltimafacturamaestro[0]['froNomFctura'];

            // Inicializar variables
            $valordeuno = 1;
            $valorFacrurasVencidas = 0;
            $valor_saldo_inicial = 0;
            $valor_saldo_adicional = 0;
            $valor_total_factura = 0;

            // Ciclo para registrar factura maestro
            for ($ct = 0; $ct < count($resulcontrato); $ct++) {
                $nuevo_numero_de_factura = $numero_ultima_factura_maestro + $valordeuno;
                $Idcontrato = $resulcontrato[$ct]['cosId'];

                // Insertar nueva factura maestro
                $sql = $this->_db->exec("INSERT INTO facturacion_maestro (froNomFctura,froPeriodo,froContrato,froFecha,froFechaVencimiento) "
                        . "VALUES ($nuevo_numero_de_factura," . $_POST['txtPeriodo'] . ",$Idcontrato,'" . $_POST['dateFechaFacturacion'] . "','" . $_POST['dateFechaVencimiento'] . "')");

                // Consulta facturas vencidas relacionadas al contrato
                $facturavencida = $this->_db->query("SELECT froNomFctura, froContrato, froPeriodo, froTotalVenta, froEstadoFactura, CONCAT_WS('/', perMes, PerAno) AS Concepto FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE froEstadoFactura='VENCIDA' AND froContrato=$Idcontrato");
                $consultafacturavencida = $facturavencida->fetchAll();

                // Ciclo para registrar detalles de facturas vencidas
                for ($FV = 0; $FV < count($consultafacturavencida); $FV++) {
                    $codFacvencida = $consultafacturavencida[$FV]['froNomFctura'];
                    $valorFacVencida = $consultafacturavencida[$FV]['froTotalVenta'];
                    $ConceptoVencida = $consultafacturavencida[$FV]['Concepto'];

                    // Insertar detalle de factura vencida
                    $sql5 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura,fleCodigoServicio,flePrecioVenta,fleNombreServicio)"
                            . "VALUES($nuevo_numero_de_factura,$codFacvencida,$valorFacVencida,'$ConceptoVencida')");

                    $valorFacrurasVencidas = $consultafacturavencida[$FV]['froTotalVenta'];

                    $sql136 = $this->_db->exec("UPDATE facturacion_maestro SET froEstadoFactura='VENCIDA_ASIGNADA' WHERE froNomFctura=$codFacvencida");
                }

                // Consulta servicio inicial del contrato
                $ConsultaservicioInicial_CTO = $this->_db->query("SELECT cosIdservicio,sosNombre,sosValor FROM contrartos INNER JOIN servicios ON contrartos.cosIdservicio=servicios.sosId WHERE contrartos.cosId=$Idcontrato");
                $resultadoSercio_Inicial_CTO = $ConsultaservicioInicial_CTO->fetchAll();

                // Ciclo para registrar detalles de servicio inicial
                for ($FC = 0; $FC < count($resultadoSercio_Inicial_CTO); $FC++) {
                    $idservicio = $resultadoSercio_Inicial_CTO[$FC]['cosIdservicio'];
                    $sosNombres = $resultadoSercio_Inicial_CTO[$FC]['sosNombre'];
                    $sosValors = $resultadoSercio_Inicial_CTO[$FC]['sosValor'];

                    // Insertar detalle de servicio inicial en factura
                    $sql5 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura,fleCodigoServicio,flePrecioVenta,fleNombreServicio)"
                            . "VALUES($nuevo_numero_de_factura,$idservicio,$sosValors,'$sosNombres')");

                    $valor_saldo_inicial = $resultadoSercio_Inicial_CTO[$FC]['sosValor'];
                }

                // Consulta servicios adicionales del contrato
                $ConsultaservicioAdicional_CTO = $this->_db->query("SELECT spfId,spfIdServicio,spfEstado,sosNombre,sosValor,spfValor FROM servicios_por_facturar INNER JOIN servicios ON servicios_por_facturar.spfIdServicio=servicios.sosId WHERE servicios_por_facturar.spfIdContrato=$Idcontrato AND servicios_por_facturar.spfEstado='P'");
                $resultadoSercio_Adicional_CTO = $ConsultaservicioAdicional_CTO->fetchAll();

                if (empty($resultadoSercio_Adicional_CTO)) {
                    // No hay servicios adicionales
                } else {
                    // Ciclo para registrar detalles de servicios adicionales
                    for ($Fda = 0; $Fda < count($resultadoSercio_Adicional_CTO); $Fda++) {
                        $IDSERVICIOADICIONAL = $resultadoSercio_Adicional_CTO[$Fda]['spfId'];
                        $idservicioa = $resultadoSercio_Adicional_CTO[$Fda]['spfIdServicio'];
                        $sosNombresa = $resultadoSercio_Adicional_CTO[$Fda]['sosNombre'];
                        $sosValorsa = $resultadoSercio_Adicional_CTO[$Fda]['spfValor'];

                        // Insertar detalle de servicio adicional en factura
                        $sql6 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura,fleCodigoServicio,flePrecioVenta,fleNombreServicio)"
                                . "VALUES($nuevo_numero_de_factura,$idservicioa,$sosValorsa,'$sosNombresa')");

                        $sql12 = $this->_db->exec("UPDATE servicios_por_facturar SET spfEstado='I' WHERE spfId=$IDSERVICIOADICIONAL");

                        $valor_saldo_adicional = $resultadoSercio_Adicional_CTO[$Fda]['sosValor'];
                    }
                }

                $valordeuno++;
                $count = +1;

                // Obtener el valor total de la factura
                $consultavalortotalFac = $this->_db->query("SELECT SUM(flePrecioVenta) AS totalvalor FROM facturacion_detalle WHERE fleIdFactura = $nuevo_numero_de_factura");
                $resultadovalortotalfac = $consultavalortotalFac->fetchAll();

                $valor_total_factura = $resultadovalortotalfac[0]['totalvalor'];

                $sql7 = $this->_db->exec("UPDATE facturacion_maestro SET froTotalVenta=$valor_total_factura, froEstadoFactura='PORPAGAR' WHERE froNomFctura=$nuevo_numero_de_factura");

                $valor_saldo_inicial = 0;
                $valor_saldo_adicional = 0;
                $valor_total_factura = 0;

                $sql8 = $this->_db->exec("UPDATE tbperiodos SET perEstado='a' WHERE perId=" . $_POST['txtPeriodo'] . "");
            }

            return $count;
        } else {
            return 0;
        }
    }

    function Consulta_Cantidad_Facturas_Periodo_Actual() {
        $consultraperiodo = $this->_db->query("SELECT froPeriodo FROM facturacion_maestro WHERE froEstadoFactura=''");
        $periodo = $consultraperiodo->fetchall();
        $array_j = array();
        if ($periodo[0]['froPeriodo'] = 0) {
            
        } else {
            $numero = $periodo[0]['froPeriodo'];
            $sql = $this->_db->query("SELECT perMes, COUNT(*) AS total FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo = tbperiodos.perId WHERE perId = $numero AND PerAno = YEAR(NOW())
");
            return $sql->fetchall();
        }
    }

    function consultacantidadfacturasactivas() {
        $sql = $this->_db->query("SELECT froEstadoFactura, COUNT(*) AS total FROM facturacion_maestro WHERE froEstadoFactura = 'PORPAGAR'");
        return $sql->fetchall();
    }

    function Consulta_Cantidad_Facturas_PORPAGAR_PORBARRIOS() {
        $sql = $this->_db->query("SELECT baid, banombre, COUNT(*) cantidad_facturas_barrio FROM barrios INNER JOIN clientes ON barrios.baid = clientes.uosIdBarrio INNER JOIN contrartos ON clientes.uosDocumento = contrartos.cosIdusuario INNER JOIN facturacion_maestro ON contrartos.cosId = facturacion_maestro.froContrato WHERE froEstadoFactura = 'PORPAGAR' GROUP BY banombre ORDER BY cantidad_facturas_barrio DESC;
");
        return $sql->fetchall();
    }

    function generarfacturacion2() {
        if ($_POST) {
//            consulta contratos activos
            $contratosfac = $this->_db->query("SELECT froNomFctura, froContrato FROM facturacion_maestro WHERE froEstadoFactura = 'activa'");
            $resulcontrato = $contratosfac->fetchall();
            $array_j = array();
//            creo ciclo con cantidad de onsulta
            for ($j = 0; $j < count($resulcontrato); $j++) {
                $Idcontrato = $resulcontrato[$j]['froContrato'];
                $froNomFctura = $resulcontrato[$j]['froNomFctura'];


                $servicioxcto = $this->_db->query("SELECT cosIdservicio, sosNombre, sosValor FROM contrartos INNER JOIN servicios ON contrartos.cosIdservicio = servicios.sosId WHERE contrartos.cosId = $Idcontrato");
                $resulservicioxcto = $servicioxcto->fetchall();


                $sql5 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio)VALUES($froNomFctura, '1', '1400', 'casd')");
            }
            return $sql5;
//             creo ciclo con cantidad de onsulta                         
            $idservicio = $resulservicioxcto[$i]['cosIdservicio'];
            $sosNombres = $resulservicioxcto[$i]['sosNombre'];
            $sosValors = $resulservicioxcto[$i]['sosValor'];


            $sql = $this->_db->exec("INSERT INTO facturacion_maestro (froPeriodo, froContrato, froFecha, froFechaVencimiento) "
                    . "VALUES ('8', $Idcontrato, '" . $_POST['dateFechaFacturacion'] . "', '" . $_POST['dateFechaVencimiento'] . "')");
//                consulto ultimo contrato activo
            return $sql;

            $sql5 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio) "
                    . "VALUES('53', '1', '1400', 'casd')");
            return $sql5;

            $ultfactura = $this->_db->query("SELECT * FROM facturacion_maestro WHERE froNomFctura = (SELECT MAX(froNomFctura) FROM facturacion_maestro) ORDER BY froNomFctura");
//                asigno el valor a una variable              
            $ultimafactura = $ultfactura->fetchall();
            $array_i = array();


            $resulultimafact = $ultimafactura[0]['froNomFctura'];
//               
            $servicioxcto = $this->_db->query("SELECT cosIdservicio, sosNombre, sosValor FROM contrartos INNER JOIN servicios ON contrartos.cosIdservicio = servicios.sosId WHERE contrartos.cosId = $Idcontrato");
            $resulservicioxcto = $servicioxcto->fetchall();
//            creo ciclo con cantidad de onsulta            


            $resulultimafact;
            $idservicio = $resulservicioxcto[$i]['cosIdservicio'];
            $sosNombres = $resulservicioxcto[$i]['sosNombre'];
            $sosValors = $resulservicioxcto[$i]['sosValor'];
            $sql3 = $this->_db->exec("INSERT INTO facturacion_detalle (fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio) VALUES('53', '1', '1400', 'casd')");


//INSERT facturacion_detalle (fleIdFactura, fleCodigoServicio, flePrecioVenta, fleNombreServicio) VALUES('','','','')
            $count = +1;

            return $count;
        } else {
            return 0;
        }
    }

//
//
    function Registrar_Contrato() {
        if ($_POST) {
//            ('203','1075293388','1','2022-09-04 16:37:26','2','P')
//            $sql = $this->_db->exec("INSERT INTO contrartos (cosId, cosIdusuario, cosIdservicio, cosFechaRegistro, cosPuntos, cosEstado) VALUES ('205', '1075293388', '1', '2022-09-04 16:37:26', '2', 'P')");

            $sql = $this->_db->exec("INSERT INTO contrartos (cosId, cosIdusuario, cosIdservicio, cosFechaRegistro, cosPuntos, cosEstado, cosEstilo) VALUES ('" . $_POST['txtContrato'] . "', '" . $_POST['txtCedula'] . "', '" . $_POST['txtServicio'] . "', '" . $_POST['txtFechaRegistro'] . "', '" . $_POST['txtPuntos'] . "', 'P', 'alert-danger')");
            return $sql;

            return $count;
        } else {
            return 0;
        }
    }

    function consultaCliente($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT uosDocumento, uosNombres, uosApellidos, uosTelefono, uosCorreo, uosIdBarrio, banombre, uosDireccion, uosEstado FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio = barrios.baid WHERE clientes.uosDocumento = '" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function Consulta_Servicios() {
        $sql = $this->_db->query("SELECT servicios.sosId, servicios.sosNombre, servicios.sosDescripcion, servicios.sosValor, servicios.sosFechaActualizacion FROM servicios WHERE servicios.sosId = '1'");
        return $sql->fetchall();
    }

    function Consulta_ultimocontrato() {
        $sql = $this->_db->query("SELECT * FROM contrartos WHERE cosId = (SELECT MAX(cosId) FROM contrartos) ORDER BY cosId");
        return $sql->fetchall();
    }

    function RegistrarOrdenes() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO ordendeservicios(IdContrato, FechaGenerada, fechaFinalizada, Estado, usuario, IdServicio, orsestilo, orsTipoServicio)VALUES ('" . $_POST['txtContrato'] . "', '" . $_POST['txtFechaRegistro'] . "', '', 'PENDIENTE', 'Miguel', '" . $_POST['txtServicio'] . "', 'alert-danger', 'INSTALACION')");
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

    function consultaBarrios() {
        $sql = $this->_db->query("SELECT baid, banombre FROM barrios WHERE baestado = 'activo'");
        return $sql->fetchall();
    }

    function Registrar_Clientes() {
        if ($_POST) {
//            
            $sql = $this->_db->exec("INSERT INTO clientes (uosDocumento, uosNombres, uosApellidos, uosTelefono, uosCorreo, uosMunicipio, uosIdBarrio, uosDireccion, uosEstado, uosEstadoContrato) VALUES ('" . $_POST['TXTDOC'] . "', '" . $_POST['TXTNOMCLIENTE'] . "', '" . $_POST['TXTAPELLIDO'] . "', '" . $_POST['TXTTELEFONO'] . "', '" . $_POST['TXTCORREO'] . "', '" . $_POST['TXTMUNICIPIO'] . "', '" . $_POST['CBBarrio'] . "', '" . $_POST['TXTDIRECCION'] . "', 'activo', 'NO ASIGNADO')
");
            return $sql;
        } else {
            return 0;
        }
    }

    function ConsultaClientesEstadosPrincipal() {
        $sql = $this->_db->query(" SELECT cosEstilo, uosDocumento, uosNombres, uosApellidos, uosEstadoContrato, cosId, cosDetalle, cosIdservicio, cosFechaRegistro, cosEstado FROM clientes INNER JOIN contrartos ON clientes.uosDocumento = contrartos.cosIdusuario WHERE clientes.uosEstado = 'activo'");
        return $sql->fetchall();
    }

    function ConsultaClientesEstadosPrincipal1() {
        $sql = $this->_db->query(" SELECT uosDocumento, uosNombres, uosApellidos, uosEstadoContrato FROM clientes WHERE clientes.uosEstado = 'activo' AND clientes.uosEstadoContrato = 'NO ASIGNADO'");
        return $sql->fetchall();
    }

//   SQL SERVICIOS
    function Cconsultadatospersonales() {
        $sql = $this->_db->query("SELECT uosDocumento, uosNombres, uosApellidos, uosTelefono, uosCorreo, uosIdBarrio, banombre, uosDireccion, uosEstado FROM clientes INNER JOIN barrios ON clientes.uosIdBarrio = barrios.baid WHERE clientes.uosEstado = 'activo' AND uosEstadoContrato = 'NO ASIGNADO'");
        return $sql->fetchall();
    }

    function Consulta_Barrios() {
        $sql = $this->_db->query("SELECT barrios.baid, barrios.banombre, barrios.badetalle, barrios.baestado FROM barrios WHERE barrios.baestado = 'activo'");
        return $sql->fetchall();
    }

    function Consulta_ultimoServicio() {
        $sql = $this->_db->query("SELECT * FROM servicios WHERE sosId = (SELECT MAX(sosId) FROM servicios) ORDER BY sosId");
        return $sql->fetchall();
    }

    function GuardarServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO servicios(sosId, sosNombre, sosDescripcion, sosValor, sosFechaActualizacion, sosEstado) VALUES ('" . $_POST['codigoServicio'] . "', '" . $_POST['txtnombreservicio'] . "', '" . $_POST['txtdetalleservicio'] . "', '" . $_POST['txtvalorservicio'] . "', '" . $_POST['txteFecha'] . "', 'activo')");
            return $sql;
        } else {
            return 0;
        }
    }

    function ConsultaServicioEditar($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT servicios.sosId, servicios.sosNombre, servicios.sosDescripcion, servicios.sosValor, servicios.sosFechaActualizacion, servicios.sosEstado FROM servicios WHERE servicios.sosId = '" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function ActualizarServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("UPDATE servicios SET sosNombre = '" . $_POST['txtnombreservicio'] . "', sosDescripcion = '" . $_POST['txtdetalleservicio'] . "', sosValor = '" . $_POST['txtvalorservicio'] . "', sosFechaActualizacion = CURDATE(), sosEstado = 'activo' WHERE sosId = '" . $_POST['txtsosId'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function EliminarServicio($arg = false) {
        if ($arg) {
            $sql = $this->_db->query(" UPDATE servicios SET sosEstado = 'inactivo' WHERE sosId = '" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function MOVEDITServicios() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO historial_novedades (codserv, tipomodificacion, objeto, fecha) VALUES ('" . $_POST['txtsosId'] . "', 'MODIFICACION DE DATOS', '" . $_POST['txtModificacion'] . "', CURRENT_TIME())");
            return $sql;
        } else {
            return 0;
        }
    }

    function ConsultaNovedades($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT codserv, sosNombre, tipomodificacion, objeto, fecha FROM historial_novedades INNER JOIN servicios ON historial_novedades.codserv = servicios.sosId WHERE historial_novedades.codserv = '" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listacategorias() {
        $sql = $this->_db->query(" SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasEstado = 'a' ORDER BY categorias.iasNombre");
        return $sql->fetchall();
    }

    function consultauncategoria($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasId = '" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function bajacategoria($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE categorias SET categorias.iasEstado = 'I' WHERE categorias.iasId = '" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

}
