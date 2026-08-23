<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Detail Transaksi" :pages="['Member Area', 'Transaksi', 'Detail']" />

		<div>
			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Informasi Transaksi</h5>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-between mb-2">
						<span class="">Invoice:</span>
						<span class="fw-bold">{{ transaction.invoice }}</span>
					</div>
					<div class="d-flex justify-content-between mb-2">
						<span class="">Nomor Pengiriman:</span>
						<span class="fw-bold">{{ transaction.tracking_number || "-" }}</span>
					</div>
					<div class="d-flex justify-content-between mb-2">
						<span class="">Status:</span>
						<span class="badge bg-warning h-100 text-capitalize">{{ transaction.status }}</span>
					</div>
					<div class="d-flex justify-content-between mb-2" v-if="transaction.tracking_number">
						<span class="">No. Resi:</span>
						<span class="fw-bold">{{ transaction.tracking_number }}</span>
					</div>
					<div class="d-flex justify-content-between mb-2">
						<span class="">Tanggal:</span>
						<span class="fw-bold">{{ $moment(transaction.created_at).format('DD MMM YYYY, HH:mm') }}</span>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Produk</h5>
				</div>
				<div class="card-body">
					<div v-for="(p, idx) in details" :key="idx" class="bg-white rounded mb-2 border-bottom pb-2">
						<div class="card-body d-flex justify-content-between align-items-center p-2">
							<div class="d-flex gap-3">
								<img :src="p.photo ? '/' + p.photo : '/assets/images/placeholder.jpg'" alt="" class="wh-80 ar-1-1 rounded" style="object-fit: cover;">
								<div>
									<h6>{{ p.name }}</h6>
									<p class=" mb-0">Rp {{ $idr(p.price) }} x {{ p.qty }}</p>
									<p class="fw-bold text-primary mb-0">Subtotal: Rp {{ $idr(p.total) }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Bukti Bayar</h5>
				</div>
				<div class="card-body">
					<div>
						<img :src="transaction.payment_photo ? '/' + transaction.payment_photo : '/assets/images/placeholder.jpg'" class="w-100 ar-16-9 img-cover-center rounded mb-2" />
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Ringkasan</h5>
				</div>
				<div class="card-body">
					<div class="d-flex justify-content-between mb-2">
						<span>Total Item:</span>
						<span class="fw-bold">{{ details.length }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span>Total Harga:</span>
						<span class="fw-bold text-primary">Rp {{ $idr(transaction.total) }}</span>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Pengiriman & Catatan</h5>
				</div>
				<div class="card-body">
					<div class="form-group mb-3">
						<label class="">Kota</label>
						<input type="text" class="form-control" :value="city ? city.name : '-'" readonly />
					</div>
					<div class="form-group mb-3">
						<label class="">Alamat Lengkap</label>
						<textarea class="form-control" readonly>{{ transaction.full_address }}</textarea>
					</div>
					<div class="form-group mb-3">
						<label class="">Deskripsi</label>
						<textarea class="form-control" readonly>{{ transaction.description }}</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	layout: "member/default",
	data() {
		return {
			transaction: {},
			details: [],
			city: null
		};
	},
	mounted() {
		this.getDetail();
	},
	methods: {
		async getDetail() {
			$.LoadingOverlay("show");
			try {
				const id = this.$route.params.id;
				const { data: response } = await this.$axios.get(`member/transactions/detail/${id}`);
				this.transaction = response.transaction;
				this.details = response.details;
				this.city = response.city;
			} catch (err) {
				Swal.fire("Gagal!", "Gagal memuat detail transaksi", "error").then(() => {
					this.$router.push("/member/transactions");
				});
			} finally {
				$.LoadingOverlay("hide");
			}
		}
	},
};
</script>
