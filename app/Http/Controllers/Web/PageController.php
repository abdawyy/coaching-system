<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // ✅ Make sure this line exists


class PageController extends Controller
{
    public function home()
    {
        return view('web.index');
    }

    public function about()
    {
        return view('web.about');
    }

    public function courses()
    {
        return view('web.courses');
    }

    public function pricing()
    {
        return view('web.pricing');
    }

    public function gallery()
    {
        return view('web.gallery');
    }

     public function contact()
    {
        return view('web.contact');
    }
}
