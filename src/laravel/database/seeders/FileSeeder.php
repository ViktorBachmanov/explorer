<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Folder;


class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Folder::get()->each(function ($folder) {
            if ($folder->name == 'empty-folder') {
                return;
            }
            
            $folder->files()->createMany([
                ['name' => 'file-1'],
                ['name' => 'file-2'],
            ]);
        });
    }
}
