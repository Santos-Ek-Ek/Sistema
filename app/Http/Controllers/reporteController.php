<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Renta;
use App\Models\Cuatrimoto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class reporteController extends Controller
{
    public function pdfRenta(){
        $renta=Renta::all();

        $pdf= new Fpdf ('P', 'mm', 'A4');
        $pdf->SetAutoPageBreak(true, 10);
        $pdf-> AddPage("landscape");
        // $pdf->SetY(-15); // Posición: a 1,5 cm del final
        $pdf->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $pdf->Cell(495, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
        $pdf->Image(public_path().'/img/tuul.jpeg',10,4,20);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(290, 15, 'REPORTE DE RENTAS DE CUATRIMOTOS', 0 , 1 , 'C');
        $pdf->Ln(10);

        $pdf->Cell(25,8,'',0,0,'L');
        $pdf->Cell(10,8,'ID',1,0,'C');
        $pdf->Cell(40,8,'Cliente',1,0,'C');
        $pdf->Cell(40,8,'Hora inicial',1,0,'C');
        $pdf->Cell(40,8,'Hora final',1,0,'C');
        $pdf->Cell(25,8,'Cantidad',1,0,'C');
        $pdf->Cell(25,8,'Costo',1,0,'C');
        $pdf->Cell(40,8,'No_Cuatrimoto',1,0,'C');
        $pdf->Cell(25,8,'Estado',1,0,'C');



        foreach ($renta as $renta){
            $pdf->Ln(8);
            $pdf->Cell(25,8,'',0,0,'L');
            $pdf->Cell(10, 8, utf8_decode($renta->id), 1, 0, 'C');
            $pdf->Cell(40,8, utf8_decode($renta->clientes->Nombre . " " . $renta->clientes->Apellido), 1, 0, 'L');
            $pdf->Cell(40,8, utf8_decode($renta->hora_inicio), 1, 0, 'C');
            $pdf->Cell(40,8, utf8_decode($renta->hora_fin), 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode($renta->cantidad), 1, 0, 'C');
            $pdf->Cell(25, 8, utf8_decode($renta->costo), 1, 0, 'C');
            $pdf->Cell(40, 8, utf8_decode($renta->no_cuatri), 1, 0, 'L');
            $pdf->Cell(25, 8, utf8_decode($renta->est), 1, 0, 'L');
            
        }

        $pdf->Output('ReporteRentasCuatrimotos_'.$hoy.'.pdf','I');
        exit;
    }

    public function pdfCuatri(){
        $cuatri=Cuatrimoto::all();
        // return($renta);
        $pdf= new Fpdf ('P', 'mm', 'A4');

        $pdf-> AddPage();
        // $pdf->SetY(-15); // Posición: a 1,5 cm del final
        $pdf->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $pdf->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
        $pdf->Image(public_path().'/img/tuul.jpeg',10,4,20);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','', 11);
        $pdf->Cell(188, 6, 'REPORTE DE CUATRIMOTOS', 0 , 1 , 'C');
        $pdf->Ln(10);
        $pdf->Cell(10,5,'',0,0,'C');
        $pdf->Cell(10,5,'ID',1,0,'C');
        $pdf->Cell(35,5,'Marca',1,0,'C');
        $pdf->Cell(45,5,'Color',1,0,'C');
        $pdf->Cell(45,5,'Placa',1,0,'C');
        $pdf->Cell(35,5,'Estado',1,0,'C');
      
      

        foreach ($cuatri as $cuatri){
            $pdf->Ln(5);
            $pdf->Cell(10,5,'',0,0,'C');
            $pdf->Cell(10, 5, utf8_decode($cuatri->id), 1, 0, 'C');
            $pdf->Cell(35, 5, utf8_decode($cuatri->marca), 1, 0, 'C');
            $pdf->Cell(45, 5, utf8_decode($cuatri->color), 1, 0, 'C');
            $pdf->Cell(45, 5, utf8_decode($cuatri->placa), 1, 0, 'C');
            $pdf->Cell(35, 5, utf8_decode($cuatri->estado), 1, 0, 'C');
        }

        $pdf->Output('ReporteCuatrimotos_'.$hoy.'.pdf','I');
        exit;
    }

    public function pdfCliente()
    {
        $cliente = Cliente::all();
        $pdf = new Fpdf ('P', 'mm', 'A4');
    
        $pdf->AddPage("landscape");
        $pdf->SetFont('Arial', 'I', 8);
        $hoy = date('d/m/Y');
        $pdf->Cell(495, 10, utf8_decode($hoy), 0, 0, 'C');
        $pdf->Image(public_path().'/img/tuul.jpeg', 10, 4, 20);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(290, 15, 'REPORTE DE CLIENTES', 0 , 1 , 'C');
        $pdf->Ln(10);
    
        // Encabezados de las celdas
        $pdf->Cell(10, 8, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Apellidos', 1, 0, 'C');
        $pdf->Cell(14, 8, 'Edad', 1, 0, 'C');
        $pdf->Cell(45, 8, utf8_decode('Teléfono'), 1, 0, 'C');
        $pdf->Cell(65, 8, 'Email', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Documento', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Integrantes/Edad', 1, 0, 'C');
    
        // Definir el ancho de la celda de integrantes
        $anchoCeldaIntegrantes = 40;
         // Salto de línea después de cada celda
         $pdf->Ln();
    
        // Recorrer los registros de clientes
        foreach ($cliente as $cliente) {
            // Convertir la cadena de integrantes en un arreglo utilizando explode
            $integrantes = explode(',', $cliente->integrante);
            $integrantesTexto = implode("\n", $integrantes);
            // Calcular la altura necesaria para la celda de integrantes
            $numLineasIntegrantes = count($integrantes);
            $alturaCeldaIntegrantes = $numLineasIntegrantes * 8; // 8 es la altura de una línea
    
            // Calcular el ancho necesario para las celdas restantes
            $anchoRestante = 495 - $anchoCeldaIntegrantes;
    
            // Calcular el ancho disponible para cada celda restante
            $anchoCeldaRestante = $anchoRestante / 7; // 7 celdas restantes (sin contar la de integrantes)
    
           
    
            // Celdas con anchos calculados dinámicamente
            $pdf->Cell(10, $alturaCeldaIntegrantes, utf8_decode($cliente->id), 1, 0, 'C');
            $pdf->Cell(40, $alturaCeldaIntegrantes, utf8_decode($cliente->Nombre), 1, 0, 'L');
            $pdf->Cell(40, $alturaCeldaIntegrantes, utf8_decode($cliente->Apellido), 1, 0, 'C');
            $pdf->Cell(14, $alturaCeldaIntegrantes, utf8_decode($cliente->edad), 1, 0, 'C');
            $pdf->Cell(45, $alturaCeldaIntegrantes, utf8_decode($cliente->telefono), 1, 0, 'C');
            $pdf->Cell(65, $alturaCeldaIntegrantes, utf8_decode($cliente->email), 1, 0, 'C');
            $pdf->Cell(30, $alturaCeldaIntegrantes, utf8_decode($cliente->Documento), 1, 0, 'C');
    
            // Celda de integrantes con altura automática
            $pdf->MultiCell($anchoCeldaIntegrantes, 8, utf8_decode($integrantesTexto), 1, 'L');
        }
    
        $pdf->Output('ReporteClientes_'.$hoy.'.pdf','I');
        exit;
    }
    
    
    
    

    public function ticket(Request $request){
        $renta = DB::table('rentas')
    ->join('clientes', 'rentas.id_cliente', '=', 'clientes.id')
    ->select('rentas.*', 'clientes.Nombre', 'clientes.Apellido')
    ->where('rentas.id', $request->id)
    ->get();

        // return($renta);
       

        $pdf = new FPDF('P','mm',array(80,150)); // Tamaño tickt 80mm x 150 mm (largo aprox)
        $pdf->AddPage();
        
   

        // $pdf->SetY(-15); // Posición: a 1,5 cm del final
        $pdf->SetFont('Helvetica','',12);
        $pdf->Cell(60,4,'Hotel Tuul',0,1,'C');
        $pdf->SetFont('Helvetica','',8);
        $pdf->Cell(60,4,'Calle 22 No. 302 x 31 y 32',0,1,'C');
        $pdf->Cell(60,4,utf8_decode('C.P.: 97540 Izamal, Yucatán, México'),0,1,'C');
        $pdf->Cell(60,4,'grupoizamal.com',0,1,'C');
        $pdf->Cell(60,4,'999 442 9506',0,1,'C');
        $pdf->Cell(60,4,'info@grupoizamal.com',0,1,'C');
        $hoy = date('d/m/Y');
        $pdf->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
        $pdf->Image(public_path().'/img/tuul.jpeg',10,4,10);
        $pdf->Ln(5);
        $pdf->Cell(60,4,'Fecha: '. $hoy,0,1,'');
        $pdf->Cell(60,4,'Cliente: '.$renta[0]->Nombre . " " . $renta[0]->Apellido,0,1,'');

        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->Cell(5, 10, 'Cantidad', 0,0,'L');
        $pdf->Cell(20, 10, 'H.I',0,0,'R');
        $pdf->Cell(25, 10, 'H.F',0,0,'C');
        $pdf->Cell(15, 10, 'Total',0,0,'C');
        $pdf->Ln(8);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(0);
        $pdf->SetFont('Helvetica', '', 7);
        $pdf->Cell(5,10,utf8_decode($renta[0]->cantidad),0,0,'L'); 
        $pdf->Cell(20, 10, utf8_decode($renta[0]->hora_inicio),0,0,'R');
        $pdf->Cell(25, 10, $renta[0]->hora_fin,0,0,'C');
        $pdf->Cell(15, 10, utf8_decode($renta[0]->costo),0,0,'C');

        $pdf->Ln(10);
        $pdf->Cell(60,0,'GRACIAS POR VISITARNOS',0,1,'C');
        $pdf->Ln(3);
        $pdf->Cell(60,0,'GRUPO IZAMAL',0,1,'C');
        

        $pdf->Output('Ticket_'.$renta[0]->Nombre . " " . $renta[0]->Apellido.$hoy.'.pdf','I');
        exit;
    }
}
