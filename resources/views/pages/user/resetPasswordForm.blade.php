@extends('layouts.layout')
@section('PageTitle')
    Password Reset
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Flower shop - reset password
@endsection
@section('PageContent')
    <div class="fake-height">
        <div class="container my-3">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 border rounded p-3">
                    <form action="{{ route('password.update') }}" method="POST" id="updateUserPasswordForm">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" />
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" />
                            <label for="password">New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password_confirmation" />
                            <label for="password_confirmation">Enter New Password Again</label>
                        </div>
                        <input type="hidden" name="token" value="{{$token}}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
