<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateAllTablesSeeder extends Seeder
{
    /**
     * Run the database truncates.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables in order (child first, parent last)
        DB::table('t_stok')->truncate();
        DB::table('t_penjualan_detail')->truncate();
        DB::table('t_penjualan')->truncate();
        DB::table('m_barang')->truncate();
        DB::table('m_kategori')->truncate();
        DB::table('m_supplier')->truncate();
        DB::table('m_user')->truncate();
        DB::table('m_level')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
