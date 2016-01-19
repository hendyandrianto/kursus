<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script>
$(document).ready(function() {
    jQuery("#detilna").hide('');
    jQuery("#nama").autocomplete({
        source: function(req,add){
            jQuery.ajax({
                url:"<?php echo base_url() . 'dashboard/get_member/';?>",
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
            jQuery('#nama').val(ui.item.id);
            jQuery('#nama').val(ui.item.nama);
            jQuery('#kode').val(ui.item.kode);
            jQuery('#foto').val(ui.item.foto);
            jQuery('#tipe').val(ui.item.nama_tipe);
            jQuery('#quota').val(ui.item.sisa);
            jQuery('#status').val(ui.item.statusna);
            var nama = jQuery('#nama').val();
            var kode = jQuery('#kode').val();
            var foto = jQuery('#foto').val();
            var tipe = jQuery('#tipe').val();
            var sisa = jQuery('#quota').val();
            var stts = jQuery("#status").val();
            if(stts==='1'){
                if(sisa > 0){
    	            jQuery("#detilna").show('slow');
                    document.getElementById('nama').focus();
                    $.gritter.add({title:"INFORMASI SISWA !",text: "NAMA : " + nama + "<br/>"+"TIPE KURSUS : "+tipe+"<br/>"+"SISA PERTEMUAN : "+sisa+" X" ,image:"<?php echo base_url() . 'foto/member/';?>"+foto});return false;
                }else{
                    document.getElementById('nama').focus();
                    $.gritter.add({title:"INFORMASI SISWA !",text: "NAMA : " + nama + "<br/>"+"TIPE KURSUS : "+tipe+"<br/>"+"SISA PERTEMUAN : "+sisa+" X" ,image:"<?php echo base_url() . 'foto/member/';?>"+foto});return false;
                }
            }else{
                document.getElementById('nama').focus();
                $.gritter.add({title:"INFORMASI SISWA !",text: "NAMA : " + nama + "<br/>"+"TIPE KURSUS : "+tipe+"<br/>"+"SISA PERTEMUAN : "+sisa+" X"+"<br/>"+"STATUS : MENGUNDURKAN DIRI" ,image:"<?php echo base_url() . 'foto/member/';?>"+foto});return false;
            }
        }
    })
});
function proses_simpan(){
	var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';  
	var kode = jQuery("#kode").val();
	var instruktur = jQuery("#instruktur").val();
	var fasilitas = jQuery("#fasilitas").val();
	jQuery.ajax({
        url : $BASE_URL+'dashboard/mulai_kursus',
        data : {kode:kode,instruktur:instruktur,fasilitas:fasilitas},
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
                    message : 'Data Berhasi Disimpan !'
                });
                window.location = $BASE_URL+'dashboard/play';
                setTimeout(function(){
                    jQuery.unblockUI();
                },500);
            } else {
                notif({
                    type: "warning",
                    msg: "Ups Data Gagal Di Simpan",
                    position: "center",
                    width: 500,
                    height: 60,
                    autohide: true
                });
                jQuery("#nama").val('');
                jQuery("#detilna").hide('');
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
		        <h4 class="panel-title">Form Siswa Kursus</h4>
		    </div>
		    <div class="panel-body panel-form">
		        <form class="form-horizontal form-bordered" action="javascript:proses_simpan();" id="form" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Siswa * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="hidden" id="foto" name="foto" data-type="foto"/>
                            <input class="form-control" type="hidden" id="tipe" name="tipe" data-type="tipe"/>
                            <input class="form-control" type="hidden" id="kode" name="kode" data-type="tipe"/>
                            <input class="form-control" type="hidden" id="status" name="status" data-type="status"/>
                            <input class="form-control" type="hidden" id="quota" name="quota" data-type="quota"/>
							<input class="form-control" type="text" id="nama" minlength="1" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" placeholder="Masukan Nama Siswa" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>

					<div id="detilna">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Instruktur * :</label>
							<div class="col-md-3 col-sm-3">
	                            <?php echo form_dropdown('instruktur',$option_instruktur,isset($default['instruktur']) ? $default['instruktur'] : '','class="form-control selectpicker" id="instruktur" data-size="10" data-live-search="true" data-parsley-required="true" data-style="btn-white"');?>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Fasilitas Yang Digunakan * :</label>
							<div class="col-md-3 col-sm-3">
	                            <?php echo form_dropdown('fasilitas',$option_fasilitas,isset($default['fasilitas']) ? $default['fasilitas'] : '','class="form-control selectpicker" id="fasilitas" data-size="10" data-live-search="true" data-parsley-required="true" data-style="btn-white"');?>
							</div>
						</div>
						<br/>
							<div style="text-align:center">
								<button type="submit" class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>
							</div>
						<br/>
					</div>
		        </form>
		    </div>
		</div>
	</div>
</div>
