// draw all milestones findspots and circles around them if a distance is mentioned in latin text
function initialize() {
    var myLatlng = new google.maps.LatLng(47,11);
    var mapOptions = {
        center: myLatlng,
        zoom: 5,
        maxZoom:11,
        minZoom: 5,
        mapTypeId: "PELAGIOS",
        mapTypeControl: true,
        streetViewControl: false,
        scaleControl:true,
        mapTypeControl: false
    }
    var pelagiosMapOptions = {
        getTileUrl: function(coord, zoom) {
            return "http://pelagios.org/tilesets/imperium/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
        },
        tileSize: new google.maps.Size(256, 256),
        maxZoom: 18
    }
    circles = new Array();
    markers = new Array();
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    map.mapTypes.set("PELAGIOS", new google.maps.ImageMapType(pelagiosMapOptions));
    createAllMarkers();
    drawMarkers();
    drawCircles();
}


function changeMarkerVisibility(){
    // get checkbox status
    var cb_2bc = document.getElementById("cb_2bc");
    var cb_1bc = document.getElementById("cb_1bc");
    var cb_1ad = document.getElementById("cb_1ad");
    var cb_2ad = document.getElementById("cb_2ad");
    var cb_3ad = document.getElementById("cb_3ad");
    var cb_4ad = document.getElementById("cb_4ad");
    var cb_5ad = document.getElementById("cb_5ad");
    var cb_undated = document.getElementById("cb_undated");
    var cb_showCircles = document.getElementById("cb_showCircles");
    for (var i = 0; i < milestones.length; i++) {
        var key = milestones[i][0];
        var cent_a = milestones[i][9];
        var cent_e = milestones[i][10];
            switch(cent_a){
                case "-2":
                    if (cb_2bc.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "-1":
                    if (cb_1bc.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "1":
                    if (cb_1ad.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "2":
                    if (cb_2ad.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "3":
                    if (cb_3ad.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;   
                case "4":
                    if (cb_4ad.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "5":
                    if (cb_5ad.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
                case "":
                    if (cb_undated.checked){
                        markers[key].setMap(map);
                        if (typeof circles[key] !== 'undefined' && cb_showCircles.checked) { circles[key].setMap(map)};
                    } else {
                        markers[key].setMap(null);
                        if (typeof circles[key] !== 'undefined') { circles[key].setMap(null)};
                    }
                    break;
            }
    }
}

function toggleVisibility(c,k){
    if (typeof k !== 'undefined'){
        if (c.checked){
            markers[k].setMap(map);
            if (typeof circles[k] !== 'undefined') { circles[k].setMap(map)};
        } else {
            markers[k].setMap(null);
            if (typeof circles[k] !== 'undefined') { circles[k].setMap(null)};
        }
    } else {
        console.log("undef");
    }
}


// iterates over milestones array & creates markers & circles array
function createAllMarkers(){
    var infowindow = new google.maps.InfoWindow();
    for (var i = 0; i < milestones.length; i++) {
        iconFile = '/images/circle_blue.png'; // blue = default color for marker
        if (milestones[i][8] == "league") {
            iconFile = '/images/circle_red.png'; // leaguestones have red markers
        }
        // draw circle around marker if there is a distance & league/mile unit in markers array for this milestone
        if (milestones[i][7] > 0 ) {
            // calculate radius in meters from roman mile/league
            var r = "";
            milestones[i][8] === "league" ? r = parseInt(milestones[i][7] * 2222.64) : r = parseInt(milestones[i][7] * 1481.76);
            // hdnr are key of assoc. array circles
            circles[milestones[i][0]] = new google.maps.Circle({
                radius: r,
                center: new google.maps.LatLng(milestones[i][1], milestones[i][2]), 
                fillColor: "#f00",
                fillOpacity: .2,
                strokeColor: "#339933",
                strokeOpacity: 0.5
            });
        }
        markers[milestones[i][0]] = new google.maps.Marker({
            position: new google.maps.LatLng(milestones[i][1], milestones[i][2]),
            icon:iconFile,
            map: map
        });
        google.maps.event.addListener(markers[milestones[i][0]], 'click', (function(marker, i) {
            return function() {
                var fotoLinks = "";
                if (typeof milestones[i][4] !== 'undefined' && milestones[i][4] !== ""){
                    var f = milestones[i][4].split(" ");
                    for (var j = 0; j < f.length; j++) {
                        fotoLinks += "<img src='http://edh-www.adw.uni-heidelberg.de/fotos/" + f[j] + ".JPG' style='max-width:150px;max-height:150px;margin-right:1em;margin:top:em'>";
                    }
                } else {
                    fotoLinks = "";
                }
                var contentString = "<a href =\"/edh/inschrift/" + milestones[i][0] + "\">" + milestones[i][0] + "</a> (" + milestones[i][5] + "; " + milestones[i][6] + ")" + "<br>" + milestones[i][3] + "<br><br>" + fotoLinks;
                infowindow.setContent(contentString);
                infowindow.open(map, markers[milestones[i][0]]);
            }
        })(markers[milestones[i][0]], i));
    }
}

function toggleCircles(cb) {
    if (cb.checked){
        drawCircles();
        changeMarkerVisibility();
    } else {
        removeCircles();
    }
}

function drawCircles(){
    var cb_showCircles = document.getElementById("cb_showCircles");
    if (cb_showCircles.checked){
        for (var key in circles) {
            circles[key].setMap(map);
        }
    }
}

function drawMarkers(){
    for (var key in markers) {
        markers[key].setMap(map);
    }
}

function removeCircles(){
    for (var key in circles) {
        circles[key].setMap(null);
    }
}
