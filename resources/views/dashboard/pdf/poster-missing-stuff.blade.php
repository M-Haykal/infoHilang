<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster Barang Hilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Source+Sans+3:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        :root {
            --bg: #faf9f7;
            --fg: #1a1a1a;
            --accent: #c41e3a;
            --muted: #6b6b6b;
            --border: #d4d4d4;
            --card: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--bg);
            color: var(--fg);
            margin: 0;
            padding: 0;
        }

        .poster {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 0 auto;
            background: var(--card);
            position: relative;
        }

        .headline-font {
            font-family: 'Bebas Neue', sans-serif;
        }

        .missing-banner {
            background: var(--accent);
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 48px;
            letter-spacing: 12px;
            font-weight: 400;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 2px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .status-hilang {
            background: #fef3c7;
            color: #92400e;
            border: 2px solid #f59e0b;
        }

        .status-ditemukan {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #10b981;
        }

        .status-ditutup {
            background: #e5e7eb;
            color: #374151;
            border: 2px solid #6b7280;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .photo-grid.single {
            grid-template-columns: 1fr;
        }

        .photo-item {
            aspect-ratio: 4/3;
            background: #f5f5f5;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 14px;
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-section {
            margin-bottom: 12px;
        }

        .info-label {
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--fg);
            border-bottom: 1px solid var(--border);
            padding-bottom: 4px;
            min-height: 24px;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .three-col {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        .highlight-box {
            background: #fff8f8;
            border: 2px solid var(--accent);
            padding: 12px;
            margin-top: 12px;
        }

        .contact-box {
            background: var(--fg);
            color: white;
            padding: 14px;
            margin-top: 12px;
        }

        .characteristics-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .characteristics-list li {
            padding: 6px 0;
            border-bottom: 1px dashed var(--border);
            font-size: 14px;
        }

        .characteristics-list li:last-child {
            border-bottom: none;
        }

        .footer-line {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            right: 15mm;
            border-top: 3px solid var(--fg);
            padding-top: 8px;
            text-align: center;
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>

<body>
    <div class="poster">
        <div class="missing-banner headline-font">BARANG HILANG</div>

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; margin-bottom: 10px;">
            <span class="status-badge status-hilang">{{ $barang->status }}</span>
            <span style="font-size: 11px; color: var(--muted);">ID: {{ $barang->slug }}</span>
        </div>

        <div class="two-col">
            <div>
                <div class="photo-grid single">
                    <div class="photo-item" style="aspect-ratio: 3/4;">
                        @if ($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto[0]) }}" alt="Foto Barang">
                        @else
                            FOTO BARANG
                        @endif
                    </div>
                </div>

                @if ($barang->foto && count($barang->foto) > 1)
                    <div class="photo-grid" style="margin-top: 8px;">
                        @foreach (array_slice($barang->foto, 1, 4) as $foto)
                            <div class="photo-item">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Barang {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <div class="info-section">
                    <div class="info-label">Nama Barang</div>
                    <div class="info-value" style="font-size: 22px; border-bottom-width: 2px;">
                        {{ $barang->nama_barang }}
                    </div>
                </div>

                <div class="two-col" style="gap: 10px;">
                    <div class="info-section">
                        <div class="info-label">Jenis</div>
                        <div class="info-value">{{ $barang->jenis_barang }}</div>
                    </div>
                    <div class="info-section">
                        <div class="info-label">Merk</div>
                        <div class="info-value">{{ $barang->merk_barang ?? '-' }}</div>
                    </div>
                </div>

                <div class="two-col" style="gap: 10px;">
                    <div class="info-section">
                        <div class="info-label">Warna</div>
                        <div class="info-value">{{ $barang->warna_barang ?? '-' }}</div>
                    </div>
                    <div class="info-section">
                        <div class="info-label">Dilaporkan</div>
                        <div class="info-value">{{ $barang->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="highlight-box">
                    <div class="info-label" style="color: var(--accent);">Terakhir Dilihat</div>
                    <div style="font-size: 13px; margin-top: 4px;">
                        <strong>{{ $barang->tanggal_terakhir_dilihat ? \Carbon\Carbon::parse($barang->tanggal_terakhir_dilihat)->format('l, d F Y - H:i') : '-' }}</strong>
                    </div>
                    <div style="font-size: 14px; margin-top: 6px;">
                        {{ $barang->lokasi_terakhir_dilihat ?? 'Lokasi tidak diketahui' }}
                    </div>
                </div>

                @if ($barang->ciri_ciri)
                    <div class="info-section" style="margin-top: 12px;">
                        <div class="info-label">Ciri-ciri Khusus</div>
                        <ul class="characteristics-list">
                            @foreach ($barang->ciri_ciri as $ciri)
                                <li>{{ $ciri }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="info-section" style="margin-top: 12px;">
            <div class="info-label">Deskripsi</div>
            <div
                style="font-size: 13px; line-height: 1.5; padding: 8px; background: #f9f9f9; border-left: 3px solid var(--accent);">
                {{ $barang->deskripsi_barang ?? 'Tidak ada deskripsi tambahan.' }}
            </div>
        </div>

        @if ($barang->document_pendukung && count($barang->document_pendukung) > 0)
            <div class="info-section" style="margin-top: 10px;">
                <div class="info-label">Dokumen Pendukung</div>
                <div style="font-size: 12px; color: var(--muted);">
                    @foreach ($barang->document_pendukung as $doc)
                        <span
                            style="display: inline-block; background: #e5e7eb; padding: 3px 8px; margin: 2px; border-radius: 2px;">{{ basename($doc) }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="contact-box">
            <div class="info-label" style="color: #fca5a5;">Jika Menemukan, Hubungi</div>
            @if ($barang->kontak)
                @php $kontak = $barang->kontak; @endphp
                <div style="font-size: 18px; font-weight: 700; margin-top: 6px;">
                    @if (isset($kontak->nama))
                        {{ $kontak->nama }}
                    @endif
                </div>
                <div class="three-col" style="margin-top: 8px; gap: 8px;">
                    @if (isset($kontak->telepon))
                        <div>
                            <div style="font-size: 10px; opacity: 0.7;">Telepon</div>
                            <div style="font-size: 14px; font-weight: 600;">{{ $kontak->telepon }}</div>
                        </div>
                    @endif
                    @if (isset($kontak->email))
                        <div>
                            <div style="font-size: 10px; opacity: 0.7;">Email</div>
                            <div style="font-size: 14px; font-weight: 600;">{{ $kontak->email }}</div>
                        </div>
                    @endif
                    @if (isset($kontak->whatsapp))
                        <div>
                            <div style="font-size: 10px; opacity: 0.7;">WhatsApp</div>
                            <div style="font-size: 14px; font-weight: 600;">{{ $kontak->whatsapp }}</div>
                        </div>
                    @endif
                </div>
            @else
                <div style="font-size: 16px;">Hubungi pelapor melalui aplikasi</div>
            @endif
        </div>

        <div class="footer-line">
            Laporkan ke @{{ config('app.name') }} — Bersama Kita Bisa Membantu
        </div>
    </div>
</body>

</html>