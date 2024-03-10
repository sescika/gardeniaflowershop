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
        <div class="row mb-3">
            <div class="col-12">
                @include('pages.admin.fixed.navAdmin')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row mb-3">
                    <div class="col-6">
                        <h4>User Logs:</h4>
                    </div>
                    <div class="col-6">
                        <select name="sortDate" id="sortDate" class="form-select">
                            <option value="desc">Newest</option>
                            <option value="asc">Oldest</option>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="table-responsive" id="userLogsDisplay">
                    {{ $data->links() }}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id:</th>
                                <th>Type:</th>
                                <th>Message</th>
                                <th>Date:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $u)
                                <tr>
                                    <td>{{ $u->id_log }}</td>
                                    <td>{{ $u->type }} {{ $u->last_name }}</td>
                                    <td>{{ $u->message }}</td>
                                    <td>{{ \Carbon\Carbon::parse($u->created_at)->format('d.m.Y | H:i:m') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
