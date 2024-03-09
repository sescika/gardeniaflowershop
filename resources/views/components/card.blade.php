<div class="col-lg-{{ $largeSize }} col-md-{{ $mediumSize }} mb-4">
    <div class="card">
       <img class="card-img-top" src="{{ $imgUrl }}"
                alt="{{ $imgAlt }}" />
        <div class="card-body">
            <h4 class="card-title">
                {{$title}}
            </h4>
            <p>{{$description}}</p>
            <p>{{$price}}</p>
        </div>
    </div>
</div>
