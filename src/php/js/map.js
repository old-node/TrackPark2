/**************************************************************************************
 Fichier :       map.js
 Auteur :        Antoine Gagnon
 Fonctionnalité : Affiche une map de sherbrooke avec tout les parc
 Date :          5 mai 2018
 =======================================================================================
 Vérification :
 Date        Nom                     Approuvé

 =======================================================================================
 Historique de modification :
 Date        Nom                     Description
 2018-05-06	Antoine Gagnon          Création
 **************************************************************************************/


var map;
var infowindow;

function initMap() {

    //La ville au centre
    var sherbrooke = {lat: 45.404, lng: -71.888};

    //Crée une map sur sherbrooke
    map = new google.maps.Map(document.getElementById('map'), {
        center: sherbrooke,
        zoom: 15
    });

    infowindow = new google.maps.InfoWindow();

    //Service qui cherche tout les parc proche
    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: sherbrooke,
        radius: 15000,
        type: ['park']
    }, loadMarkers);
}

/**
 * Appelé quand le service trouve les parcs
 * Crée un marqueur par parc
 * @param results
 * @param status
 */
function loadMarkers(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
        }
    }
}

function createMarker(place) {

    var placeLoc = place.geometry.location;

    var marker = new google.maps.Marker({
        map: map,
        position: placeLoc
    });

    //Event listner qui ouvre affiche le nom quand tu clique sur un marque
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}