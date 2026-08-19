<template>
	<div class="ac-landing">
		<!-- ========== NAVIGATION ========== -->
		<nav id="acNavbar" class="navbar navbar-expand-lg fixed-top ac-navbar">
			<div class="container">
				<a class="navbar-brand" href="#hero">
					<img src="/assets/images/logo-land.png" alt="AURA CELLIN" class="img-fluid" />
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#acNav">
					<i class="mdi mdi-menu"></i>
				</button>
				<div class="collapse navbar-collapse" id="acNav" @click="closeNav">
					<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
						<li class="nav-item"><a class="nav-link active" href="#hero">Beranda</a></li>
						<li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
						<li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
						<li class="nav-item"><a class="nav-link" href="#why-us">Mengapa Kami</a></li>
						<li class="nav-item"><a class="nav-link" href="#testimonials">Testimoni</a></li>
						<li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
					</ul>
					<a :href="`https://wa.me/${user.phone}`" target="_blank" class="btn btn-primary ac-btn rounded-pill px-4">
						<i class="mdi mdi-whatsapp me-1"></i> Konsultasi Sekarang
					</a>
				</div>
			</div>
		</nav>

		<!-- ========== HERO ========== -->
		<section id="hero" class="ac-hero">
			<div class="container position-relative">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<span class="ac-eyebrow"><i class="mdi mdi-flask-outline"></i> Wellness &amp; Cellular Health</span>
						<h1 class="ac-hero-title">
							Sehatkan <span class="ac-highlight">Selmu</span>,<br />
							Pancarkan <span class="ac-highlight">Auramu</span>
						</h1>
						<p class="ac-hero-lead">
							Rawat kesehatan dari dalam dan bantu tubuh memancarkan energi terbaiknya melalui pendekatan wellness yang personal dan menyeluruh.
						</p>
						<div class="d-flex flex-wrap gap-3">
							<a :href="`https://wa.me/${user.phone}`" target="_blank" class="btn btn-primary btn-lg ac-btn rounded-pill px-4">
								<i class="mdi mdi-whatsapp me-1"></i> Konsultasi Sekarang
							</a>
							<a href="#about" class="btn btn-outline-primary btn-lg ac-btn ac-btn-outline rounded-pill px-4">
								Kenali AURA CELLIN <i class="mdi mdi-arrow-down ms-1"></i>
							</a>
						</div>
						<div class="ac-stats">
							<div class="ac-stat">
								<b>100%</b>
								<span>Personal &amp; Menyeluruh</span>
							</div>
							<div class="ac-stat">
								<b>24/7</b>
								<span>Pendampingan Wellness</span>
							</div>
							<div class="ac-stat">
								<b>+10</b>
								<span>Layanan &amp; Produk</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 text-center text-lg-end">
						<div class="ac-hero-visual">
							<div class="ac-hero-ring">
								<img src="/assets/images/hero-1.webp" alt="AURA CELLIN Wellness" class="img-fluid" />
								<div class="ac-chip ac-chip-1"><i class="mdi mdi-leaf"></i> <span>Natural &amp; Premium</span></div>
								<div class="ac-chip ac-chip-green ac-chip-2"><i class="mdi mdi-heart-pulse"></i> <span>Cellular Health</span></div>
								<div class="ac-chip ac-chip-3"><i class="mdi mdi-shield-check"></i> <span>Personal Approach</span></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="#about" class="ac-scroll-down" aria-label="Scroll ke bawah"></a>
		</section>
		<!-- ========== ABOUT ========== -->
		<section id="about" class="ac-section">
			<div class="container">
				<div class="row align-items-center g-5">
					<div class="col-lg-5">
						<div class="ac-about-media">
							<img src="/assets/images/landing/23-2149692374.webp" alt="Perjalanan Sehat AURA CELLIN" class="img-fluid" />
							<div class="ac-about-badge">
								<i class="mdi mdi-cellphone-cog"></i>
								<div>
									<b>Sehat dari Dalam</b>
									<span>Wellness dimulai dari sel</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7">
						<span class="ac-eyebrow"><i class="mdi mdi-information-outline"></i> Tentang AURA CELLIN</span>
						<h2 class="ac-title">Perjalanan Sehat <span class="ac-highlight">Dimulai dari Dalam</span></h2>
						<p class="fs-5 mb-4">
							AURA CELLIN hadir dengan pendekatan wellness yang berfokus pada pentingnya menjaga kesehatan tubuh dari tingkat sel. Kami percaya bahwa ketika tubuh dirawat dengan baik, kesehatan, vitalitas, dan rasa percaya diri dapat terpancar secara alami.
						</p>
						<div class="row g-3">
							<div class="col-md-6">
								<div class="ac-point">
									<i class="mdi mdi-account-heart"></i>
									<div><b>Pendekatan Personal</b><span>Setiap kebutuhan dirawat secara khusus.</span></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="ac-point">
									<i class="mdi mdi-cellphone-cog"></i>
									<div><b>Kesehatan dari Dalam</b><span>Fokus pada kesehatan tingkat sel tubuh.</span></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="ac-point">
									<i class="mdi mdi-spa"></i>
									<div><b>Pengalaman Nyaman</b><span>Suasana wellness yang menenangkan.</span></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="ac-point">
									<i class="mdi mdi-compass-outline"></i>
									<div><b>Pendampingan Terarah</b><span>Berorientasi pada kebutuhan tiap individu.</span></div>
								</div>
							</div>
						</div>
						<a href="#services" class="btn btn-primary ac-btn rounded-pill px-4 mt-4">
							Pelajari Lebih Lanjut <i class="mdi mdi-arrow-right ms-1"></i>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!-- ========== SERVICES ========== -->
		<section id="services" class="ac-section ac-services">
			<div class="container">
				<div class="text-center ac-section-head">
					<span class="ac-eyebrow"><i class="mdi mdi-tools"></i> Layanan Kami</span>
					<h2 class="ac-title">Temukan Perawatan yang <span class="ac-highlight">Sesuai untukmu</span></h2>
					<p class="ac-subtitle">Pilih layanan wellness yang dirancang untuk membantu mendukung perjalananmu menuju tubuh yang lebih sehat dan hidup yang lebih berkualitas.</p>
				</div>
				<div class="row g-4">
					<div class="col-lg-4">
						<div class="ac-service-card">
							<div class="ac-service-icon"><i class="mdi mdi-dna"></i></div>
							<h4>Cellular Wellness</h4>
							<p>Pendekatan wellness yang berfokus pada dukungan terhadap kesehatan dan fungsi sel tubuh.</p>
							<a :href="`https://wa.me/${user.phone}`" target="_blank" class="ac-service-link">Lihat Detail <i class="mdi mdi-arrow-right"></i></a>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="ac-service-card">
							<div class="ac-service-icon"><i class="mdi mdi-account-group"></i></div>
							<h4>Wellness Consultation</h4>
							<p>Konsultasi personal untuk memahami kebutuhan dan tujuan wellness kamu.</p>
							<a :href="`https://wa.me/${user.phone}`" target="_blank" class="ac-service-link">Konsultasi <i class="mdi mdi-arrow-right"></i></a>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="ac-service-card">
							<div class="ac-service-icon"><i class="mdi mdi-bullseye"></i></div>
							<h4>Personalized Wellness</h4>
							<p>Pendekatan yang disesuaikan dengan kebutuhan dan perjalanan kesehatan setiap individu.</p>
							<a :href="`https://wa.me/${user.phone}`" target="_blank" class="ac-service-link">Mulai Perjalanan <i class="mdi mdi-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ========== WHY US ========== -->
		<section id="why-us" class="ac-section ac-whyus">
			<div class="container">
				<div class="text-center ac-section-head">
					<span class="ac-eyebrow"><i class="mdi mdi-star-circle"></i> Mengapa AURA CELLIN</span>
					<h2 class="ac-title">Karena Setiap Tubuh Punya <span class="ac-highlight">Cerita yang Berbeda</span></h2>
					<p class="ac-subtitle">Kami mengutamakan pengalaman wellness yang personal, nyaman, dan berorientasi pada kebutuhanmu.</p>
				</div>
				<div class="row g-4">
					<div class="col-md-6">
						<div class="ac-why-card">
							<div class="ac-why-icon"><i class="mdi mdi-account-heart"></i></div>
							<div><h5>Personal &amp; Terarah</h5><p>Setiap perjalanan dimulai dengan memahami kebutuhan dan tujuanmu.</p></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="ac-why-card">
							<div class="ac-why-icon"><i class="mdi mdi-sofa"></i></div>
							<div><h5>Nyaman &amp; Profesional</h5><p>Nikmati pengalaman yang dirancang agar terasa nyaman dari awal hingga akhir.</p></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="ac-why-card">
							<div class="ac-why-icon"><i class="mdi mdi-layers-triple"></i></div>
							<div><h5>Pendekatan Menyeluruh</h5><p>Kami melihat wellness sebagai bagian dari gaya hidup, bukan sekadar sebuah perawatan.</p></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="ac-why-card">
							<div class="ac-why-icon"><i class="mdi mdi-hand-heart"></i></div>
							<div><h5>Care That Matters</h5><p>Kami hadir untuk mendampingi setiap langkah perjalanan wellness kamu.</p></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ========== TESTIMONIALS ========== -->
		<section id="testimonials" class="ac-section ac-testimonials">
			<div class="container">
				<div class="text-center ac-section-head">
					<span class="ac-eyebrow"><i class="mdi mdi-comment-quote"></i> Cerita Mereka</span>
					<h2 class="ac-title">Pengalaman yang <span class="ac-highlight">Berbicara</span></h2>
					<p class="ac-subtitle">Dengarkan pengalaman mereka yang telah memulai perjalanan wellness bersama AURA CELLIN.</p>
				</div>
				<div class="row g-4">
					<div class="col-lg-4">
						<div class="ac-testimonial-card">
							<div class="ac-testimonial-quote"><i class="mdi mdi-format-quote-open"></i></div>
							<div class="ac-stars">
								<i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i>
							</div>
							<blockquote>“Pelayanannya nyaman dan sangat personal. Saya merasa lebih diperhatikan selama prosesnya.”</blockquote>
							<div class="ac-testimonial-person">
								<div class="ac-avatar">A</div>
								<div><b>Nama Klien</b><span>Klien AURA CELLIN</span></div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="ac-testimonial-card">
							<div class="ac-testimonial-quote"><i class="mdi mdi-format-quote-open"></i></div>
							<div class="ac-stars">
								<i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i>
							</div>
							<blockquote>“Pengalaman yang berbeda dari yang saya bayangkan. Timnya ramah dan informatif.”</blockquote>
							<div class="ac-testimonial-person">
								<div class="ac-avatar">B</div>
								<div><b>Nama Klien</b><span>Klien AURA CELLIN</span></div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="ac-testimonial-card">
							<div class="ac-testimonial-quote"><i class="mdi mdi-format-quote-open"></i></div>
							<div class="ac-stars">
								<i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star-half-full"></i>
							</div>
							<blockquote>“Saya senang bisa menemukan tempat yang membuat perjalanan wellness terasa lebih menyenangkan.”</blockquote>
							<div class="ac-testimonial-person">
								<div class="ac-avatar">C</div>
								<div><b>Nama Klien</b><span>Klien AURA CELLIN</span></div>
							</div>
						</div>
					</div>
					<div v-if="pages['section6.testimoni']" class="col-lg-12">
						<div class="ac-video mt-2">
							<iframe :src="pages['section6.testimoni']" frameborder="0" allowfullscreen title="Testimoni AURA CELLIN"></iframe>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ========== CTA ========== -->
		<section class="ac-cta">
			<div class="container ac-cta-inner">
				<div class="ac-glow-icon"><i class="mdi mdi-flash-outline"></i></div>
				<h2>Saatnya Memulai Perjalanan Wellness-mu</h2>
				<p>Tubuh yang sehat dimulai dari perhatian kecil yang dilakukan secara konsisten. Mari mulai perjalananmu bersama AURA CELLIN.</p>
				<div class="d-flex flex-wrap gap-3 justify-content-center">
					<a :href="`https://wa.me/${user.phone}`" target="_blank" class="btn btn-primary btn-lg ac-btn rounded-pill px-4">
						<i class="mdi mdi-whatsapp me-1"></i> Konsultasi Sekarang
					</a>
					<a href="#contact" class="btn btn-outline-light btn-lg rounded-pill px-4">
						<i class="mdi mdi-phone me-1"></i> Hubungi Kami
					</a>
				</div>
			</div>
		</section>
		<!-- ========== CONTACT ========== -->
		<section id="contact" class="ac-section">
			<div class="container">
				<div class="text-center ac-section-head">
					<span class="ac-eyebrow"><i class="mdi mdi-phone"></i> Hubungi Kami</span>
					<h2 class="ac-title">Kami Siap <span class="ac-highlight">Mendengarkanmu</span></h2>
					<p class="ac-subtitle">Punya pertanyaan atau ingin mengetahui layanan yang paling sesuai untukmu? Hubungi tim AURA CELLIN.</p>
				</div>
				<div class="row g-5">
					<div class="col-lg-5">
						<div class="ac-contact-item">
							<div class="ac-contact-icon"><i class="mdi mdi-whatsapp"></i></div>
							<div><b>WhatsApp</b><a :href="`https://wa.me/${user.phone}`" target="_blank">{{ user.phone }}</a></div>
						</div>
						<div class="ac-contact-item">
							<div class="ac-contact-icon"><i class="mdi mdi-email"></i></div>
							<div><b>Email</b><a href="mailto:halo@auracellin.id">halo@auracellin.id</a></div>
						</div>
						<div class="ac-contact-item">
							<div class="ac-contact-icon"><i class="mdi mdi-map-marker"></i></div>
							<div><b>Alamat</b><span>Indonesia</span></div>
						</div>
						<div class="ac-contact-item">
							<div class="ac-contact-icon"><i class="mdi mdi-clock-outline"></i></div>
							<div><b>Jam Operasional</b><span>Senin – Sabtu, 08.00 – 20.00 WIB</span></div>
						</div>
					</div>
					<div class="col-lg-6 offset-lg-1">
						<div class="ac-profile-card">
							<img :src="user.photo" alt="Member" class="ac-profile-photo" />
							<h5>{{ user.name }}</h5>
							<span>{{ user.username }}</span>
							<a :href="`https://wa.me/${user.phone}`" target="_blank" class="btn btn-light rounded-pill px-4">
								<i class="mdi mdi-whatsapp me-1 text-success"></i> Chat WhatsApp
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ========== FOOTER ========== -->
		<footer class="ac-footer pt-5">
			<div class="container">
				<div class="row g-4">
					<div class="col-lg-4">
						<div class="ac-footer-brand">
							<img src="/assets/images/logo-land.png" alt="AURA CELLIN" class="img-fluid" />
						</div>
						<p class="mb-4">Sehatkan Selmu, Pancarkan Auramu. AURA CELLIN mendampingi perjalanan wellness-mu dengan pendekatan yang personal dan menyeluruh.</p>
						<div class="d-flex gap-2 ac-social">
							<a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
							<a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
							<a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
						</div>
					</div>
					<div class="col-6 col-lg-2">
						<h6>Menu Cepat</h6>
						<ul>
							<li><a href="#hero">Beranda</a></li>
							<li><a href="#about">Tentang</a></li>
							<li><a href="#services">Layanan</a></li>
							<li><a href="#why-us">Mengapa Kami</a></li>
							<li><a href="#testimonials">Testimoni</a></li>
							<li><a href="#contact">Kontak</a></li>
						</ul>
					</div>
					<div class="col-6 col-lg-3">
						<h6>Kontak</h6>
						<ul>
							<li><a :href="`https://wa.me/${user.phone}`" target="_blank"><i class="mdi mdi-whatsapp me-1"></i> WhatsApp</a></li>
							<li><a href="mailto:halo@auracellin.id"><i class="mdi mdi-email me-1"></i> Email</a></li>
							<li><a href="#"><i class="mdi mdi-map-marker me-1"></i> Indonesia</a></li>
						</ul>
					</div>
					<div class="col-6 col-lg-3">
						<h6>Legal</h6>
						<ul>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms &amp; Conditions</a></li>
						</ul>
					</div>
				</div>
				<div class="ac-footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center">
					<p class="mb-2 mb-md-0">&copy; {{ $moment().format('YYYY') }} AURA CELLIN. All rights reserved.</p>
					<p class="mb-0"><i class="mdi mdi-shield-check me-1 text-success"></i> Secured &amp; Trusted Service</p>
				</div>
			</div>
		</footer>

		<!-- Floating WhatsApp -->
		<a :href="`https://wa.me/${user.phone}`" target="_blank" class="ac-float-wa" aria-label="WhatsApp">
			<i class="mdi mdi-whatsapp"></i>
		</a>
	</div>
</template>
<script type="text/javascript">
export default {
	async asyncData({ $axios, params, error }) {
		try {
			let slug = params.slug || "admin";
			const { data: response } = await $axios.get(`ref/${slug}`);
			return response;
		} catch (err) {
			console.log(err);
			let err_msg = "";
			if (err.response) {
				err_msg = err.response.data.message;
			} else {
				err_msg = err.toString();
			}
			error({ statusCode: 404, message: err_msg });
		}
	},
	mounted() {
		window.addEventListener("scroll", this.onScroll);
		this.onScroll();
	},
	beforeDestroy() {
		window.removeEventListener("scroll", this.onScroll);
	},
	methods: {
		onScroll() {
			const nav = document.getElementById("acNavbar");
			if (!nav) return;
			nav.classList.toggle("scrolled", window.scrollY > 40);
		},
		closeNav() {
			const el = document.getElementById("acNav");
			if (el) el.classList.remove("show");
		},
	},
};
</script>
