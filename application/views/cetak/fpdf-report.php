<?php

/*  Surat Pemberitahuan Kenaikan Gaji Berkala (KGB)
 *  Badan Kepegawaian Negara
 *  Creator : Teddy Cahyo Munanto
 *  Email   : teddcm@gmail.com
 */
include 'bootstrap/plugins/fpdf/fpdf.php';

// Instanciation of inherited class
class PDF extends FPDF {

    function Header() {
        $this->SetFont('Times', 'B', 12);

        $this->Image('bootstrap/img/logo_sk.jpg', 20, 6, 15);
        $this->Cell(0, 0, 'DATA PEGAWAI', 0, 0, 'C');
        $this->Ln(0);
        $this->Cell(0, 10, 'KANTOR REGIONAL VIII', 0, 0, 'C');
        $this->Ln(0);
        $this->Cell(0, 20, 'BADAN KEPEGAWAIAN NEGARA', 0, 0, 'C');
        $this->CreateLine(25);
        $this->CreateLine(24);

        $this->Ln(15);
        $this->SetFont('Times', 'B', 9);
        $this->Cell(-6);
        $this->Cell(6, 8, 'No', 0, 0, 'L');
        $this->Cell(50, 8, 'Nama', 0, 0, 'L');
        $this->Cell(25, 8, 'NIP', 0, 0, 'L');
        $this->Cell(10, 8, 'Gol', 0, 0, 'L');
        $this->Cell(50, 8, 'Jabatan', 0, 0, 'L');
        $this->Cell(60, 8, 'Unit Kerja', 0, 0, 'L');
        $this->CreateLine(33);
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ChapterTitle($label) {
        // Arial 12
        $this->Cell(-6);
        $this->SetFont('Arial', '', 10);
        // Background color
        $this->SetFillColor(200, 220, 255);
        // Title
        $this->Cell(210 - 10, 6, $label, 0, 1, 'L', true);
        // Line break
        $this->SetFont('Times', '', 7);
    }

    function CreateLine($y) {
        $this->Line(4, $y, 210 - 6, $y); // 50mm from each edge
    }

}

$margin = 4;
$pdf = new PDF('P', 'mm', array(210, 297));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 7);

$i = 0;
if ($bagian) {
    $bag = '';
}
if (!empty($data_pegawai)) {
    foreach ($data_pegawai as $peg) {

        if ($pdf->GetY() >= 270) {
            $pdf->AddPage();
        }
        if ($bagian) {
            if ($bag != $peg->kode_bagian) {
                if ($bag != '') {
                    $pdf->Cell(25, $margin, '', 0, 1);
                    $pdf->Cell(25, $margin, '', 0, 1);
                }
                $i = 0;
                $bag = $peg->kode_bagian;
                $pdf->CreateLine($pdf->GetY());
                $pdf->ChapterTitle($peg->nama_bag_top);
                $pdf->CreateLine($pdf->GetY());
            }
        }
        $i++;
        $pdf->Cell(-6);
        $pdf->Cell(6, $margin, $i, 0, 0);

        $current_x1 = $pdf->GetX();
        $current_y1 = $pdf->GetY();
        $pdf->Cell(50);

        $pdf->Cell(25, $margin, $peg->nip, 0, 0);
        $pdf->Cell(10, $margin, convert_golongan($peg->gol_akhir), 0, 0);

        $current_x2 = $pdf->GetX();
        $current_y2 = $pdf->GetY();
        $pdf->Cell(50);

        $current_x3 = $pdf->GetX();
        $current_y3 = $pdf->GetY();
        $pdf->Cell(60);

        $pdf->SetXY($current_x1, $current_y1);
        $pdf->MultiCell(50, $margin, $peg->nama, 0, 'L');
        $y3 = $pdf->getY();

        $pdf->SetXY($current_x2, $current_y2);
        $pdf->MultiCell(50, $margin, $peg->nama_jab, 0, 'L');
        $y2 = $pdf->getY();

        $pdf->SetXY($current_x3, $current_y3);
        $pdf->MultiCell(60, $margin, strtoupper($peg->nama_bag), 0, 'L');
        $y1 = $pdf->getY();


        $pdf->setY(max($y1, $y2, $y3));
        $pdf->CreateLine($pdf->GetY());
    }
}

$nama_file = get_user_name() . '_' . date(now());
$pdf->Output($nama_file, 'I');
?>
