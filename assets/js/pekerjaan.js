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
            var action = '<center><a href="javascript:void(0)" onclick="hapus('+"'"+kode+"'"+',\'Data Pekerjaan\',\'pekerjaan\',\'hapus\')" data-toggle="tooltip" class="btn btn-danger btn-sm" title="Hapus Data"><i class="icon-remove icon-white"></i></a> '      +      ' <a href="javascript:void(0)" onclick="edit('+"'"+kode+"'"+',\'Data Pekerjaan\',\'pekerjaan\',\'edit\')" data-toggle="tooltip" class="btn btn-warning btn-sm" title="Edit Data"><i class="icon-pencil icon-white"></i></a></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(nama);
            $('td:eq(2)', nRow).html(action);
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
        "sAjaxSource": $BASE_URL+"pekerjaan/get_data"
    });
});