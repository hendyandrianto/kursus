<?php
tcpdf();
$fontnama = TCPDF_FONTS::addTTFfont('certificatebold.ttf', 'TrueTypeUnicode', '', 96);
$font = TCPDF_FONTS::addTTFfont('Chocolate Covered Raindrops BOLD.ttf', 'TrueTypeUnicode', '', 100);
$obj_pdf = new TCPDF('P', PDF_UNIT, "LEGAL", true, 'UTF-8', true);
$obj_pdf->SetCreator("Hendy Andrianto S.Kom (www.facebook.com/opchaky.it)");
$toko = "LEMBAGA PENDIDIKAN KETERAMPILAN";
$hal = "GITA PERTIWI";
$alamat = "PUSAT : JL. KEBON TIWU I NO. 10 TASIKMALAYA";
$tlp = "(0265) 323445 HP. 085295168608";
$cabang = "CABANG : JL. RAYA TIMUR BOROLONG CILAMPUNG HILIR SINGAPARNA"."\n"."HP. 085353292292";
$judul = $alamat . "\n" . "TELP. " . $tlp;
$foto = "profile.jpg";
$cknama = $this->db->get_where('view_member',array('kode'=>$kode))->result();
foreach ($cknama as $row) {
    $nama = $row->nama;
    $tgl = date('d-m-Y',strtotime($row->tgl_lahir));
    $tempat = $row->tempat_lahir;
    $jns = strtoupper($row->nama_tipe);
}
$ckhasil = $this->db->get_where('tbl_status_izajah',array('id'=>$status))->result();
foreach ($ckhasil as $key) {
    $hasil = $key->status;
}
$obj_pdf->SetTitle($toko);
$obj_pdf->SetHeaderData("", "", "" , "");
$obj_pdf->SetPrintHeader(FALSE);
$obj_pdf->SetPrintFooter(FALSE);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(10, 34, 10);
$obj_pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->setFontSubsetting(FALSE);
$obj_pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
$obj_pdf->AddPage();
$obj_pdf->SetFont("helvetica", '', 20);
$obj_pdf->Ln(107);
$obj_pdf->MultiCell(180, 10, $no, 0, 'C', 0, 1, '', '', true, 0, false, true, 10, 'B');
$obj_pdf->Ln(30);
$obj_pdf->SetFont($fontnama, '', 22);
$obj_pdf->MultiCell(220, 10, $nama, 0, 'C', 0, 1, '', '', true, 0, false, true, 10, 'B');
$obj_pdf->Ln(5);
$obj_pdf->SetFont('helvetica', '', 12);
$obj_pdf->MultiCell(75, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(50, 8, $tgl, 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(20, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(40, 8, strtoupper($tempat), 0, 'L', 0, 1, '', '', true, 0, false, true, 9, 'B');
$obj_pdf->Ln(7);
$obj_pdf->MultiCell(120, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(70, 8, $jns, 0, 'L', 0, 1, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(70, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(80, 8, $hasil, 0, 'L', 0, 1, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(100, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(30, 8, $mulai, 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(20, 8, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->MultiCell(30, 8, $selesai, 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'B');
$obj_pdf->lastPage();
$obj_pdf->Output('Cetak Ijazah ' . $no .'.pdf', 'I');
?>