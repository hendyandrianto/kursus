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
            var tipe = $('td:eq(2)', nRow).text();
            var no_ijazah = $('td:eq(3)', nRow).text();
            var nama = $('td:eq(4)', nRow).text();
            var pch = $('td:eq(5)', nRow).text();
            var pch = pch.split(' ');
            var tgl = pch[0];
            var pchtgl = tgl.split('-');
            var tglx = pchtgl[2]+"-"+pchtgl[1]+"-"+pchtgl[0];
            var wkt = pch[1];
            var tglna = tglx + " " + wkt;
            var gambar = '<a class="fancybox" href="'+$BASE_URL+'foto/member/'+foto+'" style="width:80px;text-align:center;height:80px;" title="'+nama+'"><img src="'+$BASE_URL+'foto/member/'+foto+'" style="width:71px;" alt="" /></a>';
            var action = '<center><div class=\"btn-group m-r-5 m-b-5 btn-sm\"><a href=\"javascript:;\" class=\"btn btn-success btn-sm\">Action</a><a href=\"javascript:;\" data-toggle=\"dropdown\" class=\"btn btn-success btn-sm dropdown-toggle\"><span class=\"caret\"></span></a><ul class=\"dropdown-menu pull-right\"><li><a href=\"javascript:;\" title="Ambil Ijazah" onclick="ambil('+"'"+kode+"'"+',\'Data Pengambilan Ijazah\',\'ambil\',\'ambil\')">Ambil</a></li></ul></div></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(gambar);
            $('td:eq(2)', nRow).html(tipe);
            $('td:eq(3)', nRow).html(no_ijazah);
            $('td:eq(4)', nRow).html(nama);
            $('td:eq(5)', nRow).html(tglna);
            $('td:eq(6)', nRow).html(action);
            $('td:eq(0),td:eq(5),td:eq(7)', nRow).css('text-align','center');
            $('td:eq(3)', nRow).css('text-align','right');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "5%" },
            { "sWidth": "15%" },
            { "sWidth": "15%" },
            { "sWidth": "30%" },
            { "sWidth": "10%" },
            { "sWidth": "15%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"ambil/get_data_belum"
    });
    $('#data-table1').dataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var temp = $('td:eq(0)', nRow).text();
            var temp = temp.split('|');
            var no = temp[0]+".";
            var kode = temp[1];
            var foto = $('td:eq(1)', nRow).text();
            var tipe = $('td:eq(2)', nRow).text();
            var no_ijazah = $('td:eq(3)', nRow).text();
            var nama = $('td:eq(4)', nRow).text();
            var pch = $('td:eq(5)', nRow).text();
            var pch = pch.split(' ');
            var tgl = pch[0];
            var pchtgl = tgl.split('-');
            var tglx = pchtgl[2]+"-"+pchtgl[1]+"-"+pchtgl[0];
            var wkt = pch[1];
            var tglna = tglx + " " + wkt;
            var gambar = '<a class="fancybox" href="'+$BASE_URL+'foto/member/'+foto+'" style="width:80px;text-align:center;height:80px;" title="'+nama+'"><img src="'+$BASE_URL+'foto/member/'+foto+'" style="width:71px;" alt="" /></a>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(gambar);
            $('td:eq(2)', nRow).html(tipe);
            $('td:eq(3)', nRow).html(no_ijazah);
            $('td:eq(4)', nRow).html(nama);
            $('td:eq(5)', nRow).html(tglna);
            $('td:eq(0),td:eq(5),td:eq(7)', nRow).css('text-align','center');
            $('td:eq(3)', nRow).css('text-align','right');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "5%" },
            { "sWidth": "15%" },
            { "sWidth": "15%" },
            { "sWidth": "30%" },
            { "sWidth": "10%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"ambil/get_data_sudah"
    });
});