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
                <form class="form-horizontal form-bordered" action="<?php echo base_url();?>profile/edit_data" method="post" enctype="multipart/form-data" data-parsley-validate="true">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Foto Profile :</label>
                        <div class="col-md-2 col-sm-2">
                        <?php
                            if($foto==""){
                                $fotox = "no.jpg";
                            }else{
                                $fotox = $foto;
                            }
                        ?>
                        <a class="fancybox" title="<?php echo $nama;?>" href="<?php echo base_url();?>foto/pegawai/<?php echo $foto;?>" style="width:150px;text-align:center;height:180px;" data-fancybox-group="album"><img src="<?php echo base_url();?>foto/pegawai/<?php echo $foto;?>" style="width:150px;text-align:center;height:180px;" alt="" /></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Nama * :</label>
                        <div class="col-md-3 col-sm-3">
                            <input class="form-control" type="text" id="nama" name="nama" value="<?php echo set_value('nama',isset($default['nama']) ? $default['nama'] : ''); ?>" data-type="nama" data-parsley-required="true"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Foto Profile :</label>
                        <div class="col-md-3 col-sm-3">
                            <input name="MAX_FILE_SIZE" value="1024000" type="hidden">
                            <input type="file" id="foto" name="foto" />  
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3"></label>
                        <div class="col-md-3 col-sm-3">
                            <label><a href="<?php echo base_url();?>profile/ganti">Ganti Password ?</a></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-Kode Karyawan-3"></label>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-success btn-sm">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
