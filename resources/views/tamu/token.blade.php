<div class="container-fluid bg-success-custom py-3 border border-1 shadow shadow-1 mt-2">
    <h1 class="text-danger"><i class="fas fa-exclamation-circle"></i> Guest Mode</h1>
    <p>Sayang sekali, Beberapa dokumen tidak bisa kamu download karena kamu sekarang sedang berada pada Mode Tamu (tanpa hak akses).</p>
    <p>Silakan masukkan token anda untuk beralih ke Mode Tamu (hak akses)</p><hr>
    <p>Jangan khawatir !. Hubungi <a href="https://wa.me/{{$init->no_wa}}?text=Halo%20Admin%2C%20Saya%20ingin%20meminta%20Dokumen%0A%0ANama%20Saya%20%3A%20(Nama)%20%0AAsal%20%20%20%20%20%20%3A%20(Asal)%0AKeperluan%20%3A%20(Keperluan)%0ADokumen%20%3A%20(nama%20dokumen)" target="_blank">admin</a> untuk mendapatkan token mu. Terima Kasih</p>
</div>

<div class="container-fluid mt-3">
    <form action="{{route('tamu.token')}}", method="post">
        @csrf
        <label for="token" class="form-label">Masukan Token hak akses untuk mendownload dokumen yang dibutuhkan</label>
        <div class="form-group d-flex">
            <input type="text" class="form-control" id="token" placeholder="Token Hak Akses" name="remember_token">
            <button class="btn btn-primary">Token</button>
        </div>
    </form>
</div>