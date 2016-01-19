<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="<?php echo base_url();?>" class="navbar-brand"><span class="navbar-logo"></span> SIMKUM</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div> 
        <div class="collapse navbar-collapse pull-left" id="top-navbar">
            <ul class="nav navbar-nav">
                <li class="dropdown" id="expired">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-users fa-fw"></i> Siswa Expired Hari Ini <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Tidak Ada Siswa Expired Hari Ini</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="dropdown" id="tagihan">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-money fa-fw"></i> Tagihan Hari Ini <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Tidak Ada Tagihan Hari Ini</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Selamat Datang </span>
                </a>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo base_url();?>foto/pegawai/<?php echo $this->session->userdata('foto');?>" style="width:18px;text-align:center;height:22px;" alt="<?php echo $this->session->userdata('nama');?>" /> 
                    <span class="hidden-xs"><?php echo $this->session->userdata('nama');?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="<?php echo base_url();?>profile">Profile</a></li>
                    <li class="divider"></li>
                    <li><a onclick="logout('<?php echo $this->session->userdata('nama') ;?>')" href="javascript:void(0)">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>