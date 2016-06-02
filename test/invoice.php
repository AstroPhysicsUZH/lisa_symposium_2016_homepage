<?php
/**
    Template used to create the invoice pdf
 */

require_once "../lib/tcpdf_min/tcpdf_import.php";

// Logos and images
$UZH_LOGO      = K_PATH_IMAGES . 'uzh_logo_e_pos_klein.png';
$FOOTER_IMG    = K_PATH_IMAGES . 'footer.png';
$HEADER_IMG    = K_PATH_IMAGES . 'header.png';
$SIGNATURE_IMG = K_PATH_IMAGES . 'sig_PhJ_bw.png';


$PHY_ADDRESS = <<<EOD
<b>Physik-Institut</b><br />
Wintherthurerstrasse 190<br />
CH-8057 Z&uuml;rich<br />
Phone: +41 44 635 57 81<br />
http://www.physik.uzh.ch/events/lisa2016<br />
relativityUZH@gmail.com
EOD;

$PAYMENT_INSTRUCTIONS = [
    "Rechnungswesen der Universitat Zurich",
    "LISA Symposium",
    "8057 Zurich",
    "IBAN-Nr.: CH12 0900 0000 3109 1810 4",
    "Swift/BIC: POFICHBEXXX",
    "Message: 000 LASTNAME",
];


$REC_ADRESS = [
    "Inst Name",
    "Person Name",
    "Street1",
    "Street2",
    "PLZ Loc",
    "Country"
];

$LOCDATE = "Zurich, 2016-00-00";

$SIGNATURE_IMGPERS = [
    "Philippe Jetzer",
    "on behalf of the organizers"
];




class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        global $PHY_ADDRESS, $UZH_LOGO;
        $LEFT = $this->getMargins()['left'];
        $TOP = $this->getMargins()['header'];

        $this->Image($UZH_LOGO, $LEFT, $TOP, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', '', 10);
        $this->writeHTMLCell(0, 30, 120, $TOP, $PHY_ADDRESS, 0, 1, false, 'L');
    }

    // Page footer
    public function Footer() {
        global $FOOTER_IMG;

        $LM = $this->getMargins()['left'];
        $RM = $this->getMargins()['right'];
        $HM = $this->getMargins()['header'];
        $FM = $this->getMargins()['footer'];
        $W = $this->getPageWidth() - $RM - $LM;
        $H = $this->getPageHeight() - $HM - $FM;

        $this->Image($FOOTER_IMG, $LEFT, $H, $W, '', 'png', '', 'T', true, 300, '', false, false, 0, true, false, false);
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rafael Kueng');
$pdf->SetTitle('LISA Symposium 2016 Invoice');
$pdf->SetSubject('LISA Symposium 2016 Invoice');
$pdf->SetKeywords('LISA,Symposium,2016,Invoice');

// set header and footer fonts
$pdf->setHeaderFont(Array("helvetica", '', "12"));
$pdf->setFooterFont(Array("helvetica", '', "12"));

// set default monospaced font
$pdf->SetDefaultMonospacedFont("courier");

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// Print address
//$pdf->SetY(50);
foreach ($REC_ADRESS as $line) {
    $pdf->Cell(0,0,$line,0,1);
}

$pdf->ln();

$pdf->SetY(90);

$LM = $pdf->getMargins()['left'];
$RM = $pdf->getMargins()['right'];
$W = $pdf->getPageWidth() - $RM - $LM;

$pdf->Image($HEADER_IMG, $pdf->GetX(), $pdf->GetY(), $W, '', 'png', '', 'T', true, 300, '', false, false, 0, true, false, false);

$pdf->SetY(125);

$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0,0,"Invoice",0,1);
$pdf->SetFont('helvetica', '', 12);
//$pdf->Cell(0,0,"Conference fee for LISA Symposium XI, Zurich",1,1);

$w2 = 20;
$pdf->SetY(140);

$invoice_items = [
    ["Conference fee (incl. dinner, proceedings, coffee breaks)", "CHF", "350.00"],
    ["Dinner for 1 accompaning person(s)", "CHF", "100.00"],
    ["Special agreement", "CHF", "-100.00"],
];
$total = ["CHF", "350.00"];

foreach($invoice_items as $i) {
    $item = $i[0];
    $curr = $i[1];
    $amnt = $i[2];

    $pdf->Cell($W-2*$w2,0,$item,"B",0);
    $pdf->Cell($w2,0,$curr,"B",0,"R");
    $pdf->Cell($w2,0,$amnt,"B",1,"R");
}

$pdf->SetFont('helvetica', '', 2);
$pdf->Cell($W,1,"","B",1);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell($W-2*$w2,10,"TOTAL","B",0);
$pdf->Cell($w2,10,$total[0],"B",0,"R");
$pdf->Cell($w2,10,$total[1],"B",0,"R");
$pdf->Ln();


$pdf->SetY(180);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell($W,10,"Payment instructions:",0,1);

$pdf->SetFont('courier', 'B', 10);
foreach($PAYMENT_INSTRUCTIONS as $line){
    $pdf->Cell(0,0,$line,0,1);
}

$os = 120;
$pdf->SetY(250);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell($os,0,$LOCDATE,0,0);
$pdf->Cell(0,0,$SIGNATURE_IMGPERS[0],0,1);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell($os,0,"",0,0);
$pdf->Cell(0,0,$SIGNATURE_IMGPERS[1],0,1);

$sh = 20;
$pdf->Image($SIGNATURE_IMG, $os+$LM-5, 250-$sh, "", $sh, 'png', '', 'T', true, 300, '', false, false, 0, true, false, false);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
