<?php

class administracionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    function Consulta_Oden_Pendientes() {

        $sql = $this->_db->query("SELECT COUNT(Codigo) AS total FROM ordendeservicios WHERE Estado='PENDIENTE'");
        return $sql->fetchall();
    }

    function CONSULTAVENTASMES() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();

        $ULTP = $RESULT[0]['ULTIMOPERIODO'];
        $sql = $this->_db->query("SELECT SUM(froTotalVenta) AS TOTAL FROM facturacion_maestro WHERE froEstadoFactura='PAGADA' AND froPeriodo=$ULTP");
        return $sql->fetchall();
    }

    function Consulta_Activos() {

        $sql = $this->_db->query("SELECT COUNT(cosId) AS total FROM Contrartos WHERE cosEstado='ACTIVO'");
        return $sql->fetchall();
    }

    function Consulta_total() {

        $sql = $this->_db->query("SELECT COUNT(`cosId`) AS total FROM Contrartos WHERE cosEstado='ACTIVO' OR cosEstado='SUSPENDIDO' OR cosEstado='P'");
        return $sql->fetchall();
    }

    function Consulta_pendiente() {

        $sql = $this->_db->query("SELECT COUNT(`cosId`) AS total FROM Contrartos WHERE cosEstado='P'");
        return $sql->fetchall();
    }

    function consulta_consolidado_ventas() {

        $sql = $this->_db->query("SELECT perMes, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='PAGADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_PORPAGAR() {

        $sql = $this->_db->query("SELECT perMes, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='PORPAGAR' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function consulta_consolidado_vencida() {

        $sql = $this->_db->query("SELECT perMes, (CASE WHEN SUM(froTotalVenta)='O' THEN '0' ELSE SUM(froTotalVenta) END) AS froTotalVenta  FROM facturacion_maestro INNER JOIN tbperiodos ON facturacion_maestro.froPeriodo=tbperiodos.perId WHERE PerAno='2023' AND froEstadoFactura='VENCIDA_ASIGNADA' GROUP BY perMes
");
        return $sql->fetchall();
    }

    function Consulta_Morosos() {
        $sql253 = $this->_db->query("SELECT MAX(froPeriodo) AS ULTIMOPERIODO FROM facturacion_maestro");
        $RESULT = $sql253->fetchall();

        $ULTP = $RESULT[0]['ULTIMOPERIODO'];
        $sql = $this->_db->query("SELECT COUNT(froNomFctura) AS MOROSOS FROM facturacion_maestro WHERE froEstadoFactura='PORPAGAR' AND froTotalVenta>'20000' AND froPeriodo=$ULTP");
        return $sql->fetchall();
    }

    function CONSULTA_CAJAGENERAL() {
        $sql = $this->_db->query("SELECT tasNombre, tasValor FROM tb_cuentas WHERE tasNombre='Efectivo'");
        return $sql->fetchall();
    }

    function CONSULTA_SUSPENDIDOS() {
        $sql = $this->_db->query("SELECT COUNT(cosEstado) AS SUPENDIDOS FROM `contrartos` WHERE cosEstado='SUSPENDIDO'");
        return $sql->fetchall();
    }

//    PARAMETROS ____________________________________________________________________________________________________________________________________________________
    function barrios() {
        $sql = $this->_db->query("SELECT proveedores.resCod, proveedores.resRasonSocial, proveedores.resDireccion, proveedores.resTelefono, proveedores.resEmail, proveedores.resDescripcion FROM proveedores WHERE proveedores.resEstado='a' ORDER BY proveedores.resRasonSocial");
        return $sql->fetchall();
    }

    function listaproductos2() {
        $sql = $this->_db->query("SELECT barrios.baid,barrios.banombre,barrios.badetalle,barrios.baestado FROM barrios WHERE barrios.baestado='activo'");
        return $sql->fetchall();
    }

    function consultaunproveedor($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT proveedores.resCod, proveedores.resRasonSocial, proveedores.resDireccion, proveedores.resTelefono, proveedores.resEmail, proveedores.resDescripcion FROM proveedores WHERE proveedores.resCod='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listaclientes() {
        $sql = $this->_db->query("SELECT proveedores.resCod, proveedores.resRasonSocial, proveedores.resDireccion, proveedores.resTelefono, proveedores.resEmail, proveedores.resDescripcion FROM proveedores WHERE proveedores.resEstado='a' AND proveedores.resCliente='activo' ORDER BY proveedores.resRasonSocial");
        return $sql->fetchall();
    }

    function consultauncliente($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT proveedores.resCod, proveedores.resRasonSocial, proveedores.resDireccion, proveedores.resTelefono, proveedores.resEmail, proveedores.resDescripcion FROM proveedores WHERE proveedores.resCliente='activo' AND proveedores.resCod='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function setproveedores() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO proveedores(resCod, resRasonSocial, resDireccion, resTelefono,resEmail, resDescripcion, resEstado) VALUES ('" . $_POST['resCod'] . "','" . $_POST['txtRazonSocial'] . "','" . $_POST['txtDireccion'] . "','" . $_POST['txtTelefono'] . "','" . $_POST['txtEmail'] . "','" . $_POST['txtDescripcion'] . "','A') ON DUPLICATE KEY UPDATE resCod='" . $_POST['resCod'] . "', resRasonSocial='" . $_POST['txtRazonSocial'] . "', resDireccion='" . $_POST['txtDireccion'] . "', resTelefono='" . $_POST['txtTelefono'] . "', resEmail='" . $_POST['txtEmail'] . "', resDescripcion='" . $_POST['txtDescripcion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setclientes() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO proveedores(resCod, resRasonSocial, resDireccion, resTelefono,resEmail, resDescripcion, resEstado, resCliente) VALUES ('" . $_POST['resCod'] . "','" . $_POST['txtRazonSocial'] . "','" . $_POST['txtDireccion'] . "','" . $_POST['txtTelefono'] . "','" . $_POST['txtEmail'] . "','" . $_POST['txtDescripcion'] . "', 'A', 'activo') ON DUPLICATE KEY UPDATE resCod='" . $_POST['resCod'] . "', resRasonSocial='" . $_POST['txtRazonSocial'] . "', resDireccion='" . $_POST['txtDireccion'] . "', resTelefono='" . $_POST['txtTelefono'] . "', resEmail='" . $_POST['txtEmail'] . "', resDescripcion='" . $_POST['txtDescripcion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function bajaproveedor($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE proveedores SET proveedores.resEstado='I' WHERE proveedores.resCod='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    ////////////////////////////
    function setcategorias() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO categorias(iasId, iasNombre, iasDescripcion, iasEstado) VALUES ('" . $_POST['iasId'] . "','" . $_POST['iasNombre'] . "','" . $_POST['iasDescripcion'] . "','A') ON DUPLICATE KEY UPDATE iasId='" . $_POST['iasId'] . "', iasNombre='" . $_POST['iasNombre'] . "', iasDescripcion='" . $_POST['iasDescripcion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function listacategorias() {
        $sql = $this->_db->query(" SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasEstado='a' ORDER BY categorias.iasNombre");
        return $sql->fetchall();
    }

    function consultauncategoria($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT categorias.iasId, categorias.iasNombre, categorias.iasDescripcion FROM categorias WHERE categorias.iasId='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function bajacategoria($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE categorias SET categorias.iasEstado='I' WHERE categorias.iasId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    //productos

    function listaproductos() {
        $sql = $this->_db->query("SELECT  tosId, tosNombre, tosMarca, tosDescripcion, tosIdCategoria, iasNombre, tosFechaRegistro, tosIdUsuario, tosEstado FROM productos INNER JOIN categorias ON productos.tosIdCategoria=categorias.iasId WHERE productos.tosEstado='A'");
        return $sql->fetchall();
    }

    function insertarProductos() {
        if ($_POST) {
            for ($i = 1; $i < count($_POST['tosNombre']); $i++) {
                $count = $this->_db->exec("INSERT INTO productos (tosNombre,tosMarca,tosDescripcion,tosIdCategoria,tosFechaRegistro,tosIdUsuario,tosEstado) VALUES ('" . $_POST['tosNombre'][$i] . "','" . $_POST['tosMarca'][$i] . "','" . $_POST['tosDescripcion'][$i] . "','" . $_POST['cmbCategoria'] . "',NOW(),'" . $_POST['txtusuario'] . "','A')");
            }
            return $count;
        } else {

            return 0;
        }
    }

    function bajaproducto($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE productos SET productos.tosEstado='I' WHERE productos.tosId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    ////////////////////
    function listaprdoductos() {
        $sql = $this->_db->query(" SELECT prodoductos.tosId, prdoductos.etosNombre, prdoductos.etosPresentacion, prdoductos.etosPresentacion, prdoductos.etosPresentacion FROM prdoductos WHERE prdoductos.iasEstado='a' ORDER BY prdoductos.iasNombre");
        return $sql->fetchall();
    }

    function listausuarios() {
        $sql = $this->_db->query("SELECT usuarios.uiosId, usuarios.uiosEmailFK, usuarios.uiosNombres, usuarios.uiosTelefono, usuarios.uiosDocumento, usuarios.uiosFechaEspecial FROM usuarios ORDER BY usuarios.uiosNombres");
        return $sql->fetchall();
    }

    function vercertificados() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT certificados.cerNombre FROM certificados WHERE certificados.cerMedico='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function estadocitas() {
        if ($_POST) {
            $array = array();
            $estado = array("Pendiente", "Programada", "Cancelada", "Atendida");
            for ($i = 0; $i < count($estado); $i++) {
                $e = array();
                $e['estado'] = $estado[$i];
                $sql = $this->_db->query("SELECT COUNT(citas.ctasId) as cant FROM citas "
                        . "WHERE citas.ctasEstado='" . $estado[$i] . "' AND citas.ctasFecha BETWEEN '" . $_POST['fechai'] . "' AND '" . $_POST['fechaf'] . "' GROUP BY citas.ctasEstado");
                $res = $sql->fetchall();
                if (count($res) > 0) {
                    $e['cantidad'] = $res[0]['cant'];
                } else {
                    $e['cantidad'] = 0;
                }
                array_push($array, $e);
            }
            return $array;
        } else {
            
        }
    }

    function listarcitasusuariosreporte() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT citas.ctasId, usuarios.uiosNombres, usuarios.uiosTelefono, especialidad.espNombre, citas.ctasObservaciones, citas.ctasFecha, citas.ctasHora, citas.ctasEstado FROM citas "
                    . "INNER JOIN usuarios ON citas.ctasEmailFK=usuarios.uiosEmailFK "
                    . "INNER JOIN especialidad ON citas.ctasServicio=especialidad.espId "
                    . "WHERE citas.ctasFecha BETWEEN '" . $_POST['fechai'] . "' AND '" . $_POST['fechaf'] . "' ORDER BY citas.ctasId DESC");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function setrol() {
        if ($_POST) {
            if (!empty($_POST['confirmPassword'])) {
                $sql = $this->_db->exec("INSERT INTO roles(rlesId,rlesNombreRol, rlesUsuario, rlesPassword, rlesTipo, rlesEstado) VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtUsuario'] . "','" . Hash::getHash('sha1', $_POST['confirmPassword'], HASH_KEY) . "','" . $_POST['txtRol'] . "','" . $_POST['txtEstado'] . "') ON DUPLICATE KEY UPDATE rlesNombreRol='" . $_POST['txtNombre'] . "', rlesUsuario='" . $_POST['txtUsuario'] . "', rlesPassword='" . Hash::getHash('sha1', $_POST['confirmPassword'], HASH_KEY) . "', rlesTipo='" . $_POST['txtRol'] . "', rlesEstado='" . $_POST['txtEstado'] . "'");
            } else {
                $sql = $this->_db->exec("INSERT INTO roles(rlesId,rlesNombreRol, rlesUsuario, rlesPassword, rlesTipo, rlesEstado) VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtUsuario'] . "','" . Hash::getHash('sha1', $_POST['confirmPassword'], HASH_KEY) . "','" . $_POST['txtRol'] . "','" . $_POST['txtEstado'] . "') ON DUPLICATE KEY UPDATE rlesNombreRol='" . $_POST['txtNombre'] . "', rlesUsuario='" . $_POST['txtUsuario'] . "', rlesTipo='" . $_POST['txtRol'] . "', rlesEstado='" . $_POST['txtEstado'] . "'");
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function onerol() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT roles.rlesId, roles.rlesNombreRol, roles.rlesUsuario, roles.rlesPassword, roles.rlesTipo, roles.rlesEstado FROM roles WHERE roles.rlesId='" . $_POST['id'] . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function roles() {
        $sql = $this->_db->query("SELECT roles.rlesId, roles.rlesNombreRol, roles.rlesTipo FROM roles");
        return $sql->fetchall();
    }

    function cancelarcita() {
        if ($_POST) {
            $cancelprogramado = $this->_db->exec("UPDATE programado SET programado.pdoEstado='C' WHERE programado.pdoIdCita='" . $_POST['txtCodigo'] . "'");
            $sql = $this->_db->exec("UPDATE citas SET citas.ctasEstado='Cancelada' WHERE citas.ctasId='" . $_POST['txtCodigo'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function usuarioscitas() {
        $sql = $this->_db->query("SELECT usuarios.uiosEmailFK, usuarios.uiosNombres FROM usuarios INNER JOIN citas ON usuarios.uiosEmailFK=citas.ctasEmailFK GROUP BY usuarios.uiosEmailFK ORDER BY usuarios.uiosNombres");
        return $sql->fetchall();
    }

    function onetoken() {
        if ($_POST) {
            $sql = $this->_db->query("SELECT usuarios.uiosIdPhone FROM usuarios INNER JOIN citas ON usuarios.uiosEmailFK=citas.ctasEmailFK WHERE citas.ctasId='" . $_POST['txtCodigo'] . "'");
            $res = $sql->fetchall();
            $token[] = $res[0]['uiosIdPhone'];
            return $token;
        } else {
            return 0;
        }
    }

    function guardarProgramacion() {
        if ($_POST) {
            $ok = false;
            date_default_timezone_set('America/Bogota');
            $fechaActual = date('Y-m-d');
            $horaActual = date('H:i:s');
            $fechaCita = $_POST['txtFecha'];
            $horaCita = $_POST['txtHora'];
            $fechaActualM = strtotime($fechaActual);
            $fechaCitaM = strtotime($fechaCita);
            $horaActualM = strtotime($horaActual);
            $horaCitaM = strtotime($horaCita);
            if ($fechaCitaM < $fechaActualM) {
                $e['mensaje'] = 'La fecha de la cita no puede ser menor ala fecha actual';
                $e['response'] = 'Error';
            } else if ($fechaCitaM == $fechaActualM) {
                if ($horaCitaM < $horaActualM) {
                    $e['mensaje'] = 'La hora de la cita no puede ser menor ala hora actual';
                    $e['response'] = 'Error';
                } else {
                    $horaCita = strtotime($horaCita);
                    $horaCitaHora = strtotime('+ 1 hours', $horaCita);
                    $horaCitaHora = date('H:i:s', $horaCitaHora);
                    $horaCita = date('H:i:s', $horaCita);
                    $query = $this->_db->query("SELECT * FROM programado "
                            . "WHERE programado.pdoFecha='" . $fechaCita . "' "
                            . "AND TIME(programado.pdoHora) BETWEEN '" . $horaCita . "' AND '" . $horaCitaHora . "' "
                            . "AND programado.pdoEstado='A' AND programado.pdoDoctor='" . $_POST['txtMedico'] . "'");
                    $res = $query->fetchall();
                    if (count($res) <= 0) {
                        $ok = true;
                    } else {
                        $e['mensaje'] = 'Ya existe una cita con las mismas caracteristicas';
                        $e['response'] = 'Error';
                    }
                }
            } else if ($fechaCitaM > $fechaActualM) {
                $horaCita = strtotime($horaCita);
                $horaCitaHora = strtotime('+ 1 hours', $horaCita);
                $horaCitaHora = date('H:i:s', $horaCitaHora);
                $horaCita = date('H:i:s', $horaCita);
                $query = $this->_db->query("SELECT * FROM programado "
                        . "WHERE programado.pdoFecha='" . $fechaCita . "' "
                        . "AND TIME(programado.pdoHora) BETWEEN '" . $horaCita . "' AND '" . $horaCitaHora . "' "
                        . "AND programado.pdoEstado='A' AND programado.pdoDoctor='" . $_POST['txtMedico'] . "'");
                $res = $query->fetchall();
                if (count($res) <= 0) {
                    $ok = true;
                } else {
                    $e['mensaje'] = 'Ya existe una cita con las mismas caracteristicas ' . $horaCita . '-' . $horaCitaHora;
                    $e['response'] = 'Error';
                }
            }
            if ($ok) {
                $cita = $this->_db->exec("UPDATE citas SET citas.ctasEstado='Programada' WHERE citas.ctasId='" . $_POST['txtCodigo'] . "'");
                $sql = $this->_db->exec("INSERT INTO programado(pdoId, pdoIdCita, pdoFecha, pdoHora, pdoDoctor, pdoSede, pdoEstado) "
                        . "VALUES ('" . $_POST['txtCodigoProgramacion'] . "','" . $_POST['txtCodigo'] . "','" . $_POST['txtFecha'] . "','" . $_POST['txtHora'] . "','" . $_POST['txtMedico'] . "','" . $_POST['txtSede'] . "','A') "
                        . "ON DUPLICATE KEY UPDATE pdoFecha='" . $_POST['txtFecha'] . "', pdoHora='" . $_POST['txtHora'] . "', pdoDoctor='" . $_POST['txtMedico'] . "', pdoSede='" . $_POST['txtSede'] . "'");
                if ($sql) {
                    $e['mensaje'] = 'Cita programada exitosamente, próximamente sera aceptada.';
                    $e['response'] = 'Success';
                } else {
                    $e['mensaje'] = 'Ha ocurrido un error al programar la cita';
                    $e['response'] = 'Error';
                }
            }
            return $e;
        } else {
            return 0;
        }
    }

    function listardoctores($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT doctores.docId, doctores.docNombre, doctores.docApellido FROM doctores WHERE doctores.docEstado='A' AND doctores.docEspecialidad='" . $arg . "' ORDER BY doctores.docNombre");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function bajasedes($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("UPDATE sedes SET sedes.sedeEstado='I' WHERE sedes.sedeId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function pqrsf() {
        $query = "SELECT usuarios.uiosNombres, pqrsf.psfCorreo, pqrsf.psfId, usuarios.uiosTelefono, pqrsf.psfTipo, pqrsf.psfDescripcion, pqrsf.psfFecha FROM pqrsf INNER JOIN usuarios ON pqrsf.psfCorreo=usuarios.uiosEmailFK";
        $sql = $this->getQuery($query);
        return $sql;
    }

    function bajasede($arg = false) {
        if ($arg) {
            $query = "UPDATE especialidad SET especialidad.espEstado='I' WHERE especialidad.espId='" . $arg . "'";
            $sql = $this->getExec($query);
            return $sql;
        } else {
            return 0;
        }
    }

    function setsede() {
        if ($_POST) {
            $sql = $this->_db->exec("INSERT INTO sedes(sedeId, sedeNombre, sedeDireccion, sedeEstado) VALUES "
                    . "('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtDireccion'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE sedeNombre='" . $_POST['txtNombre'] . "', sedeDireccion='" . $_POST['txtDireccion'] . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function onesedes($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT sedes.sedeId, sedes.sedeNombre, sedes.sedeDireccion FROM sedes WHERE sedes.sedeId='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listasedes() {
        $sql = $this->_db->query("SELECT sedes.sedeId, sedes.sedeNombre, sedes.sedeDireccion FROM sedes WHERE sedes.sedeEstado='A' ORDER BY sedes.sedeNombre");
        return $sql->fetchall();
    }

    function bajamedico($arg = false) {
        if ($arg) {
            $sql = $this->_db->exec("UPDATE doctores SET doctores.docEstado='I' WHERE doctores.docId='" . $arg . "'");
            return $sql;
        } else {
            return 0;
        }
    }

    function setmedico() {
        if ($_POST) {
            if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
                $sql = $this->_db->exec("INSERT INTO doctores(docId, docNombre, docApellido, docDireccion, docTelefono, docEspecialidad, docEstado, docUsuario, docPassword) "
                        . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtApellido'] . "','" . $_POST['txtDireccion'] . "','" . $_POST['txtTelefono'] . "','" . $_POST['txtEspecialidad'] . "','A','" . $_POST['txtUsuario'] . "','" . Hash::getHash('sha1', $_POST['confirmPassword'], HASH_KEY) . "') "
                        . "ON DUPLICATE KEY UPDATE docNombre='" . $_POST['txtNombre'] . "', docApellido='" . $_POST['txtApellido'] . "', docDireccion='" . $_POST['txtDireccion'] . "', docTelefono='" . $_POST['txtTelefono'] . "', docEspecialidad='" . $_POST['txtEspecialidad'] . "', docUsuario='" . $_POST['txtUsuario'] . "', docPassword='" . Hash::getHash('sha1', $_POST['confirmPassword'], HASH_KEY) . "'");
            } else {
                $sql = $this->_db->exec("INSERT INTO doctores(docId, docNombre, docApellido, docDireccion, docTelefono, docEspecialidad, docEstado, docUsuario) "
                        . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtApellido'] . "','" . $_POST['txtDireccion'] . "','" . $_POST['txtTelefono'] . "','" . $_POST['txtEspecialidad'] . "','A','" . $_POST['txtUsuario'] . "') "
                        . "ON DUPLICATE KEY UPDATE docNombre='" . $_POST['txtNombre'] . "', docApellido='" . $_POST['txtApellido'] . "', docDireccion='" . $_POST['txtDireccion'] . "', docTelefono='" . $_POST['txtTelefono'] . "', docEspecialidad='" . $_POST['txtEspecialidad'] . "', docUsuario='" . $_POST['txtUsuario'] . "'");
            }
            $id = $this->_db->lastInsertId();
            if (isset($_FILES['txtCertificado'])) {
                for ($i = 0; $i < count($_FILES['txtCertificado']['name']); $i++) {
                    if ($_FILES['txtCertificado']['error'][$i] != 4) {
                        $nombrearchivo = htmlentities($_FILES['txtCertificado']['name'][$i]);
                        $res = $this->_db->exec("INSERT INTO certificados(cerNombre, cerMedico, cerEstado) "
                                . "VALUES ('" . $nombrearchivo . "','" . $id . "','A')");
                    }
                }
            }
            return $sql;
        } else {
            return 0;
        }
    }

    function onemedico($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT doctores.docId, doctores.docNombre, doctores.docApellido, doctores.docDireccion, doctores.docTelefono, doctores.docEspecialidad, doctores.docUsuario FROM doctores "
                    . "WHERE doctores.docId='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function onedoctor($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT doctores.docId, doctores.docNombre, doctores.docApellido FROM doctores WHERE doctores.docId='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listarprogramado($arg = false) {
        if ($arg) {
            $sql = $this->_db->query("SELECT programado.pdoId, programado.pdoFecha, programado.pdoHora, programado.pdoSede, programado.pdoIdCita, programado.pdoDoctor, especialidad.espId, citas.ctasEstado FROM programado "
                    . "INNER JOIN doctores ON programado.pdoDoctor=doctores.docId "
                    . "INNER JOIN especialidad ON doctores.docEspecialidad=especialidad.espId INNER JOIN citas ON programado.pdoIdCita=citas.ctasId "
                    . "WHERE programado.pdoIdCita='" . $arg . "'");
            return $sql->fetchall();
        } else {
            return 0;
        }
    }

    function listarsedes() {
        $sql = $this->_db->query("SELECT sedes.sedeId, sedes.sedeNombre FROM sedes WHERE sedes.sedeEstado='A' ORDER BY sedes.sedeNombre");
        return $sql->fetchall();
    }

    function listarespecialidades() {
        $query = "SELECT especialidad.espId, especialidad.espNombre, especialidad.espDescripcion FROM especialidad WHERE especialidad.espEstado='A' ORDER BY especialidad.espNombre";
        $sql = $this->getQuery($query);
        return $sql;
    }

    function setespecialidad() {
        if ($_POST) {
            $query = "INSERT INTO especialidad (espId,espNombre,espDescripcion, espEstado) "
                    . "VALUES ('" . $_POST['txtCodigo'] . "','" . $_POST['txtNombre'] . "','" . $_POST['txtDescripcion'] . "','A') "
                    . "ON DUPLICATE KEY UPDATE espNombre='" . $_POST['txtNombre'] . "', espDescripcion='" . $_POST['txtDescripcion'] . "'";
            $sql = $this->getExec($query);
            return $sql;
        } else {
            return 0;
        }
    }

    function oneespecialidad($arg = false) {
        if ($arg) {
            $query = "SELECT especialidad.espId, especialidad.espNombre, especialidad.espDescripcion FROM especialidad "
                    . "WHERE especialidad.espId='" . $arg . "'";
            $sql = $this->getQuery($query);
            return $sql;
        } else {
            return 0;
        }
    }

    function listarcitas() {
        date_default_timezone_set('America/Bogota');
        $fechaActual = date('Y-m-d');
        $sql = $this->_db->query("SELECT citas.ctasId, usuarios.uiosNombres, usuarios.uiosTelefono, especialidad.espNombre, citas.ctasObservaciones, citas.ctasFecha, citas.ctasHora, citas.ctasEstado FROM citas "
                . "INNER JOIN usuarios ON citas.ctasEmailFK=usuarios.uiosEmailFK "
                . "INNER JOIN especialidad ON citas.ctasServicio=especialidad.espId ORDER BY citas.ctasId DESC");
        return $sql->fetchall();
    }

////////////////////////////////////////////////////
}
