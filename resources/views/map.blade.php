 
    <script>
        $(document).ready(function (){
            var myLatlng = new google.maps.LatLng({!! $photo->lat !!}, {!! $photo->lng !!});
            var mapOptions = {
                zoom: 12,
                center: myLatlng,
                disableDefaultUI: true

            }
            var map = new google.maps.Map(document.getElementById("map{{$photo->id}}"), mapOptions);

            // Place a draggable marker on the map
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
//            draggable: true,
//            title: "Drag me!"
            });

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById("back-map{{$photo->id}}"));
          
            google.maps.event.addListenerOnce(map, 'idle', function () {
                $("#back-map{{$photo->id}}").fadeIn(100);
            });
            
            $("#map-modal{!! $photo->id !!}").on("shown.bs.modal", function () {
                google.maps.event.trigger(map, "resize");
            });
                
        });
       
    </script>

   <button data-dismiss="modal" style="display:none;" id="back-map{{$photo->id}}" class="btn btn-md btn-primary  btn-map" >
        <span class="glyphicon glyphicon-arrow-left"></span> Back</button>
    <div>
        <section class="map" id="map{{$photo->id}}"></section>
        
       
    </div>
    
