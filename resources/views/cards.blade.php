 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzHT8FHOLdWbUMScePYrMCzIe42ETYIgQ"></script>
@if($photos)
    @include('navbar')
@endif

@if(count($photos))
    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->

            @foreach($photos as $card)
                @include("card", $card)
            @endforeach


        </div>
    </div>
@else
    <div class="container text-center">
        <p style="margin-top: 45vh; color: white;">We have no cards yet, <a class="btn btn-primary" href="{!! route('photos.create') !!}"><span class="glyphicon glyphicon-circle-arrow-right"></span> Upload</a> right
            now!</p>
    </div>
@endif

<script>
    
    var page = 1;

    var mySwiper = new Swiper('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        swipeToggle: function(swipeStatus){
       	   this.allowSwipeToPrev = swipeStatus;
           this.allowSwipeToNext = swipeStatus;
           
       	},
        onReachEnd: function(swiper) {              
           
            $.getJSON("{!! route('photos.json') !!}?page="+page, function(data){
                if(data.length)  {
                    swiper.appendSlide(data);
                    $('.swiper-slide').each(function(){
                        var photoId = $(this).data("id");
                        if($("#modals .swiper-slide").data("id") != photoId ) {

                            $('#modals').append('<div class="modal fade modal-lg map-modal" id="map-modal'+photoId+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"></div> <!-- /.modal-content --></div> <!-- /.modal-dialog --></div> <!-- /.modal -->')
                        }

                    }); 
                    page++;    
                }                   
                         
            }); 
                               
        },
      /* onReachBeginning: function(swiper) {             
           if (currentSlide) {
                $.getJSON("{!! route('previous.json') !!}?currentSlide="+currentSlide, function(data){
                    if(data.length) {
                        swiper.prependSlide(data);   
                        page--;
                    }                     
                                     
                });     
           }
                    
                  
        },*/
        onTransitionEnd: function(swiper) {
            var lat = $(".swiper-slide-active").data("lat");
            var lng = $(".swiper-slide-active").data("lng");
            if(lat != "" && lng !="") {
                $("#mapLink").parent().show();
                $("#mapLink").attr("href", "/map/" + $(".swiper-slide-active").data("id"));
               $("#mapLink").attr("data-toggle","modal");
                $("#mapLink").attr("data-target","#map-modal"+$(".swiper-slide-active").data("id"));
            } else {
                $("#mapLink").parent().hide();
            }
        },
        onTap: function(swiper, event) {
            
            $('.card').toggleClass('show_info');
             if (this.allowSwipeToNext == true){
             	this.swipeToggle(false);
             }
             else {
             	this.swipeToggle(true);
             }       
        }
    });
    
    mySwiper.onTransitionEnd(mySwiper);


</script>


<div id="modals">
    @foreach($photos as $card)
       <div class="modal fade modal-lg map-modal" id="map-modal{{$card->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
               </div> <!-- /.modal-content -->
           </div> <!-- /.modal-dialog -->
       </div> <!-- /.modal -->
    @endforeach
</div>
