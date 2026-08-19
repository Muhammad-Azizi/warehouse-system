<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanSheet implements FromArray, WithTitle, WithEvents
{
    protected $jenisLaporan;
    protected $dariTanggal;
    protected $sampaiTanggal;

    /*
    |--------------------------------------------------------------------------
    | BARIS UNTUK STYLING
    |--------------------------------------------------------------------------
    */

    protected $barangMasukSectionRow;
    protected $barangMasukHeaderRow;
    protected $barangMasukDataStart;
    protected $barangMasukDataEnd;

    protected $barangKeluarSectionRow;
    protected $barangKeluarHeaderRow;
    protected $barangKeluarDataStart;
    protected $barangKeluarDataEnd;


    public function __construct(
        $jenisLaporan = 'semua',
        $dariTanggal = null,
        $sampaiTanggal = null
    ) {
        $this->jenisLaporan = $jenisLaporan;
        $this->dariTanggal = $dariTanggal;
        $this->sampaiTanggal = $sampaiTanggal;
    }


    /*
    |--------------------------------------------------------------------------
    | DATA EXCEL
    |--------------------------------------------------------------------------
    */

    public function array(): array
    {
        $rows = [];


        /*
        |--------------------------------------------------------------------------
        | JUDUL LAPORAN
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'PT. SOLUSI BANGUN ANDALAS'
        ];

        $rows[] = [
            'LHOKNGA WAREHOUSE'
        ];

        $rows[] = [
            ''
        ];


        /*
        |--------------------------------------------------------------------------
        | ================================================================
        | BARANG MASUK
        | ================================================================
        */

        $this->barangMasukSectionRow = count($rows) + 1;

        $rows[] = [
            'BARANG MASUK'
        ];


        /*
        | HEADER BARANG MASUK
        */

        $this->barangMasukHeaderRow = count($rows) + 1;

        $rows[] = [
            'Jenis',
            'No Transaksi',
            'Tanggal',
            'Tujuan / Supplier',
            'SAP Number',
            'Description',
            'Qty',
            'UoM',
            'Storage Bin',
        ];


        /*
        | DATA BARANG MASUK DIMULAI
        */

        $this->barangMasukDataStart = count($rows) + 1;


        if (
            $this->jenisLaporan === 'semua' ||
            $this->jenisLaporan === 'barang_masuk'
        ) {

            $query = BarangMasuk::with('details.material')
                ->latest('tanggal');


            /*
            | FILTER DARI TANGGAL
            */

            if ($this->dariTanggal) {

                $query->whereDate(
                    'tanggal',
                    '>=',
                    $this->dariTanggal
                );

            }


            /*
            | FILTER SAMPAI TANGGAL
            */

            if ($this->sampaiTanggal) {

                $query->whereDate(
                    'tanggal',
                    '<=',
                    $this->sampaiTanggal
                );

            }


            $data = $query->get();


            foreach ($data as $item) {

                foreach ($item->details as $detail) {

                    /*
                    | Nomor SAP
                    */

                    $materialNumber =
                        $detail->material->material_number ?? '';


                    /*
                    | Baris Excel saat ini
                    */

                    $excelRow = count($rows) + 1;


                    $rows[] = [

                        'Barang Masuk',

                        $item->no_masuk,

                        $item->tanggal?->format('d-m-Y'),

                        $item->supplier,

                        /*
                        | SAP Number
                        */

                        (string) $materialNumber,

                        /*
                        | Description
                        | B = SAP Number
                        | E = Desc 1
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,4,FALSE),\"\")",

                        /*
                        | Qty
                        */

                        $detail->qty ?? 0,

                        /*
                        | UOM
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,10,FALSE),\"\")",

                        /*
                        | Storage Bin
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,7,FALSE),\"\")",

                    ];
                }
            }
        }


        /*
        | AKHIR DATA BARANG MASUK
        */

        $this->barangMasukDataEnd = count($rows);


        /*
        |--------------------------------------------------------------------------
        | PEMISAH
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            ''
        ];


        /*
        |--------------------------------------------------------------------------
        | ================================================================
        | BARANG KELUAR
        | ================================================================
        */

        $this->barangKeluarSectionRow = count($rows) + 1;

        $rows[] = [
            'BARANG KELUAR'
        ];


        /*
        | HEADER BARANG KELUAR
        */

        $this->barangKeluarHeaderRow = count($rows) + 1;

        $rows[] = [
            'Jenis',
            'No Transaksi',
            'Tanggal',
            'Tujuan / Pemakai',
            'SAP Number',
            'Description',
            'Qty',
            'UoM',
            'Storage Bin',
        ];


        /*
        | DATA BARANG KELUAR DIMULAI
        */

        $this->barangKeluarDataStart = count($rows) + 1;


        if (
            $this->jenisLaporan === 'semua' ||
            $this->jenisLaporan === 'barang_keluar' ||
            $this->jenisLaporan === 'picking_list'
        ) {

            $query = BarangKeluar::with('details.material')
                ->latest('tanggal');


            /*
            | FILTER DARI TANGGAL
            */

            if ($this->dariTanggal) {

                $query->whereDate(
                    'tanggal',
                    '>=',
                    $this->dariTanggal
                );

            }


            /*
            | FILTER SAMPAI TANGGAL
            */

            if ($this->sampaiTanggal) {

                $query->whereDate(
                    'tanggal',
                    '<=',
                    $this->sampaiTanggal
                );

            }


            $data = $query->get();


            foreach ($data as $item) {

                foreach ($item->details as $detail) {

                    /*
                    | Nomor SAP
                    */

                    $materialNumber =
                        $detail->material->material_number ?? '';


                    /*
                    | Baris Excel
                    */

                    $excelRow = count($rows) + 1;


                    /*
                    | Jenis transaksi
                    */

                    $jenis =
                        $this->jenisLaporan === 'picking_list'
                        ? 'Picking List'
                        : 'Barang Keluar';


                    $rows[] = [

                        $jenis,

                        $item->no_keluar,

                        $item->tanggal?->format('d-m-Y'),

                        $item->tujuan,

                        /*
                        | SAP Number
                        */

                        (string) $materialNumber,

                        /*
                        | Description
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,4,FALSE),\"\")",

                        /*
                        | Qty
                        */

                        $detail->qty ?? 0,

                        /*
                        | UOM
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,10,FALSE),\"\")",

                        /*
                        | Storage Bin
                        */

                        "=IFERROR(VLOOKUP(E{$excelRow},'Master Material'!\$B:\$M,7,FALSE),\"\")",

                    ];
                }
            }
        }


        /*
        | AKHIR DATA BARANG KELUAR
        */

        $this->barangKeluarDataEnd = count($rows);


        return $rows;
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Laporan';
    }


    /*
    |--------------------------------------------------------------------------
    | STYLE EXCEL
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();


                /*
                |--------------------------------------------------------------------------
                | MERGE JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:I1');

                $sheet->mergeCells('A2:I2');


                /*
                |--------------------------------------------------------------------------
                | JUDUL PERUSAHAAN
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:I1')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_LEFT,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | NAMA WAREHOUSE
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A2:I2')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 15,
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_LEFT,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | ============================================================
                | BARANG MASUK - HEADER SECTION HIJAU
                | ============================================================
                */

                $sheet->mergeCells(
                    "A{$this->barangMasukSectionRow}:I{$this->barangMasukSectionRow}"
                );


                $sheet->getStyle(
                    "A{$this->barangMasukSectionRow}:I{$this->barangMasukSectionRow}"
                )->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 13,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],

                    'fill' => [
                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [
                            'rgb' => '16A34A',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_LEFT,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | HEADER TABEL BARANG MASUK
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$this->barangMasukHeaderRow}:I{$this->barangMasukHeaderRow}"
                )->applyFromArray([

                    'font' => [
                        'bold' => true,
                    ],

                    'fill' => [
                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [
                            'rgb' => 'D9EAD3',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_CENTER,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,

                        'wrapText' => true,
                    ],

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                                Border::BORDER_THIN,

                            'color' => [
                                'rgb' => '000000',
                            ],
                        ],
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | BORDER DATA BARANG MASUK
                |--------------------------------------------------------------------------
                */

                if (
                    $this->barangMasukDataEnd >=
                    $this->barangMasukDataStart
                ) {

                    $sheet->getStyle(
                        "A{$this->barangMasukDataStart}:I{$this->barangMasukDataEnd}"
                    )->applyFromArray([

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,

                                'color' => [
                                    'rgb' => 'D0D0D0',
                                ],
                            ],
                        ],

                        'alignment' => [
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | ============================================================
                | BARANG KELUAR - HEADER SECTION MERAH
                | ============================================================
                */

                $sheet->mergeCells(
                    "A{$this->barangKeluarSectionRow}:I{$this->barangKeluarSectionRow}"
                );


                $sheet->getStyle(
                    "A{$this->barangKeluarSectionRow}:I{$this->barangKeluarSectionRow}"
                )->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 13,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],

                    'fill' => [
                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [
                            'rgb' => 'DC2626',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_LEFT,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | HEADER TABEL BARANG KELUAR
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$this->barangKeluarHeaderRow}:I{$this->barangKeluarHeaderRow}"
                )->applyFromArray([

                    'font' => [
                        'bold' => true,
                    ],

                    'fill' => [
                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [
                            'rgb' => 'F4CCCC',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_CENTER,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER,

                        'wrapText' => true,
                    ],

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                                Border::BORDER_THIN,

                            'color' => [
                                'rgb' => '000000',
                            ],
                        ],
                    ],

                ]);


                /*
                |--------------------------------------------------------------------------
                | BORDER DATA BARANG KELUAR
                |--------------------------------------------------------------------------
                */

                if (
                    $this->barangKeluarDataEnd >=
                    $this->barangKeluarDataStart
                ) {

                    $sheet->getStyle(
                        "A{$this->barangKeluarDataStart}:I{$this->barangKeluarDataEnd}"
                    )->applyFromArray([

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,

                                'color' => [
                                    'rgb' => 'D0D0D0',
                                ],
                            ],
                        ],

                        'alignment' => [
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | SAP NUMBER SEBAGAI TEXT
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();


                for ($row = 1; $row <= $lastRow; $row++) {

                    if ($row === 1) {
                        continue;
                    }


                    /*
                    | Kolom E = SAP Number
                    */

                    $value = $sheet
                        ->getCell("E{$row}")
                        ->getValue();


                    if ($value !== null && $value !== '') {

                        /*
                        | Jangan ubah formula
                        */

                        if (
                            !is_string($value) ||
                            !str_starts_with($value, '=')
                        ) {

                            $sheet
                                ->getCell("E{$row}")
                                ->setValueExplicit(
                                    (string) $value,
                                    DataType::TYPE_STRING
                                );

                        }

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | WIDTH KOLOM
                |--------------------------------------------------------------------------
                */

                $widths = [

                    'A' => 18,

                    'B' => 18,

                    'C' => 15,

                    'D' => 25,

                    'E' => 18,

                    'F' => 30,

                    'G' => 12,

                    'H' => 10,

                    'I' => 18,

                ];


                foreach ($widths as $column => $width) {

                    $sheet
                        ->getColumnDimension($column)
                        ->setWidth($width);

                }


                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(28);

                $sheet
                    ->getRowDimension(2)
                    ->setRowHeight(24);

                $sheet
                    ->getRowDimension(
                        $this->barangMasukSectionRow
                    )
                    ->setRowHeight(25);

                $sheet
                    ->getRowDimension(
                        $this->barangKeluarSectionRow
                    )
                    ->setRowHeight(25);


                /*
                |--------------------------------------------------------------------------
                | FREEZE
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane(
                    "A{$this->barangMasukDataStart}"
                );


                /*
                |--------------------------------------------------------------------------
                | WRAP TEXT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle(
                        "A1:I{$lastRow}"
                    )
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

            },

        ];
    }
}