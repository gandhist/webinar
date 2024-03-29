$(document).ready(function () {

    // $('.datatable').DataTable().destroy();
    var dt = $('#data-tables').DataTable({
        "lengthMenu": [
            [100, 200, 500],
            [100, 200, 500]
        ],
        "scrollX": true,
        "scrollY": $(window).height() - 255,
        "scrollCollapse": true,
        "autoWidth": false,
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": [0, 1]
        }],
        "aaSorting": []
    });

    dt.on('order.dt search.dt', function () {
        dt.column(1, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});


// Fungsi ajax untuk chained of negara
function chainedNegara(url, idnegara, idprov, placeholder) {
    var idnegara = $('#' + idnegara).val();
    url = url + idnegara;

    $('#' + idprov).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            id: idnegara
        },
        success: function (data) {
            $("#" + idprov).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + idprov).select2({
                data: data
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data');
        }

    });
}
function goBack() {
    window.history.back();
  }

// pop up pdf
function tampilLampiran(url, title) {
    // alert('dumbass');
    $('#modalLampiran').modal('show');
    $('#iframeLampiran').attr('src', url);
    // $('#lampiranTitle').text(title);
    $('#lampiranTitle').html(` <a href="` + url + `" target="_blank" > ` + title + ` </a> `);
}

// pop up foto
function tampilFoto(url, title) {
    // alert('dumbass');
    $('#modalFoto').modal('show');
    $('#imgFoto').attr('src', url);
    // $('#iframeLampiran').attr('src', url);
    $('#lampiranTitle').html(` <a href="` + url + `" target="_blank" > ` + title + ` </a> `);
}


// fungsi ajax untuk chained of provinsi
function chainedProvinsi(url, id_prov, id_kota, placeholder) {
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}

// fungsi ajax untuk chained of kota
function chainedKota(url, id_prov, id_kota) {
    var kota = $('#' + id_kota).val();
    var formData = new FormData($('#formRegist')[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            kota: kota
        },
        success: function (datapro) {
            //console.log(datapro[0].provinsi_id);
            $('#' + id_prov).val(datapro[0].provinsi_id).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data provinsi');
        }

    });
}


// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiTimP(url, id_prov, id_kota, placeholder,id_jenis_usaha) {
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota,
            id_jenis_usaha:id_jenis_usaha
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}

function chainedProvinsiTimM(url, id_prov, id_kota, placeholder,id_jenis_usaha) {
    console.log(id_jenis_usaha);
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota,
            id_jenis_usaha:id_jenis_usaha
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}


// Fungsi ajax untuk chained of jenis_usaha
function chainedBidangSkp(url, idjenis, idbid) {
    var valjenis = $('#' + idjenis).val();
    url = url + valjenis;

    $('#' + idbid).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        success: function (databid) {
            $("#" + idbid).select2({
                data: databid
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data bidang');
            console.log(xhr);
        }

    });
}

// Fungsi merubah tanggal ke format indonesia javascript format YYYY-MM-DD
function tanggal_indonesia(string) {
    bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    tanggal = string.split("-")[2];
    bulan = string.split("-")[1];
    tahun = string.split("-")[0];

    return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
}

// Fungsi Cek nilai value kosong/NULL atau tidak
function cekNull(value) {
    return (value==null ||  value=='null' ? '' : value);
  }

  // Fungsi Rubah warna filter
function selectFilter(name) {
    $('#' + name).on('change', function () {
        idfilter = $(this).attr('id');
        if ($(this).val() == '' || $(this).val() == null) {
            $('#select2-' + idfilter + '-container').parent().css('background-color',
                'transparent');
            $('#select2-' + idfilter + '-container').parent().css('font-weight', 'unset');
        } else {
            $('#select2-' + idfilter + '-container').parent().css('background-color',
                '#b6f38f');
            $('#select2-' + idfilter + '-container').parent().css('font-weight', 'bold');
        }
    });
}

// Fungsi Rubah warna filter
function inputFilter(name) {
    $('#' + name).on('change', function () {
        idfilter = $(this).attr('id');
        if ($(this).val() == '') {
            $(this).css('background-color', 'transparent');
            $(this).css('font-weight', 'unset');
        } else {
            $(this).css('background-color', '#b6f38f');
            $(this).css('font-weight', 'bold');
        }
    });
}

// Fungsi merubah Cache warna filter input tipe select2
function selectFilterCache(name){
    $('#select2-'+name+'-container').parent().css('background-color', '#b6f38f');
    $('#select2-'+name+'-container').parent().css('font-weight', 'bold');
}

// Fungsi merubah Cache warna filter input biasa
function inputFilterCache(name){
    $('#'+name).css('background-color', '#b6f38f');
    $('#'+name).css('font-weight', 'bold');
}

// Fungsi Rubah warna filter
function inputFilter(name) {
    $('#' + name).on('input blur paste change', function () {
        idfilter = $(this).attr('id');
        if ($(this).val() == '') {
            $(this).css('background-color', 'transparent');
            $(this).css('font-weight', 'unset');
        } else {
            $(this).css('background-color', '#b6f38f');
            $(this).css('font-weight', 'bold');
        }
    });
}

// Fungsi merubah Cache warna filter input tipe select2
function selectFilterCache(name){
    $('#select2-'+name+'-container').parent().css('background-color', '#b6f38f');
    $('#select2-'+name+'-container').parent().css('font-weight', 'bold');
}

// Fungsi merubah Cache warna filter input biasa
function inputFilterCache(name){
    $('#'+name).css('background-color', '#b6f38f');
    $('#'+name).css('font-weight', 'bold');
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiBu(url, id_prov, id_kota, placeholder) {
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiPersonil(url, id_prov, id_kota, placeholder) {
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}


function sugestPersonil(id_nama_p, id_hp_p, id_email_p,url) {
    $('#' + id_nama_p).typeahead({
        source: function (query, process) {
            return $.get(url, {
                query: query
            }, function (data) {
                return process(data);
            });
        },
        displayText: function (item) {
            return item.nama;
        },
        updater: function (item) {
            if (id_hp_p == "" || id_email_p=="") {

            } else {
                $("#" + id_hp_p).val(item.hp_wa);
                $("#" + id_email_p).val(item.email_p);

                if(item.hp_wa==null || item.hp_wa==""){
                    $("#" + id_hp_p).css('background-color', 'white');
                }else{
                    $("#" + id_hp_p).css('background-color', '#b9cae6');
                }

                if(item.email_p==null || item.email_p==""){
                    $("#" + id_email_p).css('background-color', 'white');
                }else{
                    $("#" + id_email_p).css('background-color', '#b9cae6');
                }
            }
            return item;
        }
    });
}


function setDateRangePicker(input1, input2) {
    $(input1).datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
    }).on("change", function () {
        $(input2).val("").datepicker('setStartDate', $(this).val());
    }).css({
        "cursor": "pointer",
        "background": "white"
    });
    $(input2).datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        orientation: "top left"
    }).css({
        "cursor": "pointer",
        "background": "white"
    });
}


function capitalizeFirstLetter(string) {
    if(string==null){
      return "";
    }else{
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
}


// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiDokpersonil(url, id_prov, id_kota, placeholder) {
    var prov = $('#' + id_prov).val();
    var kota = $('#' + id_kota).val();

    $('#' + id_kota).empty();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            prov: prov,
            kota: kota
        },
        success: function (datapro) {
            $("#" + id_kota).html("<option value='' selected>" + placeholder + "</option>");
            $("#" + id_kota).select2({
                data: datapro
            }).val(null).trigger('change');
        },
        error: function (xhr, status) {
            alert('terjadi error ketika menampilkan data kota');
            console.log(xhr);
        }

    });
}
