<?php

namespace App\Exports;

use App\Models\JadwalIbadah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class JadwalExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $periode;

    public function __construct($periode = null)
    {
        $this->periode = $periode;
    }

    public function query()
    {
        return JadwalIbadah::select('nama_periode', 'nama_ibadah', 'waktu_ibadah', 'nama_pemain', 'nama_alat');
    }

    public function headings(): array
    {
        return [
            'Periode',
            'Nama Ibadah',
            'Tanggal & Jam',
            'Personil',
            'Alat Musik'
        ];
    }
}
