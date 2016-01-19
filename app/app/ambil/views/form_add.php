<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?php echo base_url();?>assets/js/duit.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#bayar').priceFormat({
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
		        <form class="form-horizontal form-bordered" action="<?php echo base_url();?>ambil/proses_ambil" id="form" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Biaya Pengambilan * :</label>
						<div class="input-group col-md-3 col-sm-3">
                            <span class="input-group-addon">RP.</span>
							<input class="form-control" style="text-align:right" type="text" id="bayar" minlength="1" name="bayar" value="<?php echo set_value('bayar',isset($default['bayar']) ? $default['bayar'] : ''); ?>" data-type="bayar" data-parsley-required="true" data-parsley-minlength="1"/>
                            <span class="input-group-addon">.00</span>
                        </div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3"></label>
						<div class="col-md-3 col-sm-3">
							<button type="submit" class="btn btn-success btn-sm">Bayar</button>
                      		<button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm">Batal</button>
						</div>
					</div>
		        </form>
		    </div>
		</div>
	</div>
</div>
