<div id="map" class="w-full h-64 mt-4 rounded-lg shadow-inner border"></div>

@push('script')
    <script>
        let map, marker;

        function initMap() {
            const mapContainer = document.getElementById('map');

            if (!map) {
                map = L.map(mapContainer).setView([-6.200000, 106.816666], 10);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                map.on('click', function(e) {
                    const {
                        lat,
                        lng
                    } = e.latlng;
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);

                    if (marker) map.removeLayer(marker);
                    marker = L.marker([lat, lng]).addTo(map);
                });
            }

            // Minta lokasi pengguna
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 13);
                        if (marker) map.removeLayer(marker);
                        marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup("Lokasi Anda Disini").openPopup();
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                    },
                    function(error) {
                        console.warn("Gagal mendapatkan lokasi, gunakan default Jakarta");
                    }
                );
            } else {
                console.warn("Browser tidak mendukung geolocation");
            }

            setTimeout(() => {
                map.invalidateSize();
            }, 800);
        }

        window.addEventListener('load', initMap);
    </script>
@endpush
