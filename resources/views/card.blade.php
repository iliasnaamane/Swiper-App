<div class="swiper-slide slide" data-lat="{!! $card->lat !!}" data-lng="{!! $card->lng !!}" data-id="{!! $card->id !!}">
    <section class="card">
        
             @if($card->type == "landscape")
             <div class="image landscape"
                  style="background: url('/photos/iphone/{!! $card->filename !!}')  center;">
            @else
             <div class="image"
                  style="background: url('/photos/iphone/{!! $card->filename !!}')  top;">

            @endif
                <div class="info container-fluid">
                    <h1>{{ $card->title }}</h1>
                </div>
            </div>
            <div class="back">
                <div class="info info-title container-fluid">
                  <h1 style=""> {{ $card->title }}</h1>
                </div>
                <br><br>
                <h4> {{ $card->description }} </h4>
            </div> 
    </section>
</div>