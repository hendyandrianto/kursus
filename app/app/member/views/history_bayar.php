<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script>
$(document).ready(function() {
    TableManageResponsive.init();
});
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
	            <div class="panel-heading-btn">
                <a href="<?php echo base_url();?>member/cetak_bayar/<?php echo $kode;?>" title="Cetak History Pembayaran" class="btn btn-primary btn-xs m-r-5">Print</a>
                <a href="javascript:void()" title="Sembunyikan" onclick="nyumput()" class="btn btn-primary btn-xs m-r-5">Hide</a>
                </div>
                <h4 class="panel-title">History Pembayaran Paket Kursus <?php echo $kursusna;?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-bayar" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align:center" width="1%">No.</th>
                                <th style="text-align:center" width="10">Tgl Bayar</th>
                                <th style="text-align:center" width="20%">Waktu Bayar</th>
                                <th style="text-align:center" width="30%">Bayar</th>
                                <th style="text-align:center" width="30%">Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
							$i=0;
							$ckdata = $this->db->query("SELECT * FROM tbl_transaksi WHERE kode_member = '$kode'")->result();
							foreach ($ckdata as $row) {
								$i++;
								$tgl = date("d-m-Y",strtotime($row->tgl_bayar));
								$waktu = date("H:i:s",strtotime($row->tgl_bayar));
								$bayar = "Rp. " . number_format($row->bayar);
								$sisa = "Rp. " . number_format($row->sisa);
							?>	
                            <tr>
								<td style="text-align:center"><?php echo $i . ".";?></td>
								<td style="text-align:center"><?php echo $tgl;?></td>
								<td style="text-align:center"><?php echo $waktu;?></td>
								<td style="text-align:right"><?php echo $bayar;?></td>
								<td style="text-align:right"><?php echo $sisa;?></td>
                            </tr>                           
								<?php
							}
							?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                <a href="<?php echo base_url();?>member/cetak_absen/<?php echo $kode;?>" title="Cetak History Kehadiran Kursus" class="btn btn-primary btn-xs m-r-5">Print</a>
                </div>
                <h4 class="panel-title">History Kehadiran Kursus <?php echo $kursusna;?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="data-absen" class="table table-striped table-bordered nowrap" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align:center" width="1%">No.</th>
                                <th style="text-align:center" width="30">Instruktur</th>
                                <th style="text-align:center" width="10">Tanggal</th>
                                <th style="text-align:center" width="10">Jam Mulai</th>
                                <th style="text-align:center" width="10">Jam Selesai</th>
                                <th style="text-align:center" width="20%">Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=0;
                            $ckdata = $this->db->query("SELECT tbl_username.nama as nama_instruktur,tbl_mobil.nama as nama_fasilitas,tbl_mulai.tgl_mulai,tbl_mulai.tgl_selesai FROM tbl_mulai INNER JOIN tbl_username ON tbl_mulai.instruktur = tbl_username.id INNER JOIN tbl_mobil ON tbl_mulai.fasilitas = tbl_mobil.id WHERE tbl_mulai.kode_member = '$kode' AND tbl_mulai.status = '0'")->result();
                            foreach ($ckdata as $row) {
                                $i++;
                                $nama = $row->nama_instruktur;
                                $tgl = date("d-m-Y",strtotime($row->tgl_mulai));
                                $waktu_mulai = date("H:i:s",strtotime($row->tgl_mulai));
                                $waktu_selesai = date("H:i:s",strtotime($row->tgl_selesai));
                                $fasilitas = $row->nama_fasilitas;
                            ?>  
                            <tr>
                                <td style="text-align:center" width="5%"><?php echo $i . ".";?></td>
                                <td style="text-align:left" width="40%"><?php echo $nama;?></td>
                                <td style="text-align:center" width="10%"><?php echo $tgl;?></td>
                                <td style="text-align:center" width="10%"><?php echo $waktu_mulai;?></td>
                                <td style="text-align:center" width="10%"><?php echo $waktu_selesai;?></td>
                                <td style="text-align:left" width="20%"><?php echo $fasilitas;?></td>
                            </tr>                           
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
