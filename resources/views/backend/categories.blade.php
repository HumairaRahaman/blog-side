@extends('backend.layout.master')

@section('title')
    Blog - Chategories
@endsection

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Chategories</h1>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Chategories</h6>
            <a href="" class="float-right btn btn-success"  data-toggle="modal" data-target="#addCategoryModal">Add Category</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered w-100" id="categories" >
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>

            </table>
    </div>
    @include('backend.partials.categoryModal')

@endsection



@section('scripts')
    <script type="text/javascript" src="/backend/partials/category.js">
    </script>
@endsection
