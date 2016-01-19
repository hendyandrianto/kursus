<script type="text/javascript">
var host = window.location.host;
$BASE_URL = 'http://'+host+'/';  
jQuery(document).ready(function(){
    jQuery("#tombol_laporan").hide("slow");
    jQuery(".lap_siswa").click(function (){
        var checked_value = jQuery(".lap_siswa:checked").val();
        if(checked_value==0){
            jQuery("#tombol_laporan").show("slow");
        }else if(checked_value==1){
            jQuery("#tombol_laporan").show("slow");
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
                  &nbsp;<input type="radio" name="radiolap" id="menjahit" style="width:20px" class="lap_siswa" value="0"/>Menjahit&nbsp;
                  &nbsp;<input type="radio" name="radiolap" id="mengemudi" style="width:20px" class="lap_siswa" value="1"/>Mengemudi&nbsp;
                </td>
              </tr>
            </table>
          </div>
          <br/>
          <br/>
          <div id="tombol_laporan">
            <div class="form-group">
              <div class="col-md-3 col-sm-3">
                <button class="btn btn-primary btn-sm" onclick="cetak_siswa('<?php echo $link;?>')">TAMPILKAN</button>
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
