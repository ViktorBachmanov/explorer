<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Folder;
use App\Http\Resources\Folder as FolderResource;


class TreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new FolderResource(Folder::firstWhere('name', 'root'));
    }
}
