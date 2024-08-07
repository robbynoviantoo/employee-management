<?php

namespace Database\Seeders;
use App\Models\Materi;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Materi Training
        Materi::create(['materi_name' => 'Component', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Introduction', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Cutting', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Stitching', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Assembly', 'kategori' => 'Training']);
        Materi::create(['materi_name' => '2nd Process', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Report', 'kategori' => 'Training']);
        Materi::create(['materi_name' => '6 & 9 Checkpoint', 'kategori' => 'Training']);
        // Materi Beginner
        Materi::create(['materi_name' => 'QIP Manual', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Planning/Logic', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Continuous Improvement', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Cutting', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Stitching', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Assembly', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Bottom', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Defect Knowledge', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Practical', 'kategori' => 'Beginner']);
        // Materi Intermediate
        Materi::create(['materi_name' => 'WI & Jobdesk', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Product Creation', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Laboratory', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Incoming Materials Warehouse', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Chemicals', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Packing', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'AQL Inspection', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Beautiful Audit', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Visual Standard', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Best Practice', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Practical', 'kategori' => 'Intermediate']);
        // Materi Advanced
        Materi::create(['materi_name' => 'Factory Performance', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Customer Return', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Leadership', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Problem Solving', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Procedure', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Equipment/Device', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Digitalization', 'kategori' => 'Advanced']);
        // Materi Initiative
        Materi::create(['materi_name' => 'Roles and Responsibility', 'kategori' => 'Initiative']);
        Materi::create(['materi_name' => 'Collaboration Training', 'kategori' => 'Initiative']);
        Materi::create(['materi_name' => 'Inovation Training', 'kategori' => 'Initiative']);
        // Materi Advanced
        Materi::create(['materi_name' => 'A01, CPSIA, Country Compliance', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'FGT', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'OCPT & Slip on Inspection', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'CMAP & Color Manual', 'kategori' => 'CFA']);
    }
}
