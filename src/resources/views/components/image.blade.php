@if(isset($image))
    <picture>
        @foreach($resizes as $resize)
            <source media="({{$resize->media}})" srcset="{{Storage::url($resize->srcset)}}">
        @endforeach
        <img src="{{$image->url()}}" alt="{{$image->alt}}">
    </picture>
@endif
