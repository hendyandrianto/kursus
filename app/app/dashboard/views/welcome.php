<script type="text/javascript">
    jQuery(document).ready(function(){
        var calendar = jQuery('#log_activity').fullCalendar({
            editable: true,
            header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: "<?php echo base_url();?>dashboard/log_activity/",
            eventRender: function(event, element, view) {
                if(event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            }  
        });
    });
</script>
<div class="row">
    <?php
    $totsiswa = $this->db->get_where('view_member',array('status'=>'1'));
    $jahit = $this->db->get_where('view_member',array('status'=>'1','id_tipe'=>'1'));
    $supir = $this->db->get_where('view_member',array('status'=>'1','id_tipe'=>'2'));
    ?>  
    <div id="online" class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"><i class="fa fa-user"></i></div>
			<div class="stats-info">
				<h4>Total Siswa</h4>
				<p><?php echo $totsiswa->num_rows();?> Orang</p>	
			</div>
            <div class="stats-desc">Total Siswa Saat Ini : <?php echo $totsiswa->num_rows();?> Orang</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-purple">
            <div class="stats-icon"><i class="fa fa-users"></i></div>
            <div class="stats-info">
                <h4>Siswa Mengemudi</h4>
                <p><?php echo $supir->num_rows();?> Orang</p> 
            </div>
            <div class="stats-desc">Total Siswa Mengemudi : <?php echo $supir->num_rows();?> Orang</div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-users"></i></div>
			<div class="stats-info">
				<h4>Siswa Menjahit</h4>
				<p><?php echo $jahit->num_rows();?> Orang</p>	
			</div>
            <div class="stats-desc">Total Siswa Menjahit : <?php echo $jahit->num_rows();?> Orang</div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
			<div class="stats-info">
				<h4>Waktu</h4>
				<p><span id="waktos"><script type="text/javascript">window.onload = waktos('waktos');</script></span></p>	
			</div>
            <div class="stats-desc"><span id="kaping"><script type="text/javascript">window.onload = kaping('kaping');</script></span></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary" data-sortable-id="ui-widget-16">
            <div class="panel-heading">
                <h4 class="panel-title">Menu Transaksi - Transaksi</h4>
            </div>
            <div class="panel-body bg-blue text-white">
                <p>
                <div style="text-align:center">
                    <a href="<?php echo base_url();?>dashboard/play" class="btn btn-lg btn-info">
                        <i class="fa fa-car fa-2x pull-left"></i>
                        Activitas<br />
                        <small>Kursus</small>
                    </a>
                    <a href="<?php echo base_url();?>member/add" class="btn btn-lg btn-info">
                        <i class="fa fa-users fa-2x pull-left"></i>
                        Registrasi<br />
                        <small>Siswa baru</small>
                    </a>
                    <a href="<?php echo base_url();?>bayar" class="btn btn-lg btn-info">
                        <i class="fa fa-money fa-2x pull-left"></i>
                        Pembayaran<br />
                        <small>Kursus Siswa</small>
                    </a>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
$tipe = $this->db->get('tbl_tipe')->result();
foreach ($tipe as $key) {
    $nama = $key->nama;
    $idx = $key->id
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo "Kursus " . $nama;?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:left" width="1%">No.</th>
                                <th style="text-align:left" width="5%">Foto Siswa</th>
                                <th style="text-align:left" width="15%">Tgl Mulai</th>
                                <th style="text-align:left" width="20%">Nama Siswa</th>
                                <th style="text-align:left" width="20%">Instruktur</th>
                                <th style="text-align:left" width="20%">Fasilitas</th>
                                <th style="text-align:left" width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           $i = 0;
                           $nukursus = $this->db->query("SELECT tbl_mulai.id as id_tran,tbl_member.foto,tbl_member.kode,tbl_member.nama,tbl_mulai.tgl_mulai,tbl_username.nama as nama_instruktur,tbl_mobil.nama as nama_fasilitas FROM tbl_mulai INNER JOIN tbl_member ON tbl_mulai.kode_member = tbl_member.kode INNER JOIN tbl_username ON tbl_mulai.instruktur = tbl_username.id INNER JOIN tbl_mobil ON tbl_mulai.fasilitas = tbl_mobil.id WHERE tbl_mulai.id_tipe = '$idx' AND tbl_mulai.status = '1'")->result();
                           foreach ($nukursus as $row) {
                                $i++;
                           ?>
                           <tr>
                               <td style="text-align:center"><?php echo $i . ".";?></td>
                               <td style="text-align:left"><img src="<?php echo base_url();?>foto/member/<?php echo $row->foto;?>" style="width:80px;height:80px"></td>
                               <td style="width:10px"><?php echo date("d-m-Y H:i:s",strtotime($row->tgl_mulai));?></td>
                               <td style="width:35px"><?php echo $row->nama;?></td>
                               <td style="width:35px"><?php echo $row->nama_instruktur;?></td>
                               <td style="width:20px"><?php echo $row->nama_fasilitas;?></td>
                               <td style="width:13px"><a href="<?php echo base_url();?>dashboard/selesai/<?php echo $row->id_tran;?>/<?php echo $row->kode;?>" title="Selesai Kursus" class="btn btn-danger btn-sm">Finish</td>
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
<?php
}
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Log Activity</h4>
    </div>

    <div class="panel-body p-0">
        <div class="vertical-box">
            <div id="log_activity" class="vertical-box-column p-20 calendar"></div>
        </div>
    </div>
</div>
