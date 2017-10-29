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
      #searchBox{
        position: absolute;
        top: 50px;
        left: 20px;
      }
      #myInput {
        float: left;
        width: 200px;
        font-size: 16px;
        padding: 12px 20px 12px 12px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    #myUL {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #myUL li a {
        border: 1px solid #ddd;
        margin-top: -1px;
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        color: black;
        display: block;
    }

    #myUL li a:hover:not(.header) {
        background-color: #eee;
    }
    #myBtn{
      float: left;
      font-size: 32px;
      margin: 1px;
      cursor: pointer;
    }
		</style>
	</head>

	<body>
		<div id="map"></div>
    <div id="searchBox">
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
      <p id="myBtn" onclick="onMyBtnClicked()">&#9914</p>
      <div style="clear: both;"></div>
      <ul id="myUL">        
      </ul>
    </div>
		<script src="jquery.min.js"></script>
		<script>
      var map = null;
      var arrUserNames = [];
      var markers = [];
			var customLabel = {
				restaurant: {
					label: 'R'
				},
				bar: {
					label: 'B'
				},
        selected: {
          label: 'S'
        }
			};
      var isShow = true;
      function onMyBtnClicked(){
        isShow = !isShow;
        if( !isShow){
          $("#myBtn").html("&#9915");
          $("#myUL").css("display","none");
        }
        else {
          $("#myBtn").html("&#9914");
          $("#myUL").css("display","block");
        }

      }
      function myFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById('myInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName('li');

        for (i = 0; i < li.length; i++) {
          a = li[i].getElementsByTagName("a")[0];
          if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
          } else {
              li[i].style.display = "none";
          }
        }
      }
      function listClicked(elem){
        console.log(elem);
        var name = $(elem).find("a").html();
        console.log(name);
        var nIndex = arrUserNames.indexOf(name);
        for( var i = 0; i < markers.length; i++){
          if( i == nIndex)
            markers[i].setAnimation(google.maps.Animation.BOUNCE);
          else
            markers[i].setAnimation(null);
        }
        if( map != null){
          map.setCenter( markers[nIndex].position);
        }
      }
      function usersToMap(map,infoWindow, userId){
        jQuery.ajax({
          type: 'POST',
          url: 'getUserLocation.php',
          dataType: 'json',
          data: { userId:0},
          success: function(obj, textstatus){
            arrUserInfos = obj;
            arrUserNames = [];
            for( i = 0; i < arrUserInfos.length; i ++){
              var userInfo = arrUserInfos[i];
              var id = userInfo.Id;
              var name = userInfo.Name;
              arrUserNames.push(name);
              var point = new google.maps.LatLng( userInfo.Lat, userInfo.Lang);
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name;
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
              var icon = customLabel[0] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              markers.push(marker);
              strHtml = '<li onclick="listClicked(this)"><a href="#">'+name+'</a></li>';
              $("#myUL").append(strHtml);
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            }
          }
        })
      }
			function initMap() {
  			map = new google.maps.Map(document.getElementById('map'), {
  				center: new google.maps.LatLng(-33.863276, 151.207977),
  				zoom: 8
  			});
  			var infoWindow = new google.maps.InfoWindow;
        usersToMap(map,infoWindow, 0);
			}
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