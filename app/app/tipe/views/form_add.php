<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
 	jQuery('#h_daftar').priceFormat({
	    prefix: '',
	    centsSeparator: ',',
	    thousandsSeparator: '.'
	});
	jQuery('#h_pokok').priceFormat({
	    prefix: '',
	    centsSeparator: ',',
	    thousandsSeparator: '.'
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
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" id="form" method="post" enctype="multipart/form-data" data-parsley-validate="true">
			        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Jenis * :</label>
                        <div class="col-md-2 col-sm-2">
                            <?PHP echo form_dropdown('jenis',$option_jenis,isset($default['jenis']) ? $default['jenis'] : '','id="jenis" data-size="10" data-parsley-group="wizard-step-1" data-parsley-required="true" data-live-search="true" data-style="btn-white" class="form-control selectpicker"');?>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tipe Kursus * :</label>
						<div class="col-md-4 col-sm-4">
							<input class="form-control" type="text" id="tipe" minlength="1" name="tipe" value="<?php echo set_value('tipe',isset($default['tipe']) ? $default['tipe'] : ''); ?>" data-type="tipe" placeholder="Masukan Tipe Kursus" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Pendaftaran * :</label>
						<div class="input-group col-md-3 col-sm-3">
                            <span class="input-group-addon">RP.</span>
							<input class="form-control" style="text-align:right" type="text" id="h_daftar" minlength="1" name="h_daftar" value="<?php echo set_value('h_daftar',isset($default['h_daftar']) ? $default['h_daftar'] : ''); ?>" data-type="h_daftar" data-parsley-required="true" data-parsley-minlength="1"/>
                            <span class="input-group-addon">.00</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Harga Pendidikan * :</label>
						<div class="input-group col-md-3 col-sm-3">
                            <span class="input-group-addon">RP.</span>
							<input class="form-control" style="text-align:right" type="text" id="h_pokok" minlength="1" name="h_pokok" value="<?php echo set_value('h_pokok',isset($default['h_pokok']) ? $default['h_pokok'] : ''); ?>" data-type="h_pokok" data-parsley-required="true" data-parsley-minlength="1"/>
                            <span class="input-group-addon">.00</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Durasi * :</label>
						<div class="input-group col-md-2 col-sm-2">
							<input class="form-control" style="text-align:right" type="text" id="durasi" minlength="1" name="durasi" value="<?php echo set_value('durasi',isset($default['durasi']) ? $default['durasi'] : ''); ?>" data-type="durasi" data-parsley-required="true" data-parsley-minlength="1" data-parsley-type="number"/>
                            <span class="input-group-addon">hari</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Pertemuan * :</label>
						<div class="input-group col-md-2 col-sm-2">
							<input class="form-control" style="text-align:right" type="text" id="pertemuan" minlength="1" name="pertemuan" value="<?php echo set_value('pertemuan',isset($default['pertemuan']) ? $default['pertemuan'] : ''); ?>" data-type="pertemuan" data-parsley-required="true" data-parsley-minlength="1" data-parsley-type="number"/>
                            <span class="input-group-addon">Pertemuan</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Expired * :<br/><small>* Batas hari mengundurkan diri</small></label>
						<div class="input-group col-md-2 col-sm-2">
							<input class="form-control" style="text-align:right" type="text" id="expire" minlength="1" name="expire" value="<?php echo set_value('expire',isset($default['expire']) ? $default['expire'] : ''); ?>" data-type="expire" data-parsley-required="true" data-parsley-minlength="1" data-parsley-type="number"/>
                            <span class="input-group-addon">hari</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-3 col-sm-3">
							<button type="submit" class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>
                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>
						</div>
					</div>
		        </form>
		    </div>
		</div>
	</div>
</div>
