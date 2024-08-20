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
        Materi::create(['materi_name' => 'Basic Defect Knowledge', 'kategori' => 'Training']);
        Materi::create(['materi_name' => '6 & 9 Checkpoint', 'kategori' => 'Training']);
        Materi::create(['materi_name' => 'Report', 'kategori' => 'Training']);
        // Materi Beginner
        Materi::create(['materi_name' => 'QIP Manual', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Planning/Logic', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Continuous Improvement', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Cutting', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Stitching', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Assembly', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Bottom', 'kategori' => 'Beginner']);
        Materi::create(['materi_name' => 'Defect Knowledge', 'kategori' => 'Beginner']);
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
        Materi::create(['materi_name' => 'BP Cutting', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'BP Sewing', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'BP Assembly', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'BP 2nd Process', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'BP Mold Prevention', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'BP MD', 'kategori' => 'Intermediate']);
        Materi::create(['materi_name' => 'Device & Equipment', 'kategori' => 'Intermediate']);
        // Materi Advanced
        Materi::create(['materi_name' => 'Costumer Return', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Leadership Training', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Problem Solving', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Q-KPI New', 'kategori' => 'Advanced']);
        Materi::create(['materi_name' => 'Digitalization', 'kategori' => 'Advanced']);
        // Materi Initiative
        Materi::create(['materi_name' => '3rd Party intensive', 'kategori' => 'Initiative']);
        Materi::create(['materi_name' => 'BNP & Metal Handling to Prod', 'kategori' => 'Initiative']);
        // CFA
        Materi::create(['materi_name' => 'Metal Detection', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Mold Prevention', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'SHAS', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'A01', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'CPSIA', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Country Compliance', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Slip-on Inspection', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'First Production', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'MCS', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'OCTP', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'FGT', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Color Manual', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'CMAP', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Defect List', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Inspection Step', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'EVS', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'AQL Validation', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => '3rd Party Inspection', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => '9 Step Check Point', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Inspection Flow', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Practical Metal in CTB, Loading, & How to handle metal issue', 'kategori' => 'CFA']);
        Materi::create(['materi_name' => 'Validation by Quality Head & LOPM', 'kategori' => 'CFA']);
    }
}
