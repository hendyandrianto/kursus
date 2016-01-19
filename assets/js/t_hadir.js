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
            var ket = $('td:eq(2)', nRow).text();
            var pch = $('td:eq(3)', nRow).text();
            var tgl = pch[0];
            var pchtgl = tgl.split('-');
            var tglx = pchtgl[2]+"-"+pchtgl[1]+"-"+pchtgl[0];
            var pchx = $('td:eq(4)', nRow).text();
            var tglx = pchx[0];
            var pchtglx = tglx.split('-');
            var tglxx = pchtglx[2]+"-"+pchtglx[1]+"-"+pchtglx[0];
            var action = '<center><a href="javascript:void(0)" onclick="hapus('+"'"+kode+"'"+',\'Data Ketidakhadiran\',\'t_hadir\',\'hapus\')" data-toggle="tooltip" class="btn btn-danger btn-sm" title="Hapus Data"><i class="icon-remove icon-white"></i></a> '      +      ' <a href="javascript:void(0)" onclick="edit('+"'"+kode+"'"+',\'Data Ketidakhadiran\',\'t_hadir\',\'edit\')" data-toggle="tooltip" class="btn btn-warning btn-sm" title="Edit Data"><i class="icon-pencil icon-white"></i></a></center>';
            $('td:eq(0)', nRow).html(no);
            $('td:eq(1)', nRow).html(nama);
            $('td:eq(2)', nRow).html(ket);
            $('td:eq(3)', nRow).html(pch);
            $('td:eq(4)', nRow).html(pchx);
            $('td:eq(5)', nRow).html(action);
            $('td:eq(0),td:eq(3),td:eq(4)', nRow).css('text-align','center');
        },
        "bAutoWidth": false,
        "aoColumns": [
            { "sWidth": "1%" },
            { "sWidth": "20%" },
            { "sWidth": "30%" },
            { "sWidth": "10%" },
            { "sWidth": "10%" },
            { "sWidth": "13%" }
        ],
        "bProcessing": false,
        "bServerSide": true,
        "responsive" : false,
        "sAjaxSource": $BASE_URL+"t_hadir/get_data"
    });
    var calendar = jQuery('#calendar').fullCalendar({
            editable: true,
        header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    events: $BASE_URL+"t_hadir/getdata/",
        eventRender: function(event, element, view) {
            if(event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
       }  
    });
});