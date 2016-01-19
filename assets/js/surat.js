$(document).ready(function() {
    TableManageResponsive.init();
    var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';  
    $('#data-table1').dataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var temp = $('td:eq(0)', nRow).text();
            var temp = temp.split('|');
            var no = temp[0]+".";
            var kode = temp[1];
            var tglna = $('td:eq(1)', nRow).text();
            var pch = tglna.split(' ');
            var waktos = pch[0];
            var pecah = waktos.split('-');
            var tgl = pecah[2]+"-"+pecah[1]+"-"+pecah[0]+" "+pch[1];
            var nosurat = $('td:eq(2)', nRow).text();
            var faktur = $('td:eq(3)', nRow).text();
            var nopol = $('td:eq(4)', nRow).text();
            var supir = $('td:eq(5)', nRow).text();
            var action = '<center><div class=\"btn-group m-r-5 m-b-5 btn-sm\"><a href=\"javascript:;\" class=\"btn btn-success btn-sm\">Action</a><a href=\"javascript:;\" data-toggle=\"dropdown\" class=\"btn btn-success btn-sm dropdown-toggle\"><span class=\"caret\"></span></a><ul class=\"dropdown-menu pull-right\"><li><a href=\"javascript:;\" title="Edit Data" onclick="edit('+"'"+kode+"'"+',\'Data Surat Jalan\',\'surat\',\'edit\')">Edit</a></li><li><a href=\"javascript:;\" onclick="hapus('+"'"+kode+"'"+',\'Data Surat Jalan\',\'surat\',\'hapus\')" title="Hapus Data">Hapus</a></li><li class=\"divider\"></li><li><a onclick="tampilkan('+"'"+kode+"'"+',\'surat\',\'Data Surat Jalan\',\'detil\')" href=\"javascript:;\" title="View Detil">View Detil</a></li><li><a onclick="cetak('+"'"+kode+"'"+',\'Data Surat Jalan\',\'surat\',\'cetak\')" href=\"javascript:;\" title="Cetak Surat Jalan">Cetak</a></li></ul></div></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(tgl);
            $('td:eq(2)', nRow).html(nosurat);
            $('td:eq(3)', nRow).html(faktur);
            $('td:eq(4)', nRow).html(nopol);
            $('td:eq(5)', nRow).html(supir);
            $('td:eq(6)', nRow).html(action);
            $('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4)', nRow).css('text-align','center');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "12%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "35%" },
            { "sWidth": "13%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"surat/get_data"
    });
});