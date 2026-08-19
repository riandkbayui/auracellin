<?= $this->extend('email/template') ?>
<?= $this->section('content') ?>
<p class="mb-0">YTH <?= "<b>{$name}</b> ({$username})" ?></p>
<p class="mt-0">Kami ingin memberitahukan bahwa kami menerima permintaan untuk mereset kata sandi akun anda.</p>
<p>Silakan klik tombol berikut untuk mengatur ulang password anda :</p>
<div style="text-align: center; margin: 2rem 0px;">
<?= anchor($link, "Lupa Sandi", ["title"=>"Lupa Sandi", "style"=>'
    background: #270606;
    color: white;
    padding: 0.75rem;
    border-radius: 0.75rem;
    text-decoration: none;
    display: inline-block;
    width: 170px;
']) ?>
</div>
<p>Jika Anda merasa tidak melakukan permintaan ini, mohon segera menghubungi kami melalui kontak yang telah disediakan.</p>
<?= $this->endSection() ?>