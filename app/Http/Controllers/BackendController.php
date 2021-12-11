<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    //User Dashboard
    public function userDashboard(){
        return view('userpanel.dashbord');
    }
    //create blog view for user
    public function createBlog(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('userpanel.createBlog', compact('categories', 'tags'));
    }
}
