<?php

require_once './App/Controller.php';
require_once './Model/VehiculoModel.php';
require_once '/views/fpdf/fpdf.php';

class PdfController extends Controller {

    private $pdf;
    private $mod_v;

    function __construct() {
        parent::__construct();
        $this->pdf = new FPDF();
        $this->mod_v = new VehiculoModel();
    }

    private function getPDF() {
        return $this->pdf;
    }

    public function rep_vehiculos() {
        if (Session::get("tipo") == "admin") {
            Session::set('pdf', $this->getPDF());
            $this->getPDF()->AddPage();
            $this->getPDF()->SetFont('Arial', 'B', 16);
            $this->getPDF()->Cell(40, 10, utf8_decode('Reporte de Vehículos'));
            $this->getPDF()->Ln(15);
            $this->getPDF()->SetFont('Arial', 'B', 12);
            $this->getPDF()->Cell(30, 5, utf8_decode('Vehículo'), 1);
            $this->getPDF()->Cell(30, 5, utf8_decode('Matrícula'), 1);
            $this->getPDF()->Cell(30, 5, 'Cantidad', 1);
            $this->getPDF()->Cell(30, 5, utf8_decode('Descripción'), 1);
            $this->getPDF()->Cell(40, 5, 'Modelo', 1);
            $this->getPDF()->Cell(30, 5, 'Tipo', 1);
            $this->getPDF()->Ln(8);
            foreach ($this->mod_v->obtenerTodos() as $vehiculo) {
                $this->getPDF()->Cell(30, 5, $vehiculo['id'], 1);
                $this->getPDF()->Cell(30, 5, $vehiculo['mat'], 1);
                $this->getPDF()->Cell(30, 5, $vehiculo['cant'], 1);
                $this->getPDF()->Cell(30, 5, $vehiculo['des'], 1);
                $this->getPDF()->Cell(40, 5, $vehiculo['modelo'], 1);
                $this->getPDF()->Cell(30, 5, utf8_decode($vehiculo['tipov']), 1);
                $this->getPDF()->Ln(5);
            }
            $this->getPDF()->Output();
        } else {
            Session::set("msg", "Debe ser administrador para acceder.");
            $this->redirect(array('Main', 'index.php'));
        }
    }

}
