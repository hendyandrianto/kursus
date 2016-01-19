<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/plugins/password-indicator/js/password-indicator.js"></script>
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
                <form class="form-horizontal form-bordered" action="<?php echo base_url();?>profile/edit_pass" method="post" enctype="multipart/form-data" data-parsley-validate="true">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Username * :</label>
                        <div class="col-md-3 col-sm-3">
                            <input class="form-control" type="text" id="username" maxlength="20" minlength="1" name="username" value="<?php echo set_value('username',isset($default['username']) ? $default['username'] : ''); ?>" data-type="username" data-parsley-required="true" data-parsley-maxlength="20"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Password * :</label>
                        <div class="col-md-3 col-sm-3">
                            <input type="password" name="password" minlength="5" maxlength="12" id="password" class="form-control m-b-5" data-parsley-required="true" data-parsley-maxlength="12" data-parsley-minlength="5" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Ketik Ulang Password * :</label>
                        <div class="col-md-3 col-sm-3">
                            <input type="password" name="password1" id="password-indicator-default" class="form-control m-b-5" data-parsley-required="true" data-parsley-maxlength="12" data-parsley-minlength="5"/>
                            <div id="passwordStrengthDiv" class="is0 m-t-5"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3"></label>
                        <div class="col-md-3 col-sm-3">
                            <button type="submit" class="btn btn-success btn-sm">Edit</button>
                            <button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
