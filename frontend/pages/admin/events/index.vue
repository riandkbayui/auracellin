<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Event" :pages="['Admin Area']" />

		<div class="text-end mb-4">
			<NuxtLink class="btn btn-success bg-success bg-secondary" to="/admin/events/add">
				<i class="mdi mdi-plus-circle"></i>
				Tambah Baru
			</NuxtLink>
		</div>

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card w-100 mb-2 overflow-hidden">
					<div class="card-header p-0">
						<img :src="item.photo" class="w-100 ar-16-9 img-cover-center mb-2" />
					</div>
					<div class="card-body">
						<h5 class="text-primary">{{ item.name }}</h5>
						<p>{{ item.description }}</p>
						<div class="mb-2">
							<div :class="['badge fsz-12 px-2 text-white', badgeClass(item)]">{{ item.status }}</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex gap-2">
							<NuxtLink class="btn btn-primary waves-effect w-100" :to="`/admin/events/edit/${item.id}`">
								<i class="mdi mdi-pencil"></i>
								Edit
							</NuxtLink>
							<button v-on:click.prevent="remItem(index, item)" class="btn btn-danger bg-danger bg-gradient w-100">
								<i class="mdi mdi-trash-can"></i>
								Hapus
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
			<div class="skeleton skeleton-card ht-280"></div>
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
					text: `Anda akan menghapus event yang dipilih?`,
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
							const { slug } = this.$route.params;
							data.append("id", item.id);
							const { data: response } = await this.$axios.post(`admin/events/delete`, data, {
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
		badgeClass(v) {
			switch (String(v.status).toLocaleLowerCase()) {
				case "active":
					return "badge-soft-success";
				case "inactive":
					return "badge-soft-danger";
				default:
					return "";
			}
		},
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`admin/events`, {
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
