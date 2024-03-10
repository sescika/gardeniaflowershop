@extends('layouts.layout')
@section('PageTitle')
    About Author
@endsection
@section('PageKeywords')
    flowers, flower, shop, buy
@endsection
@section('PageDescription')
    Gardenia - Author
@endsection
@section('PageContent')
    <div class="container fake-height my-3">
        <div class="row">
            <div class="col-12 col-lg-8">
                <ul>
                    <li>Graduate student - ICT College</li>
                    <li>Software Develper</li>
                    <li>Hobbies:
                        <ul>
                            <li>Gaming</li>
                        </ul>
                    </li>
                    <li>Links:
                        <ul>
                            <li><a href="https://www.linkedin.com/in/lazar-pelanovic-321a5927a" target="_blank">Linkedin</a></li>
                            <li><a href="https://github.com/sescika/gardeniaflowershop" target="_blank">Gtihub</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <figure>
                    <img src="{{ asset('assets/img/author.jpg') }}" alt="JA_SLIKA" class="img-fluid" />
                </figure>
            </div>
        </div>
    </div>
@endsection
