<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    //Get all documents
    public function index(){
        
        $documents = Document::all();
        return $documents;
    }
}
