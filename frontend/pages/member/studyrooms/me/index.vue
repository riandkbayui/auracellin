<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Milik Saya" :pages="['Member Area', 'Ruang Belajar']" />

        <ul v-if="results.length>0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card overflow-hidden">
					<div class="card-header p-0">
						<img :src="item.photo" class="w-100 ar-16-9 img-cover-center">
					</div>
					<div class="card-body">
                        <h5 class="text-primary">{{ item.name }}</h5>
						<p class="text-prewrap text-ellipsis-3">{{ item.description }}</p>
					</div>
					<div class="card-footer">
                        <div class="d-flex gap-2">
							<NuxtLink :to="`/member/studyrooms/edit/${item.code}`" class="btn btn-warning flex-grow-1"><i class="mdi mdi-pencil"></i> Edit</NuxtLink>
							<button v-on:click.prevent="rem(item)" class="btn btn-danger flex-grow-1"><i class="mdi mdi-trash-can"></i> Hapus</button>
						</div>
					</div>
				</div>
			</li>
		</ul>

        <button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" v-on:click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-300"></div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/studyrooms",
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
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`member/studyrooms/me`, {
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
		rem(item) {
			Swal.fire({
				title: 'Peringatan!',
				text: `Anda akan menghapus ${item.name}?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: false,
				cancelButtonColor: false,
				cancelButtonText: 'Batal',
				confirmButtonText: 'Ya',
			}).then(async result => {
				if (result.isConfirmed) {
					try {
						$.LoadingOverlay("show");
						const data = new URLSearchParams();
						data.append('code', item.code);
						const { data: response } = await this.$axios.post(`member/studyrooms/delete`, data, {
							headers: {
								'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
							}
						});
						Swal.fire('Berhasil!', response.message, 'success');
						let pos = this.results.indexOf(item);
						this.results.splice(pos, 1);
					} catch (err) {
						console.log(err);
						let err_msg = '';
						if (err.response) {
							err_msg = err.response.data.message;
						} else {
							err_msg = err.toString();
						}
						Swal.fire('Maaf!', err_msg, 'error');
					} finally {
						$.LoadingOverlay("hide");
					}
				}
			});
		}
	},
};
</script>
