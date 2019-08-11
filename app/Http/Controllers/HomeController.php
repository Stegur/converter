<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $array = [
            'B10' => 'Some',
            'C10' => 'text',
            'D10' => 'in',
            'E10' => 'array',
        ];

        // Данные из БД
        $datafromDB = DB::select('select cell, value from data');

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

        //return view('home');
    }
}
