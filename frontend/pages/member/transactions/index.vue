<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Transaksi" :pages="['Member Area']" />

		<div class="text-end mb-4">
			<NuxtLink class="btn btn-success bg-success bg-secondary" to="/member/transactions/add">
				<i class="mdi mdi-plus-circle"></i>
				Tambah Transaksi
			</NuxtLink>
		</div>

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card w-100 mb-2 overflow-hidden">
					<div class="card-body">
						<div class="d-flex justify-content-between">
							<h5 class="text-primary">{{ item.code }}</h5>
							<div :class="['badge fsz-12 px-2 text-white', statusBadgeClass(item.status)]">{{ item.status.toUpperCase() }}</div>
						</div>
						<p class="text-muted fsz-14 mb-1">Total: {{ item.amount }}</p>
						<p class="text-muted fsz-14 mb-1">Tanggal: {{ $moment(item.created_at).format('DD MMM YYYY, HH:mm') }}</p>
						<p class="mb-0">{{ item.description }}</p>
					</div>
					<div class="card-footer">
						<NuxtLink class="btn btn-info bg-info bg-gradient w-100" :to="`/member/transactions/detail/${item.id}`">
							<i class="mdi mdi-eye"></i>
							Detail
						</NuxtLink>
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
		statusBadgeClass(status) {
			switch (status.toLowerCase()) {
				case 'pending': return 'badge-soft-warning';
				case 'success': return 'badge-soft-success';
				default: return 'badge-soft-danger';
			}
		},
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`member/transactions`, {
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
	},
};
</script>
