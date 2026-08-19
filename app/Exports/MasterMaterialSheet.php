<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MasterMaterialSheet implements FromArray, WithTitle, WithEvents
{
    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    public function array(): array
    {
        $rows = [];


        /*
        |--------------------------------------------------------------------------
        | JUDUL
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

        $rows[] = [
            'ITEM MASTER DATA'
        ];


        /*
        |--------------------------------------------------------------------------
        | HEADER MASTER MATERIAL
        |--------------------------------------------------------------------------
        */

        $rows[] = [

            'No.',

            'SAP Number',

            'JDE Number',

            'Mat. Type',

            'Desc 1',

            'Desc 2',

            'MRP Type',

            'Location',

            'Location 2',

            'QOH ' . now()->format('d F Y'),

            'UoM',

            'Mat Group',

            'Photo',

        ];


        /*
        |--------------------------------------------------------------------------
        | DATA MATERIAL
        |--------------------------------------------------------------------------
        */

        $materials = Material::orderBy('id', 'asc')->get();


        foreach ($materials as $index => $material) {

            $rows[] = [

                /*
                | No.
                */
                $index + 1,


                /*
                | SAP Number
                */
                (string) ($material->material_number ?? ''),


                /*
                | JDE Number
                */
                '',


                /*
                | Material Type
                */
                '',


                /*
                | Description
                */
                $material->description ?? '',


                /*
                | Description 2
                */
                '',


                /*
                | MRP Type
                */
                '',


                /*
                | Location
                */
                $material->storage_bin ?? '',


                /*
                | Location 2
                */
                '',


                /*
                | QOH
                */
                $material->qty_stock ?? 0,


                /*
                | UoM
                */
                $material->uom ?? '',


                /*
                | Material Group
                */
                '',


                /*
                | Photo
                */
                '',

            ];
        }


        return $rows;
    }


    /*
    |--------------------------------------------------------------------------
    | NAMA SHEET
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Master Material';
    }


    /*
    |--------------------------------------------------------------------------
    | EVENT SETELAH SHEET DIBUAT
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

                $sheet->mergeCells('A1:M1');

                $sheet->mergeCells('A2:M2');

                $sheet->mergeCells('A4:M4');


                /*
                |--------------------------------------------------------------------------
                | JUDUL PT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:M1')->applyFromArray([

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

                $sheet->getStyle('A2:M2')->applyFromArray([

                    'font' => [

                        'bold' => true,

                        'size' => 16,

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
                | ITEM MASTER DATA
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A4:M4')->applyFromArray([

                    'font' => [

                        'bold' => true,

                        'size' => 14,

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
                | HEADER TABLE
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A5:M5')->applyFromArray([

                    'font' => [

                        'bold' => true,

                        'color' => [

                            'rgb' => '000000',

                        ],

                    ],

                    'fill' => [

                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [

                            'rgb' => 'FFFF00',

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
                | LAST ROW
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();


                /*
                |--------------------------------------------------------------------------
                | BORDER DATA
                |--------------------------------------------------------------------------
                */

                if ($lastRow >= 6) {

                    $sheet
                        ->getStyle("A6:M{$lastRow}")
                        ->applyFromArray([

                            'borders' => [

                                'allBorders' => [

                                    'borderStyle' =>
                                        Border::BORDER_THIN,

                                    'color' => [

                                        'rgb' => 'B7B7B7',

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
                | SAP NUMBER JADI TEXT
                |--------------------------------------------------------------------------
                |
                | Supaya 45500001234 tidak berubah menjadi 4,55E+10.
                |
                */

                for (
                    $row = 6;
                    $row <= $lastRow;
                    $row++
                ) {

                    $value = $sheet
                        ->getCell("B{$row}")
                        ->getValue();


                    $sheet
                        ->getCell("B{$row}")
                        ->setValueExplicit(

                            (string) $value,

                            DataType::TYPE_STRING

                        );

                }


                /*
                |--------------------------------------------------------------------------
                | FORMAT QOH
                |--------------------------------------------------------------------------
                */

                if ($lastRow >= 6) {

                    $sheet
                        ->getStyle("J6:J{$lastRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');

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
                    ->setRowHeight(25);

                $sheet
                    ->getRowDimension(4)
                    ->setRowHeight(24);

                $sheet
                    ->getRowDimension(5)
                    ->setRowHeight(45);


                /*
                |--------------------------------------------------------------------------
                | LEBAR KOLOM
                |--------------------------------------------------------------------------
                */

                $widths = [

                    'A' => 7,

                    'B' => 18,

                    'C' => 18,

                    'D' => 12,

                    'E' => 30,

                    'F' => 25,

                    'G' => 12,

                    'H' => 18,

                    'I' => 18,

                    'J' => 16,

                    'K' => 10,

                    'L' => 15,

                    'M' => 15,

                ];


                foreach ($widths as $column => $width) {

                    $sheet
                        ->getColumnDimension($column)
                        ->setWidth($width);

                }


                /*
                |--------------------------------------------------------------------------
                | FILTER
                |--------------------------------------------------------------------------
                */

                $sheet->setAutoFilter(
                    "A5:M{$lastRow}"
                );


                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A6');

            },

        ];
    }
}