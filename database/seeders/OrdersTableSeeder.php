<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->delete();

        $csvFile = fopen(base_path('database/seeders/test_orders.csv'), 'r');
        $firstline = true; // Инициализируем переменную
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if ($firstline) {
                $firstline = false; // Переключаем переменную после пропуска первой строки
                continue;
            }
            DB::table('orders')->insert([
                'order_number' => $data[0],
                'order_date' => $data[1],
                'customer_first_name' => $data[2],
                'customer_last_name' => $data[3],
                'customer_middle_name' => $data[4] !== '' ? $data[4] : null,
                'total_amount' => $data[5],
                'status' => $data[6],
            ]);
        }
        fclose($csvFile);
    }
}
