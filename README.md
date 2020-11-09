# Webinar
webinar

    upgrade to laravel 5.8

    "vinkla/hashids": "5.2.0",
    "yajra/laravel-datatables-oracle": "~9.0",

    upgrade to laravel 6.0

    "php": "^7.2.5",
    "vinkla/hashids": "7.0.0",
    "tymon/jwt-auth": "^1.0.0",
    delete "yoeunes/rateable"
    str_limit to \Illuminate\Support\Str::limit

    upgrade to laravel 7.0

    "vinkla/hashids": "8.0.0",
    "laravel/tinker": "^2.0",
    "nunomaduro/collision": "^4.1",
    "phpunit/phpunit": "^8.5"
    add "laravel/ui": "2.4",
    app/Exceptions/Handler.php change Exception to Throwable
    
#To Do

    *masih belum jelas:
        -resize upload kpt+npwp (personal)
        -nge-link antara foto diri di personal sama peserta
        
    *Rafi:
    - GANTI MAIL VIEW EMAIL
    - Re-code di parameter rata-rata & persen di feedback

        -Fungsi hapus
        -Handle kalau email udah ada (import)
        -Integrasi Midtrans
        
        tambah field/column 'url' di srtf_seminar (varchar)

        *nanda
        profile peserta 
        upload ktp/pdfimage di profile
        no registrasi ska di profile
        tambah field nilai sktk di srtf_peserta_seminar
        tambah field total nilai sktk di table peserta
        ENV : 
        untuk api whatsapp tambahkan env nya
        USER_ZZ=43c6df9a2fb6
        PASS_ZZ=bry8ntb4y5
        URL_WA_ZZ=https://gsm.zenziva.net/api/sendWA/
        function nya ada di traist globalFunction
        


NOTE
    .env buat midtrans

        MIDTRANS_CLIENTKEY='SB-Mid-client-5gCnj0pfWsUX6sDH'
        MIDTRANS_SERVERKEY='SB-Mid-server-shaJKNWpA0EGWMwex5Veag8s'
        MIDTRANS_IS_PRODUCTION= false
        MIDTRANS_IS_SANITIZED= true
        MIDTRANS_IS3DS= true
        
    .env google login

        GOOGLE_CLIENT_ID=451175512287-5ncc5oh266fkippep8rkcva2chb168lj.apps.googleusercontent.com
        GOOGLE_CLIENT_SECRET=GM5acmxsH0MgDEdxbh_AWw6-
        GOOGLE_REDIRECT_CALLBACK='https://srtf.p3sm.or.id/login/google/callback'

        
    kalau masih error, coba:
        -composer install
        -php artisan config:cache
        
        -restart serve
