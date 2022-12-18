var acontactsmap_execute = function(params){

ymaps.ready(init);
var myMap, 
  myPlacemark;

function init(){ 
    ymaps.geocode(params.city+', '+params.addr).then(function (res) {
        myMap = new ymaps.Map("YMapsID"+params.id, {
            center: res.geoObjects.get(0).geometry.getCoordinates(),
            zoom: 17,
            controls: ["zoomControl", "fullscreenControl"]
        });

    myPlacemark = new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(), {
        hintContent: params.company,
        balloonContent: params.city+', '+ params.addr
    });
            
    myMap.geoObjects.add(myPlacemark);

    }); 
}
}
