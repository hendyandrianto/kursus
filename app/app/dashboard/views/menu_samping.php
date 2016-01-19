<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <div class="image1" style="text-align:center">
                    <a class="fancybox" href="<?php echo base_url();?>foto/pegawai/<?php echo $this->session->userdata('foto');?>" style="width:80px;text-align:center;height:102px;" data-fancybox-group="gallery" title="<?php echo $this->session->userdata('nama');?>"><img src="<?php echo base_url();?>foto/pegawai/<?php echo $this->session->userdata('foto');?>" style="width:71px;" alt="" /></a>
                </div>
                <div class="info" style="text-align:center">
                    <?php echo $this->session->userdata('nama');?>
                    <small>IP : <?php echo $ip=$_SERVER['REMOTE_ADDR'];?></small>
                </div>
            </li>
        </ul>
        <ul class="nav">
            <li class="nav-header"><div style="text-align:center"><span id="date_time"><script type="text/javascript">window.onload = date_time('date_time');</script></span></div></li>
            <li <?php if($link=="dashboard"){echo "class=\"active\"";}?>><a href="<?php echo base_url();?>dashboard"><i class="fa fa-laptop"></i> <span>Dashboard</span></a></li>
            <?php 
            if($this->session->userdata('level')=='0'){
                $out = "";
                $menu = $this->db->query("SELECT * FROM tbl_menu WHERE status = '1' ORDER BY urutan")->result();
                $pmen = array();
                $pmenus = array();
                $smen = array();
                $smenus = array();
                $menusba = array();
                $menusbb = array();
                $menusbax = array();
                $menusbbx = array();
                foreach ($menu as $key) {
                    $pmen = array('nama_menu'=>$key->nama_menu,'link'=>$key->link,'icon'=>$key->icon,'menu_id'=>$key->menu_id,'kelas'=>$key->kelas);
                    array_push($pmenus, $pmen);
                } 
                $menusub = $this->db->query("SELECT * FROM tbl_submenu WHERE sstatus='1' ORDER BY urut")->result();
                foreach ($menusub as $key ) {           
                    $menusba = array('nama_smenu'=>$key->nama_smenu,'sicon'=>$key->sicon,'anak'=>$key->anak,'parent'=>$key->parent,'smenu_id'=>$key->smenu_id,'link'=>$key->slink);
                    array_push($menusbb, $menusba);
                }
                $menusubx = $this->db->query("SELECT * FROM tbl_submenux WHERE sstatusx='1' ORDER BY urut ASC")->result();
                foreach ($menusubx as $key ) {           
                    $menusbax = array('nama_smenux'=>$key->nama_smenux,'parentx'=>$key->parentx,'linkx'=>$key->slinkx);
                    array_push($menusbbx, $menusbax);
                }
                for ($i=0; $i < count($pmenus) ; $i++) { 
                    if ( is_array ( $pmenus [ $i ] ) ) {
                        if($kelas==$pmenus[$i]['kelas']){
                            $kls = 'class="has-sub active"';
                            $kk = 'class="sub-menu"';
                            $kx = 'class="caret pull-right"';
                        }else{
                            $kls = 'class="has-sub"';
                            $kk = 'class="sub-menu"';
                            $kx = 'class="caret pull-right"';
                        }
                        $out .=  "<li " . $kls . "><a href='javascript:;'><b ".$kx."></b><i class='".$pmenus[$i]['icon'] ."'></i><span>" . $pmenus[$i]['nama_menu'] . "</span></a>" . "\n";  
                        $out .= "<ul " . $kk .  " >" ."\n";
                        for ($x=0; $x < count($menusbb); $x++) {   
                            if($pmenus[$i]['menu_id']==$menusbb[$x]['parent']){
                                if($namamenu==$menusbb[$x]['nama_smenu']){
                                    $klsx = 'class="has-sub active"';
                                }else{
                                    $klsx = 'class="has-sub"';
                                }
                                if($menusbb[$x]['anak']=='1'){
                                    $kx = 'class="caret pull-right"';
                                    $hehe = "href='javascript:;'";
                                    $kk = 'class="sub-menu"';
                                }else{
                                    $kx = '';
                                    $kk = '';
                                    $hehe = "href='" . base_url() . $menusbb[$x]['link'] ."'";
                                }
                                $out .= "<li " . $klsx . "><a ".$hehe."><b ".$kx."></b><i class='".$menusbb[$x]['sicon'] ."'></i><span> " . $menusbb[$x]['nama_smenu'] . "</span></a>" . "\n";  
                                $out .= "<ul " . $kk .  " >" ."\n";
                                for ($xx=0; $xx < count($menusbbx); $xx++) { 
                                    if($menusbbx[$xx]['parentx']==$menusbb[$x]['smenu_id']){
                                        $kk = 'class="sub-menu"';
                                        $kx = '';
                                        $out .= "<li ".$kls." ><a href='" . base_url() . $menusbbx[$xx]['linkx'] ."'><b ".$kx."></b>" . $menusbbx[$xx]['nama_smenux'] . "</a></li>" ."\n";
                                    }
                                }
                                $out .= '</ul>'."\n";
                                $out .= '</li>' . "\n";
                            }
                        }
                        $out .= '</ul>'."\n";
                    }
                    $out .= '</li>' . "\n";
                }
                echo $out;
            }else{
                $pmen = array();
                $pmenus = array();
                $smen = array();
                $smenus = array();
                $menusba = array();
                $menusbb = array();
                $menusbbx = array();
                $menusbax = array();
                $this->db->order_by('urutan','ASC');
                $menu = $this->db->get_where('tbl_menu',array('status'=>"1"))->result();
                foreach ($menu as $key) {
                    $pmen = array('nama_menu'=>$key->nama_menu,'link'=>$key->link,'icon'=>$key->icon,'menu_id'=>$key->menu_id,'kelas'=>$key->kelas);
                    array_push($pmenus, $pmen);
                }   
                $smenu = $this->db->get_where('tbl_usermenu',array('kode'=>$this->session->userdata('kode')))->result();  
                foreach ($smenu as $keys ) {
                    $mnid = $keys->menu;
                    $mnidx = $keys->menux;
                }
                $mnids = explode("|",$mnid);
                $mnidsx = explode("|",$mnidx);
                for ($i=0; $i < count($mnids)-1; $i++) { 
                    $this->db->order_by('urut','ASC');
                    $menusub = $this->db->get_where('tbl_submenu',array('smenu_id'=>$mnids[$i],'sstatus'=>'1'))->result();
                    foreach ($menusub as $key ) {           
                        $menusba = array('nama_smenu'=>$key->nama_smenu,'anak'=>$key->anak,'sicon'=>$key->sicon,'parent'=>$key->parent,'link'=>$key->slink,'smenu_id'=>$key->smenu_id);
                        array_push($menusbb, $menusba);
                    }
                }
                for ($ii=0; $ii < count($mnidsx)-1; $ii++) { 
                    $this->db->order_by('urut','ASC');
                    $menusubx = $this->db->get_where('tbl_submenux',array('smenu_id'=>$mnidsx[$ii],'sstatusx'=>'1'))->result();
                    if(count($menusubx)>0){
                        foreach ($menusubx as $key ) {           
                            $menusbax = array('nama_smenux'=>$key->nama_smenux,'siconx'=>$key->siconx,'parentx'=>$key->parentx,'linkx'=>$key->slinkx,'smenu_idx'=>$key->smenu_id);
                            array_push($menusbbx, $menusbax);
                        }
                    }
                }
                create_menu($pmenus,$menusbb,$menusbbx,$kelas,$namamenu);
            }
            function create_menu($pmenus,$menusbb,$menusbbx,$kelas,$namamenu){
                $out = "";
                for ($i=0; $i < count($pmenus) ; $i++) { 
                    if ( is_array ( $pmenus [ $i ] ) ) {
                        if($kelas==$pmenus[$i]['kelas']){
                            $kls = 'class="has-sub active"';
                            $kk = 'class="sub-menu"';
                            $kx = 'class="caret pull-right"';
                            // $klsx = 'class="has-sub"';
                        }else{
                            $kls = 'class="has-sub"';
                            $kk = 'class="sub-menu"';
                            $kx = 'class="caret pull-right"';
                            // $klsx = 'class="has-sub active"';
                        }
                        for ($xix=0; $xix < count($menusbb); $xix++) {   
                            if($pmenus[$i]['menu_id']==$menusbb[$xix]['parent']){
                                $out .=  "<li " . $kls . "><a href='javascript:;'><b ".$kx."></b><i class='".$pmenus[$i]['icon'] ."'></i><span>" . $pmenus[$i]['nama_menu'] . "</span></a>" . "\n";  
                                $out .= "<ul " . $kk .  " >" ."\n";
                                break;
                            }
                        }
                        for ($x=0; $x < count($menusbb); $x++) {   
                            if($pmenus[$i]['menu_id']==$menusbb[$x]['parent']){
                                if($namamenu==$menusbb[$x]['nama_smenu']){
                                    $klsx = 'class="has-sub active"';
                                }else{
                                    $klsx = 'class="has-sub"';
                                }
                                if($menusbb[$x]['anak']=='1'){
                                    $kx = 'class="caret pull-right"';
                                    $hehe = "href='javascript:;'";
                                    $kk = 'class="sub-menu"';
                                }else{
                                    $kx = '';
                                    $kk = '';
                                    $hehe = "href='" . base_url() . $menusbb[$x]['link'] ."'";
                                }
                                for ($xx=0; $xx < count($menusbb); $xx++) {   
                                    $out .= "<li " . $klsx . "><a ".$hehe."><b ".$kx."></b><i class='".$menusbb[$x]['sicon'] ."'></i><span> " . $menusbb[$x]['nama_smenu'] . "</span></a>" . "\n";  
                                    $out .= "<ul " . $kk .  " >" ."\n";
                                    break;
                                }
                                // for ($xx=0; $xx < count($menusbbx); $xx++) {   
                                //     $out .= "<li " . $klsx . "><a ".$hehe."><b ".$kx."></b><i class='".$menusbb[$x]['sicon'] ."'></i><span> " . $menusbb[$x]['nama_smenu'] . "</span></a>" . "\n";  
                                //     $out .= "<ul " . $kk .  " >" ."\n";
                                //     break;
                                // }
                                for ($xx=0; $xx < count($menusbbx); $xx++) {   
                                    if($menusbbx[$xx]['parentx']==$menusbb[$x]['smenu_id']){
                                        $out .= "<li>"."\n";
                                        break;
                                    }
                                }
                                for ($xx=0; $xx < count($menusbbx); $xx++) {   
                                    if($menusbb[$x]['smenu_id']==$menusbbx[$xx]['parentx']){
                                        $kx = '';
                                        $out .= "<a href='" . base_url() . $menusbbx[$xx]['linkx'] ."'><b ".$kx."></b>" . $menusbbx[$xx]['nama_smenux'] . "</a>" ."\n";
                                    }
                                }
                                for ($xx=0; $xx < count($menusbbx); $xx++) {   
                                    if($menusbbx[$xx]['parentx']==$menusbb[$x]['smenu_id']){
                                        $out .= "</li>"."\n";
                                        break;
                                    }
                                }
                                // for ($xx=0; $xx < count($menusbbx); $xx++) {   
                                //     $out .= '</ul>'."\n";
                                //     $out .= '</li>' . "\n";
                                //     break;
                                // }
                                for ($xx=0; $xx < count($menusbb); $xx++) {   
                                    $out .= '</ul>'."\n";
                                    $out .= '</li>' . "\n";
                                    break;
                                }
                            }
                        }
                        for ($x=0; $x < count($menusbb); $x++) {   
                            if($pmenus[$i]['menu_id']==$menusbb[$x]['parent']){
                                $out .= '</ul>'."\n";
                                $out .= '</li>' . "\n";
                                break;
                            }
                        }
                    }
                }
                echo $out;
            }
            ?>
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
        </ul>
    </div>
</div>