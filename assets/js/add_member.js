$(document).ready(function() {
    FormWizardValidation.init();
    jQuery('#debit').hide();
    jQuery('#pembayaran').hide();
	jQuery('#kredit').hide();
	jQuery('#transfer').hide();
    jQuery("#detil_kursus").hide();
    jQuery("#detil_reg").hide();
    jQuery('#bayarna').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });     
    var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';
    jQuery("#jenis").change(function(){
        var jenis = jQuery("#jenis").val();
        if(jenis!=""){
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
	            jQuery.unblockUI();
            },500);
            jQuery("#tipe").load ($BASE_URL+'member/get_tipe/'+jenis);
            jQuery("#tipe").trigger("liszt:updated");
            jQuery("#detil_kursus").show('hide');
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Jenis Kursus Tidak Boleh Kosong !"});return false;
        }
    });
    $("input[name=bayar]").change(function() {
     	var n = $(this).val();
	 	switch(n){
			case "0":
				$('#debit').hide();
				$('#kredit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "1":
				$('#debit').show();
				$('#kredit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "2":
				$('#kredit').show();
				$('#debit').hide();
				$('#transfer').hide();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
			case "3":
				$('#debit').hide();
				$('#kredit').hide();
				$('#transfer').show();
				$('#pembayaran').show('slow');
				var total = jQuery("#totalnax").unmask();
				var bayar = jQuery("#bayarna").val(0);
				jQuery("#sisa").val(parseInt(total)-0);
				jQuery('#sisa').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();
				break;
		}
  	});
	jQuery("#simpan").click(function(){
		var nama = jQuery("#nama").val();
		if(nama!="") {
			var r=confirm("Data sudah benar  ?");
			if(r==true){
				$.post($BASE_URL+"member/proses_add", $("#tform").serialize(),
				function(data){
                  	$("#message").html(data);
                  	$("#message").hide();
                  	$("#message").fadeIn(1500); //Fade in the data given by the insert.php file
                 	window.location.href = $BASE_URL+'member';
            	});
				return false; 
			}
		}else{
			alert("Data tidak boleh kosong !")
		}
	});
    jQuery("#tipe").change(function(){
        var tipe = jQuery("#tipe").val();                            
        if (jQuery("#tipe").val()!=''){
        	jQuery.post($BASE_URL+"member/get_harga/"+tipe,
            function(data){
                var dt = data.split("|");
                jQuery("#h_daftar").val(dt[0]);
                jQuery('#h_daftar').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });     
                document.getElementById("h_daftar_label").textContent = "Rp. "+jQuery("#h_daftar").val();
                jQuery("#h_pokok").val(dt[1]);
                jQuery('#h_pokok').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("h_pokok_label").textContent = "Rp. "+jQuery("#h_pokok").val();
                var daftar = jQuery("#h_daftar").unmask();
                var biaya = jQuery("#h_pokok").unmask();
                jQuery("#subtotal").val(parseInt(daftar)+parseInt(biaya));
                    jQuery('#subtotal').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                jQuery("#totalna").val(parseInt(daftar)+parseInt(biaya));
                    jQuery('#totalna').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                jQuery("#diskon").val(0);
                document.getElementById("subtotal_label").textContent = "Rp. "+jQuery("#totalna").val();
                var tot = jQuery("#totalna").unmask();
                var dsc = jQuery("#diskon").unmask();
                var subtotal = parseInt(tot) - (parseInt(dsc)/100);
                jQuery("#totalnax").val(parseInt(subtotal));
                jQuery('#totalnax').priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.'
                });
                document.getElementById("totalna").textContent = "Rp. "+jQuery("#totalnax").val();
                jQuery('#detil_reg').show("slow");;
            });     
        }else{
            $.gritter.add({title:"Informasi !",text: " Data Jenis Kursus Tidak Boleh Kosong !"});
            jQuery('#detil_reg').hide("slow");;
            return false;
        }
    });
});
function etang () {
	var subtotal = jQuery("#subtotal").unmask();
	var dsc = jQuery("#diskon").val();
	var total = parseInt(subtotal) - (parseInt(subtotal) * (parseInt(dsc)/100));
	jQuery("#totalnax").val(parseInt(total));
	jQuery('#totalnax').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    document.getElementById("totalna").textContent = "Rp. "+jQuery("#totalnax").val();
}
function hitung () {
	var subtotal = jQuery("#totalnax").unmask();
	var bayar = jQuery("#bayarna").unmask();
	var total = parseInt(subtotal) - parseInt(bayar);
	jQuery("#sisa").val(parseInt(total));
	jQuery('#sisa').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    document.getElementById("sisana").textContent = "Rp. "+jQuery("#sisa").val();	
}
