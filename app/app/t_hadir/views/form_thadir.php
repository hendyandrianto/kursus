<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>
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
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" method="post" data-parsley-validate="true">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Siswa * :</label>
						<div class="col-md-6 col-sm-6">
                            <?PHP echo form_dropdown('pegawai',$option_pegawai,isset($default['pegawai']) ? $default['pegawai'] : '','class="form-control selectpicker" data-size="10" data-parsley-required="true" data-live-search="true" data-style="btn-white"');?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tanggal * :</label>
                        <div class="col-md-3">
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control" name="mulai" value="<?php echo set_value('mulai',isset($default['mulai']) ? $default['mulai'] : ''); ?>"  data-parsley-required="true"  placeholder="Mulai" />
                                <span class="input-group-addon">sd</span>
                                <input type="text" class="form-control" name="selesai" value="<?php echo set_value('selesai',isset($default['selesai']) ? $default['selesai'] : ''); ?>"  data-parsley-required="true"  placeholder="Selesai" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Jenis Ketidakhadiran * :</label>
						<div class="col-md-3 col-sm-3">
                            <?PHP echo form_dropdown('thadir',$option_thadir,isset($default['thadir']) ? $default['thadir'] : '','class="form-control selectpicker" data-size="10" data-parsley-required="true" data-live-search="true" data-style="btn-white"');?>
						</div>
					</div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Keterangan :</label>
						<div class="col-md-5 col-sm-5">
                            <textarea class="form-control" id="ket" name="ket" data-parsley-required="true" rows="3" ><?php echo set_value('ket',isset($default['ket']) ? $default['ket'] : ''); ?></textarea>
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
