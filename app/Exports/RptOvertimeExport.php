<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use \App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RptOvertimeExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(string $start_date, string $end_date, string $karyawan_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->karyawan_id = $karyawan_id;
    }

    public function headings(): array {
        return [
           "NIK","Nama","Tanggal","Hari","Jam Masuk","Jam Keluar","Jam Masuk Lembur", "Jam Akhir Lembur", "Total Jam Lembur","Telat","Jam Terlambat","Fee"
        ];
    }

    public function collection()
    {
        // setting parameter sql
        DB::statement( DB::raw( "SET @tanggal_awal = '$this->start_date'"));
        DB::statement( DB::raw( "SET @tanggal_akhir = '$this->end_date'"));
        // shift 1
        DB::statement( DB::raw( 'SET @firsthour_ds = (SELECT CONCAT(" ",end_time) FROM master_lembur_rest WHERE id = 2)'));
        DB::statement( DB::raw( 'SET @firsthour_day_rest = (SELECT CONCAT(" ",start_time) FROM master_lembur_rest WHERE id = 3)'));
        DB::statement( DB::raw( 'SET @sechour_day_rest = (SELECT CONCAT(" ",end_time) FROM master_lembur_rest WHERE id = 3)'));
        DB::statement( DB::raw( 'SET @sechour_ds = (SELECT CONCAT(" ",start_time) FROM master_lembur_rest WHERE id = 4)'));
        
        // shift 2
        DB::statement( DB::raw( 'SET @firsthour_ns = (SELECT CONCAT(" ",end_time) FROM master_lembur_rest WHERE id = 4)'));
        DB::statement( DB::raw( 'SET @firsthour_night_rest_23 = " 23:59:59"'));
        DB::statement( DB::raw( 'SET @firsthour_night_rest = (SELECT CONCAT(" ",start_time) FROM master_lembur_rest WHERE id = 1)'));
        DB::statement( DB::raw( 'SET @sechour_night_rest = (SELECT CONCAT(" ",end_time) FROM master_lembur_rest WHERE id = 1)'));
        DB::statement( DB::raw( 'SET @sechour_ns = (SELECT CONCAT(" ",start_time) FROM master_lembur_rest WHERE id = 2)'));
        
        // rest time
        DB::statement( DB::raw( 'SET @os_duasatu = HOUR(TIMEDIFF(@firsthour_ds, @sechour_ns))'));
        DB::statement( DB::raw( 'SET @os_satudua = HOUR(TIMEDIFF(@firsthour_ns, @sechour_ds))'));
        DB::statement( DB::raw( 'SET @rest_satu = HOUR(TIMEDIFF(@sechour_day_rest, @firsthour_day_rest))'));
        DB::statement( DB::raw( 'SET @rest_dua= HOUR(TIMEDIFF(@sechour_night_rest, @firsthour_night_rest))'));
        //return Employee::query()->select('nama','nik')->get();

        return collect(DB::select("
        SELECT b.nik, b.nama, a.tanggal, 
        CASE 
	WHEN DAYNAME(a.tanggal) = 'Monday' THEN 'Senin'
	WHEN DAYNAME(a.tanggal) = 'Tuesday' THEN 'Selasa'
	WHEN DAYNAME(a.tanggal) = 'Wednesday' THEN 'Rabu'
	WHEN DAYNAME(a.tanggal) = 'Thursday' THEN 'Kamis'
	WHEN DAYNAME(a.tanggal) = 'Friday' THEN 'Jumat'
	WHEN DAYNAME(a.tanggal) = 'Saturday' THEN 'Sabtu'
	WHEN DAYNAME(a.tanggal) = 'Sunday' THEN 'Minggu' 
    END AS hari,
a.check_in, a.check_out, a.mulai, a.selesai, SUM(a.total_jam_lembur) AS total_jam_lembur, ROUND(SUM(a.telat),2) AS telat, SEC_TO_TIME( SUM( TIME_TO_SEC( a.jam_telat ) ) ) AS jam_telat, SUM(a.fee) AS fee FROM
(
        SELECT
        a.karyawan_id,
        a.date AS tanggal,
        b.masuk AS check_in,
        b.pulang AS check_out,
        c.mulai,
        c.selesai,
        c.total_jam_lembur,
        b.telat,
        b.jam_telat,
        CASE 
            WHEN (c.total_jam_lembur - b.telat) < '3.00' AND (c.total_jam_lembur - b.telat) IS NOT NULL THEN ROUND(3.00 * b.fee_lembur)
            ELSE ROUND((c.total_jam_lembur - b.telat)* b.fee_lembur)
        END AS fee
        FROM working_schedule a LEFT JOIN
        (
        SELECT
        karyawan_id, tanggal, masuk, pulang, 
        ADDTIME(schedule_start, late_tolerance) AS late_tolerance,
        CASE 
            WHEN TIME(masuk) > ADDTIME(schedule_start, late_tolerance) THEN ROUND(TIMESTAMPDIFF(SECOND, ADDTIME(schedule_start, late_tolerance), TIME(masuk)) / 3600,2)
            ELSE 'N/A'
        END AS telat,
        CASE 
            WHEN TIME(masuk) > ADDTIME(schedule_start, late_tolerance) THEN TIMEDIFF(TIME(masuk), ADDTIME(schedule_start, late_tolerance))
            ELSE 'N/A'
        END AS jam_telat,
        fee_lembur
        FROM karyawan_absensi WHERE deleted_at IS NULL AND tanggal BETWEEN @tanggal_awal AND @tanggal_akhir
        ) b ON a.karyawan_id = b.karyawan_id AND a.date = b.tanggal
        LEFT JOIN (
        SELECT 
        karyawan_id,
        tanggal,
        mulai,
        selesai,
        DATEDIFF(DATE(selesai), DATE(mulai))  AS hari_by_date,
        CASE 
        -- 0 day
        WHEN DATEDIFF(DATE(selesai), DATE(mulai)) = 0 THEN 
            CASE
            
                -- 00-01 s/d 02
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai <= CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),' 00:00:00'), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 00-01 s/d 02-07	
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai), @sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua) HOUR), selesai) / 3600,2)
                -- 00-01 s/d 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai), @firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua) HOUR), CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 00-01 s/d 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai), @firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua+@os_duasatu) HOUR), selesai) / 3600,2)
                -- 00-01 s/d 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua+@os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest) ) / 3600,2)
                -- 00-01 s/d 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua+@os_duasatu+@rest_satu) HOUR) , selesai) / 3600,2)
                -- 00-01 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua+@os_duasatu+@rest_satu) HOUR) , CONCAT(DATE(selesai),@sechour_ds) ) / 3600,2)
                -- 00-01 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),' 00:00:00') AND CONCAT(DATE(mulai),@firsthour_night_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua+@os_duasatu+@rest_satu+@os_satudua) HOUR) , selesai) / 3600,2)
                
                
                -- 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai <= CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, selesai) / 3600,2)
                -- 02-07 s/d 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai),@firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 02-07 s/d 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai),@firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_duasatu) HOUR), selesai) / 3600,2)
                -- 02-07 s/d 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai),@sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 02-07 s/d 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai),@sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_duasatu+@rest_satu) HOUR), selesai) / 3600,2)
                -- 02-07 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai),@firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_duasatu+@rest_satu) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 02-07 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_night_rest) AND CONCAT(DATE(mulai),@sechour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_duasatu+@rest_satu+@os_satudua) HOUR), selesai) / 3600,2)
                
                
                -- 07-08 s/d 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai <= CONCAT(DATE(selesai),@firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@firsthour_ds), selesai) / 3600,2)
                -- 07-08 s/d 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@firsthour_ds) , CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 07-08 s/d 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu) HOUR) , selesai ) / 3600,2)
                -- 07-08 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu) HOUR), CONCAT(DATE(selesai), @sechour_ds)  ) / 3600,2)
                -- 07-08 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua) HOUR), selesai ) / 3600,2)
                
                    
                -- 08-12 s/d 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai),@sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 08-12 s/d 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai),@sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu) HOUR), selesai) / 3600,2)
                -- 7-12 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai),@firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + @rest_satu HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 7-12 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
                
                -- 12-13 s/d 13-17 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@sechour_day_rest) , selesai ) / 3600,2)
                -- 12-13 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@sechour_day_rest), CONCAT(DATE(selesai), @sechour_ds)  ) / 3600,2)
                -- 12-13 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua) HOUR), selesai ) / 3600,2)
                
                -- 13-17 s/d 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai),@firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 13-17 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua) HOUR), selesai) / 3600,2)
                        
                -- 17-18 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@firsthour_ns), selesai ) / 3600,2)
                        
                -- 18 – 24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, selesai) / 3600,2)
                
            END

        WHEN DATEDIFF(DATE(selesai), DATE(mulai)) = 1 THEN 
            CASE
            
            -- == 07-08 == --
                -- 07-08 s/d ND 00-01 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
                -- 07-08 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua) HOUR), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 07-08 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua) HOUR), selesai) / 3600,2)
                -- 07-08 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai),@firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua) HOUR), CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 07-08 s/d ND 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai),@firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 07-08 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai),@sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 07-08 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai),@sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), selesai) / 3600,2)
                -- 07-08 s/d ND 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai),@firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 07-08 s/d ND 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ns) AND CONCAT(DATE(mulai),@firsthour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ds), INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 07-08 == --
                
            -- == 08-12 == --
                -- 08-12 s/d ND 00-01
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
                -- 08-12 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua) HOUR), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 08-12 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua) HOUR), selesai) / 3600,2)
                -- 08-12 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai),@firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua) HOUR), CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 08-12 s/d ND 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai),@firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 08-12 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai),@sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 08-12 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai),@sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), selesai) / 3600,2)
                -- 08-12 s/d ND 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai),@firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 08-12 s/d ND 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ds) AND CONCAT(DATE(mulai),@firsthour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai),@firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_satu + @os_satudua + @rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 08-12 == --
            
            -- == 12-13 == --
                -- 12-13 s/d ND 00-01
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua) HOUR), selesai) / 3600,2)
                -- 12-13 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua) HOUR), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 12-13 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL +  (@os_satudua + @rest_dua) HOUR) , selesai) / 3600,2)		
                -- 12-13 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai), @firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + ( @os_satudua + @rest_dua) HOUR ) , CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 12-13 s/d ND 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai), @firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua + @rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 12-13 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua + @rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 12-13 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), selesai) / 3600,2)
                -- 12-13 s/d ND 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 12-13 s/d ND 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_day_rest) AND CONCAT(DATE(mulai),@sechour_day_rest) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@sechour_day_rest), INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 12-13 == --		
                
            -- == 13-17 == --
                -- 13-17 s/d ND 00-01
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua) HOUR), selesai) / 3600,2)
                -- 13-17 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua) HOUR), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 13-17 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL +  (@os_satudua + @rest_dua) HOUR) , selesai) / 3600,2)		
                -- 13-17 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai), @firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua) HOUR ) , CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)		
                -- 13-17 s/d ND 08-12 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai), @firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 13-17 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 13-17 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu) HOUR), selesai) / 3600,2)
                -- 13-17 s/d ND 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 13-17 s/d ND 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_day_rest) AND CONCAT(DATE(mulai),@sechour_ds) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@os_satudua + @rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 13-17 == --
            
            -- == 17-18 == --
                -- 17-18 s/d ND 00-01
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@firsthour_ns), selesai) / 3600,2)
                -- 17-18 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, CONCAT(DATE(mulai),@firsthour_ns), CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 17-18 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL +  (@rest_dua) HOUR) , selesai) / 3600,2)		
                -- 17-18 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai), @firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua) HOUR ) , CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 17-19 s/d ND 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai), @firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 17-19 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 17-19 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua + @os_duasatu + @rest_satu ) HOUR), selesai) / 3600,2)
                -- 17-19 s/d ND 17-18
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 17-19 s/d 18-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@sechour_ds) AND CONCAT(DATE(mulai),@firsthour_ns) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(CONCAT(DATE(mulai),@firsthour_ns), INTERVAL + (@rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 17-18 == --
            
            -- == 18-24 == -- 
                -- 18-24 s/d ND 00-01
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai <= CONCAT(DATE(selesai),@firsthour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, selesai) / 3600,2)
                -- 18-24 s/d ND 01-02 REST 
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_night_rest) AND CONCAT(DATE(selesai),@sechour_night_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, mulai, CONCAT(DATE(selesai),@firsthour_night_rest)) / 3600,2)
                -- 19-24 s/d ND 02-07
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_night_rest) AND CONCAT(DATE(selesai),@sechour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + ( @rest_dua) HOUR), selesai) / 3600,2)		
                -- 19-24 s/d ND 07-08 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ns) AND CONCAT(DATE(selesai), @firsthour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua) HOUR ) , CONCAT(DATE(selesai),@sechour_ns)) / 3600,2)
                -- 19-24 s/d ND 08-12
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ds) AND CONCAT(DATE(selesai), @firsthour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua + @os_duasatu) HOUR), selesai) / 3600,2)
                -- 19-24 s/d ND 12-13 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_day_rest) AND CONCAT(DATE(selesai), @sechour_day_rest) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua + @os_duasatu) HOUR), CONCAT(DATE(selesai),@firsthour_day_rest)) / 3600,2)
                -- 19-24 s/d ND 13-17
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_day_rest) AND CONCAT(DATE(selesai), @sechour_ds) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua + @os_duasatu + @rest_satu) HOUR), selesai) / 3600,2)
                -- 19-24 s/d ND 17-18 REST
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@sechour_ds) AND CONCAT(DATE(selesai), @firsthour_ns) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua + @os_duasatu + @rest_satu ) HOUR), CONCAT(DATE(selesai),@sechour_ds)) / 3600,2)
                -- 19-24 s/d 19-24
                WHEN mulai BETWEEN CONCAT(DATE(mulai),@firsthour_ns) AND CONCAT(DATE(mulai),@firsthour_night_rest_23) AND selesai BETWEEN CONCAT(DATE(selesai),@firsthour_ns) AND CONCAT(DATE(selesai), @firsthour_night_rest_23) THEN ROUND(TIMESTAMPDIFF(SECOND, DATE_ADD(mulai, INTERVAL + (@rest_dua + @os_duasatu + @rest_satu + @os_satudua) HOUR), selesai) / 3600,2)
            -- == 19-24 == --
            END
        END AS total_jam_lembur
        FROM
        karyawan_lembur
        WHERE DATE(mulai) BETWEEN @tanggal_awal 
        AND @tanggal_akhir 
        AND deleted_at IS NULL
        GROUP BY mulai, karyawan_id
        ) c ON a.karyawan_id = c.karyawan_id AND a.date = c.tanggal
        WHERE a.date BETWEEN @tanggal_awal AND @tanggal_akhir
        AND a.deleted_at IS NULL
        AND a.karyawan_id = $this->karyawan_id
        GROUP BY a.date, a.karyawan_id
        ORDER BY a.karyawan_id, a.date ASC) a INNER JOIN karyawan b ON a.karyawan_id = b.id
        GROUP BY a.tanggal WITH ROLLUP
        "));
    }
}
