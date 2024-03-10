@extends('layouts.layout')
@section('PageTitle')
    Home
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Gardenia - Home
@endsection
@section('PageContent')
    <div id="cover" class="mb-3 d-flex justify-content-center align-items-center text-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4 text-center">Welcome to Gardenia, your local flower shop!</h1>
                </div>
            </div>
        </div>

    </div>
    <div id="products" class="container mb-3">
        <div class="row">
            <h4 class="mb-4 text-center">Check out some of our new products!</h4>
        </div>
        <div class="row">
            <div class="card-group">
                @foreach ($products as $p)
                    <div class="card text-center">
                        <a href="{{ route('products.show', ['id' => $p->id_flower]) }}">
                            <img src="{{ asset($p->image->path) }}" class="card-img-top" alt="{{ $p->image->img_name }}" />
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->flower_name }}</h5>
                            <p class="fw-light">{{ $p->currentPricing->price }}&euro;</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <p class="my-3 text-end">Or visit our <a class="text-decoration-none text-success" href="{{route('products')}}">Products</a> page</p>
        </div>
    </div>
@endsection
