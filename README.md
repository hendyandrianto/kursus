# Catatan
Sistem Manajemen Kursus Mengemudi &amp; Menjahit Codeigniter
Untuk menjalankan aplikasi ini pastikan di buatkan virtual hostnya dan juga tambahkan .htaccess
untuk lebih lanjut silahkan kontak
Facebook : https://www.facebook.com/opChaky.it
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /

    #Removes access to the system folder by users.
    #Additionally this will allow you to create a System.php controller,
    #previously this would not have been possible.
    #'system' can be replaced if you have renamed your system folder.
    RewriteCond %{REQUEST_URI} ^system.*
    RewriteRule ^(.*)$ /index.php?/$1 [L]
    
    #When your application folder isn't in the system folder
    #This snippet prevents user access to the application folder
    #Submitted by: Fabdrol
    #Rename 'application' to your applications folder name.
    RewriteCond %{REQUEST_URI} ^application.*
    RewriteRule ^(.*)$ /index.php?/$1 [L]

    #Checks to see if the user is attempt
