@extends('_layouts.app')

@section('head')
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
@endsection

@section('title', 'Rekam Medis')

@section('content')

    <div class="row">
        <div class=" col-lg-6 mb-8">
            <img src="" class="img-fluid rounded">
        </div>
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h2 class="h6 m-0 font-weight-bold text-primary">Data Rekam Medis</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <img src="{{ asset('storage/profiles/profile.jpg') }}" style="width: 300px;" alt="">
                        </div>
                        <div class="col-sm">
                            <h2 class="h4 mb-2 font-weight-bold text-primary">Biodata</h2>
                            <div class="row">
                                <dt class="col-4">Nama</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient->user['name'] }}</dd>

                                <dt class="col-4">Jenis Kelamin</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient->user['jenis_kelamin'] }}</dd>

                                <dt class="col-4">No. Telp</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient->user['phone'] }}</dd>

                                <dt class="col-4">Email</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient->user['email'] }}</dd>

                                <dt class="col-4">Tanggal Lahir</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient->user['tanggal_lahir'] }}</dd>

                                <dt class="col-4">Alamat</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient->user['alamat'] }}</dd>
                            </div>
                        </div>
                        <div class="col-sm">
                            <h2 class="h4 mb-2 font-weight-bold text-primary">Detail Monitoring</h2>
                            <div class="row">
                                <dt class="col-4">Lokasi</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">
                                    {{ $patient->monitoring_location['latitude'] }}
                                </dd>
                                <dt class="col-4"></dt>
                                <dd class="col"></dd>
                                <dd class="col-7">
                                    {{ $patient->monitoring_location['longitude'] }}
                                </dd>

                                <dt class="col-4">Perangkat</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient->device_type }}</dd>

                                <dt class="col-4">Spo2</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient->monitoring_result['averrage_spo2'] }}</dd>

                                <dt class="col-4">Status</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient->monitoring_result['status'] }}</dd>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <h2 class="h4 mb-2 font-weight-bold text-center text-primary">Kontak Erat</h2>
                            <div class="row">
                                <div class="container">
                                    <div id="map" style="width:auto;height:400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="{{ route('record.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        //Begin geocoding
        const lat = '-8.455762646839869';
        const long = '114.26299020120373';

        // let test = {{ json_encode($patient->close_contact[0]) }};
        // let parse = JSON.parse(test.replace(/&quot;/, '"'));
        // console.log(parse);


        // init api key
        const platform = new H.service.Platform({
            apikey: 'X5wdPPV7YALJd-lJEmbgp8evwHrMBrDYpk7WrX1G7bs'
        });
        // instance seaarch service
        const service = platform.getSearchService();

        const defaultLayers = platform.createDefaultLayers();
        const map = new H.Map(document.getElementById('map'),
            defaultLayers.vector.normal.map, {
                center: {
                    lat: lat,
                    lng: long
                },
                zoom: 12,
                pixelRatio: window.devicePixelRatio || 1
            });

        // Create a marker icon from an image URL:
        var icon = new H.map.Icon('https://i.ibb.co/Yjwq79f/contacts-512.png');

        // resize event maps
        window.addEventListener('resize', () => map.getViewPort().resize());
        // behavior
        const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

        //set default ui
        const ui = H.ui.UI.createDefault(map, defaultLayers);


        // Call the reverse geocode method with the geocoding parameters,
        // the callback and an error callback function (called if a
        // communication error occurs):
        service.reverseGeocode({
            at: `${lat},${long}`
        }, (result) => {
            result.items.forEach((item) => {
                // Assumption: ui is instantiated
                // Create an InfoBubble at the returned location with
                // the address as its contents:
                ui.addBubble(new H.ui.InfoBubble(item.position, {
                    content: item.address.label
                }));
            });
        }, alert);


        // set zoom tools
        var mapSettings = ui.getControl('mapsettings');
        var zoom = ui.getControl('zoom');
        var scalebar = ui.getControl('scalebar');
        mapSettings.setAlignment('top-left');
        zoom.setAlignment('top-left');
        scalebar.setAlignment('top-left');

        service.reverseGeocode({
            at: lat + ',' + long
        }, (result) => {
            result.items.forEach((item) => {
                map.addObject(new H.map.Marker(item.position));
            });
        }, alert);


        window.onload = function() {
            addMarkersToMap(map);
        }


        function addMarkersToMap(map) {
            var romeMarker = new H.map.Marker({
                lat: -8.397131138390339,
                lng: 114.27665545941093
            });
            map.addObject(romeMarker);

            var berlinMarker = new H.map.Marker({
                lat: -8.320451050603433,
                lng: 114.28788258711977
            });
            map.addObject(berlinMarker);

            var madridMarker = new H.map.Marker({
                lat: -8.43762384076669,
                lng: 114.32653985633021
            });
            map.addObject(madridMarker);
        }

    </script>


@endsection
