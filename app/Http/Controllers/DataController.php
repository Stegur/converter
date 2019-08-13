<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Data;

class DataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $array = [
            'B10' => 'Some',
            'C10' => 'text',
            'D10' => 'in',
            'E10' => 'array',
        ];

        // Данные из БД
        $datafromDB = Data::select('cell', 'value')->get();

        // Объеденение данных из БД с массивом
        foreach ($datafromDB as $row) {
            $array[$row->cell] = $row->value;
        }

        // запись даннных из массива в файл
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($array as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('data.xlsx');

    }
}
