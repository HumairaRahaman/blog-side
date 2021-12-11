@extends('frontend.layout.master')

@section('meta'){{ $blog->meta ?? ''}}@endsection
@section('title')
    Blog - Blog Detail
@endsection

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/post-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="post-heading">
                        <h1>{{ $blog->title ?? ''}}</h1>



                        <span class="meta mb-3">Category :
              <a href="#" class="badge badge-info">{{ $blog->category->name ?? '' }}</a>
              </span>

                        <span class="meta mb-3">Tags :
                            @foreach($blog->tags as $tag)
              <a href="#" class="badge badge-info">{{ $tag->name ?? '' }}</a>
                            @endforeach
              </span>


                        <span class="meta">Posted by
              <a href="#">{{ $blog->user->name ?? '' }}</a>
              on {{  \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">

                    <blockquote class="blockquote">{{ $blog->short_description ?? '' }}</blockquote>

                   <div class="text-center">
                       <img class="img-fluid rounded" src="{{ asset('/images/blogImages/'.$blog->image) }}" alt="{{ $blog->image_alt ?? '' }}">
                   </div>

                    <p> {!! $blog->description ?? '' !!}</p>

                </div>
            </div>
        </div>
    </article>

    <hr>
@endsection


@section('scripts')
@endsection
