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
$txt = 'LAPORAN KEUANGAN TANGGAL : ' .  date("d-m-Y",strtotime($tgl));
$obj_pdf->MultiCell(200, 10, $txt, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->Ln(2);
$obj_pdf->SetFont('helvetica', 'B', 8);
$txxt = '1. Registrasi Member';
$obj_pdf->Ln(5);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(35, 5, 'Kode Trans', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(105, 5, 'Nama Siswa', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(42, 5, 'Nominal', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$i=0;
$bayarregmember = 0;
$tgl = date("Y-m-d",strtotime($tgl));
$ckdata = $this->db->query("SELECT * FROM view_laporan WHERE LEFT(kode_trans,4) = 'MREG' AND LEFT(tgl_bayar,10) = '$tgl'")->result();
foreach ($ckdata as $row) {
    $i++;
    $bayarregmember += $row->bayar;
    $obj_pdf->MultiCell(8, 5, $i . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(35, 5, $row->kode_trans, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(105, 5, $row->nama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(42, 5, "Rp. " . number_format($row->bayar), 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(43, 5, "TOTAL", 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(147, 5, "Rp. " . number_format($bayarregmember), 1, 'R', 1, 1, '', '', true, 0, false, true, 5, 'M');
$txxt = '2. Transaksi Pembayaran';
$obj_pdf->Ln(5);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(35, 5, 'Kode Trans', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(105, 5, 'Nama Siswa', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(42, 5, 'Nominal', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$i=0;
$bayartran = 0;
$ckdata = $this->db->query("SELECT * FROM view_laporan WHERE LEFT(kode_trans,4) = 'TRAN' AND LEFT(tgl_bayar,10) = '$tgl'")->result();
foreach ($ckdata as $row1) {
    $i++;
    $bayartran += $row1->bayar;
    $obj_pdf->MultiCell(8, 5, $i . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(35, 5, $row1->kode_trans, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(105, 5, $row1->nama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(42, 5, "Rp. " . number_format($row1->bayar), 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(43, 5, "TOTAL", 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(147, 5, "Rp. " . number_format($bayartran), 1, 'R', 1, 1, '', '', true, 0, false, true, 5, 'M');

$txxt = '3. Migrasi Pembayaran';
$obj_pdf->Ln(5);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(35, 5, 'Kode Trans', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(105, 5, 'Nama Siswa', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(42, 5, 'Nominal', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$i=0;
$bayarmig = 0;
$ckdata = $this->db->query("SELECT * FROM view_laporan WHERE LEFT(kode_trans,4) = 'MRAN' AND LEFT(tgl_bayar,10) = '$tgl'")->result();
foreach ($ckdata as $row2) {
    $i++;
    $bayarmig += $row2->bayar;
    $obj_pdf->MultiCell(8, 5, $i . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(35, 5, $row2->kode_trans, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(105, 5, $row2->nama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(42, 5, "Rp. " . number_format($row2->bayar), 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(43, 5, "TOTAL", 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(147, 5, "Rp. " . number_format($bayarmig), 1, 'R', 1, 1, '', '', true, 0, false, true, 5, 'M');

$txxt = '4. Pembayaran Ijazah';
$obj_pdf->Ln(5);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(35, 5, 'Kode Trans', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(105, 5, 'Nama Siswa', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(42, 5, 'Nominal', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
$i=0;
$bayarmig = 0;
$ckdata = $this->db->query("SELECT * FROM view_laporan WHERE LEFT(kode_trans,4) = 'IREG' AND LEFT(tgl_bayar,10) = '$tgl'")->result();
foreach ($ckdata as $row2) {
    $i++;
    $bayarmig += $row2->bayar;
    $obj_pdf->MultiCell(8, 5, $i . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(35, 5, $row2->kode_trans, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(105, 5, $row2->nama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(42, 5, "Rp. " . number_format($row2->bayar), 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(43, 5, "TOTAL", 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(147, 5, "Rp. " . number_format($bayarmig), 1, 'R', 1, 1, '', '', true, 0, false, true, 5, 'M');


$obj_pdf->Ln(5);
$total = 0;
$cksub = $this->db->query("SELECT * FROM view_laporan WHERE LEFT(tgl_bayar,10) = '$tgl'")->result();
foreach ($cksub as $key) {
	$total += $key->bayar;
}
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(43, 5, "SUBTOTAL", 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$obj_pdf->MultiCell(147, 5, "Rp. " . number_format($total), 1, 'R', 1, 1, '', '', true, 0, false, true, 5, 'M');

$obj_pdf->lastPage();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('Surat Jalan ' . $no_surat .'.pdf', 'I');
?>