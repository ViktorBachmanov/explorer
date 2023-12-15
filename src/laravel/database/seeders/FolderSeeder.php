<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Folder;


class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Folder::firstOrCreate(
            ['id' => 1],
            ['name' => 'root']
        );

        Folder::firstOrCreate(
            ['id' => 2],
            ['name' => 'folder-1', 'parent_folder_id' => 1]
        );

        Folder::firstOrCreate(
            ['id' => 3],
            ['name' => 'folder-2', 'parent_folder_id' => 1]
        );

        Folder::firstOrCreate(
            ['id' => 4],
            ['name' => 'folder-11', 'parent_folder_id' => 2]
        );
    }
}
