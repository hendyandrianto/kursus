<script src="<?php echo base_url();?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url();?>assets/js/table-manage-responsive.demo.min.js"></script>
<script>
$(document).ready(function() {
    TableManageResponsive.init();
});
</script>
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
                <div data-scrollbar="true" data-height="360px">
                    <?php
                    // $menu = $this->db->get("tbl_menu_pro")->result();
                    $ii = "0";
                    $menu = $this->db->query("SELECT * FROM tbl_menu_pro ORDER BY urutan ASC")->result();
                    foreach ($menu as $key) {
                        $ii++;
                        $mid = $key->menu_id;
                        $sat = $key->status;
                        if($sat=='0'){
                            $satmenu = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahmenu('noaktiv','" . $mid . "','Data Menu','set_menu')\" class=\"label label-danger\">NoAktiv</span>";
                        }else{
                            $satmenu = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahmenu('aktiv','" . $mid . "','Data Menu','set_menu')\" class=\"label label-success\">Aktiv</span>";
                        }
                        echo "<strong>" . $ii . "." . "&nbsp;" . $key->nama_menu . "</strong>" . $satmenu . "<br/>";
                        $sub = $this->db->query("SELECT * FROM tbl_submenu_pro WHERE parent = '$mid' ORDER BY smenu_id")->result();
                        // $sub = $this->db->get_where("tbl_submenu_pro",array('parent'=>$mid))->result();
                        if(count($sub)>0){
                            ?>
                            <ul>
                            <?php
                            foreach ($sub as $row) {
                                $midx = $row->smenu_id;
                                $ank = $row->anak;
                                $satsub = $row->sstatus;
                                if($satsub=='0'){
                                    $satmenux = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenu('noaktiv','" . $midx . "','Data SubMenu','set_menu')\" class=\"label label-danger\">NoAktiv</span>";
                                }else{
                                    $satmenux = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenu('aktiv','" . $midx . "','Data SubMenu','set_menu')\" class=\"label label-success\">Aktiv</span>";
                                }
                                $level = $row->level;
                                if($level=='0'){
                                    $levelx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahlevel('noaktiv','" . $row->smenu_id . "','Data SubMenu','set_menu')\" class=\"label label-danger\">Admin</span>";
                                }else{
                                    $levelx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahlevel('aktiv','" . $row->smenu_id . "','Data SubMenu','set_menu')\"   class=\"label label-success\">Publik</span>";
                                }
                                ?>
                                    <li><?php echo $row->nama_smenu . $satmenux . $levelx;?></li>
                                <?php
                                if($ank=="1"){
                                    // $subx = $this->db->get_where("tbl_submenux_pro",array("parentx"=>$midx))->result();
                                    $subx = $this->db->query("SELECT * FROM tbl_submenux_pro WHERE parentx = '$midx' ORDER BY urut ASC")->result();
                                    if(count($subx)>0){
                                        ?>
                                        <ul>
                                        <?php
                                        foreach ($subx as $rows) {
                                            $satsubx = $rows->sstatusx;
                                            if($satsubx=='0'){
                                                $satmenuxx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenux('noaktiv','" . $rows->smenu_id . "','Data SubMenu','set_menu')\" class=\"label label-danger\">NoAktiv</span>";
                                            }else{
                                                $satmenuxx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenux('aktiv','" . $rows->smenu_id . "','Data SubMenu','set_menu')\"   class=\"label label-success\">Aktiv</span>";
                                            }
                                            $levelxxx = $rows->levelx;
                                            if($levelxxx=='0'){
                                                $lvlx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenux('noaktiv','" . $rows->smenu_id . "','Data SubMenu','set_menu')\" class=\"label label-danger\">Admin</span>";
                                            }else{
                                                $lvlx = "&nbsp;&nbsp;&nbsp;<span href=\"javascript:void()\" onclick=\"ubahsubmenux('aktiv','" . $rows->smenu_id . "','Data SubMenu','set_menu')\"   class=\"label label-success\">Publik</span>";
                                            }
                                            ?>
                                            <li><?php echo $rows->nama_smenux . $satmenuxx . $lvlx;?></li>
                                            <?php
                                        }
                                        ?>
                                        </ul>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </ul>
                            <?php
                        }
                    }
                    ?>
                </div>                                  
            </div>
        </div>
    </div>
</div>