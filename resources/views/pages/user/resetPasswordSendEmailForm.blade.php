@extends('layouts.layout')
@section('PageTitle')
    Password Reset Email
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Flower shop - reset password email
@endsection
@section('PageContent')
    <div class="fake-height">
        <div class="container my-3">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 border rounded p-3">
                    <form action="{{ route('user.sendEmail') }}" method="POST" id="updateUserPasswordForm">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" />
                            <label for="email">Enter your email address</label>
                        </div>
                        <div class="d-flex justify-content-lg-end justify-content-end">
                            <button type="submit" class="btn btn-success" id="submitupdateUser">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
