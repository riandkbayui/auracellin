<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<style scoped>
.title-ellipsis {
	max-width: 200px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
</style>

<template>
	<div>
		<Breadcrumb title="Manajemen Transaksi" :pages="['Admin Area']" />

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card w-100 mb-2 overflow-hidden">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<h5 class="text-primary title-ellipsis mb-0">{{ item.invoice }}</h5>
							<div :class="['badge fsz-12 px-2 text-white', statusBadgeClass(item.status)]">{{ item.status.toUpperCase() }}</div>
						</div>
						<p class="text-white small mb-1 mt-2">Tanggal: {{ $moment(item.created_at).format('DD MMM YYYY, HH:mm') }}</p>
						<p class="mb-1 text-truncate">{{ item.description }}</p>
						<p class="text-warning mb-2">Total: {{ $idr(item.total) }}</p>
					</div>
					<div class="card-footer bg-transparent">
						<div class="d-flex gap-2">
							<NuxtLink class="btn btn-primary btn-sm w-100" :to="`/admin/transactions/detail/${item.id}`">
								<i class="mdi mdi-eye"></i> Detail
							</NuxtLink>
							<button @click.prevent="remItem(index, item)" class="btn btn-danger btn-sm w-100">
								<i class="mdi mdi-trash-can"></i> Hapus
							</button>
						</div>
					</div>
				</div>
			</li>
		</ul>

		<button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" @click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-120"></div>
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
		statusBadgeClass(status) {
			switch (String(status).toLowerCase()) {
				case 'pending': return 'badge-soft-warning';
				case 'success': return 'badge-soft-success';
				case 'completed': return 'badge-soft-success';
				case 'sent': return 'badge-soft-info';
				default: return 'badge-soft-danger';
			}
		},
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`admin/transactions`, {
					params: { page: this.page },
				});

				this.err = "";
				this.results = [...this.results, ...response.results];
				this.has_next = response.has_next;
			} catch (err) {
				console.log(err);
				this.err = err.response ? err.response.data.message : err.toString();
			} finally {
				this.loadingNext = false;
			}
		},
		next() {
			this.page++;
			this.getData();
		},
		remItem(index, item) {
			Swal.fire({
				title: "Peringatan!",
				text: `Anda akan menghapus transaksi ${item.invoice}?`,
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Ya, Hapus",
				cancelButtonText: "Batal",
			}).then(async (result) => {
				if (result.isConfirmed) {
					try {
						const data = new URLSearchParams();
						data.append("id", item.id);
						const { data: response } = await this.$axios.post(`admin/transactions/delete`, data, {
							headers: {
								"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
							},
						});
						Swal.fire("Berhasil!", response.message, "success");
						this.results.splice(index, 1);
					} catch (err) {
						Swal.fire("Gagal!", err.response ? err.response.data.message : err.toString(), "error");
					}
				}
			});
		}
	},
};
</script>
