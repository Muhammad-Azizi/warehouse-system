<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements Export, WithMultipleSheets
{
    use Exportable;

    protected $jenisLaporan;
    protected $dariTanggal;
    protected $sampaiTanggal;

    public function __construct(
        $jenisLaporan = 'semua',
        $dariTanggal = null,
        $sampaiTanggal = null
    ) {
        $this->jenisLaporan = $jenisLaporan;
        $this->dariTanggal = $dariTanggal;
        $this->sampaiTanggal = $sampaiTanggal;
    }

    public function sheets(): array
    {
        return [

            new MasterMaterialSheet(),

            new LaporanSheet(
                $this->jenisLaporan,
                $this->dariTanggal,
                $this->sampaiTanggal
            ),

        ];
    }
}