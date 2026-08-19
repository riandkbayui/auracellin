<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Mutasi Stok" :pages="['Admin Area']" />

		<div class="text-end mb-4">
			<NuxtLink class="btn btn-success bg-success bg-secondary" to="/admin/productstocks/add">
				<i class="mdi mdi-plus-circle"></i>
				Tambah Mutasi
			</NuxtLink>
		</div>

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card w-100 mb-2 overflow-hidden">
          <div class="card-header">
            <h5 class="text-primary mb-0">{{ item.name }}</h5>
						<p class="text-white fsz-12 mb-0">Tanggal: {{ $moment(item.created_at).format('DD MMM YYYY, HH:mm') }}</p>
          </div>
					<div class="card-body">
						<p class="text-warning fsz-12 mb-1">Jumlah: {{ item.qty }}</p>
						<p class="mb-2">{{ item.description }}</p>
            <div :class="['badge px-3 mb-0 fsz-12 text-white', typeBadgeClass(item.type)]">{{ item.type.toUpperCase() }}</div>
					</div>
					<div class="card-footer">
						<button v-on:click.prevent="remItem(index, item)" class="btn btn-danger bg-danger bg-gradient w-100">
							<i class="mdi mdi-trash-can"></i>
							Hapus
						</button>
					</div>
				</div>
			</li>
		</ul>

		<button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" @click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-100"></div>
		</div>
	</div>
</template>

<script>
export default {
	layout: "member/default",
	data() {
		return {
			results: [],
			page: 1,
			has_next: false,
			err: "",
			loadingNext: true,
		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		remItem(index, item) {
			try {
				Swal.fire({
					title: "Peringatan!",
					text: `Anda akan menghapus mutasi stok ini?`,
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: false,
					cancelButtonColor: false,
					cancelButtonText: "Batal",
					confirmButtonText: "Ya",
				}).then(async (result) => {
					if (result.isConfirmed) {
						try {
							const data = new URLSearchParams();
							data.append("id", item.id);
							const { data: response } = await this.$axios.post(`admin/productstocks/delete`, data, {
								headers: {
									"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
								},
							});
							Swal.fire("Berhasil!", response.message, "success");
							this.results.splice(index, 1);
						} catch (err) {
							console.log(err);
							let err_msg = "";
							if (err.response) {
								err_msg = err.response.data.message;
							} else {
								err_msg = err.toString();
							}
							this.err = err_msg;
						}
					}
				});
			} catch (error) {
				console.log(error);
			}
		},
		typeBadgeClass(type) {
			return type === 'in' ? 'badge-soft-success' : 'badge-soft-danger';
		},
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`admin/productstocks`, {
					params: {
						page: this.page,
					},
				});

				this.err = "";
				this.results = [...this.results, ...response.results];
				this.has_next = response.has_next;
			} catch (err) {
				console.log(err);
				if (err.response) {
					this.err = err.response.data.message;
				} else {
					this.err = err.toString();
				}
			} finally {
				this.loadingNext = false;
			}
		},
		next() {
			this.page++;
			this.getData();
		},
	},
};
</script>
