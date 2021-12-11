@extends('backend.layout.master')

@section('title')
    Blog - Tags
@endsection

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tags</h1>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tags</h6>
            <a href="" class="float-right btn btn-success"  data-toggle="modal" data-target="#addTagModal">Add Tag</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered w-100" id="tags" >
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
        @include('backend.partials.tagsModal')

        @endsection



        @section('scripts')
            <script type="text/javascript" src="/backend/partials/tags.js">
            </script>
@endsection
