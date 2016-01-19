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
            var nama = $('td:eq(1)', nRow).text();
            var action = '<center><div class=\"btn-group m-r-5 m-b-5 btn-sm\"><a href=\"javascript:;\" class=\"btn btn-success btn-sm\">Action</a><a href=\"javascript:;\" data-toggle=\"dropdown\" class=\"btn btn-success btn-sm dropdown-toggle\"><span class=\"caret\"></span></a><ul class=\"dropdown-menu pull-right\"><li><a href=\"javascript:;\" title="Edit Data" onclick="edit('+"'"+kode+"'"+',\'Data Pengiriman\',\'kirim\',\'edit\')">Edit</a></li><li><a href=\"javascript:;\" onclick="hapus('+"'"+kode+"'"+',\'Data Pengiriman\',\'kirim\',\'hapus\')" title="Hapus Data">Hapus</a></li><li class=\"divider\"></li><li><a onclick="tampil('+"'"+kode+"'"+',\'Data Pengiriman\',\'kirim\',\'detil\')" href=\"javascript:;\" title="View Detil">View Detil</a></li></ul></div></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(nama);
            $('td:eq(0),td:eq(2)', nRow).css('text-align','center');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "80%" },
            { "sWidth": "13%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"jenis/get_data"
    });
});