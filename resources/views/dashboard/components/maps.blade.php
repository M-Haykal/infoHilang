<div id="wilayah-selector" class="hidden space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
        <select id="provinsi" class="w-full px-3 py-2 border rounded">
            <option value="">Pilih Provinsi</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Kabupaten / Kota</label>
        <select id="kabupaten" class="w-full px-3 py-2 border rounded" disabled>
            <option value="">Pilih Kabupaten/Kota</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
        <select id="kecamatan" class="w-full px-3 py-2 border rounded" disabled>
            <option value="">Pilih Kecamatan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Kelurahan / Desa</label>
        <select id="kelurahan" class="w-full px-3 py-2 border rounded" disabled>
            <option value="">Pilih Kelurahan/Desa</option>
        </select>
    </div>
    <button type="button" id="use-wilayah"
        class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50" disabled>
        Gunakan Lokasi Ini
    </button>
</div>
<button type="button" id="toggle-wilayah" class="text-sm text-blue-600 hover:underline mb-4">
    Pilih dari daftar wilayah (lebih akurat)
</button>
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

            const map = L.map(mapContainer).setView([defaultLat, defaultLng], 10);

            const satellite = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri'
                }
            );

            const labels = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Labels &copy; Esri',
                    pane: 'overlayPane' // penting: agar tidak menutupi satelit
                }
            );

            satellite.addTo(map);

            labels.addTo(map);

            let marker = L.marker([defaultLat, defaultLng]).addTo(map)
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

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-wilayah');
            const manualLoc = document.getElementById('manual-location');
            const wilayahSel = document.getElementById('wilayah-selector');
            const lokasiInput = document.getElementById('lokasi_terakhir_dilihat');

            const provinsi = document.getElementById('provinsi');
            const kabupaten = document.getElementById('kabupaten');
            const kecamatan = document.getElementById('kecamatan');
            const kelurahan = document.getElementById('kelurahan');
            const useBtn = document.getElementById('use-wilayah');

            let wilayahData = {
                provinsi: null,
                kabupaten: null,
                kecamatan: null,
                kelurahan: null
            };

            // Toggle tampilan
            toggleBtn.addEventListener('click', () => {
                if (wilayahSel.classList.contains('hidden')) {
                    loadProvinces();
                    wilayahSel.classList.remove('hidden');
                    manualLoc.classList.add('hidden');
                } else {
                    wilayahSel.classList.add('hidden');
                    manualLoc.classList.remove('hidden');
                }
            });

            // Load provinsi
            async function loadProvinces() {
                try {
                    const res = await fetch('/wilayah/provinces');
                    if (!res.ok) throw new Error('API error');
                    const data = await res.json();
                    wilayahData.provinsi = data;
                    populateSelect(provinsi, data, 'Pilih Provinsi');
                } catch (e) {
                    alert('Gagal memuat daftar provinsi. Gunakan input manual.');
                    wilayahSel.classList.add('hidden');
                    manualLoc.classList.remove('hidden');
                }
            }

            // Isi select
            function populateSelect(select, data, placeholder) {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.code;
                    opt.textContent = item.name;
                    select.appendChild(opt);
                });
            }

            // Event: Pilih provinsi
            provinsi.addEventListener('change', async () => {
                kabupaten.disabled = true;
                kecamatan.disabled = true;
                kelurahan.disabled = true;
                useBtn.disabled = true;

                if (!provinsi.value) return;

                try {
                    const res = await fetch(`/wilayah/regencies/${provinsi.value}`);
                    if (!res.ok) throw new Error('Gagal ambil kabupaten');
                    const data = await res.json();
                    wilayahData.kabupaten = data;
                    populateSelect(kabupaten, data, 'Pilih Kabupaten/Kota');
                    kabupaten.disabled = false;
                } catch (e) {
                    alert('Gagal memuat kabupaten.');
                }
            });

            // Event: Pilih kabupaten
            kabupaten.addEventListener('change', async () => {
                kecamatan.disabled = true;
                kelurahan.disabled = true;
                useBtn.disabled = true;

                if (!kabupaten.value) return;

                try {
                    const res = await fetch(`/wilayah/districts/${kabupaten.value}`);
                    if (!res.ok) throw new Error('Gagal ambil kecamatan');
                    const data = await res.json();
                    wilayahData.kecamatan = data;
                    populateSelect(kecamatan, data, 'Pilih Kecamatan');
                    kecamatan.disabled = false;
                } catch (e) {
                    alert('Gagal memuat kecamatan.');
                }
            });

            // Event: Pilih kecamatan
            kecamatan.addEventListener('change', async () => {
                kelurahan.disabled = true;
                useBtn.disabled = true;

                if (!kecamatan.value) return;

                try {
                    const res = await fetch(`/wilayah/villages/${kecamatan.value}`);
                    if (!res.ok) throw new Error('Gagal ambil kelurahan');
                    const data = await res.json();
                    wilayahData.kelurahan = data;
                    populateSelect(kelurahan, data, 'Pilih Kelurahan/Desa');
                    kelurahan.disabled = false;
                } catch (e) {
                    alert('Gagal memuat kelurahan.');
                }
            });

            // Event: Pilih kelurahan
            kelurahan.addEventListener('change', () => {
                useBtn.disabled = !kelurahan.value;
            });

            // Gunakan lokasi terpilih
            // Gunakan lokasi terpilih → tambahkan ke input yang sudah ada
            useBtn.addEventListener('click', () => {
                const prov = wilayahData.provinsi.find(p => p.code === provinsi.value)?.name || '';
                const kab = wilayahData.kabupaten.find(k => k.code === kabupaten.value)?.name || '';
                const kec = wilayahData.kecamatan.find(k => k.code === kecamatan.value)?.name || '';
                const kel = wilayahData.kelurahan.find(k => k.code === kelurahan.value)?.name || '';

                const alamatWilayah = [kel, kec, kab, prov].filter(Boolean).join(', ');
                const lokasiSaatIni = lokasiInput.value.trim();

                // Gabungkan: jika sudah ada isi, tambahkan koma + alamat wilayah
                if (lokasiSaatIni) {
                    lokasiInput.value = `${lokasiSaatIni}, ${alamatWilayah}`;
                } else {
                    lokasiInput.value = alamatWilayah;
                }

                manualLoc.classList.remove('hidden');
                wilayahSel.classList.add('hidden');
            });
        });
    </script>
@endpush
