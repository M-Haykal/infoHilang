<!-- Map Lokasi -->
<div id="map" class="w-full h-64 mt-4 rounded-lg shadow-inner border"></div>

@push('script')
    <script>
        let map, marker;

        function initMap() {
            const mapContainer = document.getElementById('map');
            if (!mapContainer) return;

            const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.200000;
            const defaultLng = parseFloat(document.getElementById('longitude').value) || 106.816666;

            map = L.map(mapContainer).setView([defaultLat, defaultLng], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([defaultLat, defaultLng]).addTo(map)
                .bindPopup("Klik untuk ubah lokasi").openPopup();

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Lokasi dipilih").openPopup();
            });

            setTimeout(() => map.invalidateSize(), 800);
        }

        window.addEventListener('load', initMap);
    </script>
@endpush
