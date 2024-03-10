@extends('layouts.layout')
@section('PageSpecificScript')
    <script src="{{ asset('assets/js/products.js') }}" type="text/javascript"></script>
@endsection
@section('PageTitle')
    Products
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Gardenia Flower shop - Products
@endsection
@section('PageContent')
    <div class="fake-height my-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-2">
                    <div class="mb-3 input-group">
                        <input class='form-control' type="text" name="productsSearch" id="productsSearch" />
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                    <hr>
                    <div class="border rounded p-1" id="categoryFilter">
                        <div class="mb-3">
                            <h4 class="mb-3">Sort by:</h4>
                            <select class='form-select' name="productsSelect" id="productsSelect">
                                <option value="0" @if (old('productsSelect') == '0') selected='selected' @endif>
                                    Select</option>
                                <option value="name-asc" @if (old('productsSelect') == 'name-asc') selected='selected' @endif>Name
                                    A - Z</option>
                                <option value="name-desc" @if (old('productsSelect') == 'name-desc') selected='selected' @endif>Name
                                    Z - A</option>
                                <option value="price-asc" @if (old('productsSelect') == 'price-asc') selected='selected' @endif>Price
                                    Low - High</option>
                                <option value="price-desc" @if (old('productsSelect') == 'price-desc') selected='selected' @endif>
                                    Price
                                    High - Low</option>
                            </select>
                        </div>
                        <hr />
                        <div class="mb-3">
                            <h4 class="mb-3">Category:</h4>
                            <hr />
                            @foreach ($categories as $c)
                                <div class="form-check mb-3">
                                    <input class="form-check-input form-filters" name='form-filters' type="checkbox"
                                        role="switch" id="{{ $c->id_category }}cb" value="{{ $c->id_category }}" />
                                    <label class="form-check-label text-capitalize"
                                        for="{{ $c->id_category }}cb">{{ $c->category_name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <hr />
                    </div>
                </div>
                <div class="col-12 col-md-9 col-lg-10">
                    <div class="row" id="productsDisplay">
                        {{ $products->links() }}
                        @foreach ($products as $p)
                            <div class="col-12 col-md-6 col-lg-4 card-group">
                                <div class="card mb-3  text-center">
                                    <a href="{{ route('products.show', ['id' => $p->id_flower]) }}">
                                        <img src="{{ asset($p->image->path) }}" class="card-img-top"
                                            alt="{{ $p->image->img_name }}" />
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $p->flower_name }}</h5>
                                        <p class="fw-light">{{ $p->currentPricing->price }}&euro;</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
