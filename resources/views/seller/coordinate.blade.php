<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>موقعیت رستوران</title>
</head>
<body>

{{--<button onclick="getLocation()">دریافت موقعیت</button>--}}

<form id="locationForm" action="{{ route('set.coordinates') }}" method="post">
    @csrf
    <input type="text" name="title" id="title" placeholder="Title"/>
    <input type="text" name="address" id="address" placeholder="Address"/>
    <input type="hidden" name="latitude" id="latitude" />
    <input type="hidden" name="longitude" id="longitude" />
    <button type="submit">ذخیره</button>
</form>

<div id="map" style="height: 400px;"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // مختصات پیشفرض تهران
    var defaultLocation = [35.6895, 51.3890];

    var mymap = L.map('map').setView(defaultLocation, 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mymap);

    var marker = L.marker(defaultLocation, {
        draggable: true // قابل جابجایی با موس
    }).addTo(mymap);

    // رویداد تغییر موقعیت نشانگر
    marker.on('dragend', function (event) {
        var marker = event.target;
        var position = marker.getLatLng();
        document.getElementById("latitude").value = position.lat;
        document.getElementById("longitude").value = position.lng;
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("مرورگر شما از ویژگی موقعیت جغرافیایی پشتیبانی نمی‌کند.");
        }
    }

    function showPosition(position) {
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;

        // حذف نشانگر قبلی (اگر وجود داشته باشد)
        if (marker) {
            mymap.removeLayer(marker);
        }

        // نمایش موقعیت بر روی نقشه با نشانگر
        marker = L.marker([position.coords.latitude, position.coords.longitude], {
            draggable: true // قابل جابجایی با موس
        }).addTo(mymap);

        // رویداد تغییر موقعیت نشانگر
        marker.on('dragend', function (event) {
            var marker = event.target;
            var position = marker.getLatLng();
            document.getElementById("latitude").value = position.lat;
            document.getElementById("longitude").value = position.lng;
        });

        // زوم به موقعیت فعلی
        mymap.setView([position.coords.latitude, position.coords.longitude], mymap.getZoom());
    }
</script>
</body>
</html>
