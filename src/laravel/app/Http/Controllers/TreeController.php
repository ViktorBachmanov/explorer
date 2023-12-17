<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Folder;
use App\Http\Resources\Item as ItemResource;


class TreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ItemResource(Folder::firstWhere('name', 'root'));
    }
}
