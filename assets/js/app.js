var host = window.location.host;
$BASE_URL = 'http://'+host+'/';  
jQuery(document).ready(function(){
    jQuery("#tombol").hide();
    jQuery("#hakakses").hide();
    jQuery("#produsen_user").change(function(){
        var produsen = jQuery("#produsen_user").val();
        if(produsen!=""){
            jQuery("#hakakses").show('slow');
            $.gritter.add({title:"Informasi !",text: " Anda Membuat Pengguna Dengan Level Produsen !"});return false;
        }else{
            jQuery("#hakakses").hide('slow');
            $.gritter.add({title:"Informasi !",text: " Anda Membuat Pengguna Dengan Level Administrator !"});return false;
        }
    });
    jQuery("#detil_kirim").hide();
    jQuery("#tambahkirim").click(function(){
        var no = jQuery("#tbladdkirim tr").length;
        var jns = jQuery("#pupuk").val();
        var jml = jQuery("#jml").val();
        var ket = jQuery("#ket").val();
        if(jns!="" && jml!=""){ 
            if(isNumber(jml)==false){
                isValid = false;
                $.gritter.add({title:"Informasi Penginputan !",text: "Jumlah Hanya Karakter Angka !"});return false;
            }else{
                jQuery('#tbladdkirim > tbody:first').append("<tr id='"+no+"''><td><input style=\'width:315px\' class='form-control' type='text' readonly='readonly' value='"+ jns + "' name='jnsna[]' /></td><td><input style='width:90px' readonly='readonly' class='form-control' type='text' value='"+ jml + "' name='jmlna[]'/></td><td><input type='text' value='"+ ket + "' name='ketna[]' readonly='readonly' class='form-control' style='width:250px'/></td><td><button id='delRow' style=\"text-align:center\" class=\"btn btn-primary btn-xs m-r-5\" onclick=\"delrow('"+no+"');return false;\"><i class=\"fa fa-remove\"></i></button></td></tr>"); 
                jQuery("#tombol").show("slow");
                jQuery("#jml").val('');
                jQuery("#ket").val('');
                jQuery("#detil_kirim").show('slow');
            }
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Tidak Boleh Kosong !<br/>Jns. Pupuk Tidak Boleh Kosong ! <br/>Jumlah Pengiriman Tidak Boleh Kosong !"});return false;
        }
    });
    jQuery("#simpan_kirim").click(function(){
        jQuery.blockUI({
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        },
          message : 'Sedang Melakukan Penyimpanan Data, Mohon menunggu ... '
        });
        jQuery.post($BASE_URL+"kirim/proses_add", jQuery("#form").serialize(),
        function(data){
            jQuery.unblockUI();
            window.location.href = $BASE_URL+'kirim';
        });
        return true;
    });
})
function cek_expired(){
      var
      $http,
      $self = arguments.callee;
      if (window.XMLHttpRequest) {
          $http = new XMLHttpRequest();
      }else if (window.ActiveXObject) {
          try {
              $http = new ActiveXObject('Msxml2.XMLHTTP');
          } catch(e) {
              $http = new ActiveXObject('Microsoft.XMLHTTP');
          }
      }
      if($http) {
          $http.onreadystatechange = function(){
              if (/4|^complete$/.test($http.readyState)) {
                  document.getElementById('expired').innerHTML = $http.responseText;
                  setTimeout(function(){$self();}, 50000);
              }
          };
          $http.open('GET', $BASE_URL+'dashboard/cek_expired' + '/' + new Date().getTime(), true);
          $http.send(null);
      }
      else{
          document.getElementById('expired').innerHTML = $http.responseText;
      }
}
function cek_tagihan(){
      var
      $http,
      $self = arguments.callee;
      if (window.XMLHttpRequest) {
          $http = new XMLHttpRequest();
      }else if (window.ActiveXObject) {
          try {
              $http = new ActiveXObject('Msxml2.XMLHTTP');
          } catch(e) {
              $http = new ActiveXObject('Microsoft.XMLHTTP');
          }
      }
      if($http) {
          $http.onreadystatechange = function(){
              if (/4|^complete$/.test($http.readyState)) {
                  document.getElementById('tagihan').innerHTML = $http.responseText;
                  setTimeout(function(){$self();}, 50000);
              }
          };
          $http.open('GET', $BASE_URL+'dashboard/cek_tagihan' + '/' + new Date().getTime(), true);
          $http.send(null);
      }
      else{
          document.getElementById('tagihan').innerHTML = $http.responseText;
      }
}
function tampil(kode){
    jQuery.blockUI({
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        },
        message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
    });
    jQuery.ajax({
        url : $BASE_URL+"kirim/caridetil/"+kode,
        type : 'POST',
        data : kode,
        success: function(msg){ 
            jQuery("#detilna").show('slow');    
            jQuery("#detilna").html(msg);    
            jQuery.unblockUI();                   
        }
    });
}

function tampil_member(kode){
    jQuery.blockUI({
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        },
        message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
    });
    jQuery.ajax({
        url : $BASE_URL+"member/caridetil/"+kode,
        type : 'POST',
        data : kode,
        success: function(msg){ 
            jQuery("#detilna").show('slow');    
            jQuery("#detilna").html(msg);    
            jQuery.unblockUI();                   
        }
    });
}
function tampilkan(kode,link){
    jQuery.blockUI({
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        },
        message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
    });
    jQuery.ajax({
        url : $BASE_URL+link+"/caridetil/"+kode,
        type : 'POST',
        data : kode,
        success: function(msg){ 
            jQuery("#detilna").show('slow');    
            jQuery("#detilna").html(msg);    
            jQuery.unblockUI();                   
        }
    });
}
function tampil_pending(kode){
    jQuery.blockUI({
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.5, 
            color: '#fff' 
        },
        message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
    });
    jQuery.ajax({
        url : $BASE_URL+"kirim/caridetil/"+kode,
        type : 'POST',
        data : kode,
        success: function(msg){ 
            jQuery("#detilna_pending").show('slow');    
            jQuery("#detilna_pending").html(msg);    
            jQuery.unblockUI();                   
        }
    });
}
function nyumput () {
    jQuery("#detilna").hide('slow');
    jQuery("#detilna_pending").hide('slow');
}
function delrow(id){
  jQuery("#"+id).remove();
}
function date_time(id){
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
    months = new Array('Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    d = date.getDate();
    day = date.getDay();
    days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    h = date.getHours();
    if(h<10){
        h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10){
        m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10){
        s = "0"+s;
    }
    result = ''+days[day]+', '+d+'-'+months[month]+'-'+year+' '+h+':'+m+':'+s;
    document.getElementById(id).innerHTML = result;
    setTimeout('date_time("'+id+'");','1000');
    return true;
}
function waktos(id){
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
    months = new Array('Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    d = date.getDate();
    day = date.getDay();
    days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    h = date.getHours();
    if(h<10){
        h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10){
        m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10){
        s = "0"+s;
    }
    result = ' '+h+':'+m+':'+s;
    document.getElementById(id).innerHTML = result;
    setTimeout('waktos("'+id+'");','1000');
    return true;
}
function kaping(id){
    date = new Date;
    year = date.getFullYear();
    month = date.getMonth();
    months = new Array('Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    d = date.getDate();
    day = date.getDay();
    days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    h = date.getHours();
    if(h<10){
        h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10){
        m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10){
        s = "0"+s;
    }
    result = ''+days[day]+', '+d+'-'+months[month]+'-'+year+'';
    document.getElementById(id).innerHTML = result;
    setTimeout('kaping("'+id+'");','1000');
    return true;
}
function hapus(id,page,link,action){
	bootbox.confirm("Yakin Akan Menghapus " +page+ " Berikut ?", function(result) {
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
			$.ajax({
				url : $BASE_URL+link+'/'+action+'/'+id,
				dataType : 'json',
				type : 'post',
				success : function(json) {
					$.unblockUI();
					if(json.say == "ok") {
						window.location.href = $BASE_URL+link;
					}else{
						$.gritter.add({title:"Informasi Penghapusan !",text: page+ " ini tidak bisa dihapus,terkait dengan database lain !"});return false;
					}
				}
			});				
			
		}
	});
}
function cetak(id,page,link,action){
    bootbox.confirm("Yakin Akan Mencetak " +page+ " Berikut ?", function(result) {
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
            $.ajax({
                url : $BASE_URL+link+'/'+action+'/'+id,
                dataType : 'json',
                type : 'post',
                success : function(json) {
                    $.unblockUI();
                    if(json.say == "ok") {
                        window.location.href = $BASE_URL+link+"/cetak_data/"+id;
                    }else if(json.say=="NotOk"){
                        $.gritter.add({title:"Informasi Pencetakan !",text: page+ " ini tidak bisa dicetak,karena sudah dicetak sebelumnya !"});return false;
                    }else{
                        $.gritter.add({title:"Informasi Pencetakan !",text: " Anda tidak ada akses untuk mencetak "+page+" ini !"});return false;
                    }
                }
            });             
            
        }
    });
}
function cetak_siswa (link) {
    if(jQuery('#menjahit').is(':checked')) {
        window.location.href = $BASE_URL+"lap_siswa"+"/"+"cetak_menjahit";
    }else{
        window.location.href = $BASE_URL+"lap_siswa"+"/"+"cetak_mengemudi";
    }
}
function cetak_laporan (link) {
    if(jQuery('#pertgl').is(':checked')) {
        var tgl = jQuery("#mulaip").val();
        var tipe_tgl = jQuery("#tipe_pertgl").val();
        if(tgl!="" && tipe_tgl!=""){
            jQuery.blockUI({
                css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: 0.5, 
                    color: '#fff' 
                },
                message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
            });
            setTimeout(function(){
                $.unblockUI();
            },1000);
            $.ajax({
                url : $BASE_URL+link+'/cekdata/'+tgl,
                dataType : 'json',
                type : 'post',
                success : function(json) {
                    $.unblockUI();
                    window.location.href = $BASE_URL+link+'/pertanggal/'+tgl+"/"+tipe_tgl;
                }
            });             
        }else{
            $.gritter.add({title:"Informasi Pencetakan !",text: " Pastikan Tanggal Sudah Terisi !"});return false;
        }
    }else{
        var tipe_perperiode = jQuery("#tipe_perperiode").val();
        var mulai = jQuery("#tgl_mulai").val();
        var selesai = jQuery("#tgl_akhir").val();
        if(mulai!="" && selesai!="" && tipe_perperiode!=""){
            jQuery.blockUI({
                css: { 
                    border: 'none', 
                    padding: '15px', 
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: 0.5, 
                    color: '#fff' 
                },
                message : 'Sedang Melakukan Pengecekan Data, Mohon menunggu ... '
            });
            setTimeout(function(){
                $.unblockUI();
            },1000);
            $.ajax({
                url : $BASE_URL+link+'/cek_data/'+mulai+"/"+selesai,
                dataType : 'json',
                type : 'post',
                success : function(json) {
                    $.unblockUI();
                    window.location.href = $BASE_URL+link+'/perperiode/'+mulai+"/"+selesai+"/"+tipe_perperiode;
                }
            });             
        }else{
            $.gritter.add({title:"Informasi Pencetakan !",text: " Pastikan Tanggal Sudah Terisi !"});return false;
        }
    }
}
function ambil(id,page,link){
    bootbox.confirm("Yakin Akan Mengambil Ijazah Berikut ?", function(result) {
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
            $.ajax({
                url : $BASE_URL+link+'/cekdata/'+id,
                dataType : 'json',
                type : 'post',
                success : function(json) {
                    $.unblockUI();
                    if (json.say == "ok") {
                        window.location.href = $BASE_URL+link+'/ambil_ijazah/'+id;
                    }else{
                        $.gritter.add({title:"Informasi Pengambilan !",text: " Ijazah ini tidak ditemukan di database !"});return false;
                    }
                }
            });             
            
        }
    });
}
function edit(id,page,link){
	bootbox.confirm("Yakin Akan Mengedit " +page+ " Berikut ?", function(result) {
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
			$.ajax({
				url : $BASE_URL+link+'/cekdata/'+id,
				dataType : 'json',
				type : 'post',
				success : function(json) {
					$.unblockUI();
					if (json.say == "ok") {
						window.location.href = $BASE_URL+link+'/edit/'+id;
					}else{
						$.gritter.add({title:"Informasi Pengeditan !",text: page+ " ini tidak ditemukan di database !"});return false;
					}
				}
			});				
			
		}
	});
}
function detil(id,page,link){
    bootbox.confirm("Yakin Akan Mengedit " +page+ " Berikut ?", function(result) {
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
            $.ajax({
                url : $BASE_URL+link+'/cekdata/'+id,
                dataType : 'json',
                type : 'post',
                success : function(json) {
                    $.unblockUI();
                    if (json.say == "ok") {
                        window.location.href = $BASE_URL+link+'/detil/'+id;
                    }else{
                        $.gritter.add({title:"Informasi Data !",text: page+ " ini tidak ditemukan di database !"});return false;
                    }
                }
            });             
            
        }
    });
}

function logout(nama){
	bootbox.confirm(nama+" apakah yakin akan keluar ?", function(result) {
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
	            message : 'Sedang Melakukan Proses Log Out, Mohon menunggu ... '
            });
			setTimeout(function(){
                $.unblockUI();
            },1000);
			$.ajax({
				url : $BASE_URL+'dashboard/log_out',
				complete : function(response) {
					$.unblockUI();
					window.location.href = $BASE_URL;
				}
			});				
			
		}
	});
}
function isNumber (o) {
    return ! isNaN (o-0) && o !== null && o.replace(/^\s\s*/, '') !== "" && o !== false;
}