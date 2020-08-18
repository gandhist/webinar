# Webinar
 webinar

#To Do

    *masih belum jelas:
        -resize upload kpt+npwp (personal)
        -nge-link antara foto diri di personal sama peserta
        
    *Rafi:
        -Fungsi hapus
        -Handle kalau email udah ada (import)
        -Integrasi Midtrans
        buat absensi
        pennilaian :
        1. inisiator
        2. penyelenggara
        3. narasumber
        4. moderator
        kesan dan pesan untuk semua
        
        tambah field/column 'url' di srtf_seminar (varchar)

        *nanda
        profile peserta 
        upload ktp/pdfimage di profile
        no registrasi ska di profile
        tambah field nilai sktk di srtf_peserta_seminar
        tambah field total nilai sktk di table peserta
        


NOTE
    .env buat midtrans

        MIDTRANS_CLIENTKEY='SB-Mid-client-5gCnj0pfWsUX6sDH'
        MIDTRANS_SERVERKEY='SB-Mid-server-shaJKNWpA0EGWMwex5Veag8s'
        MIDTRANS_IS_PRODUCTION= false
        MIDTRANS_IS_SANITIZED= true
        MIDTRANS_IS3DS= true
        
    kalau masih error, coba:
        -composer install
        -php artisan config:cache
        
        -restart serve
