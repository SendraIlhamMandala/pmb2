<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pendaftaran Pengguna</title>
    <style>
        /* Gaya kontainer */
        .email-container {
            background-color: #f7fafc;
            padding: 20px;
            font-family: Arial, sans-serif;
            max-width: 600px; /* Tambahkan lebar maksimal untuk kontainer */
            margin: 0 auto; /* Pusatkan kontainer */
        }

        /* Gaya judul */
        .email-heading {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            text-align: center; /* Pusatkan teks */
        }

        /* Gaya konten */
        .email-content {
            margin-top: 20px;
            font-size: 16px;
            color: #4a5568;
        }

        /* Gaya tombol */
        .email-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4299e1;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            display: block; /* Jadikan tombol lebar penuh */
            text-align: center; /* Pusatkan teks tombol */
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1 class="email-heading">Pendaftaran Mahasiswa Baru</h1>
        <p style="text-align: center" >
            Pembayaran PMB FISIP UNIGA atas nama {{ $data['name'] }} telah di verifikasi.
        </p>
        <p class="email-content" style="text-align: center">
            silahkan klik tombol dibawah untuk melanjutkan ke tahap selanjutnya:
        </p>
     
        <a class="email-button" href="{{route('dashboard')}}">Lanjutkan</a>
    </div>
</body>
</html>
