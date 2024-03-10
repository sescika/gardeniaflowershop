@extends('layouts.layout')
@section('PageSpecificScript')
    <script src="{{ asset('assets/js/admin.js') }}" type="text/javascript"></script>
@endsection
@section('PageTitle')
    Admin pannel
@endsection
@section('PageKeywords')
    flower, shop, buy, online
@endsection
@section('PageDescription')
    Gardenia - Admin pannel
@endsection
@section('PageContent')
    <div class="container fake-height my-3">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                @if ($errors->any())
                    <div class="alert alert-danger my-3">
                        <ul class="list-group list-group-flush">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">- {{ $error }}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success my-3">
                        <p>{{ session('product-edit-success') }}</p>
                    </div>
                @endif

                @if (session('error-msg'))
                    <div class="alert alert-danger my-3">
                        <p>{{ session('error-msg') }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                @include('pages.admin.fixed.navAdmin')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-6 col-lg-6">
                        <h4>List of products:</h4>
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-end">
                        <button id="newProductAdmin" type="button" class="btn btn-success">Add new product</button>
                        <button id="refreshProducts" type="button" class="btn btn-secondary"><i
                                class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="table-responsive" id="productDisplay">
                        {{ $flowers->links() }}
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Id:</th>
                                    <th>Product Name:</th>
                                    <th>Image:</th>
                                    <th>Price:</th>
                                    <th>Edit:</th>
                                    <th>Delete:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flowers as $u)
                                    <tr>
                                        <td>{{ $u->id_flower }}</td>
                                        <td>{{ $u->flower_name }}</td>
                                        <td> <img src="{{ asset($u->image->path) }}" alt="{{ $u->image->img_name }}"
                                                class="img-small" /></td>
                                        <td class="fw-bold">{{ $u->currentPricing->price }} &euro;</td>
                                        <td>
                                            <button data-id='{{ $u->id_flower }}' type="button"
                                                class="btn btnEditProduct"><i
                                                    class="fa-regular fa-pen-to-square"></i></button>
                                        </td>
                                        <td>
                                            <button data-id='{{ $u->id_flower }}' type="button"
                                                class="btn btnDeleteProduct"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <dialog>
        <h4>Add new product:</h4>
        <hr />
        <form action="{{ route('admin.products.store') }}" method="POST" id="adminProductForm"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="productName">Name</label>
                <input class="form-control" type="text" name="productName" id="productName"
                    value="{{ old('productName') }}" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="productPrice">Price</label>
                <input class="form-control" type="number" step="0.1" min="0" name="productPrice"
                    id="productPrice" value="{{ old('productPrice') }}" />
            </div>
            <div class="mb-3">
                <p>Categories</p>
                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                    @foreach ($categories as $c)
                        <input type="checkbox" name="productCategories[]" class="btn-check " id="cat-{{ $c->id_category }}"
                            value="{{ $c->id_category }}" autocomplete="off"
                            @if (old('productCategories') && in_array($c->id_category, old('productCategories'))) checked @endif />
                        <label class="btn btn-outline-primary"
                            for="cat-{{ $c->id_category }}">{{ $c->category_name }}</label>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <div class="mb-3">
                    <label for="productImage" class="form-label">Image</label>
                    <input class="form-control" type="file" id="productImage" name="productImage" />
                </div>
            </div>
            <div class="mt-5">
                <button type="button" class="btn btn-secondary" id="dialogClose">Close</button>
                <button type="submit" class="btn btn-success" id="submitNewProduct">Save</button>
            </div>

        </form>


    </dialog>
@endsection
