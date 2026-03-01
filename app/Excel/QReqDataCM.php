<?php

namespace App\Excel;

use App\Models\Service;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class QReqDataCM implements FromCollection, WithHeadings, WithStyles
{
// for master
    public function collection()
    {
        return Service::select(
            'cof_id',
            'brand',
            'serial_number',
            'product_number',
            'nama_type',
            'status',
            'received_date',
            'started_date',
            'finished_date',
            'contact',
            'customer_name',
            'email',
            'phone_number',
            'address',
            'fault_description',
            'accessories',
            'kondisi_unit',
            'repair_summary'
        )
            ->where('status', 'quotation request')
        ->orderBy('received_date', 'desc')
        ->get();
    }

    public function headings(): array
    {
        $reportingDate = Carbon::now()->format('d F Y');

        return [
            ['KLA Quotation Request Report'], // Title
            ['Export Date: ' . $reportingDate], 
            [], // Space before table
            [
                'COF-ID',
                'Brand',
                'Serial Number',
                'Product Number',
                'Nama Type',
                'Case Status',
                'Received Date',
                'Started Date',
                'Finished Date',
                'Contact',
                'Customer Name',
                'Email',
                'Phone Number',
                'Address',
                'Fault Description',
                'Accessories',
                'Kondisi Unit',
                'Repair Summary'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style Title
        $sheet->mergeCells('A1:R1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Style Export Date
        $sheet->mergeCells('A2:R2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);

        // Header Grey Background
        $sheet->getStyle('A4:R4')->getFont()->setBold(true);
        $sheet->getStyle('A4:R4')->getFill()->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setARGB('D9D9D9');

        return [];
    }
}
