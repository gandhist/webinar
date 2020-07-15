<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use \App\WorkingSchedule;
use \App\Karyawan;
use \App\KaryawanAbsensi;
use \App\KaryawanPermission;
use \App\Permission;
use \App\KaryawanleaveQuota;
use \App\Sakit;
use \App\KaryawanLembur;
use \App\KaryawanLeave;
use \App\KaryawanLeaveTrail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RptKehadiran implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        
    }

    public function headings(): array {
        return [
           "NIK","Nama Karyawan","Total Hari","Masuk","Absent","Telat","Cuti","Sakit",
           "Izin","Alpha","Sisa Cuti","Total Cuti"
        ];
    }

    public function collection()
    {
        
        DB::statement( DB::raw( "SET @start_date = '$this->start_date'"));
        DB::statement( DB::raw( "SET @end_date = '$this->end_date'"));
        //return Employee::query()->select('nama','nik')->get();

        return collect(DB::select("
        
        SELECT kr.id,kr.nik,kr.nama,DATEDIFF(@end_date, @start_date) AS total_hari, q.masuk, DATEDIFF(@end_date, @start_date)-q.masuk AS absent,
        SEC_TO_TIME(SUM(TIME_TO_SEC(t1.telat))) AS total_telat, a.cuti, b.izin,skt.sakit,
        DATEDIFF(@end_date, @start_date)-q.masuk - a.cuti - b.izin - skt.sakit AS alpha, w.total_cuti, w.sisa_cuti
        FROM karyawan_absensi ka
        INNER JOIN
        (SELECT id,nik,nama FROM karyawan WHERE STATUS = 1 AND deleted_at IS NULL GROUP BY id) kr
        ON ka.karyawan_id = kr.id
        LEFT JOIN
        (SELECT karyawan_id, COUNT(leave_date) AS cuti FROM karyawan_leave_trail WHERE STATUS = 0 AND leave_date BETWEEN @start_date AND @end_date AND deleted_at IS NULL GROUP BY karyawan_id) a
        ON ka.karyawan_id = a.karyawan_id
        LEFT JOIN
        (SELECT karyawan_id, COUNT(permission_date) AS izin FROM karyawan_permission_trail WHERE STATUS = 0 AND permission_date BETWEEN @start_date AND @end_date GROUP BY karyawan_id) b
        ON ka.karyawan_id = b.karyawan_id
        LEFT JOIN
        (SELECT karyawan_id, COUNT(DATE) AS sakit FROM karyawan_sakit_trail WHERE STATUS = 0 AND DATE BETWEEN @start_date AND @end_date GROUP BY karyawan_id) skt
        ON ka.karyawan_id  = skt.karyawan_id
        LEFT JOIN
        (SELECT karyawan_id, nama,COUNT(tanggal) AS masuk 
        FROM karyawan q INNER JOIN karyawan_absensi ka ON q.id = ka.karyawan_id WHERE q.beban_id = ka.beban_id GROUP BY q.nama) q
        ON ka.karyawan_id = q.karyawan_id 
        LEFT JOIN
        (SELECT karyawan_id, TIMEDIFF(pulang,masuk) AS selisih,tanggal,
        CASE
        WHEN TIME(masuk) >= ADDTIME(schedule_start, late_tolerance) THEN TIMEDIFF(TIME(masuk), ADDTIME(schedule_start,late_tolerance))
        ELSE 'N/A'
        END AS telat
        FROM karyawan_absensi WHERE deleted_at IS NULL AND tanggal BETWEEN @start_date AND @end_date GROUP BY karyawan_id,tanggal) t1
        ON ka.karyawan_id = t1.karyawan_id AND ka.tanggal = t1.tanggal
        LEFT JOIN
        (
        SELECT p.karyawan_id, p.total_cuti, v.sisa_cuti FROM 
        (SELECT karyawan_id,
        CASE 
        WHEN is_taken = 1 AND leave_date BETWEEN @start_date AND @end_date THEN COUNT(leave_date)
        END AS total_cuti
        FROM karyawan_leave_quota GROUP BY karyawan_id) p
        LEFT JOIN
        (SELECT karyawan_id,
        COUNT(is_taken) AS sisa_cuti
        FROM karyawan_leave_quota WHERE is_taken = 0 GROUP BY karyawan_id)v
        ON p.karyawan_id = v.karyawan_id
        ) w
        ON ka.karyawan_id = w.karyawan_id
        WHERE ka.tanggal BETWEEN @start_date AND @end_date AND ka.deleted_at IS NULL
        GROUP BY ka.karyawan_id
        "));
    }
}

