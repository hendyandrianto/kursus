<script type="text/javascript">
var host = window.location.host;
$BASE_URL = 'http://'+host+'/';  
jQuery(document).ready(function(){
    jQuery("#tombol").hide("slow");
    jQuery("#tombollaporan").hide("slow");
    jQuery("#lappertanggal").hide();
    jQuery("#lapperiode").hide();
    jQuery(".lap").click(function (){
        var checked_value = jQuery(".lap:checked").val();
        if(checked_value==0){
            jQuery("#tombollaporan").show("slow");
            jQuery("#lappertanggal").show("slow");
            jQuery("#lapperiode").hide("slow");
        }else if(checked_value==1){
            jQuery("#tombollaporan").show("slow");
            jQuery("#lappertanggal").hide("slow");
            jQuery("#lapperiode").show("slow");
        }
    });

});
</script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-inverse" data-sortable-id="form-validation-2">
      <div class="panel-heading">
          <div class="panel-heading-btn">
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
              <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
          </div>
          <h4 class="panel-title"><?php echo $halaman;?></h4>
      </div>
      <div class="panel-body panel-form">
        <div class="form-group">
          <form action="javascript:void(0)">
            <table id="data-table" class="table table-striped nowrap">
                <tr>
                  <td colspan="4">&nbsp;<strong>PILIH TIPE LAPORAN :</strong></td>
                </tr>
            </table>
          <div class="table-responsive">
            <table border="0" cellspacing="0" cellpadding="0" class="table table-striped nowrap">
              <tr>
                <td width="1%">
                  &nbsp;<input type="radio" name="radiolap" id="pertgl" style="width:20px" class="lap" value="0"/>Per Tanggal&nbsp;
                  &nbsp;<input type="radio" name="radiolap" id="periode" style="width:20px" class="lap" value="1"/>Per Periode&nbsp;
                </td>
              </tr>
            </table>
          </div>
          <hr></hr>
          <div id="lappertanggal">
            <div class="form-group">
              <div class="col-md-2 col-sm-2">
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" value="<?php echo set_value('mulai',isset($default['mulai']) ? $default['mulai'] : ''); ?>" name="mulai" id="mulaip" data-parsley-required="true" placeholder="Masukan Tanggal" />
                </div>
                <br/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3 col-sm-3">
                <div class="input-group input-daterange">
                  <select class="form-control selectpicker" id="tipe_pertgl" name="tipe_pertgl" data-size="10" data-live-search="true" data-style="btn-white">
                      <option value="" selected>Pilih Kursus</option>
                      <?php
                      $tipe = $this->db->get('tbl_tipe')->result();
                      foreach ($tipe as $row) {
                        ?>
                        <option value="<?php echo $row->id;?>"><?php echo $row->nama;?></option>
                        <?php
                      }
                      ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div id="lapperiode">
            <div class="form-group">
              <div class="col-md-3 col-sm-3">
                <div class="input-group input-daterange">
                    <input type="text" class="form-control" id="tgl_mulai" name="mulai" placeholder="Tanggal Mulai" />
                    <span class="input-group-addon">to</span>
                    <input type="text" class="form-control" id="tgl_akhir" name="akhir" placeholder="Tanggal Selesai" />
                </div>
                <br/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3 col-sm-3">
                <div class="input-group input-daterange">
                  <select class="form-control selectpicker" id="tipe_perperiode" name="tipe_perperiode" data-size="10" data-live-search="true" data-style="btn-white">
                      <option value="" selected>Pilih Kursus</option>
                      <?php
                      $tipe = $this->db->get('tbl_tipe')->result();
                      foreach ($tipe as $row) {
                        ?>
                        <option value="<?php echo $row->id;?>"><?php echo $row->nama;?></option>
                        <?php
                      }
                      ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div id="tombollaporan">
            <div class="form-group">
              <div class="col-md-3 col-sm-3">
                <button class="btn btn-primary btn-sm" onclick="cetak_laporan('<?php echo $link;?>')">TAMPILKAN</button>
                <button type="button" onclick="history.go(-1)" class="btn btn-primary btn-sm">BATAL</button>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>  
    </div>
  </div>
</div>
