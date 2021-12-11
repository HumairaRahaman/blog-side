<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Tag;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use http\Env\Response;


//use phpDocumentor\Reflection\DocBlock\Tag;


class TagController extends Controller
{
    //Return Tag view

    public function index()
    {

        return view('backend.tags');
    }

    //Getting all the tags in datatable
    public function getAllTags()
    {
        $tags = Tag::all();

        return Datatables::of($tags)
            ->editColumn('created_at', function ($tag) {
                return $tag->created_at ? with(new Carbon($tag->created_at))->format('d-M-Y') : '';
            })
            ->editColumn('updated_at', function ($tag) {
                return $tag->updated_at ? with(new Carbon($tag->updated_at))->format('d-M-Y') : '';;
            })
            ->make(true);
    }

    //create Tag

    public function create(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|min:3|max:255',
        ]);

        $slug = Str::slug($request->tag_name);

        $tag = Tag::create([
            'name' => $request->tag_name,
            'slug' => $slug,
        ]);
        return "Success";
    }

    //Get Tag for edit
    public function getTag($id)
    {
        $tag = Tag::find($id);


        if ($tag) {
            return $tag;
        } else {
            return Response::json(['error' => 'Not Found'], 404);
        }
    }

    //update Tag
    public function updateTag(Request $request)
    {
        $request->validate([
            'edit_tag' => 'required|min:3|max:255',
        ], [
            'edit_tag-required' => 'The Tag name field is required.',
            'edit_tag-min' => 'The Tag name should be atleast 3 characters',
            'edit_tag-max' => 'The Tag name may not be greater then 255 characters.',

        ]);
        $tag = Tag::find($request->tag_id);
        $tag->name = $request->edit_tag;
        $tag->slug = Str::slug($request->edit_tag);
        $tag->save();

        return "Success";
    }

    //Delete tag
    public function deleteTag($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return "Success";
        } else {
            return Response::json(['error' => 'Not Found'], 404);
        }
    }
}
