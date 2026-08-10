<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Pengguna" :pages="['Admin Area']" />

		<div class="form-group mb-4">
			<div class="input-group">
				<input v-model="search" placeholder="Pencarian ..." class="form-control" type="text" autocomplete="off">
				<button class="btn btn-primary" @click.prevent="triggerSearch"><i class="mdi mdi-search-web"></i></button>
			</div>
		</div>

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<NuxtLink :to="`/admin/users/edit/${item.id}`">
					<div class="card waves-effect w-100 mb-2">
						<div class="card-body">
							<div class="d-flex gap-2 align-items-center">
								<div>
									<img :src="item.photo" class="avatar-md rounded-circle ar-1-1 img-cover-center">
								</div>
								<div class="flex-grow-1">
									<div class="d-flex mb-1">
										<h5 class="text-primary flex-fill">{{ item.name }}</h5>
										<div v-html="$badge(item.status, [
											{value: `pending`, class: `badge badge-soft-info fsz-12`, label: `Pending`},
											{value: `active`, class: `badge badge-soft-success fsz-12`, label: `Aktif`},
											{value: `inactive`, class: `badge badge-soft-danger fsz-12`, label: `Tidak Aktif`},
										])"></div>
									</div>
									<div class="text-primary d-flex justify-content-between g-2">
										<div><i class="mdi mdi-account"></i> {{ item.username }}</div>
										<div><i class="mdi mdi-whatsapp"></i> {{ item.phone || "-" }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</NuxtLink>
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
			search: "",
			results: [],
			page: 1,
			has_next: false,
			err: "",
			loadingNext: true,
			cancelTokenSource: null,
			searchTimeout: null,
		};
	},
	watch: {
		search() {
			clearTimeout(this.searchTimeout);
			this.searchTimeout = setTimeout(() => {
				this.page = 1;
				this.results = [];
				this.getData();
			}, 400);
		},
	},
	mounted() {
		this.getData();
	},
	methods: {
		triggerSearch() {
			clearTimeout(this.searchTimeout);
			this.page = 1;
			this.results = [];
			this.getData();
		},
		async getData() {
			try {
				this.loadingNext = true;

				// Batalkan request sebelumnya jika ada
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Pencarian dibatalkan");
				}

				this.cancelTokenSource = this.$axios.CancelToken.source();

				const { data: response } = await this.$axios.get(`admin/users`, {
					params: {
						page: this.page,
						search: this.search,
					},
					cancelToken: this.cancelTokenSource.token
				});

				this.err = "";
				if (this.page === 1) {
					this.results = response.results;
				} else {
					this.results = [...this.results, ...response.results];
				}
				this.has_next = response.has_next;
			} catch (err) {
				if (this.$axios.isCancel(err)) return;
				console.error(err);
				this.err = err.response?.data?.message || err.toString();
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
