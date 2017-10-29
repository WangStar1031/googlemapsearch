<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>

    <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0AzerNvCabczIm9EO3dsQHWKJCLXdc_k&callback=initMap">
    </script>
  </body>
</html>

<!-- 
<markers>
<marker id="1" name="Billy Kwong" address="1/28 Macleay Street, Elizabeth Bay, NSW" lat="-33.869843" lng="-151.225769" type="restaurant"/>
<marker id="2" name="Love.Fish" address="580 Darling Street, Rozelle, NSW" lat="-33.861034" lng="151.171936" type="restaurant"/>
<marker id="3" name="Young Henrys" address="76 Wilford Street, Newtown, NSW" lat="-33.898113" lng="151.174469" type="bar"/>
<marker id="4" name="Hunter Gatherer" address="Greenwood Plaza, 36 Blue St, North Sydney NSW" lat="-33.840282" lng="151.207474" type="bar"/>
<marker id="5" name="The Potting Shed" address="7A, 2 Huntley Street, Alexandria, NSW" lat="-33.910751" lng="151.194168" type="bar"/>
<marker id="6" name="Nomad" address="16 Foster Street, Surry Hills, NSW" lat="-33.879917" lng="151.210449" type="bar"/>
<marker id="7" name="Three Blue Ducks" address="43 Macpherson Street, Bronte, NSW" lat="-33.906357" lng="151.263763" type="restaurant"/>
<marker id="8" name="Single Origin Roasters" address="60-64 Reservoir Street, Surry Hills, NSW" lat="-33.881123" lng="151.209656" type="restaurant"/>
<marker id="9" name="Red Lantern" address="60 Riley Street, Darlinghurst, NSW" lat="-33.874737" lng="151.215530" type="restaurant"/>
</markers> -->