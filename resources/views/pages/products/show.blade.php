@extends('layouts.layout')
@section('PageTitle')
    Products
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Flower shop - Products
@endsection
@section('PageContent')
    <div class="fake-height">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row border rounded py-3">
                        <div class="col-12 col-lg-5">
                            <img src="{{ asset($product->image->path) }}" class="img-fluid"
                                alt="{{ $product->image->img_name }}" />
                        </div>
                        <div class="col-12 col-lg-7 text-end">
                            <h2>{{ $product->flower_name }}</h2>
                            <hr />
                            <p class="fw-bolder">Price: {{ $product->currentPricing->price }}&euro;</p>
                            <h3 class="text-end mb-3">Categories:</h3>

                            @foreach ($product->categories as $c)
                                <p class="fw-light text-end text-capitalize">{{ $c->category_name }}</p>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
