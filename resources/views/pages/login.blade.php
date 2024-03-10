@extends('layouts.layout')
@section('PageTitle')
    Login
@endsection
@section('PageKeywords')
    flower, shop, buy, online
@endsection
@section('PageDescription')
    Gardenia- Login
@endsection
@section('PageSpecificScript')
    <script src="{{ asset('assets/js/loginValidation.js') }}" type="text/javascript"></script>
@endsection
@section('PageContent')
    <div class="container fake-height my-3">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6" id="loginErrors">
                @if (session('error-msg'))
                    <div class="alert alert-danger">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">- {{ session('error-msg') }}</li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 py-4 border rounded my-5">
                <h4>Login:</h4>
                <hr />
                <form action="{{ route('performLogin') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail">Email address:</label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail"
                            value="{{ old('loginEmail') }}" />
                    </div>
                    <div class="mb-2">
                        <label for="loginPassword">Password:</label>
                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" />
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <label for="loginStayLoggedIn" class="text-muted fw-light fst-italic me-1">Do you want to stayed
                            logged in? </label>
                        <input class="form-check-input" type="checkbox" name="loginStayLoggedIn" id="loginStayLoggedIn" />
                    </div>
                    <div class="d-flex justify-content-lg-end justify-content-center">
                        <button type="submit" class="btn btn-success" id="submitLogin">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
