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
            var plat = $('td:eq(2)', nRow).text();
            var nama = $('td:eq(3)', nRow).text();
            var gambar = '<a class="fancybox" href="'+$BASE_URL+'foto/mobil/'+foto+'" style="width:80px;text-align:center;height:80px;" title="'+nama+'"><img src="'+$BASE_URL+'foto/mobil/'+foto+'" style="width:71px;" alt="" /></a>';
            var action = '<center><a href="javascript:void(0)" onclick="hapus('+"'"+kode+"'"+',\'Data Kendaraan\',\'kendaraan\',\'hapus\')" data-toggle="tooltip" class="btn btn-danger btn-sm" title="Hapus Data"><i class="icon-remove icon-white"></i></a> '      +      ' <a href="javascript:void(0)" onclick="edit('+"'"+kode+"'"+',\'Data kendaraan\',\'kendaraan\',\'edit\')" data-toggle="tooltip" class="btn btn-warning btn-sm" title="Edit Data"><i class="icon-pencil icon-white"></i></a></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(gambar);
            $('td:eq(2)', nRow).html(plat);
            $('td:eq(3)', nRow).html(nama);
            $('td:eq(4)', nRow).html(action);
            $('td:eq(0),td:eq(2)', nRow).css('text-align','center');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "60%" },
            { "sWidth": "13%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"kendaraan/get_data"
    });
});