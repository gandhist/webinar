<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use \App\WorkingSchedule;
use \App\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RptSecurity implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        
    }

    public function headings(): array {
        return [
           "Tanggal","Piket Pagi (09.00-18.00)","Piket malam (18.00-03.00)"
        ];
    }

    public function collection()
    {
        
        DB::statement( DB::raw( "SET @start_date = '$this->start_date'"));
        DB::statement( DB::raw( "SET @end_date = '$this->end_date'"));
        //return Employee::query()->select('nama','nik')->get();

        return collect(DB::select("
        
        SELECT 
        a.date AS tanggal,
        (SELECT b.nama FROM  working_schedule d INNER JOIN karyawan b ON  d.karyawan_id = b.id WHERE d.date = a.date AND d.working_type_id = 4) AS shift_siang,
        (SELECT b.nama FROM  working_schedule d INNER JOIN karyawan b ON  d.karyawan_id = b.id WHERE d.date = a.date AND d.working_type_id = 8) AS Shift_malam

        FROM  working_schedule a INNER JOIN working_schedule c ON a.id = c.id INNER JOIN karyawan b
        ON a.karyawan_id = b.id
        WHERE a.date BETWEEN @start_date AND @end_date
        AND a.working_type_id IN ('4','8')
        GROUP BY a.date 
        "));
    }
}