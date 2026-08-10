<style scoped>
#body {
    background: var(--bs-gray-100) !important;
    min-height: 100vh;
}
#hero {
    background: var(--bs-gradient-secondary);
    min-height: 30rem;
    margin-top: 6rem;
}
.wake-up-bg::before {
    content: '';
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    position: absolute;
    background: linear-gradient(45deg, var(--bs-primary-lighten), transparent, transparent), url(/assets/images/landing/23-2150489730..webp);
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    filter: blur(2px);
}
#shopping {
    background: linear-gradient(45deg, var(--bs-primary), var(--bs-primary-lighten));
}


.ytframe-wrapper {
    position: relative; 
    padding-bottom: 56.25%; 
    height: 0; 
    overflow: hidden;
}

.ytframe-content {
    position: absolute; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%;
}
</style>

<template>
	<div id="body" class="fsz-16 text-dark">
		<header>
			<nav class="navbar bg-secondary-gradient navbar-expand-lg py-3 fixed-top shadow-sm">
				<div class="container">
					<a class="navbar-brand fw-bold text-gradient fs-3" href="#">
						<img src="/assets/images/logo-land.png" alt="AURA CELLIN" class="avatar-md w-auto" />
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
						<span class="mdi mdi-menu text-white"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav ms-auto text-primary fsz-14">
							<li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
							<li class="nav-item"><a class="nav-link" href="#product">Produk</a></li>
							<li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
        <section id="hero">
            <div class="container d-flex align-items-center h-100">
                <div class="row w-100 h-100 justify-content-between">
                    <div class="col-lg-5 pt-4 pt-lg-0 d-flex flex-column justify-content-center">
                        <h4 class="text-primary">AURA CELLIN</h4>
                        <h1 class="text-primary fsz-42">Kesadaran Baru, Jalan Baru:</h1>
                        <p class="fs-4 text-white">Ubah Cara Hidupmu Sekarang — Atau Selamanya Tetap Begitu!</p>
                        <a :href="`https://wa.me/${user.phone}`" class="btn btn-success btn-lg text-wrap"><i class="mdi mdi-whatsapp"></i> Bergabung Sekarang</a>
                    </div>
                    <div class="col-lg-7 d-flex align-items-end justify-content-end">
                        <img src="/assets/images/hero-1.webp" class="w-100">
                    </div>
                </div>
            </div>
        </section>
        <section id="start" class="section">
            <div class="container">
               <div class="text-center mb-5">
                    <h4 class="text-dark">PEMBUKA</h4>
                    <h1 class="text-secondary">PERTANYAAN YANG MENAMBAK JIWA</h1>
                    <p class="text-muted">“Sibuk setiap hari… tapi masih di tempat yang sama?”</p>
                </div>
                <div class="text-center">
                    <p>Kamu bangun pagi → kerja → pulang → tidur → ulang lagi. Tahun berganti, tapi hidup masih seperti kemarin.</p>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row row-cols-1 row-cols-lg-2 justify-content-center">
                            <div class="col">
                                <CardStart><span>Mimpi besar hanya jadi hiasan dinding.</span></CardStart>
                            </div>
                            <div class="col">
                                <CardStart><span>Tabungan tak pernah tumbuh.</span></CardStart>
                            </div>
                            <div class="col">
                                <CardStart><span>Gaji habis sebelum bulan berakhir.</span></CardStart>
                            </div>
                            <div class="col">
                                <CardStart><span>Menabung 1 juta/bulan? Butuh 83 TAHUN untuk 1 miliar.</span></CardStart>
                            </div>
                            <div class="col">
                                <CardStart><span>Harga hidup naik, pendapatan stagnan.</span></CardStart>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <img src="/assets/images/landing/23-2149692374.webp" alt="23-2149692374" class="w-100 img-cover-center rounded mb-3">
                        <p class="text-center">Masalahnya bukan kamu malas. Masalahnya: kamu belum SADAR ada jalan yang lebih cepat.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="wake-up" class="position-relative section">
            <div class="wake-up-bg"></div>
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">WAKE UP CALL</h4>
                    <h1 class="text-secondary">PUKULAN KESADARAN</h1>
                    <p>⚡ “Kesibukan tanpa arah adalah treadmill kehidupan — bergerak cepat tapi tak ke mana-mana.”</p>
                </div>
                <div class="text-start">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-primary"><i class="mdi mdi-comment-account"></i> Renungkan</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled text-white">
                                        <li>👉 Berhenti sejenak.</li>
                                        <li>👉 Tatap masa depanmu.</li>
                                        <li>👉 Tanyakan: “Kalau aku terus begini, 5 tahun lagi aku akan jadi apa?”</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title text-primary"><i class="mdi mdi-star"></i> Di AURA CELLIN, kami percaya</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled text-white">
                                        <li><i class="text-primary mdi mdi-arrow-right-circle"></i> Kesadaran.</li>
                                        <li><i class="text-primary mdi mdi-arrow-right-circle"></i> Langkah Baru.</li>
                                        <li><i class="text-primary mdi mdi-arrow-right-circle"></i> Sistem.</li>
                                        <li><i class="text-primary mdi mdi-arrow-right-circle"></i> Perubahan Hidup.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="about" class="position-relative section bg-white">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">SOLUSI</h4>
                    <h1 class="text-secondary">AURA CELLIN & PT BGN</h1>
                    <p>🌟 “Kami tidak hanya memberi peluang, kami memberi KENDARAAN MENUJU HIDUP BARU.”</p>
                </div>
                <div class="text-start mb-5">
                    <ul class="list-unstyled">
                        <li>✅ AURA CELLIN: Tempat di mana orang biasa tumbuh luar biasa</li>
                        <li>✅ PT BGN: Perusahaan nasional dengan produk berkualitas & sistem duplikasi</li>
                        <li>✅ Support System Otomatisasi: Teknologi & materi siap pakai yang bekerja 24 jam membangun tim & omset</li>
                        <li>✅ Modal ringan, sistem sederhana, pendampingan langsung</li>
                        <li>✅ Reward nyata, bukan sekadar jualan atau rekrut</li>
                    </ul>
                </div>
                <div class="text-center">
                    <p>🎯 Misi kami: Membantu orang biasa menciptakan penghasilan yang mengubah hidup mereka.</p>
                    <div class="row">
                        <div class="col-lg-3 pb-3">
                            <img src="/assets/images/landing/7861-2558.webp" alt="7861-2558" class="w-100 ar-1-1 img-cover-center rounded">
                        </div>
                        <div class="col-lg-3 pb-3">
                            <img src="/assets/images/landing/640221-316.webp" alt="640221-316" class="w-100 ar-1-1 img-cover-center rounded">
                        </div>
                        <div class="col-lg-3 pb-3">
                            <img src="/assets/images/landing/1048944-3970093.webp" alt="1048944-3970093" class="w-100 ar-1-1 img-cover-center rounded">
                        </div>
                        <div class="col-lg-3 pb-3">
                            <img src="/assets/images/landing/1048944-10325266.webp" alt="1048944-10325266" class="w-100 ar-1-1 img-cover-center rounded">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="benefit" class="position-relative section">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">KEUNTUNGAN</h4>
                    <h1 class="text-secondary">YANG AKAN ANDA DAPATKAN JIKA BERGABUNG</h1>
                    <p>🎁 Manfaat Nyata & Lengkap</p>
                </div>
                <div class="text-start">
                    <div class="row">
                        <div class="col-lg-8">
                            <ol>
                                <li>Ilmu Kesadaran & Mindset Sukses → Cara berpikir yang membuka peluang, bukan menutup pintu.</li>
                                <li>Peluang Usaha Berpotensi Milyaran → Sistem kerja tim & otomatisasi.</li>
                                <li>Ilmu Digital Marketing → Strategi promosi online yang teruji, langsung bisa dipraktekkan.</li>
                                <li>Komunitas Positif & Supportif → Lingkungan yang mendorong pertumbuhan.</li>
                                <li>Mentoring Langsung → Dibimbing oleh leader berpengalaman.</li>
                                <li>Sistem Otomatisasi 24 Jam → Landing page, follow-up, closing berjalan tanpa henti.</li>
                                <li>Akses Pelatihan & Event Eksklusif → Online & offline.</li>
                                <li>Jaringan Bisnis Luas → Partner dari berbagai daerah.</li>
                                <li>Reward & Bonus Menggiurkan → Dari gadget, liburan, hingga rumah & mobil.</li>
                                <li>Bisnis yang Bisa Diturunkan → Aset jangka panjang untuk keluarga.</li>
                            </ol>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-6 pb-3">
                                    <img src="/assets/images/landing/35674-12822.webp" alt="image" class="ar-1-1 w-100 img-cover-center rounded">
                                </div>
                                <div class="col-6 pb-3">
                                    <img src="/assets/images/landing/368093-10480.webp" alt="image" class="ar-1-1 w-100 img-cover-center rounded">
                                </div>
                                <div class="col-6 pb-3">
                                    <img src="/assets/images/landing/23-2149304774.webp" alt="image" class="ar-1-1 w-100 img-cover-center rounded">
                                </div>
                                <div class="col-6 pb-3">
                                    <img src="/assets/images/landing/1048944-26783204.webp" alt="image" class="ar-1-1 w-100 img-cover-center rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="shopping" class="position-relative section">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">POLA BELANJA CERDAS</h4>
                    <h1 class="text-secondary">MESIN PENGHASILAN</h1>
                    <p>💳 “Belanja seperti biasa, tapi kali ini uangnya kembali ke kamu.”</p>
                </div>
                <div class="text-start">
                    <div class="row">
                        <div class="col-lg-5 pb-3 pb-lg-0">
                            <img src="/assets/images/landing/shopping-diagram.png" alt="shopping-diagram" class="w-100 ar-1-1 img-cover-center">
                        </div>
                        <div class="col-lg-7 d-flex align-items-center">
                            <ul class="text-black">
                                <li>Belanja → Produk bernilai → Omset tim → Penghasilan</li>
                                <li>Sistem kolektif: semua saling dorong</li>
                                <li>Tanpa stok berlebihan</li>
                                <li>Tanpa harus jago jualan</li>
                                <li>Support System Otomatisasi: promosi, edukasi, follow-up otomatis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="product" class="position-relative section bg-secondary bg-soft    ">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">PRODUK BERNILAI</h4>
                    <h1 class="text-secondary">HASIL TERBUKTI</h1>
                    <p>🌿 “Produk yang dibutuhkan orang, hasil yang dirasakan nyata.”</p>
                </div>
                <div class="text-start">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/ProtectGen-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>ProtectGen: Minuman Sehat Antioksidan Tinggi</h4>
                                    <ul>
                                        <li>Minuman antioksidan tinggi</li>
                                        <li>Bahan alami</li>
                                        <li>Ekstrak tebu</li>
                                        <li>Menangkal radikal bebas</li>
                                        <li>Daya tahan tubuh</li>
                                        <li>Detoksifikasi</li>
                                        <li>Kesehatan kulit</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/BGN-Mustika-Tani-Pupuk-Serbuk-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>Pupuk Organik Super Mustika Tani Serbuk</h4>
                                    <ul>
                                        <li>Tanah subur &amp; sehat</li>
                                        <li>Biaya produksi lebih murah</li>
                                        <li>Memperpanjang usia tanaman</li>
                                        <li>Tanaman lebih kuat</li>
                                        <li>Hasil berlimpah</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/BGN-Neogoat-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>Neogoat: Sehat & Cantik Alami dari Dalam</h4>
                                    <ul>
                                        <li>Mudah dicerna</li>
                                        <li>Kulit lebih sehat</li>
                                        <li>Kaya nutrisi</li>
                                        <li>Imun tubuh kuat</li>
                                        <li>Rasa creamy</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/BGN-ENBooster-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>EN BOOSTER: Herbal Premium untuk Pemulihan, Energi & Daya Tahan Tubuh</h4>
                                    <ul>
                                        <li>10 Herbal alami terbaik</li>
                                        <li>Aman untuk anak &amp; dewasa</li>
                                        <li>Diproses teknologi modern</li>
                                        <li>Bentuk cair, lebih cepat diserap tubuh</li>
                                        <li>Bersertifikat BPOM, halal &amp; terdaftar resmi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/BGN-Coffeemu-1-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>Coffeemu: Kopi Pria Sejati, Siap Tampil Prima & Perkasa</h4>
                                    <ul>
                                        <li>Rasa nikmat, khas pria dewasa</li>
                                        <li>Bahan berkualitas</li>
                                        <li>Fokus &amp; daya ingat semakin tajam</li>
                                        <li>Dukungan vitalitas menyeluruh</li>
                                        <li>Pilihan pria sejati</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card overflow-hidden h-100">
                                <div class="card-header p-0">
                                    <img src="/assets/images/products/Pupuk-Cair-Mustika-Tani-POC-1-1-500x500.webp" alt="product" class="ar-1-1 w-100 img-cover-center">
                                </div>
                                <div class="card-body bg-white">
                                    <h4>Pupuk Organik Super Mustika Tani Cair</h4>
                                    <ul>
                                        <li>Tanah subur &amp; sehat</li>
                                        <li>Biaya produksi lebih murah</li>
                                        <li>Memperpanjang usia tanaman</li>
                                        <li>Tanaman lebih kuat</li>
                                        <li>Hasil berlimpah</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div v-if="pages['section6.testimoni']" class="col-lg-8">
                            <div class="ytframe-wrapper">
                                <iframe 
                                    :src="pages['section6.testimoni']" 
                                    frameborder="0" 
                                    allowfullscreen 
                                    class="ytframe-content"
                                >
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="system" class="position-relative section bg-white">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">DUKUNGAN</h4>
                    <h1 class="text-secondary">SISTEM YANG MENGANGKATMU</h1>
                    <p>💼 “Bisnis ini dirancang untuk orang sibuk sekalipun.”</p>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <ul class="list-unstyled mb-3">
                            <li>✔️ Bonus dari omset tim</li>
                            <li>✔️ Komunitas aktif & mentor berpengalaman</li>
                            <li>✔️ Edukasi mingguan</li>
                            <li>✔️ Strategi simpel: share – edukasi – closing otomatis</li>
                            <li>✔️ Sistem Otomatisasi berjalan walau kamu tidur</li>
                        </ul>

                        <div v-if="pages['section7.testimoni']" class="ytframe-wrapper">
                            <iframe 
                                :src="pages['section7.testimoni']" 
                                frameborder="0" 
                                allowfullscreen 
                                class="ytframe-content"
                            >
                            </iframe>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <img src="/assets/images/dashboard.webp" alt="dashboard" class="w-100 rounded">
                    </div>
                </div>
            </div>
        </section>
        <section id="chance" class="position-relative section">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">PELUANG</h4>
                    <h1 class="text-secondary">UNTUK SIAPA BISNIS INI?</h1>
                    <p>👥 “Bukan untuk yang sudah puas. Ini untuk yang LAYAK lebih baik.”</p>
                </div>
                <div class="row">
                    <div class="col-lg-6 pb-3">
                        <img src="/assets/images/landing/profession.webp" alt="dashboard" class="w-100 rounded">
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <ul class="list-unstyled">
                            <li>✅ Mahasiswa</li>
                            <li>✅ Ibu rumah tangga</li>
                            <li>✅ Karyawan</li>
                            <li>✅ Pensiunan</li>
                            <li>✅ Siapa pun yang mau mengubah hidup</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="join" class="position-relative section bg-success bg-soft">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">JOIN</h4>
                    <h1 class="text-success">CARA GABUNG & AKTIVASI</h1>
                    <p>🚀 Langkah Bergabung:</p>
                </div>
                <div class="row">
                    <div class="col-lg-7 d-flex align-items-center">
                        <ol class="mb-3">
                            <li>Isi Formulir & Registrasi</li>
                            <li>Dapatkan akun & akses sistem bisnis</li>
                            <li>Masuk komunitas pembinaan</li>
                            <li>Bagikan halaman ini</li>
                            <li>Nikmati hasil dari omset tim + sistem otomatisasi</li>
                        </ol>

                        <div v-if="pages['section9.testimoni']" class="ytframe-wrapper">
                            <iframe 
                                :src="pages['section9.testimoni']" 
                                frameborder="0" 
                                allowfullscreen 
                                class="ytframe-content"
                            >
                            </iframe>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img src="/assets/images/landing/register.webp" alt="register" class="w-100 rounded">
                    </div>
                </div>
            </div>
        </section>
        <section id="closing" class="position-relative section bg-white">
            <div class="container position-relative">
               <div class="text-center mb-5">
                    <h4 class="text-dark">PENUTUP</h4>
                    <h1 class="text-secondary">JANGAN TUNGGU WAKTU YANG “TEPAT”</h1>
                    <p>“Waktu yang tepat tidak akan datang — kamulah yang menciptakannya.”</p>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-unstyled mb-5">
                            <li>📌 Kesadaran tanpa tindakan = tetap di tempat</li>
                            <li>📌 Support System Otomatisasi akan membawamu lebih cepat ke tujuan</li>
                            <li>📌 Jangan fanatik pada cara lama, fanatiklah pada tujuanmu</li>
                        </ul>
                        <p class="text-center">🎯 Saatnya berpindah jalur, bertumbuh, dan bergerak bersama AURA CELLIN.</p>
                        <div class="row mb-3">
                            <div class="col-lg-3 pb-3">
                                <img src="/assets/images/landing/53876-84124.webp" alt="event" class="img-cover-center ar-1-1 w-100 rounded">
                            </div>
                            <div class="col-lg-3 pb-3">
                                <img src="/assets/images/landing/1099133-9214.webp" alt="event" class="img-cover-center ar-1-1 w-100 rounded">
                            </div>
                            <div class="col-lg-3 pb-3">
                                <img src="/assets/images/landing/146671-16288.webp" alt="event" class="img-cover-center ar-1-1 w-100 rounded">
                            </div>
                            <div class="col-lg-3 pb-3">
                                <img src="/assets/images/landing/office.webp" alt="event" class="img-cover-center ar-1-1 w-100 rounded">
                            </div>
                        </div>
                        <div v-if="pages['section10.testimoni']" class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="ytframe-wrapper">
                                    <iframe 
                                        :src="pages['section10.testimoni']" 
                                        frameborder="0" 
                                        allowfullscreen 
                                        class="ytframe-content"
                                    >
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="contact" class="position-relative section bg-secondary-gradient">
            <div class="container text-center">
                <div class="text-white">
                    <div class="d-inline-block mb-3">
                        <img :src="user.photo" class="avatar-lg img-cover-center rounded-circle" alt="Member">
                    </div>
                    <div class="mb-1">{{ user.name }}</div>
                    <div class="fw-bold">{{ user.username }}</div>
                </div>
                <h3 class="my-4 text-primary">
                    <i class="fas fa-fire me-2"></i>
                    Jangan Tunggu Waktu Yang "Tepat"
                </h3>
                
                <div class="mb-4">
                    <a :href="`https://wa.me/${user.phone}`" target="_blank" class="btn btn-success btn-lg">
                        <i class="fab fa-whatsapp me-2"></i>
                        GABUNG SEKARANG
                    </a>
                </div>
                
                <p class="mb-0 text-white">
                    <i class="fas fa-phone me-2"></i>
                    Hubungi orang yang mengirim halaman ini untuk langkah selanjutnya
                </p>
            </div>
        </section>
        <footer class="bg-black text-white py-5">
			<div class="container">
				<div class="row g-4">
					<div class="col-lg-4">
						<img src="/assets/images/logo-land.png" alt="AURA CELLIN" class="img-fluid ht-72 mb-3">
						<p class="text-white mb-4">AURA CELLIN & PT BGN memberikan peluang usaha dengan modal ringan dan sistem otomatis modern, didukung produk berkualitas, pendampingan langsung, serta reward nyata untuk mengantarkan Anda menuju hidup baru.</p>
						<div class="d-flex gap-3">
							<a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
							<a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
							<a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
							<a href="#" class="text-white"><i class="fab fa-telegram fa-lg"></i></a>
						</div>
					</div>
					<div class="col-lg-3">
						<h6 class="fw-bold mb-3 text-white">Bantuan</h6>
						<ul class="list-unstyled">
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Cara Kerja</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">FAQ</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Panduan</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Kontak</a></li>
						</ul>
					</div>
					<div class="col-lg-3">
						<h6 class="fw-bold mb-3 text-white">Perusahaan</h6>
						<ul class="list-unstyled">
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Tim</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Karir</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Blog</a></li>
						</ul>
					</div>
					<div class="col-lg-2">
						<h6 class="fw-bold mb-3 text-white">Legal</h6>
						<ul class="list-unstyled">
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Syarat & Ketentuan</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Kebijakan Privasi</a></li>
							<li class="mb-2"><a href="#" class="text-white text-decoration-none">Disclaimer</a></li>
						</ul>
					</div>
				</div>
				<hr class="my-4 border-secondary" />
				<div class="row align-items-center">
					<div class="col-md-6">
						<p class="mb-0 text-white">&copy; {{ $moment().format('YYYY') }} AURA CELLIN. All rights reserved.</p>
					</div>
					<div class="col-md-6 text-md-end">
						<p class="mb-0 text-white">
							<i class="fas fa-shield-check text-success me-2"></i>
							Secured & Trusted Service
						</p>
					</div>
				</div>
			</div>
		</footer>
	</div>
</template>

<script type="text/javascript">
    export default {
        async asyncData({$axios, params, error}) {
            try {
            let slug = params.slug || "admin";
            const { data: response } = await $axios.get(`ref/${slug}`);
            return response;
        } catch (err) {
            console.log(err);
            let err_msg = '';
            if (err.response) {
                err_msg = err.response.data.message;
            } else {
                err_msg = err.toString();
            }
            error({statusCode: 404, message: err_msg});
        }
        },
        components: {
            CardStart: {
                render() {
                    return (
                        <div class="card border-3 border-0 border-top overflow-hidden border-secondary">
                            <div class="card-body bg-white">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-md ar-1-1 rounded-circle bg-secondary d-flex">
                                        <i class="fsz-24 text-white mdi mdi-emoticon-cry m-auto"></i>
                                    </div>
                                    {this.$slots.default}
                                </div>
                            </div>
                        </div>
                    )
                }
            }
        }
    }
</script>
