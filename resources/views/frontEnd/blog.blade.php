@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Topbar Start -->
    @include('partials.topbar')
    <!-- Topbar End -->

    <!-- Navbar Start -->
    @include('partials.navbar')
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-5" style="max-width: 900px;">
            <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Our Blog</h4>
            <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-primary">Blog</li>
            </ol>    
        </div>
    </div>
    <!-- Header End -->

    <!-- Blog Start -->
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">From Blog</h4>
                <h1 class="display-4 mb-4">News And Updates</h1>
                <p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur adipisci facilis cupiditate recusandae aperiam temporibus corporis itaque quis facere, numquam, ad culpa deserunt sint dolorem autem obcaecati, ipsam mollitia hic.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($blogs as $blog)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset($blog->image) }}" class="img-fluid rounded-top w-100" alt="">
                                <div class="blog-categiry py-2 px-4">
                                    <span>Business</span>
                                </div>
                            </div>
                            <div class="blog-content p-4">
                                <div class="blog-comment d-flex justify-content-between mb-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span> Admin</div>
                                    <div class="small"><span class="fa fa-calendar text-primary"></span> {{ $blog->created_at->format('d M Y') }}</div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span> 0 Comments</div>
                                </div>
                                <a href="{{ route('blog.show', $blog->id) }}" class="h4 d-inline-block mb-3">{{ $blog->title_en }}</a>
                                <p class="mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($blog->text_en), 100) }}</p>
                                <a href="{{ route('blog.show', $blog->id) }}" class="btn p-0">Read More  <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No blog posts found.</p>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
    <!-- Blog End -->

    @include('partials.footer')
@endsection 