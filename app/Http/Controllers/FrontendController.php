<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class FrontendController extends Controller
{
    public function index(){
        $blogs = Blog::where('active', 1 )->orderBy('id', 'desc')->paginate(2);

        return view('frontend.blog', compact('blogs'));
    }
    //Blog Details Page
    public function blogDetails($url){

        $blog = Blog::where('url', $url)->first();
        return view('frontend.blogDetail', compact('blog'));
    }
}
