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
        <div class="row mb-3">
            <div class="col-12">
                @include('pages.admin.fixed.navAdmin')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-6 col-lg-6">
                        <h4>List of users:</h4>
                    </div>
                    <div class="col-12 col-lg-6 d-flex justify-content-end">
                        <button id="newUserAdminButton" type="button" class="btn btn-success">Register new user</button>
                        <button id="refreshUsers" type="button" class="btn btn-secondary"><i
                                class="fa-solid fa-arrows-rotate"></i></button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="table-responsive" id="userDisplay">
                        {{ $data['users']->links() }}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id:</th>
                                    <th>First / Last Name:</th>
                                    <th>Email:</th>
                                    <th>Role:</th>
                                    <th>Edit:</th>
                                    <th>Delete:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['users'] as $u)
                                    <tr>
                                        <td>{{ $u->id }}</td>
                                        <td>{{ $u->first_name }} {{ $u->last_name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->role->role_name }}</td>
                                        <td>
                                            <button data-id='{{ $u->id }}' type="button" class="btn btnEditUser"><i
                                                    class="fa-regular fa-pen-to-square"></i></button>
                                        </td>
                                        <td>
                                            <button data-id='{{ $u->id }}' type="button"
                                                class="btn btnDeleteUser"><i class="fa-regular fa-trash-can"></i></button>
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
        <h4>Register new user:</h4>
        <hr />
        <form action="{{ route('admin.users.store') }}" method="POST" id="registerUserDialogForm">
            @csrf
            <div class="mb-3">
                <label for="registerEmail">Email address:</label>
                <input type="email" class="form-control" id="registerEmail" name="registerEmail"
                    placeholder="johndoe@gmail.com" value="{{ old('registerEmail') }}" />
            </div>
            <div class="mb-3">
                <label for="registerPassword">Password:</label>
                <input type="password" class="form-control" id="registerPassword" name="registerPassword"
                    value="{{ old('registerPassword') }}" />
            </div>
            <div class="mb-3">
                <label for="registerFirstName">First Name:</label>
                <input type="text" class="form-control" id="registerFirstName" name="registerFirstName"
                    placeholder="John" value="{{ old('registerFirstName') }}" />
            </div>
            <div class="mb-3">
                <label for="registerLastName">Last Name:</label>
                <input type="text" class="form-control" id="registerLastName" name="registerLastName" placeholder="Doe"
                    value="{{ old('registerLastName') }}" />
            </div>
            <div class="mb-3">
                <select class="form-select" id="registerRoleId" name="registerRoleId">
                    <option value="0" selected>Role:</option>
                    @foreach ($data['roles'] as $r)
                        <option value="{{ $r->id_role }}">{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <p class="text-muted font-weight-light font-italic mb-4">Note: Password must contain on letter and one
                number, min 8 characters. </p>
            <div class="d-flex justify-content-lg-between justify-content-center">
                <button type="button" class="btn btn-secondary me-3" id="dialogCloseButton">Close</button>
                <button type="submit" class="btn btn-success" id="editUserDialog">Register new user</button>
            </div>

        </form>
        <div id="registerUserDialogErrors">

        </div>
    </dialog>
@endsection
