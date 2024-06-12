<?php

class View {

    private $_cont;

    public function __construct($c) {
        $this->_cont = $c;
    }

    public function renderizar($vista, $layout, $NoLayout = false) {
        $nombrelayoyt = $layout . "Layout";
        $men1 = $this->menu();
        $men12 = $this->menu1();
        $_layoutParams = array(
            'ruta_img' => RUTA_URL . 'public/' . $nombrelayoyt . '/img/',
            'ruta_js' => RUTA_URL . 'public/' . $nombrelayoyt . '/js/',
            'ruta_css' => RUTA_URL . 'public/' . $nombrelayoyt . '/css/',
            'menu' => $men1,
            'menu1' => $men12
        );
        $rutaview = ROOT . $this->_cont . DS . 'views' . DS . $vista . '.phtml';
        if (is_readable($rutaview)) {
            if ($NoLayout) {
                include_once $rutaview;
                exit();
            }
            include_once ROOT . 'public' . DS . $nombrelayoyt . DS . 'header.phtml';
            include_once $rutaview;
            include_once ROOT . 'public' . DS . $nombrelayoyt . DS . 'footer.phtml';
        } else {
            throw new Exception("error en la vista");
        }
    }

    public function menu() {
        $menu = array();
        if (Session::get('autenticado') && Session::get('level') == 'General') {
            $menu = array(
                array(
                    'id' => 'Inicio',
                    'titulo' => 'Inicio',
                    'icono' => 'fa fa-fw  fa-home',
                    'enlace' => RUTA_URL . 'administracion/bienvenido',
                    'sub' => 'inicio',
                ),
                array(
                    'id' => 'facturacion',
                    'titulo' => 'Suscripciones',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'facturacion/suscriptores',
                    'sub' => 'facturacion',
                ),
                array(
                    'id' => 'facturacion',
                    'titulo' => 'Pagos',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'facturacion/pagos',
                    'sub' => 'facturacion',
                ),
                array(
                    'id' => 'facturacion',
                    'titulo' => 'Generar Facturacion',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'facturacion/facturacion',
                    'sub' => 'facturacion',
                ),
                array(
                    'id' => 'facturacion',
                    'titulo' => 'Factura Unica',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'facturacion/factutaunica',
                    'sub' => 'facturacion',
                ),
                //                menu ordenes
                array(
                    'id' => 'ordenes',
                    'titulo' => 'Por Ejecutar',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'ordenes/ordenes',
                    'sub' => 'ordenes',
                ),
                array(
                    'id' => 'ordenes',
                    'titulo' => 'Ejecutadas',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'ordenes/ordenesRealizadas',
                    'sub' => 'ordenes',
                ),
//                RECURSOS HUMANOS
                array(
                    'id' => 'recursos',
                    'titulo' => 'Clientes',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'humanos/inicioclientes',
                    'sub' => 'recursos',
                ),
//                array(
//                    'id' => 'recursos',
//                    'titulo' => 'Empleados',
//                    'icono' => 'fa fa-fw  fa-cogs',
//                    'enlace' => RUTA_URL . 'administracion/bienvenido',
//                    'sub' => 'recursos',
//                ),
//                INGREOS
                array(
                    'id' => 'reportes',
                    'titulo' => 'Usuarios Morosos',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'reportes/iniciomorosos',
                    'sub' => 'reportes',
                ),
                array(
                    'id' => 'reportes',
                    'titulo' => 'Usuarios Suspendidos',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'reportes/iniciosuspendidos',
                    'sub' => 'reportes',
                ),
//                  ALMACEN
                array(
                    'id' => 'reportes',
                    'titulo' => 'Recaudos',
                    'icono' => 'fa fa-fw  fa-money',
                    'enlace' => RUTA_URL . 'reportes/inicioreportepagos',
                    'sub' => 'reportes',
                ),
//                MENU PARAMETROS
                array(
                    'id' => 'Parametros',
                    'titulo' => 'Barrios',
                    'icono' => 'fa fa-fw  fa-users',
                    'enlace' => RUTA_URL . 'parametros/barrios',
                    'sub' => 'Parametros',
                ),
                array(
                    'id' => 'Parametros',
                    'titulo' => 'Servicios',
                    'icono' => 'fa fa-fw  fa-cogs',
                    'enlace' => RUTA_URL . 'parametros/servicios',
                    'sub' => 'Parametros',
                ),
            );
        } else if (Session::get('autenticado') && Session::get('level') == 'Citas') {
            $menu = array(
                array(
                    'id' => 'Citas',
                    'titulo' => 'Citas',
                    'icono' => 'fa fa-fw fa-calendar-o',
                    'enlace' => RUTA_URL . 'administracion/bienvenido',
                    'sub' => '',
                ),
            );
        } else if (Session::get('autenticado') && Session::get('level') == 'Usuario') {
            $menu = array(
            );
        }
        return $menu;
    }

    public function menu1() {
        $menu1 = array();
        if (Session::get('autenticado') && Session::get('level') == 'General') {
            $menu1 = array(
                array(
                    'id' => 'Inicio',
                    'titulo' => 'Inicio',
                    'icono' => 'fa fa-lg fa-home',
                    'enlace' => RUTA_URL . 'administracion/bienvenido',
                    'sub' => 'NO',
                ),
                array(
                    'id' => 'facturacion',
                    'titulo' => 'Facturacion',
                    'icono' => 'fa fa-lg fa-money',
                    'sub' => 'SI',
                ),
                array(
                    'id' => 'ordenes',
                    'titulo' => 'Ordenes',
                    'icono' => 'fa fa-lg fa-money',
                    'sub' => 'SI',
                ),
                array(
                    'id' => 'recursos',
                    'titulo' => 'Recursos Humanos',
                    'icono' => 'fa fa-lg fa-money',
                    'sub' => 'SI',
                ),
                array(
                    'id' => 'Parametros',
                    'titulo' => 'Parametros',
                    'icono' => 'fa fa-lg fa-cogs',
                    'sub' => 'SI',
                ),
                array(
                    'id' => 'reportes',
                    'titulo' => 'Reportes',
                    'icono' => 'fa fa-lg fa-money',
                    'sub' => 'SI',
                ),
                array(
                    'id' => 'PQRS',
                    'titulo' => 'PQRS',
                    'icono' => 'fa fa-lg fa-cogs',
                    'sub' => 'SI',
                ),
            );
        } else if (Session::get('autenticado') && Session::get('level') == 'Citas') {
            $menu1 = array(
                array(
                    'id' => 'Citas',
                    'titulo' => 'Citas',
                    'icono' => 'fa fa-fw fa-calendar-o',
                    'enlace' => RUTA_URL . 'administracion/bienvenido',
                    'sub' => 'NO',
                ),
            );
        } else if (Session::get('autenticado') && Session::get('level') == 'Usuario') {
            $menu1 = array(
            );
        }
        return $menu1;
    }

}
