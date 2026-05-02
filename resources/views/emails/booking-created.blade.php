<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Baru</title>
</head>
<body>
    <h2>Booking Baru Masuk</h2>
    <p>Berikut detail booking terbaru di Travelin:</p>

    <h3>Data User</h3>
    <ul>
        <li>Nama: {{ $booking->user->name ?? '-' }}</li>
        <li>Email: {{ $booking->user->email ?? '-' }}</li>
    </ul>

    <h3>Data Trip</h3>
    <ul>
        <li>Paket: {{ $booking->trip->name ?? '-' }}</li>
        <li>Tanggal: {{ $booking->travel_date }}</li>
        <li>Jumlah Peserta: {{ $booking->travelers }}</li>
        <li>Total Harga: {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</li>
    </ul>

    <h3>Kontak</h3>
    <ul>
        <li>Nama: {{ $booking->contact_name }}</li>
        <li>Email: {{ $booking->contact_email }}</li>
        <li>Telepon: {{ $booking->contact_phone ?? '-' }}</li>
    </ul>

    @if($booking->notes)
        <h3>Catatan</h3>
        <p>{{ $booking->notes }}</p>
    @endif
</body>
</html>
