@extends('layouts.app')

@section('content')

<div
    class="min-h-screen bg-slate-100"
    x-data="navigation()"
    x-init="startTracking()"
>

    <div class="relative h-screen">

        <div id="map" class="w-full h-full"></div>

        <div class="absolute top-4 left-4 right-4 z-[1000]">
            <div class="bg-white rounded-2xl shadow-lg p-4">

                <h1 class="font-bold text-lg">
                    Get to your house
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Allow location access so CribSearch can show
                    your position on the map.
                </p>

            </div>
        </div>

        <div class="absolute bottom-5 left-4 right-4 z-[1000]">

            <div class="bg-white rounded-2xl shadow-xl p-5">

                <div class="flex items-center gap-3">

                    <div class="text-2xl">
                        🚶
                    </div>

                    <div>
                        <p class="font-bold">
                            Navigation
                        </p>

                        <p
                            id="distance"
                            class="text-sm text-gray-500"
                        >
                            Finding your location...
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    // const HOUSE_LAT = @json($house->lat);
    // const HOUSE_LNG = @json($house->long);
    const HOUSE_LAT = -1.092688;
    const HOUSE_LNG = 37.021072;

    let map;
    let userMarker;
    let houseMarker;
    let routeLayer = null;

    let lastRouteLat = null;
    let lastRouteLng = null;

    function navigation() {

        return {

            startTracking() {

                map = L.map('map').setView(
                    [HOUSE_LAT, HOUSE_LNG],
                    16
                );

                L.tileLayer(
                    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }
                ).addTo(map);

                houseMarker = L.marker([
                    HOUSE_LAT,
                    HOUSE_LNG
                ])
                .addTo(map)
                .bindPopup('Your house');

                this.trackUser();
            },

            trackUser() {

                if (!navigator.geolocation) {

                    alert(
                        'Location services are not supported.'
                    );

                    return;
                }

                navigator.geolocation.watchPosition(

                    position => {

                        const lat =
                            position.coords.latitude;

                        const lng =
                            position.coords.longitude;

                        this.updateUserLocation(
                            lat,
                            lng
                        );

                    },

                    error => {

                        console.error(error);

                        alert(
                            'Please allow location access.'
                        );

                    },

                    {
                        enableHighAccuracy: true,
                        maximumAge: 3000,
                        timeout: 10000
                    }
                );
            },

            async updateUserLocation(lat, lng) {

                if (!userMarker) {

                    userMarker = L.marker([
                        lat,
                        lng
                    ])
                    .addTo(map)
                    .bindPopup('You are here');

                    const bounds = L.latLngBounds(
                        [lat, lng],
                        [HOUSE_LAT, HOUSE_LNG]
                    );

                    map.fitBounds(bounds, {
                        padding: [80, 80],
                        maxZoom: 16
                    });

                } else {

                    userMarker.setLatLng([
                        lat,
                        lng
                    ]);
                }

                await this.getWalkingRoute(
                    lat,
                    lng
                );
            },

            async getWalkingRoute(lat, lng) {

                if (
                    lastRouteLat !== null &&
                    lastRouteLng !== null
                ) {

                    const moved = map.distance(
                        [lastRouteLat, lastRouteLng],
                        [lat, lng]
                    );

                    if (moved < 20) {
                        return;
                    }
                }

                lastRouteLat = lat;
                lastRouteLng = lng;

                try {

                    const response = await fetch(
                        '/navigation/route',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        .getAttribute(
                                            'content'
                                        )
                            },

                            body: JSON.stringify({

                                start_lat: lat,
                                start_lng: lng,

                                end_lat: HOUSE_LAT,
                                end_lng: HOUSE_LNG

                            })
                        }
                    );

                    const data =
                        await response.json();

                    if (!response.ok) {

                        console.error(data);

                        return;
                    }

                    this.drawRoute(data);

                } catch (error) {

                    console.error(
                        'Route calculation failed:',
                        error
                    );
                }
            },

            drawRoute(data) {

                if (
                    !data.paths ||
                    !data.paths.length
                ) {
                    return;
                }

                const path =
                    data.paths[0];

                const coordinates =
                    path.points.coordinates.map(
                        point => [
                            point[1],
                            point[0]
                        ]
                    );

                if (routeLayer) {
                    map.removeLayer(routeLayer);
                }

                routeLayer =
                    L.polyline(
                        coordinates,
                        {
                            weight: 6,
                            opacity: 0.85
                        }
                    ).addTo(map);

                const distanceKm =
                    (
                        path.distance / 1000
                    ).toFixed(1);

                const minutes =
                    Math.round(
                        path.time / 60000
                    );

                document
                    .getElementById('distance')
                    .innerText =
                        `${distanceKm} km · approximately ${minutes} min`;
            }

        };
    }
</script>

@endsection