<link href="<?php echo base_url();?>assets/plugins/bootstrap-wizard/css/bwizard.min.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap-wizard/js/bwizard.js"></script>
<script src="<?php echo base_url();?>assets/js/form-wizards-validation.demo.min.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
<script src="<?php echo base_url();?>assets/js/webcam.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    FormWizardValidation.init();
    jQuery('#debit').hide();
    jQuery('#pembayaran').hide();
	jQuery('#kredit').hide();
	jQuery('#transfer').hide();
    jQuery("#detil_kursus").hide();
    jQuery("#detil_reg").hide();
    jQuery('#bayarna').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });     
    jQuery('#diskon').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });     
    var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';
    jQuery("#jenis").change(function(){
        var jenis = jQuery("#jenis").val();
        if(jenis!=""){
            jQuery.blockUI({
                css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: 0.5, 
                    color: '#fff' 
                },
                message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
            });
            setTimeout(function(){
	            jQuery.unblockUI();
            },500);
            jQuery("#tipe").load ($BASE_URL+'member/get_tipe/'+jenis);
            jQuery("#tipe").trigger("liszt:updated");
            jQuery("#detil_kursus").show('hide');
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Jenis Kursus Tidak Boleh Kosong !"});return false;
        }
    });
    $("input[name=bayar]").change(function() {
     	var n = $(this).val();
	 	switch(n){
			case "0":
				$('#debit').hide();
				$('#kredit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "1":
				$('#debit').show();
				$('#kredit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "2":
				$('#kredit').show();
				$('#debit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "3":
				$('#debit').hide();
				$('#kredit').hide();
				$('#transfer').show();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
		}
  	});
	jQuery("#simpan_data").click(function(){
		var nama = jQuery("#nama").val();
		if(nama!="") {
			var r=confirm("Data sudah benar  ?");
			if(r==true){
				$.post($BASE_URL+"member/proses_add", $("#tform").serialize(),
				function(data){
                  	$("#message").html(data);
                  	$("#message").hide();
                  	$("#message").fadeIn(1500); //Fade in the data given by the insert.php file
                 	window.location.href = $BASE_URL+'member';
            	});
				return false; 
			}
		}else{
			alert("Data tidak boleh kosong !")
		}
	});
    jQuery("#tipe").change(function(){
        var tipe = jQuery("#tipe").val();                            
        if (jQuery("#tipe").val()!=''){
        	jQuery.post($BASE_URL+"member/get_harga/"+tipe,
            function(data){
                var dt = data.split("|");
                jQuery("#h_daftar").val(dt[0]);
                jQuery('#h_daftar').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });     
                document.getElementById("h_daftar_label").textContent = "Rp. "+jQuery("#h_daftar").val();
                jQuery("#h_pokok").val(dt[1]);
                jQuery('#h_pokok').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("h_pokok_label").textContent = "Rp. "+jQuery("#h_pokok").val();
                var daftar = jQuery("#h_daftar").unmask();
                var biaya = jQuery("#h_pokok").unmask();
                jQuery("#subtotal").val(parseInt(daftar)+parseInt(biaya));
                    jQuery('#subtotal').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                jQuery("#totalna").val(parseInt(daftar)+parseInt(biaya));
                    jQuery('#totalna').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                jQuery("#diskon").val(0);
                document.getElementById("subtotal_label").textContent = "Rp. "+jQuery("#totalna").val();
                var tot = jQuery("#totalna").unmask();
                var dsc = jQuery("#diskon").unmask();
                var subtotal = parseInt(tot) - (parseInt(dsc)/100);
                jQuery("#totalnax").val(parseInt(subtotal));
                jQuery('#totalnax').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("totalna").textContent = "Rp. "+jQuery("#totalnax").val();
                jQuery('#detil_reg').show("slow");;
            });     
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Jenis Kursus Tidak Boleh Kosong !"});
            jQuery('#detil_reg').hide("slow");;
            return false;
        }
    });
});
function etang () {
	var subtotal = jQuery("#subtotal").unmask();
	var dsc = jQuery("#diskon").unmask();
	var total = parseInt(subtotal) - parseInt(dsc);
	jQuery("#totalnax").val(parseInt(total));
	jQuery('#totalnax').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    document.getElementById("totalna").textContent = "Rp. "+jQuery("#totalnax").val();
}
function hitung () {
	var subtotal = jQuery("#totalnax").unmask();
	var bayar = jQuery("#bayarna").unmask();
	var total = parseInt(subtotal) - parseInt(bayar);
	jQuery("#sisa").val(parseInt(total));
	jQuery('#sisa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();	
}

</script>
<style type="text/css">
#apDiv1 {
	position:inherit;
	left:500px;
}
#foto {
	position:absolute;
	top:10px;
	left:10px;
	width:10px;
	height:10px;
	float:right;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title"><?php echo $halaman;?></h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">

	                <form action="javascript:simpan_data()" enctype="multipart/form-data" id="tform" method="POST" data-parsley-validate="true" name="form-wizard">
						<div id="wizard">
							<ol>
								<li>
								    Data Pribadi
								    <small>Masukan Data Pribadi Siswa dengan benar dan sesuai ketentuan</small>
								</li>
								<li>
								    Paket Kursusan
								    <small>Masukan Data Paketan Kursus Siswa dengan benar dan sesuai ketentuan.</small>
								</li>
								<li>
								    Take Picture
								    <small>Proses Pengambilan Foto Siswa.</small>
								</li>
	                            <li>
	                                Proses Simpan Data
	                                <small>Jika Data Sudah Terisi Dengan Benar Silahkan Lakukan Penyimpanan Data.</small>
	                            </li>
							</ol>
							<div class="wizard-step-1">
	                            <fieldset>
	                                <legend class="pull-left width-full">Data Pribadi Calon Peserta Didik</legend>
	                                <div class="form-horizontal form-bordered" >
	                                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Kode Reg * :</label>
										<div class="col-md-2 col-sm-2">
											<input class="form-control" readonly="readonly" type="text" id="kode" minlength="1" name="kode" value="<?php echo $kode; ?>" data-type="kode" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-minlength="1"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Nama Siswa * :</label>
										<div class="col-md-3 col-sm-3">
											<input class="form-control" type="text" id="nama" minlength="2" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" placeholder="Masukan Nama Siswa" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-minlength="2"/>
										</div>
									</div>
									<div class="form-group">
	                                    <label class="control-label col-md-2 col-sm-2">Nama Orangtua * :</label>
	                                    <div class="col-md-4 col-sm-4">
	                                        <input class="form-control" type="text" id="nama_ortu" data-parsley-group="wizard-step-1" minlength="1" name="nama_ortu" value="<?php echo set_value('nama_ortu',isset($default['nama_ortu']) ? $default['nama_ortu'] : ''); ?>" placeholder="Masukan Nama Orangtua" data-type="nama_ortu" data-parsley-required="true" data-parsley-minlength="2"/>
	                                    </div>
	                                </div>
				                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Tempat Lahir * :</label>
										<div class="col-md-3 col-sm-3">
											<input class="form-control" type="text" id="tempat" minlength="1" name="tempat" value="<?php echo set_value('tempat',isset($default['tempat']) ? $default['tempat'] : ''); ?>" data-type="tempat" placeholder="Masukan Tempat Lahir" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-minlength="2"/>
										</div>
									</div>
									<div class="form-group">
				                        <label class="control-label col-md-2 col-sm-2">Tanggal Lahir * :</label>
				                        <div class="col-md-2 col-sm-2"> 
				                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
				                                <input type="text" class="form-control" data-parsley-group="wizard-step-1" name="tgllahir" value="<?php echo set_value('tgllahir',isset($default['tgllahir']) ? $default['tgllahir'] : ''); ?>"  data-type="tgllahir" data-parsley-group="wizard-step-1" data-parsley-required="true"/>
				                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                            </div>
				                        </div>
				                    </div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Jenis Kelamin * :</label>
										<div class="col-md-3 col-sm-3">
											<input type="radio" name="sex" class="uniform" data-parsley-group="wizard-step-1" data-parsley-required="true" value="L"  />&nbsp;Laki-Laki 
											<input type="radio" name="sex" class="uniform" data-parsley-group="wizard-step-1" data-parsley-required="true" value="P" />&nbsp;Perempuan
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Alamat * :</label>
										<div class="col-md-5 col-sm-5">
											<input class="form-control" type="text" id="alamat" minlength="1" name="alamat" value="<?php echo set_value('alamat',isset($default['alamat']) ? $default['alamat'] : ''); ?>" data-type="alamat" placeholder="Masukan Alamat" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-minlength="1"/>
										</div>
									</div>
				                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Agama * :</label>
										<div class="col-md-2 col-sm-2">
				                            <?php echo form_dropdown('agama',$option_agama,isset($default['agama']) ? $default['agama'] : '','class="form-control selectpicker" data-parsley-group="wizard-step-1" data-parsley-required="true" id="agama" data-size="10" data-live-search="true" data-style="btn-white"');?>
										</div>
				                    </div>
				                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Pendidikan * :</label>
										<div class="col-md-3 col-sm-3">
				                            <?php echo form_dropdown('pendidikan',$option_pendidikan,isset($default['pendidikan']) ? $default['pendidikan'] : '','class="form-control selectpicker" id="pendidikan" data-size="10" data-live-search="true" data-parsley-group="wizard-step-1" data-parsley-required="true" data-style="btn-white"');?>
										</div>
				                    </div>
				                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">Pekerjaan * :</label>
										<div class="col-md-3 col-sm-3">
				                            <?php echo form_dropdown('pekerjaan',$option_pekerjaan,isset($default['pekerjaan']) ? $default['pekerjaan'] : '','class="form-control selectpicker" id="pekerjaan" data-parsley-group="wizard-step-1" data-parsley-required="true" data-size="10" data-live-search="true" data-style="btn-white"');?>
										</div>
				                    </div>
				                    <div class="form-group">
										<label class="control-label col-md-2 col-sm-2">No Handphone * :</label>
										<div class="col-md-2 col-sm-2">
											<input class="form-control" style="text-align:right" type="text" id="nope" minlength="1" name="nope" value="<?php echo set_value('nope',isset($default['nope']) ? $default['nope'] : ''); ?>" data-type="nope" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-type="number" data-parsley-minlength="1"/>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="wizard-step-2">
								<fieldset>
									<legend class="pull-left width-full">Data Paketan Kursus</legend>
	                                <div class="form-horizontal form-bordered" >
	                                    <div class="form-group">
											<label class="control-label col-md-2 col-sm-2">Jenis Kursus * :</label>
											<div class="col-md-3 col-sm-3">
					                            <?php echo form_dropdown('jenis',$option_jenis,isset($default['jenis']) ? $default['jenis'] : '','class="form-control selectpicker" id="jenis" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
											</div>
					                    </div>
	                                </div>
	                                <div id="detil_kursus">
		                                <div class="form-horizontal form-bordered" >
		                                    <div class="form-group">
												<label class="control-label col-md-2 col-sm-2">Tipe Kursus * :</label>
												<div class="col-md-4 col-sm-4">
						                            <?php echo form_dropdown('tipe',$option_tipe,isset($default['tipe']) ? $default['tipe'] : '','class="default-select2 form-control" id="tipe" data-size="10" data-live-search="true" data-parsley-group="wizard-step-2" data-parsley-required="true" data-style="btn-white"');?>
												</div>
						                    </div>
		                                </div>
	                                </div>
	                                <div id="detil_reg">                                
	                                	<div class="invoice-content">
						                    <div class="table-responsive">
						                        <table class="table table-invoice">
						                            <thead>
						                                <tr>
						                                    <th>DESKRIPSI</th>
						                                    <th></th>
						                                    <th>TOTAL</th>
						                                </tr>
						                            </thead>
						                            <tbody>
						                                <tr>
						                                    <td>
						                                        <strong>Uang Pendaftaran<strong><br />
						                                        <small></small>
						                                    </td>
						                                    <td>
						                                    </td>
						                                    <td>
																<input class="form-control" style="text-align:right" readonly="readonly" type="hidden" id="h_daftar" minlength="1" name="h_daftar" data-type="h_daftar" data-parsley-required="true" data-parsley-minlength="1"/>
									                            <strong><label id="h_daftar_label"></label></strong>
								                            </td>
						                                </tr>
						                                <tr>
						                                    <td>
						                                        <strong>Biaya Pendidikan</strong><br />
						                                        <small></small>
						                                    </td>
						                                    <td>
						                                    </td>
						                                    <td>
																<input class="form-control" style="text-align:right" type="hidden" readonly="readonly" id="h_pokok" minlength="1" name="h_pokok" data-type="h_pokok" data-parsley-required="true" data-parsley-minlength="1"/>
									                            <strong><label id="h_pokok_label"></label></strong>
									                        </td>
						                                </tr>
						                            </tbody>
						                        </table>
						                    </div>
						                    <div class="invoice-price">
						                        <div class="invoice-price-left">
						                            <div class="invoice-price-row">
						                                <div class="sub-price">
						                                    <small><strong>SUBTOTAL</strong></small>
															<input class="form-control" style="text-align:right" readonly="readonly" type="hidden" id="subtotal" minlength="1" name="subtotal" data-type="subtotal" data-parsley-required="true" data-parsley-minlength="1"/>
															<label id="subtotal_label"></label>
						                                </div>
						                                <div class="sub-price">
						                                    <i class="fa fa-minus"></i>
						                                </div>
						                                <div class="sub-price">
						                                    <small><strong>DISKON (Rp)</strong></small>
															<input class="form-control" style="text-align:right;width:80px" onchange="etang()" type="text" id="diskon" minlength="1" name="diskon" data-type="diskon"/>
						                                </div>
						                            </div>
						                        </div>
						                        <div class="invoice-price-right">
													<input class="form-control" style="text-align:right;width:80px" type="hidden" id="totalnax" minlength="1" name="totalnax" data-type="totalnax"/>
						                            <small><strong>TOTAL</strong></small> <label style="color:white" id="totalna"></label>
						                        </div>
						                    </div>
						                    <br/>
											<legend class="pull-left width-full">Cara Pembayaran</legend>
											<div style="text-align:center">
												<img src="<?php echo base_url();?>assets/img/card_logos.png">
												<p>
												    <input type="radio" name="bayar" id="bayar" class="uniform" value="0" />&nbsp;Dimuka
												    <input type="radio" name="bayar" id="bayar" class="uniform" value="1" />&nbsp;Kartu Debit
												    <input type="radio" name="bayar" id="bayar" class="uniform" value="2"/>&nbsp;Kartu Kredit
												    <input type="radio" name="bayar" class="uniform" value="3" id="bayar" />&nbsp;Transfer Bank
												</p>
												<p>&nbsp;</p>
											</div>

											<div id="debit" >
												<div class="form-horizontal form-bordered" >
				                                    <div class="form-group">
														<label class="control-label col-md-2 col-sm-2">Nama Bank * :</label>
														<div class="col-md-3 col-sm-3">
								                            <?PHP echo form_dropdown('dbank',$option_bank,isset($default['kode']) ? $default['kode'] : '','id="dbank" class="form-control selectpicker" data-style="btn-white" style="width:80px"');?>
														</div>
														<label class="control-label col-md-2 col-sm-2">Nomor Kartu * :</label>
														<div class="col-md-3 col-sm-3">
								                            <input name="nokartud" id="nokartud" class="form-control" style="width:190px;" title="Nomor Kartu"  type="text" />
														</div>
								                    </div>
				                                </div>
											</div>

											<div id="kredit" >
												<div class="form-horizontal form-bordered" >
				                                    <div class="form-group">
														<label class="control-label col-md-2 col-sm-2">Tipe Bank * :</label>
														<div class="col-md-3 col-sm-3">
								                            <?PHP echo form_dropdown('jkartu',$option_jkartu,isset($default['kode']) ? $default['kode'] : '','id="jkartu" class="form-control selectpicker" data-style="btn-white" style="width:80px"');?>
														</div>
														<label class="control-label col-md-2 col-sm-2">Nama Bank * :</label>
														<div class="col-md-3 col-sm-3">
								                            <?PHP echo form_dropdown('kbank',$option_bank,isset($default['kode']) ? $default['kode'] : '','id="kbank" class="form-control selectpicker" data-style="btn-white" style="width:80px"');?>
														</div>
								                    </div>
				                                </div>
				                                <div class="form-horizontal form-bordered" >
				                                    <div class="form-group">
														<label class="control-label col-md-2 col-sm-2">Nomor Kartu * :</label>
														<div class="col-md-3 col-sm-3">
								                            <input name="nokartuk" id="nokartuk" class="form-control" style="width:190px;" title="Nomor Kartu"  type="text" />
														</div>
								                    </div>
				                                </div>
											</div>

											<div id="transfer">
												<div class="form-horizontal form-bordered" >
				                                    <div class="form-group">
														<label class="control-label col-md-2 col-sm-2">dari Bank * :</label>
														<div class="col-md-3 col-sm-3">
								                            <?PHP echo form_dropdown('tbanka',$option_bank,isset($default['kode']) ? $default['kode'] : '','id="tbanka" class="form-control selectpicker" data-style="btn-white" style="width:80px"');?>
														</div>
														<label class="control-label col-md-2 col-sm-2">Nomor Kartu * :</label>
														<div class="col-md-3 col-sm-3">
								                            <input name="reka" id="reka" class="form-control" style="width:190px;" title="Nomor Kartu"  type="text" />
														</div>
								                    </div>
				                                </div>
				                                <div class="form-horizontal form-bordered" >
				                                    <div class="form-group">
														<label class="control-label col-md-2 col-sm-2">ke Bank * :</label>
														<div class="col-md-3 col-sm-3">
								                            <?PHP echo form_dropdown('tbankb',$option_bank,isset($default['kode']) ? $default['kode'] : '','id="tbankb" class="form-control selectpicker" data-style="btn-white" style="width:80px"');?>
														</div>
														<label class="control-label col-md-2 col-sm-2">Nomor Kartu * :</label>
														<div class="col-md-3 col-sm-3">
								                            <input name="rekb" id="rekb" class="form-control" style="width:190px;" title="Nomor Kartu"  type="text" />
														</div>
								                    </div>
				                                </div>
											</div>

											<div id="pembayaran">
												<div class="invoice-price">
							                        <div class="invoice-price-left">
							                            <div class="invoice-price-row">
							                                <div class="sub-price">
							                                    <small><strong>TOTAL BAYAR</strong></small>
																<input class="form-control" style="text-align:right" type="text" data-parsley-group="wizard-step-2" onchange="hitung()" id="bayarna" minlength="1" name="bayarna" data-type="bayarna" data-parsley-required="true" data-parsley-minlength="1"/>
							                                </div>
							                            </div>
							                        </div>
							                        <div class="invoice-price-right">
														<input class="form-control" style="text-align:right;width:80px" type="hidden" id="sisa" minlength="1" name="sisa" data-type="sisa"/>
							                            <small>SISA PEMBAYARAN</small> <label style="color:white" id="sisana"></label>
							                        </div>
							                    </div>
						                    </div>

						                    <br/>
						                </div>
	                                </div>
								</fieldset>
							</div>
							<div class="wizard-step-3">
								<fieldset>
									<legend class="pull-left width-full">Take Picture</legend>
	                                <div class="form-horizontal form-bordered" >
										<div id="apDiv1" style="text-align:center">
										  	<script type="text/javascript">
										  		webcam.set_api_url('<?php echo base_url();?>member/proses_foto/'+kode);
												webcam.set_swf_url('<?php echo base_url();?>assets/webcam.swf' );
												webcam.set_quality(100);
												webcam.set_shutter_sound(true,'<?php echo base_url();?>assets/shutter.mp3');
											</script>
											<script language="JavaScript">
												document.write( webcam.get_html(220, 300) );
											</script>
											<br/><br/>
											<button onClick="webcam.configure()" class="btn btn-primary btn-sm">Setting</button>
											<button class="btn btn-primary btn-sm" onClick="webcam.freeze()">Capture</button>
											<button class="btn btn-primary btn-sm" onClick="do_upload()">Upload</button>
											<script language="JavaScript">
											webcam.set_hook( 'onError', 'salah' );
											function salah(){
												alert("EROR");	
											}
											function do_upload(){
												webcam.upload();
												webcam.reset();
											}
											</script>
										</div>
										<div id="foto"></div>
	                                </div>
	                            </fieldset>
							</div>
	                        <div>
	                            <div class="jumbotron m-b-0 text-center">
	                                <h4>Data Sudah Terisi Dengan Benar ?</h4>
	                                <p><button type="button" id="simpan_data" onclick="simpan_data()" class="btn btn-success btn-sm">Simpan Data</button></p>
	                            </div>
	                        </div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="message"></div>