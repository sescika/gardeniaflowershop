@extends('layouts.layout')
@section('PageTitle')
    Register
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy,
@endsection
@section('PageDescription')
    Flower shop - Register
@endsection
@section('PageSpecificScript')
<script src="{{ asset('assets/js/registerValidation.js')}}" type="text/javascript"></script>
@endsection
@section('PageContent')
    <div class="container fake-height">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6" id="registrationErrors">
                @if ($errors->any())
                    <div class="alert alert-danger my-3">
                        <ul class="list-group list-group-flush">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">- {{ $error }}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif

                @if (session('registration-success'))
                    <div class="alert alert-success my-3">
                        <p>{{ session('registration-success') }}</p>
                    </div>
                @endif

                @if (session('registration-error'))
                    <div class="alert alert-danger my-3">
                        <p>{{ session('registration-error') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="row d-flex justify-content-center ">
            <div class="col-12 col-lg-6 border p-3 rounded my-5">
                <h4>Register:</h4>
                <hr />
                <form action="{{ route('register.store') }}" method="POST" id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="johndoe@gmail.com" value="{{ old('email') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="John" value="{{ old('first_name') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Doe" value="{{ old('last_name') }}" />
                    </div>
                    <p class="text-muted font-weight-light font-italic mb-4">Note: Password must contain on letter and one
                        number, min 8 characters. </p>
                    <div class="d-flex justify-content-lg-end justify-content-end">
                        <button type="submit" class="btn btn-success" id="submitRegister">Register</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
