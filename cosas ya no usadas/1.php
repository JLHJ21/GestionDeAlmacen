<?php 

    require_once('/xampp/htdocs/final_poo/plantillas/bd.php');
    require_once('/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php');
    require_once('/xampp/htdocs/final_poo/insertar/insertar_pdf.php');
    require('../fpdf/fpdf.php');

    date_default_timezone_set('America/Caracas');
    class PDF extends FPDF 
    {

    function Header()
    {   

        $id_fac = $_GET['id_fac']; //Identificar de la factura
        $tit = $_GET['tit']; //Titulo de la factura
        $ide_pdf = $_GET['ide_pdf']; //Identificar del RIF de la empresa
        $dir_pdf = $_GET['dir_pdf']; //Direccion de la empresa
        $num_pdf = $_GET['num_pdf']; //Número de telefono de la empresa
        $nom_cliente = $_GET['nom_cliente']; //Nombre del cliente
        $fecha = $_GET['fecha']; //Fecha a la hora de la realización de la compra


        $this->setY(12);
        $this->setX(10);
        
        
        $this->SetFont('times', 'B', 30);
        
        $this->Text(90, 13, utf8_decode('SENIAT'));

        $this->SetFont('times', 'B', 13);

        $this->Text(90, 20, utf8_decode($tit));
        
        $this->Text(85, 26, utf8_decode($dir_pdf));
        $this->Text(95,32, utf8_decode($num_pdf));
        $this->Text(90,38, utf8_decode('RIF: J-'.$ide_pdf));
        
        
        //información de # de factura
        $this->SetFont('Arial','B',10);   
        $this->Text(150,48, utf8_decode('FACTURA N°: '));
        $this->SetFont('Arial','',10);  
        $this->Text(175,48,$id_fac);
        
        
        
        // Agregamos los datos del cliente
        $this->SetFont('Arial','B',10);    
        $this->Text(10,48, utf8_decode('Fecha de compra: '));
        $this->SetFont('Arial','',10);    
        $this->Text(41,48, $fecha); //$fecha
        
        
        
        
        // Agregamos los datos de la factura
        $this->SetFont('Arial','B',10);    
        $this->Text(10,54, utf8_decode('Cliente: '));
        $this->SetFont('Arial','',10);    
        $this->Text(24,54,$nom_cliente);
        
        $this->Ln(50);
    }

    function Footer()
    {
        $pie_pdf = $_GET['pie_pdf']; //Pie de Página de la empresa

        $this->SetFont('helvetica', 'B', 8);
            $this->SetY(-15);
            $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
            $this->Cell(95,5,date('d/m/Y | g:i:a') ,00,1,'R');
            $this->Line(10,287,200,287);
            $this->Cell(0,5,utf8_decode($pie_pdf),0,0,"C");
            
    }


    }

    //


    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->SetTopMargin(15);
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);

    $id_compra = $_GET['id_com'];
    $id_com = $_GET['id_com']; //Identificar de las compras realizadas
    $fecha = $_GET['fecha']; //Fecha a la hora de la realización de la compra
    $monto = $_GET['monto']; //Total o monto total de las compras hechas
    $id_prod = $_GET['id_prod']; //Identificador de los productos
    $id_usu = $_GET['id_usu'];

    $objLista = new PDF_insertar; // POO
    $ListaCompras = $objLista->ProductosLista(); 

    $pdf->setY(60);$pdf->setX(135);
        $pdf->Ln();
    // En esta parte estan los encabezados
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20, 7, utf8_decode('Código'),1,0,'C',0);
        $pdf->Cell(95, 7, utf8_decode('Nombre del Producto'),1,0,'C',0);
        $pdf->Cell(20, 7, utf8_decode('Cantidad'),1,0,'C',0);
        $pdf->Cell(25, 7, utf8_decode('Precio'),1,0,'C',0);
        $pdf->Cell(25, 7, utf8_decode('Total'),1,1,'C',0);
    
        $pdf->SetFont('Arial','',10);

    //Aqui inicia el for con todos los productos
    foreach ($ListaCompras as $e){ 
    
        $pdf->Cell(20, 7, $e['id_com'],1,0,'L',0);
        $pdf->Cell(95, 7, utf8_decode($e['nom_prod']),1,0,'L',0);
        $pdf->Cell(20, 7, utf8_decode($e['cantidad_vender_carr']),1,0,'R',0);
        $pdf->Cell(25, 7, utf8_decode(number_format($e['(Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod'],2, ".", ",")),1,0,'R',0);
        $pdf->Cell(25, 7, utf8_decode(number_format($e['cantidad_vender_carr']*$e['(Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod'],2,".",",")),1,1,'R',0);
        
        //Se puede utilizar number_format para decimales y str_replace para cambiar . y ,

    } 

    //// Apartir de aqui esta la tabla con los subtotales y totales

    $pdf->Ln(10);

            $pdf->setX(95);
            $pdf->Cell(40,6,'Subtotal',1,0); 
            $pdf->Cell(60,6,number_format($monto,2,".",","),'1',1,'R');
            $pdf->setX(95);
            $pdf->Cell(40,6,'Descuento',1,0);
            $pdf->Cell(60,6,'','1',1,'R');
            $pdf->setX(95);
            $pdf->setX(95);
            $pdf->Cell(40,6,'Total',1,0);
            $pdf->Cell(60,6,number_format($monto,2,".",","),'1',1,'R');
    
    $pdf->Output();
?>