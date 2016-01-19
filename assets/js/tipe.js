$(document).ready(function() {
    TableManageResponsive.init();
    var host = window.location.host;
    $('.h_daftar').autoNumeric('init', {aSep: '.', aDec: ',',  mDec: '0'});
    $('.h_pokok').autoNumeric('init', {aSep: '.', aDec: ',',  mDec: '0'});
    $BASE_URL = 'http://'+host+'/';  
    $('#data-table').dataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var temp = $('td:eq(0)', nRow).text();
            var temp = temp.split('|');
            var no = temp[0]+".";
            var kode = temp[1];
            var jenis = $('td:eq(1)', nRow).text();
            var tipe = $('td:eq(2)', nRow).text();
            var h_daftar = $('td:eq(3)', nRow).text();
            var h_pokok = $('td:eq(4)', nRow).text();
            var durasi = $('td:eq(5)', nRow).text();
            var pertemuan = $('td:eq(6)', nRow).text();
            var ex = $('td:eq(7)', nRow).text();
            var action = '<center><a href="javascript:void(0)" onclick="hapus('+"'"+kode+"'"+',\'Data Tipe Kursus\',\'tipe\',\'hapus\')" data-toggle="tooltip" class="btn btn-danger btn-sm" title="Hapus Data"><i class="icon-remove icon-white"></i></a> '      +      ' <a href="javascript:void(0)" onclick="edit('+"'"+kode+"'"+',\'Data Tipe Kursus\',\'tipe\',\'edit\')" data-toggle="tooltip" class="btn btn-warning btn-sm" title="Edit Data"><i class="icon-pencil icon-white"></i></a></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(jenis);
            $('td:eq(2)', nRow).html(tipe);
            $('td:eq(3)', nRow).html('<span class="h_daftar">'+ h_daftar +'</span>');
            $('td:eq(4)', nRow).html('<span class="h_pokok">'+ h_pokok +'</span>');
            $('td:eq(5)', nRow).html(durasi+' hari');
            $('td:eq(6)', nRow).html(pertemuan+' Pertemuan');
            $('td:eq(7)', nRow).html(ex+' hari');
            $('td:eq(8)', nRow).html(action);
            $('td:eq(0)', nRow).css('text-align','center');
            $('td:eq(3),td:eq(4),td:eq(5),td:eq(6)', nRow).css('text-align','right');
            $('td:eq(3)', nRow).find('.h_daftar').autoNumeric('init', {aSep: '.', aDec: ',',  mDec: '0'});
            $('td:eq(4)', nRow).find('.h_pokok').autoNumeric('init', {aSep: '.', aDec: ',',  mDec: '0'});
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "20%" },
            { "sWidth": "50%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"tipe/get_data"
    });
});