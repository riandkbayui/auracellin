<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Tambah Transaksi" :pages="['Member Area', 'Transaksi']" />

		<form action="" v-on:submit.prevent="form_submit" method="post">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Produk</h5>
				</div>
				<div class="card-body">
					<div v-for="(p, idx) in cart" :key="idx" class="bg-white rounded mb-2">
						<div class="card-body d-flex justify-content-between align-items-center">
              <div class="d-flex gap-3">
                <img :src="p.photo" alt="" class="wh-80 ar-1-1 rounded">
                <div>
                  <h6>{{ p.name }}</h6>
                  <p class="text-muted mb-0">Rp {{ $idr(p.price) }}</p>
                  <input type="number" class="form-control form-control-sm mt-1" v-model.number="p.qty" min="1" style="width: 80px;">
                </div>
              </div>
							<button class="btn btn-danger btn-sm" @click="removeFromCart(idx)">Hapus</button>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productModal">Tambah Produk</button>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h5 class="card-title text-white">Bukti Bayar</h5>
				</div>
				<div class="card-body">
					<div>
            <img :src="payment_photo_url" class="w-100 ar-16-9 img-cover-center rounded mb-2" />
          </div>
					<div class="form-group">
						<label>Upload Bukti</label>
						<input name="payment_photo" v-on:change.prevent="upload_img" class="form-control" type="file" accept=".jpg,.jpeg,.png" required />
						<span validation-for="payment_photo"></span>
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
						<span class="fw-bold">{{ cart.length }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span>Total Harga:</span>
						<span class="fw-bold text-primary">Rp {{ $idr(totalAmount) }}</span>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label>Kota</label>
						<select name="city_id" class="form-control" required style="width: 100%">
							<option value="">-- Pilih Kota --</option>
							<option v-for="city in cities" :value="city.id" :key="city.id">{{ city.name }}</option>
						</select>
						<span validation-for="city_id"></span>
					</div>
					<div class="form-group">
						<label>Alamat Lengkap</label>
						<textarea name="full_address" class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="description" class="form-control" required></textarea>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary w-100">Submit</button>
				</div>
			</div>
		</form>

		<!-- Product Modal -->
		<div class="modal fade" id="productModal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Pilih Produk</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div v-for="item in products" :key="item.id" class="card mb-2 cursor-pointer" @click="addToCart(item)">
							<div class="card-body d-flex align-items-center">
								<img :src="item.photo" class="wh-80 ar-1-1 rounded me-3" style="object-fit: cover" />
								<div>
									<h6 class="text-primary">{{ item.name }}</h6>
									<p class="text-warning text-opacity-75 mb-0">Rp {{ item.price }}</p>
									<p class="text-warning text-opacity-75 mb-0">{{ item.description }}</p>
								</div>
							</div>
						</div>
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
		return { products: [], cart: [], cities: [], payment_photo_url: '/assets/images/placeholder.jpg' };
	},
	mounted() {
		this.getProducts();
		this.getCities();
	},
	computed: {
		totalAmount() {
			return this.cart.reduce((total, p) => total + (p.price * p.qty), 0);
		}
	},
	methods: {
		async getProducts() {
			const { data: response } = await this.$axios.get("admin/products?limit=100");
			this.products = response.results;
		},
		addToCart(product) {
			const existing = this.cart.find((item) => item.id === product.id);
			if (existing) {
				existing.qty += 1;
			} else {
				this.cart.push({ ...product, qty: 1 });
			}
			$("#productModal").modal("hide");
		},
		removeFromCart(index) {
			this.cart.splice(index, 1);
		},
		upload_img(e) {
			const [file] = e.target.files;
			this.payment_photo_url = URL.createObjectURL(file);
		},
		async getCities() {
			const { data: response } = await this.$axios.get("common/cities");
			this.cities = response;
			this.$nextTick(() => {
				$('select[name="city_id"]').select2({ placeholder: "Pilih Kota", width: "100%" });
			});
		},
		async form_submit(e) {
			$.LoadingOverlay("show");
			const formData = new FormData(e.target);
			const productData = this.cart.map((p) => ({ product_id: p.id, qty: p.qty }));
			formData.set("products", JSON.stringify(productData));

			try {
				await this.$axios.post(`member/transactions/create`, formData);
				Swal.fire("Berhasil!", "Transaksi dibuat", "success").then(() => this.$router.push("/member/transactions"));
			} catch (err) {
				Swal.fire("Gagal!", "Terjadi kesalahan", "error");
			} finally {
				$.LoadingOverlay("hide");
			}
		},
	},
};
</script>
