<?php include 'partials/header.php' ?>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Places Searchbox</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/mapstyle.css">
        <script src="<?php echo base_url();?>assets/js/searchByPlaces.js"></script>
        <!--    <script src="--><?php //echo base_url();?><!--assets/js/jquery.min.js"></script>-->

    </head>

    <div class="container-fluid">
    <h1>Employee Task view</h1>

    <div>
        <input id="pac-input" class="controls" type="text" placeholder="Search">

        <select id ="type">
            <option value="Emp1">Emp1</option>
            <option value="Emp2">Emp2</option>
            <option value="Pharmacy">Emp3</option>
            <option value="Textile">Emp4</option>
        </select>
        <button id="search-by-selection" onclick="getMarker()">Search</button>

    </div>


    <div class="row">
        <div class="col-md-8" >

            <div id="map">
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDccLlV_rbSEOElJchCKxcP8ayVoatGNFc&libraries=places&callback=initAutocomplete"
                        async defer>

                </script>

            </div>



            <div class="col-md-4">

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                <p>Some text in the modal.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>







    <script type="text/javascript">
        //Function For Request Locations from Database
        var type = document.getElementById("type").value;
        function getMarker() {
            var type = 'type';
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/Markers/closest_locations2') ?>?keyword="+type,
                dataType: "json",

                success: function(data) {
                    //When Request Succeeded return Locations from Database;
                    console.log(data);
                    addMarkers(data);

                },
                error: function(){
                    console.log('error');
                }
            });
        }


        function addMarkers(data){

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: new google.maps.LatLng(6.902431,79.861326),
                // scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });


            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < data.length; i++) {
                var coords = [data[i].lat, data[i].lng];
                console.log(coords);
                // console.log(data[i].name)
                var pt = new google.maps.LatLng(parseFloat(coords[0]), parseFloat(coords[1]));
                marker = new google.maps.Marker({
                    position: pt,
                    map: map,
                    address: data[i].address,
                    title: data[i].name
                });


                var contentString = '<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<h1 id="firstHeading" class="firstHeading">'+data[i].name+'</h1>'+
                    '<div id="bodyContent">'+
                    '<p><b>'+data[i].address+'</b></p></br>'+
                    '<p>'+data[i].description+'</p>'+
                    '</div>'+
                    '</div>';

                //marker.setMap(map);
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(
                            '<div id="content">'+
                            '<div id="siteNotice">'+
                            '</div>'+
                            '<h1 id="firstHeading" class="firstHeading">'+data[i].name+'</h1>'+
                            '<div id="bodyContent">'+
                            '<p><b>'+data[i].address+'</b></p></br>'+
                                //  '<p>'+data[i].description+'</p>'+
                                //'<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>'+
                            '</div>'+
                            '</div>'
                        );

                        infowindow.open(map, marker);
                        openModal(data[i].name);

                    }
                })
                (marker, i));


            }

        }

        function openModal(id){
            var EmpID = id;
            // alert(EmpID);


        }



    </script>










<?php include 'partials/footer.php' ?>