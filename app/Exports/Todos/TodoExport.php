<?php

namespace App\Exports\Todos;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class TodoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $todos;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function collection()
    {
        return $this->todos;
    }

    public function headings(): array
    {
        return [
            'Title',
            'Assignee',
            'Due Date',
            'Time Tracked',
            'Status',
            'Priority',
        ];
    }

    public function map($todo): array
    {
        return [
            $todo->title,
            $todo->assignee,
            $todo->due_date->format('Y-m-d'),
            $todo->time_tracked,
            $todo->status,
            $todo->priority,
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow() + 1;

                $sheet->setCellValue("A{$lastRow}", 'Total Todos:');
                $sheet->setCellValue("B{$lastRow}", $this->todos->count());
                
                $sheet->setCellValue("C{$lastRow}", 'Total Time Tracked:');
                $sheet->setCellValue("D{$lastRow}", $this->todos->sum('time_tracked'));

                $sheet->getStyle("A{$lastRow}:D{$lastRow}")->getFont()->setBold(true);
            },
        ];
    }
}