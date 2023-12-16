<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Folder;


class FolderSeeder extends Seeder
{
    const FOLDER_1_NAME = 'folder-1';
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rootFolder = Folder::firstOrCreate(
            ['id' => 1],
            ['name' => 'root']
        );

        $rootFolder->folders()->createMany([
            ['name' => self::FOLDER_1_NAME],
            ['name' => 'folder-2'],
        ]);

        Folder::firstWhere('name', self::FOLDER_1_NAME)->folders()->createMany([
            ['name' => self::FOLDER_1_NAME],
            ['name' => 'folder-2'],
        ]);

        Folder::create(['name' => 'empty-folder', 'parent_id' => 1]);
    }
}
