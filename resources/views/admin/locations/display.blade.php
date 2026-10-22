<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR {{ $location->name }} - Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="text-center">
    <h3 class="mb-1">{{ $location->name }}</h3>
    <p class="text-muted mb-4">Arahkan kamera aplikasi Absensi QR ke kode di bawah ini</p>
    <div id="qr-container" class="bg-white p-4 rounded d-inline-block">
        <p class="text-dark">Memuat QR...</p>
    </div>
    <p class="mt-3">Kode akan berganti otomatis dalam <span id="countdown">--</span> detik</p>
</div>

<script>
const refreshUrl = "{{ route('admin.locations.refresh', $location) }}";
let countdownTimer = null;

async function loadQr() {
    const res = await fetch(refreshUrl, { headers: { 'Accept': 'application/json' } });
    const data = await res.json();

    document.getElementById('qr-container').innerHTML = atob(data.qr_svg_base64);

    let secondsLeft = Math.max(0, data.expires_in);
    if (countdownTimer) clearInterval(countdownTimer);

    countdownTimer = setInterval(() => {
        secondsLeft -= 1;
        document.getElementById('countdown').innerText = secondsLeft;
        if (secondsLeft <= 0) {
            clearInterval(countdownTimer);
            loadQr(); // Ambil token baru begitu yang lama kedaluwarsa
        }
    }, 1000);
}

loadQr();
</script>
</body>
</html>
