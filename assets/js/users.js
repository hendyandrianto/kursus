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
            var uname = $('td:eq(3)', nRow).text();
            var gambar = '<a class="fancybox" href="'+$BASE_URL+'foto/pegawai/'+foto+'" style="width:80px;text-align:center;height:80px;" title="'+nama+'"><img src="'+$BASE_URL+'foto/pegawai/'+foto+'" style="width:71px;" alt="" /></a>';
            var action = '<center><a href="javascript:void(0)" onclick="hapus('+"'"+kode+"'"+',\'Data Pengguna\',\'users\',\'hapus\')" data-toggle="tooltip" class="btn btn-danger btn-sm" title="Hapus Data"><i class="icon-remove icon-white"></i></a> '      +      ' <a href="javascript:void(0)" onclick="edit('+"'"+kode+"'"+',\'Data Pengguna\',\'users\',\'edit\')" data-toggle="tooltip" class="btn btn-warning btn-sm" title="Edit Data"><i class="icon-pencil icon-white"></i></a></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(gambar);
            $('td:eq(2)', nRow).html(nama);
            $('td:eq(3)', nRow).html(uname);
            $('td:eq(4)', nRow).html(action);
            $('td:eq(0),td:eq(1)', nRow).css('text-align','center');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "10%" },
            { "sWidth": "50%" },
            { "sWidth": "15%" },
            { "sWidth": "10%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"users/get_data"
    });
});