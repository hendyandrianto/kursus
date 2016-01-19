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
		        <form class="form-horizontal form-bordered" action="<?php echo $action;?>" id="form" method="post" enctype="multipart/form-data" data-parsley-validate="true">
					<?php
					if($cek=='edit'){
						?>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">Foto * :</label>
							<div class="col-md-3 col-sm-3">
			                    <a class="fancybox" href="<?php echo base_url();?>foto/pegawai/<?php echo $foto;?>" style="width:80px;text-align:center;height:102px;" data-fancybox-group="gallery"><img src="<?php echo base_url();?>foto/pegawai/<?php echo $foto;?>" style="width:71px;" alt="" /></a>
							</div>
						</div>
						<?php
					}
					?>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="nama" minlength="2" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" placeholder="Masukan Nama Pegawai" data-parsley-required="true" data-parsley-minlength="2"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Username * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="username" minlength="2" name="username" value="<?php echo set_value('username',isset($default['username']) ? $default['username'] : ''); ?>" data-type="username" placeholder="Masukan Username" data-parsley-required="true" data-parsley-minlength="2"/>
						</div>
					</div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Foto Profile :</label>
						<div class="col-md-3 col-sm-3">
                            <input name="MAX_FILE_SIZE" value="9999999999" type="hidden">
				            <input type="file" id="foto" name="foto" />  
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
