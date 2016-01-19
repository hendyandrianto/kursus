<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, "A4", true, 'UTF-8', true);
$obj_pdf->SetCreator("Hendy Andrianto S.Kom (www.facebook.com/opchaky.it)");
$toko = "LEMBAGA PENDIDIKAN KETERAMPILAN";
$hal = "GITA PERTIWI";
$alamat = "PUSAT : JL. KEBON TIWU I NO. 10 TASIKMALAYA";
$tlp = "(0265) 323445 HP. 085295168608";
$cabang = "CABANG : JL. RAYA TIMUR BOROLONG CILAMPUNG HILIR SINGAPARNA"."\n"."HP. 085353292292";
$judul = $alamat . "\n" . "TELP. " . $tlp;
$foto = "profile.jpg";
$obj_pdf->SetTitle($toko);
$obj_pdf->SetDefaultMonospacedFont('helvetica','B','12');
$obj_pdf->SetHeaderData($foto, 20, $toko , $hal . "\n" . $judul . "\n" . $cabang);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(10, 34, 10);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->setFontSubsetting(FALSE);
$obj_pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
$obj_pdf->SetFillColor(255, 235, 235);
$obj_pdf->AddPage();
$obj_pdf->SetFont('helvetica', 'B', 9);
$txt = 'LAPORAN DATA PEKERJAAN';
$obj_pdf->MultiCell(200, 10, $txt, 0, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->Ln(2);
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(150, 5, 'Nama Pekerjaan', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(32, 5, 'Jml Siswa', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$gawe = $this->db->get('tbl_pekerjaan')->result();
foreach ($gawe as $key) {
    $id = $key->id;
    $namagawe = $key->nama;
    $x=0;
    $ckdatax = $this->db->query("SELECT * FROM view_member WHERE id_pekerjaan = '$id'")->result();
    foreach ($ckdatax as $row) {
        $x++;
        $obj_pdf->MultiCell(8, 5, $x . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(150, 5, $namagawe, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(32, 5, count($ckdatax) . " Orang", 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
    }
}
$obj_pdf->Ln(2);
$obj_pdf->lastPage();
$obj_pdf->Output('Laporan Kerja.pdf', 'I');
?>