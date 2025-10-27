<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poster Orang Hilang</title>
    <link rel="stylesheet" href="{{ public_path('build/assets/app-55865bb1.css') }}">
    <style>
        body {
            background: white;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 40px;
            text-align: center;
        }

        h1 {
            color: red;
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 20px;
            letter-spacing: 3px;
        }

        .photo {
            width: 400px;
            height: 400px;
            border: 3px solid black;
            margin: 0 auto 20px;
            overflow: hidden;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h2 {
            color: red;
            font-size: 1.8rem;
            font-weight: 900;
            margin: 15px 0 5px;
        }

        h3 {
            font-size: 1.6rem;
            font-weight: bold;
            margin: 8px 0;
        }

        p {
            margin: 6px 0;
            font-size: 1rem;
        }

        .info {
            font-size: 0.9rem;
            color: #444;
            max-width: 600px;
            margin: 10px auto;
            line-height: 1.4;
        }

        .footer {
            color: red;
            font-size: 1.6rem;
            font-weight: 900;
            margin-top: 25px;
            letter-spacing: 1px;
        }

        .details {
            font-size: 1rem;
            margin: 10px auto;
            max-width: 650px;
            line-height: 1.4;
        }

        .details strong {
            color: #000;
        }
    </style>
</head>

<body>

    <h1>Dicari Orang Hilang</h1>

    <div class="photo">
        <img src="{{ public_path('storage/' . ($orangHilang->foto[0] ?? 'default.jpg')) }}"
            alt="{{ $orangHilang->nama_orang }}">
    </div>

    <h2>Apakah Anda Pernah Melihat Orang ini?</h2>

    <h3>{{ $orangHilang->nama_orang }}</h3>

    <div class="details">
        <p>
            Jenis Kelamin: {{ $orangHilang->jenis_kelamin }}, Umur: {{ $orangHilang->umur }} tahun, @if (!empty($ciriList)){{ $ciriList }}@endif
        </p>
    </div>

    <p class="info">
        {{ $orangHilang->deskripsi_orang }}
    </p>

    <p class="info">
        Jika Anda Memiliki Informasi atau Pernah Melihat {{ strtoupper($orangHilang->nama_orang) }}, Harap Segera
        Hubungi Kontak ini: {{ $kontakList }}
    </p>

    <p class="footer">PLEASE - INFORMATION NEEDED</p>

</body>

</html>
