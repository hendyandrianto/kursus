<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script>
$(document).ready(function() {
    jQuery("#detilna").hide('');
    jQuery("#nama").autocomplete({
        source: function(req,add){
            jQuery.ajax({
                url:"<?php echo base_url() . 'cetak/get_member/';?>",
                dataType:'json',
                type:'POST',
                data:req,                                                   
                success:function(data){
                    if(data.response=='true'){
                        add(data.message);                              
                    }else{
                        jQuery("#detilna").hide('');
                        $.gritter.add({title:"INFORMASI SISWA !",text: "DATA SISWA TIDAK DITEMUKAN"});return false;
                    }
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        minLength:3,
        select: function(event,ui){
            jQuery("#detilna").show('slow');
            jQuery('#nama').val(ui.item.id);
            jQuery('#nama').val(ui.item.nama);
            jQuery('#kode').val(ui.item.kode);
            jQuery('#foto').val(ui.item.foto);
            jQuery('#tipe').val(ui.item.nama_tipe);
            jQuery('#sisa').val(ui.item.sisa);
            jQuery('#sisa').priceFormat({
		        prefix: '',
		        centsSeparator: ',',
		        thousandsSeparator: '.'
		    });     
		    jQuery('#bayar').priceFormat({
		        prefix: '',
		        centsSeparator: ',',
		        thousandsSeparator: '.'
		    });     
            var nama = jQuery('#nama').val();
            var kode = jQuery('#kode').val();
            var foto = jQuery('#foto').val();
            var tipe = jQuery('#tipe').val();
            document.getElementById('nama').focus();
            $.gritter.add({title:"INFORMASI SISWA !",text: "NAMA : " + nama + "<br/>"+"TIPE KURSUS : "+tipe,image:"<?php echo base_url() . 'foto/member/';?>"+foto});return false;
        }
    })
});
function cetak_data(){
	var kode = jQuery("#kode").val();
	var stts = jQuery("#prestasi").val();
	var no = jQuery("#no_ijazah").val();
    var tgl_mulai = jQuery("#tgl_mulai").val();
    var tgl_akhir = jQuery("#tgl_akhir").val();
	jQuery.ajax({
        url : $BASE_URL+'cetak/cek_data',
        data : {kode:kode,stts:stts,no:no,tgl_mulai:tgl_mulai,tgl_akhir:tgl_akhir},
        type : 'POST',
        dataType: 'json',
        success:function(data){
            jQuery.unblockUI();
            if(data.response=='true'){
                jQuery.blockUI({
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: 2, 
                        color: '#fff' 
                    },
                    message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
                });
                window.location = $BASE_URL+'cetak/cetak_data/'+kode+"/"+stts+"/"+no+"/"+tgl_mulai+"/"+tgl_akhir;
                setTimeout(function(){
                    jQuery.unblockUI();
                },500);
            }            
        }
    });
}
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
		        <form class="form-horizontal form-bordered" action="javascript:cetak_data()" id="form" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Siswa * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="hidden" id="foto" name="foto" data-type="foto"/>
                            <input class="form-control" type="hidden" id="tipe" name="tipe" data-type="tipe"/>
                            <input class="form-control" type="hidden" id="kode" name="kode" data-type="tipe"/>
							<input class="form-control" type="text" id="nama" minlength="1" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" placeholder="Masukan Nama Siswa" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>
					<div id="detilna">
						<input class="form-control" style="text-align:right" readonly="readonly" type="hidden" id="sisa" minlength="1" name="sisa" value="<?php echo set_value('sisa',isset($default['sisa']) ? $default['sisa'] : ''); ?>" data-type="sisa" data-parsley-required="true" data-parsley-minlength="1"/>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">No Ijazah * :</label>
							<div class="col-md-3 col-sm-3">
								<input class="form-control" type="text" id="no_ijazah" minlength="1" name="no_ijazah" value="<?php echo set_value('no_ijazah',isset($default['no_ijazah']) ? $default['no_ijazah'] : ''); ?>" data-type="no_ijazah" placeholder="Masukan No Ijazah" data-parsley-required="true" data-parsley-minlength="1"/>
							</div>
						</div>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Tanggal Diselenggarakan * :</label>
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
							<label class="control-label col-md-3 col-sm-3">Prestasi * :</label>
							<div class="input-group col-md-3 col-sm-3">
	                            <?php echo form_dropdown('prestasi',$option_prestasi,isset($default['prestasi']) ? $default['prestasi'] : '','class="form-control selectpicker" id="prestasi" data-parsley-group="wizard-step-1" data-parsley-required="true" data-size="10" data-live-search="true" data-style="btn-white"');?>
	                        </div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3"></label>
							<div class="col-md-3 col-sm-3">
								<button type="submit" class="btn btn-success btn-sm">Cetak</button>
	                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>
							</div>
						</div>
					</div>
		        </form>
		    </div>
		</div>
	</div>
</div>
