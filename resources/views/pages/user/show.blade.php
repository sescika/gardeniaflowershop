@extends('layouts.layout')
@section('PageTitle')
    Profile
@endsection
@section('PageSpecificScript')
    <script src="{{ asset('assets/js/profileValidation.js') }}" type="text/javascript"></script>
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Flower shop - Profile
@endsection
@section('PageContent')
    <div class="fake-height">
        <div class="container border rounded p-3 my-3">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger my-3">
                        <ul class="list-group list-group-flush">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">- {{ $error }}</li>
                            @endforeach

                        </ul>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <figure>
                        <img src="https://placehold.co/300x300" alt="default"
                            class="img-fluid img-thumbnail rounded-circle" />
                    </figure>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active text-uppercase" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="true">Profile Information</button>
                            <button class="nav-link text-uppercase" id="nav-profile-update-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile-update" type="button" role="tab"
                                aria-controls="nav-profile-update" aria-selected="false">update profile</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active pt-2" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab" tabindex="0">
                            <div class="mb-3">
                                <h5 class="text-uppercase">Name:</h5>
                                <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="text-uppercase">Email:</h5>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="mb-4">
                                <h5 class="text-uppercase">Role:</h5>
                                <p>{{ $user->role->role_name }}</p>
                            </div>
                            <div>
                                <p class="text-muted fw-light fst-italic">Member since:
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-2" id="nav-profile-update" role="tabpanel"
                            aria-labelledby="nav-profile-update-tab" tabindex="0">
                            <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="post"
                                id="updateUserInfoForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role_id" value="{{ $user->role_id }}" />
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" />
                                    <label for="email">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ $user->first_name }}" />
                                    <label for="first_name">First Name:</label>

                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ $user->last_name }}" />
                                    <label for="last_name">Last Name:</label>
                                </div>
                                {{-- <div class="mb-3">
                                    <a href="{{ route('user.resetPasswordSendEmailForm') }}">Reset password</a>
                                </div> --}}
                                <div class="d-flex justify-content-lg-end justify-content-end">
                                    <button type="submit" class="btn btn-success" id="submitUpdateUser">Save</button>
                                </div>

                            </form>
                            <div id="updateInfoErros" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
