<div id="objectMap-[contact.id]" class="contact-item-map" style="width:100%; height:400px;"></div>
<footer:js>
<script type='text/javascript'>
    ymaps.ready(init);
    function init(){
        var geocoder = new ymaps.geocode('[contact.address]', {
            results: 1
        });
        geocoder.then(function (res) {
            var coord = res.geoObjects.get(0).geometry.getCoordinates();
            var map = new ymaps.Map('objectMap-[contact.id]', {
                center: coord,
                zoom: 14,
                behaviors: ['default', 'scrollZoom']
            });
            var placemark = new ymaps.Placemark(coord, {
                balloonContent: <noempty:[contact.name]>'<h5>[contact.name]</h5></noempty><noempty:[contact.image]><img src="[contact.image]"></noempty><i style="display:inline-block;max-width:200px;">[contact.address]</i>'
            });
            map.geoObjects.add(placemark);
            placemark.balloon.open();        
                    
            map.controls.add('mapTools').add('zoomControl').add('typeSelector');
        });
    }
</script>
</footer:js>
