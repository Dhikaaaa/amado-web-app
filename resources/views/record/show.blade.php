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
                                <dd class="col-7">{{ $patient[0]['name'] }}</dd>

                                <dt class="col-4">Jenis Kelamin</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient[0]['jenis_kelamin'] }}</dd>

                                <dt class="col-4">No. Telp</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient[0]['phone'] }}</dd>

                                <dt class="col-4">Email</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient[0]['email'] }}</dd>

                                <dt class="col-4">Tanggal Lahir</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient[0]['tanggal_lahir'] }}</dd>

                                <dt class="col-4">Alamat</dt>
                                <dd class="col-1">:</dd>
                                <dd class="col-7">{{ $patient[0]['alamat'] }}</dd>
                            </div>
                        </div>
                        <div class="col-sm">
                            <h2 class="h4 mb-2 font-weight-bold text-primary">Detail Monitoring</h2>
                            <div class="row">
                                <dt class="col-4">Lokasi</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">
                                    {{ $patient[1]['latitude'] }}
                                </dd>
                                <dt class="col-4"></dt>
                                <dd class="col"></dd>
                                <dd class="col-7">
                                    {{ $patient[1]['longitude'] }}
                                </dd>

                                <dt class="col-4">Perangkat</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient[3] }}</dd>

                                <dt class="col-4">Spo2</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient[4]['averrage_spo2'] }}</dd>

                                <dt class="col-4">Status</dt>
                                <dd class="col">:</dd>
                                <dd class="col-7">{{ $patient[4]['status'] }}</dd>
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
        let closeContact = @json($patient[2]);
        let latPatient = @json($patient[1]['latitude']);
        let lonPatient = @json($patient[1]['longitude']);


        // init api key
        const platform = new H.service.Platform({
            apikey: 'X5wdPPV7YALJd-lJEmbgp8evwHrMBrDYpk7WrX1G7bs'
        });

        function addMarkerToGroup(group, coordinate, html) {
            let marker = new H.map.Marker(coordinate);
            // add custom data to the marker
            marker.setData(html);
            group.addObject(marker);
        }

        function addInfoBubble(map, latitude, longitude, nama, alamat, tanggal) {
            let group = new H.map.Group();

            map.addObject(group);

            // add 'tap' event listener, that opens info bubble, to the group
            group.addEventListener('tap', function(evt) {
                // event target is the marker itself, group is a parent event target
                // for all objects that it contains
                let bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
                    // read custom data
                    content: evt.target.getData()
                });
                // show info bubble
                ui.addBubble(bubble);
            }, false);

            addMarkerToGroup(group, {
                    lat: latitude,
                    lng: longitude
                },

                '<div>' + nama + '</div> <hr>' +
                '<div>' + alamat + '</div> <hr>' +
                '<div>' + tanggal + '</div>');
        }

        const defaultLayers = platform.createDefaultLayers();

        const map = new H.Map(document.getElementById('map'),
            defaultLayers.vector.normal.map, {
                center: {
                    lat: latPatient,
                    lng: lonPatient
                },
                zoom: 12,
                pixelRatio: window.devicePixelRatio || 1
            });

        window.addEventListener('resize', () => map.getViewPort().resize());

        const behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

        const ui = H.ui.UI.createDefault(map, defaultLayers);

        closeContact.forEach(element => {
            addInfoBubble(map, element['latitude'], element['longitude'], element['name'], element['address'],
                element['date']
            );
        });

    </script>


@endsection
