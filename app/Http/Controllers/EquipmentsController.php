<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentsController extends Controller
{
    //Get equipments for user
    public function index($id){
        
        $equipments = Equipment::where('user_id', $id)->get();
        return $equipments;
    }
}
