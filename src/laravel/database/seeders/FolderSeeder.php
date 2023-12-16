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

        // Folder::firstOrCreate(
        //     ['id' => 2],
        //     ['name' => 'folder-1', 'parent_id' => 1]
        // );

        // Folder::firstOrCreate(
        //     ['id' => 3],
        //     ['name' => 'folder-2', 'parent_id' => 1]
        // );

        // Folder::firstOrCreate(
        //     ['id' => 4],
        //     ['name' => 'folder-11', 'parent_id' => 2]
        // );

        // Folder::firstOrCreate(
        //     ['id' => 5],
        //     ['name' => 'folder-12', 'parent_id' => 2]
        // );

        $rootFolder->folders()->createMany([
            ['name' => self::FOLDER_1_NAME],
            ['name' => 'folder-2'],
        ]);

        Folder::firstWhere('name', self::FOLDER_1_NAME)->folders()->createMany([
            ['name' => self::FOLDER_1_NAME],
            ['name' => 'folder-2'],
        ]);
    }
}
