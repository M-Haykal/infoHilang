<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hilang Berhasil Dibuat</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .details {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .details h3 {
            margin-top: 0;
            color: #1e3a8a;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/logo-infoHilang.png') }}" alt="InfoHilang Logo" style="max-width: 150px; margin-bottom: 15px;">
            <h1>Laporan Hilang Berhasil Dibuat</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $user->fullname }}</strong>,</p>
            <p>Laporan Anda tentang <strong>{{ $type }} hilang</strong> telah berhasil kami terima dan dipublikasikan di platform InfoHilang.</p>
            
            <div class="details">
                <h3>Detail Laporan:</h3>
                <p><strong>Nama:</strong> {{ $report->nama_orang ?? $report->nama_hewan ?? $report->nama_barang }}</p>
                <p><strong>Lokasi Terakhir:</strong> {{ $report->lokasi_terakhir_dilihat }}</p>
                <p><strong>Tanggal Terakhir:</strong> {{ $report->tanggal_terakhir_dilihat }}</p>
                <p><strong>Status:</strong> <span style="color: #ef4444; font-weight: bold;">{{ $report->status }}</span></p>
            </div>

            <p>Kami akan memberitahu Anda jika ada informasi terbaru mengenai laporan ini. Semoga segera ditemukan!</p>
            
            @php
                $detailUrl = '#'; // Default fallback
                if($type == 'orang') $detailUrl = route('form-orang-hilang.detail', $report->slug);
                elseif($type == 'hewan') $detailUrl = route('form-hewan-hilang.detail', $report->slug);
                elseif($type == 'barang') $detailUrl = route('form-barang-hilang.detail', $report->slug);
            @endphp

            <a href="{{ $detailUrl }}" class="button">Lihat Detail Laporan</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} InfoHilang. Semua Hak Dilindungi.<br>
            Bantuan? Hubungi kami di <a href="mailto:support@infohilang.com" style="color: #3b82f6;">support@infohilang.com</a>
        </div>
    </div>
</body>
</html>
