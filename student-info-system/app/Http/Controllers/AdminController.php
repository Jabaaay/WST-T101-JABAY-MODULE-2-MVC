<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function subject()
{
    return view('admin.subject'); // Siguraduhang naa ni nga view
}

public function grades()
{
    return view('admin.grades'); // Siguraduhang naa ni nga view
}

public function enrollment()
{
    return view('admin.enrollment'); // Siguraduhang naa ni nga view
}

public function student()
{
    return view('admin.student'); // Siguraduhang naa ni nga view
}

}
