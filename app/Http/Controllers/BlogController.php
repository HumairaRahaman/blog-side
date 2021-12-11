<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Auth;
use App\Blog;
use App\category;
use App\Tag;
use Yajra\DataTables\DataTables;
use Str;


class BlogController extends Controller
{
    //Return Blog Listing View
    public function index()
    {
        return view('backend.blogs');
    }

    //Return create Blog View
    public function createBlogView()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('backend.createBlog', compact('categories', 'tags'));
    }

    //Get All Blogs
    public function getAllBlogs()
    {

        $blogs = Blog::all();

        return Datatables::of($blogs)
            ->editColumn('user_id', function ($blog) {
                return "<span class='badge badge-success badge-pill'>".$blog->user->name . "</span>";
            })
            ->editColumn('category_id', function ($blog) {
                return "<span class='badge badge-dark badge-pill'>".$blog->category->name . "</span>";
            })
//            ->addColumn('id', function (Blog $blog) {
//                return $blog->tags->map(function($tag) {
//                    return "<span class='badge badge-dark badge-pill'>".$tag->name . "</span>";
//                })->implode('&nbsp');
//            })
            ->editColumn('active', function ($blog) {
              if($blog->active == '1'){
                return "<span class='badge badge-success badge-pill'>Approved</span>";
              }
              else{
                  return "<span class='badge badge-dark badge-pill'>Waiting Approval</span>";
              }
            })
            ->editColumn('short_description', function ($blog) {
                return Str::words($blog->short_description,3, '....');
            })
//            ->editColumn('description', function ($blog) {
//                return $blog->description;
//            })
            ->editColumn('created_at', function ($blog) {
                return $blog->created_at ? with(new Carbon($blog->created_at))->format('d-M-Y') : '';
            })
            ->editColumn('updated_at', function ($blog) {
                return $blog->updated_at ? with(new Carbon($blog->updated_at))->format('d-M-Y') : '';;
            })
            ->rawColumns(['user_id', 'category_id', 'description', 'active'])
            ->make(true);
    }

    //Create Blog
    public function create(Request $request)
    {

        $user = Auth::user();

        $active = $request->active == 'on' ? 1 : 0;


        $this->validateBlog($request);

        $uploadedImage = $request->file('image');
        $imageWithExt = $uploadedImage->getClientOriginalName();
        $imageName = pathinfo($imageWithExt, PATHINFO_FILENAME);
        $imageExt = $uploadedImage->getClientOriginalExtension();
        $image = $imageName . time() . ' . ' . $imageExt;
        $request->image->move(public_path('/images/blogImages'), $image);

        $blog = Blog::create([
            'user_id' => $user->id,
            'category_id' => $request->category,
            'title' => $request->title,
            'url' => $request->url,
            'image' => $image,
            'image_alt' => $request->image_alt,
            'meta' => $request->meta,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'active' => $active,
        ]);
        $blog->tags()->attach($request->tags);

        return redirect()->back()->with('success', 'Successful.');
    }


    //validate Blog
    public function validateBlog($request)
    {

        $request->validate([
            'title' => 'required|min:3|max:255',
            'url' => 'required|min:3|max:255|unique:blogs',
            'category' => 'required',
            'tags' => 'required',
            'image' => 'required|mimes:jpg,png,bnp,gif|max:2000',
            'image_alt' => 'required|min:3|max:255',
            'meta' => 'required|min:3|max:255',
            'short_description' => 'required|min:3|max:255',
            'description' => 'required|min:10',


        ]);
        return $request;

    }
        //Return Edit Blog View
        public function editBlogView($id){
        $categories = Category::all();
        $tags = Tag::all();

        $blog = Blog::find($id);

        return view('backend.editBlog', compact('blog','categories','tags'));

        }

        //Update Blog
    public function update(Request $request){
        $blog = Blog::findOrFail($request->blog_id);
        $this->validateBlogForUpdate($request);


        $active = $request->active == 'on' ? 1 : 0;


        $storeImage = $blog->image;

        if($request->has('image')){
           $path = "/image/blogImage/";
           $image = $blog->image;
           $this->deleteImage($path,$image);

            $uploadedImage = $request->file('image');
            $imageWithExt = $uploadedImage->getClientOriginalName();
            $imageName = pathinfo($imageWithExt, PATHINFO_FILENAME);
            $imageExt = $uploadedImage->getClientOriginalExtension();
            $storeImage = $imageName . time() . ' . ' . $imageExt;
            $request->image->move(public_path('/images/blogImages'), $storeImage);
        }
        $blog->title = $request->title;
        $blog->url = $request->url;
        $blog->category_id = $request->category;
        $blog->image = $storeImage;
        $blog->image_alt = $request->image_alt;
        $blog->meta = $request->meta;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->active = $active;

        $blog->save();

        $blog->tags()->sync($request->tags);

        return redirect()->back()->with('success','Successfull');



    }

    //Validation for update
    public function validateBlogForUpdate($request){
          if($request->has('image')){
              $request->validate([
                  'title' => 'required|min:3|max:255',
                  'url' => 'required|min:3|max:255|unique:blogs,url,'.$request->blog_id,
                  'category' => 'required',
                  'tags' => 'required',
                  'image' => 'required|mimes:jpg,png,bnp,gif|max:2000',
                  'image_alt' => 'required|min:3|max:255',
                  'meta' => 'required|min:3|max:255',
                  'short_description' => 'required|min:3|max:255',
                  'description' => 'required|min:10',


              ]);
          }
          else{
              $request->validate([
                  'title' => 'required|min:3|max:255',
                  'url' => 'required|min:3|max:255|unique:blogs,url,'.$request->blog_id,
                  'category' => 'required',
                  'tags' => 'required',
                  'image_alt' => 'required|min:3|max:255',
                  'meta' => 'required|min:3|max:255',
                  'short_description' => 'required|min:3|max:255',
                  'description' => 'required|min:10',


              ]);
          }

          return $request;
    }

    //Delete Blog
    public function deleteBlog($id){
      $blog = Blog::findOrFail($id);


      if($blog){
          $path = '/images/blogImages/';
          $image = $blog->image;

          $this->deleteImage($path,$image);

          $blog->delete();

          return "success";
      }

      else{
          return Response::json(['error' => 'Not Found'], 400);
      }

    }


    //Delete Blog Image

    public function deleteImage($path,$image){
        if(file_exists(public_path().$path.$image)){
            unlink(public_path().$path.$image);
        }
    }


}
