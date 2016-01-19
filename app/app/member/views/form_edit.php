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
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="nama" minlength="1" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" placeholder="Masukan Agama" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Nama Orangtua * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="nama_ortu" minlength="1" name="nama_ortu" value="<?php echo set_value('nama_ortu',isset($default['nama_ortu']) ? $default['nama_ortu'] : ''); ?>" data-type="nama_ortu" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Tempat Lahir * :</label>
						<div class="col-md-3 col-sm-3">
							<input class="form-control" type="text" id="tempat" minlength="1" name="tempat" value="<?php echo set_value('tempat',isset($default['tempat']) ? $default['tempat'] : ''); ?>" data-type="tempat" data-parsley-required="true" data-parsley-minlength="2"/>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Tanggal Lahir * :</label>
                        <div class="col-md-2 col-sm-2"> 
                            <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                <input type="text" class="form-control" name="tgllahir" value="<?php echo set_value('tgllahir',isset($default['tgllahir']) ? $default['tgllahir'] : ''); ?>"  data-type="tgllahir" data-parsley-required="true"/>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Jenis Kelamin * :</label>
						<div class="col-md-3 col-sm-3">
							<input type="radio" name="sex" class="uniform" data-parsley-required="true" value="L" <?php if($sex=='L'){ echo 'checked="checked"';} ;?> />&nbsp;Laki-Laki 
							<input type="radio" name="sex" class="uniform" data-parsley-required="true" value="P" <?php if($sex=='P'){ echo 'checked="checked"';} ;?> />&nbsp;Perempuan
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Alamat * :</label>
						<div class="col-md-5 col-sm-5">
							<input class="form-control" type="text" id="alamat" minlength="1" name="alamat" value="<?php echo set_value('alamat',isset($default['alamat']) ? $default['alamat'] : ''); ?>" data-type="alamat" placeholder="Masukan Alamat" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-minlength="1"/>
						</div>
					</div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Agama * :</label>
						<div class="col-md-2 col-sm-2">
                            <?php echo form_dropdown('agama',$option_agama,isset($default['agama']) ? $default['agama'] : '','class="form-control selectpicker" data-parsley-group="wizard-step-1" data-parsley-required="true" id="agama" data-size="10" data-live-search="true" data-style="btn-white"');?>
						</div>
                    </div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Pendidikan * :</label>
						<div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('pendidikan',$option_pendidikan,isset($default['pendidikan']) ? $default['pendidikan'] : '','class="form-control selectpicker" id="pendidikan" data-size="10" data-live-search="true" data-parsley-group="wizard-step-1" data-parsley-required="true" data-style="btn-white"');?>
						</div>
                    </div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">Pekerjaan * :</label>
						<div class="col-md-3 col-sm-3">
                            <?php echo form_dropdown('pekerjaan',$option_pekerjaan,isset($default['pekerjaan']) ? $default['pekerjaan'] : '','class="form-control selectpicker" id="pekerjaan" data-parsley-group="wizard-step-1" data-parsley-required="true" data-size="10" data-live-search="true" data-style="btn-white"');?>
						</div>
                    </div>
                    <div class="form-group">
						<label class="control-label col-md-3 col-sm-3">No Handphone * :</label>
						<div class="col-md-2 col-sm-2">
							<input class="form-control" style="text-align:right" type="text" id="nope" minlength="1" name="nope" value="<?php echo set_value('nope',isset($default['nope']) ? $default['nope'] : ''); ?>" data-type="nope" data-parsley-group="wizard-step-1" data-parsley-required="true" data-parsley-type="number" data-parsley-minlength="1"/>
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
