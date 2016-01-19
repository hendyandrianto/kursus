function doLogin(){
    var host = window.location.host;
    $BASE_URL = 'http://'+host+'/';
    var uname = jQuery("#username").val();
    var password = jQuery("#password").val();
    if (uname == "") {
        jQuery("#username").effect('shake','1500').attr('placeholder','Username tidak boleh kosong');
    } else if (password == "") {
        jQuery("#password").effect('shake','1500').attr('placeholder','Password tidak boleh kosong');
    } else {
        jQuery.blockUI({
            css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: 2, 
                color: '#fff' 
            },
            message : 'Pengecekan Username dan Password <br/> Mohon menunggu ... '
        });
        
        jQuery.ajax({
            url : $BASE_URL+'login/do_login',
            data : {txtuser:uname,txtpass:password},
            type : 'POST',
            dataType: 'json',
            success:function(data){
                jQuery.unblockUI();
                if(data.response=='true'){
                    jQuery.blockUI({
                        css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: 2, 
                            color: '#fff' 
                        },
                        message : 'Berhasil Login !!! Sedang Memuat Halaman, Mohon menunggu ... '
                    });
                    window.location = $BASE_URL+'dashboard';
                    setTimeout(function(){
                        jQuery.unblockUI();
                    },1000);
                } else {
                    notif({
                        type: "warning",
                        msg: "Ups Username dan Password Anda tidak dikenal Silahkan Login Kembali",
                        position: "center",
                        width: 500,
                        height: 60,
                        autohide: true
                    });
                    jQuery("#username").val('');
                    jQuery("#password").val('');
                }            
            }
        });
    }
}