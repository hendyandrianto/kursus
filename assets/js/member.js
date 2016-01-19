$(document).ready(function() {
    TableManageResponsive.init();
    var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';  
    $('#data-table').dataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var temp = $('td:eq(0)', nRow).text();
            var temp = temp.split('|');
            var no = temp[0]+".";
            var kode = temp[1];
            var foto = $('td:eq(1)', nRow).text();
            var nama = $('td:eq(2)', nRow).text();
            var alamat = $('td:eq(3)', nRow).text();
            var tipe = $('td:eq(4)', nRow).text();
            var no_hp = $('td:eq(5)', nRow).text();
            var quota = $('td:eq(6)', nRow).text();
            var stts = $('td:eq(7)', nRow).text();
            var gambar = '<a class="fancybox" href="'+$BASE_URL+'foto/member/'+foto+'" style="width:80px;text-align:center;height:80px;" title="'+nama+'"><img src="'+$BASE_URL+'foto/member/'+foto+'" style="width:71px;" alt="" /></a>';
            var action = '<center><div class=\"btn-group m-r-5 m-b-5 btn-sm\"><a href=\"javascript:;\" class=\"btn btn-success btn-sm\">Action</a><a href=\"javascript:;\" data-toggle=\"dropdown\" class=\"btn btn-success btn-sm dropdown-toggle\"><span class=\"caret\"></span></a><ul class=\"dropdown-menu pull-right\"><li><a href=\"javascript:;\" title="Edit Data" onclick="edit('+"'"+kode+"'"+',\'Data Member\',\'member\',\'edit\')">Edit</a></li><li><a href=\"javascript:;\" onclick="hapus('+"'"+kode+"'"+',\'Data Member\',\'member\',\'hapus\')" title="Hapus Data">Hapus</a></li><li class=\"divider\"></li><li><a onclick="tampil_member('+"'"+kode+"'"+',\'Data Member\',\'member\',\'detil\')" href=\"javascript:;\" title="View Detil">View Detil</a></li></ul></div></center>';
            if(stts=="1"){
                var status = '<center><span class="label label-primary">Aktiv</span>';
            }else{
                var status = '<center><a href="javascript:void(0)" onclick="rbstatus(\'taktif\','+"'"+kode+"'"+',\'Data Member\',\'member\',\'ubah_status\')" data-toggle="tooltip" title="Status NonAktif"><span class="label label-danger">NonAktiv</span></a></center>';
            }
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(gambar);
            $('td:eq(2)', nRow).html(nama);
            $('td:eq(3)', nRow).html(alamat);
            $('td:eq(4)', nRow).html(no_hp);
            $('td:eq(5)', nRow).html(tipe);
            $('td:eq(6)', nRow).html(quota);
            $('td:eq(7)', nRow).html(status);
            $('td:eq(8)', nRow).html(action);
            $('td:eq(0),td:eq(1),td:eq(6)', nRow).css('text-align','center');
            $('td:eq(7)', nRow).css('text-align','right');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "5%" },
            { "sWidth": "15%" },
            { "sWidth": "20%" },
            { "sWidth": "10%" },
            { "sWidth": "5%" },
            { "sWidth": "5%" },
            { "sWidth": "5%" },
            { "sWidth": "20%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"member/get_data"
    });
});
function rbstatus (jns,id,page,link){
    if(jns=="aktif"){
        bootbox.confirm("Non aktifkan " +page+ " ini ?", function(result) {
            if (result) {
                $.blockUI({
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: 2, 
                        color: '#fff' 
                    },
                    message : 'Sedang Melakukan Pengecekan Data <br/> Mohon menunggu ... '
                });
                setTimeout(function(){
                    $.unblockUI();
                },1000);
                jQuery.post($BASE_URL+link+"/ubah_status/"+jns+"/"+id, jQuery("#form1").serialize(),
                function(data){
                    $.unblockUI();
                    window.location.href = $BASE_URL+link;
                });
            }
        });
    }else{
        bootbox.confirm("Aktifkan " +page+ " ini ?", function(result) {
            if (result) {
                $.blockUI({
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: 2, 
                        color: '#fff' 
                    },
                    message : 'Sedang Melakukan Pengecekan Data <br/> Mohon menunggu ... '
                });
                setTimeout(function(){
                    $.unblockUI();
                },1000);
                jQuery.post($BASE_URL+link+"/ubah_status/"+jns+"/"+id, jQuery("#form1").serialize(),
                function(data){
                    $.unblockUI();
                    window.location.href = $BASE_URL+link;
                });
            }
        });
    }
}