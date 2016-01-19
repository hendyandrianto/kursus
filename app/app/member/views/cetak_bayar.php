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
$obj_pdf->SetHeaderData($foto, 30, $toko , $hal . "\n" . $judul . "\n" . $cabang);
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
$txt = 'LAPORAN HISTORI PEMBAYARAN KURSUS';
$obj_pdf->MultiCell(200, 10, $txt, 0, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$ckdata = $this->db->get_where('view_member_kursus',array('kode'=>$kode))->result();
foreach ($ckdata as $key) {
	$tipena = $key->nama_tipe;
    $nama = $key->nama;
}
$cektotal = $this->db->get_where('tbl_registermember',array('kode_member'=>$kode))->result();
foreach ($cektotal as $keyx) {
    $total = $keyx->total;
    $disk = $keyx->discount;
    $berish = $total - $disk;
}
$txxt = "Nama Siswa : " . $nama . "\n" . "Tipe Kursus : " . $tipena;
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(35, 5, 'Kode Transaksi', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(25, 5, 'Tanggal Bayar', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(25, 5, 'Waktu Bayar', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(25, 5, 'Bayar', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(20, 5, 'Sisa', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$ckdata = $this->db->query("SELECT * FROM tbl_transaksi WHERE kode_member = '$kode'")->result();
$totbayarx = 0;
foreach ($ckdata as $row) {
    $x++;
    $totbayar += $totbayarx + $row->bayar;
    $tgl = date("d-m-Y",strtotime($row->tgl_bayar));
    $waktu = date("H:i:s",strtotime($row->tgl_bayar));
    $bayar = "Rp. " . number_format($row->bayar);
    $sisa = "Rp. " . number_format($row->sisa);
    $kodetrans = $row->kode_trans;
    $obj_pdf->MultiCell(8, 5, $x . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(35, 5, $kodetrans, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(25, 5, $tgl, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(25, 5, $waktu, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(25, 5, $bayar, 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(20, 5, $sisa, 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(93, 5, 'Total Bayar', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(25, 5, "Rp. " . number_format($totbayar), 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->Ln(1);
$txxtx = "Dengan Total Pembayaran : " . "Rp. " . number_format($total) . " Diskon : " . "Rp. " . number_format($disk) . "\n". "Pembayaran Bersih : " . "Rp. " . number_format($berish);
$obj_pdf->SetFont('helvetica', '', 7);
$obj_pdf->MultiCell(100, 15, $txxtx, 0, 'L', 0, 1, '', '', true, 0, false, true, 15, 'M');
$obj_pdf->lastPage();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('Laporan Histori Pembayaran ' . $kode .'.pdf', 'I');
?>