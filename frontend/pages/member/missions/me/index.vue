<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Misi Saya" :pages="['Member Area', 'Misi']" />

		<ul v-if="results.length>0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card">
					<div class="card-header">
						<div class="d-flex gap-2 justify-content-between text-white">
							<div>
								<img :src="item.user.photo" class="avatar-sm ar-1-1 rounded-circle border border-3 img-cover-center" />
							</div>
							<div class="flex-grow-1">
								<div class="fsz-16">{{ item.user.name }}</div>
								<div class="fw-bold">{{ item.user.username }}</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<h5 class="text-primary">{{ item.name }}</h5>
						<p class="text-prewrap text-ellipsis-3">{{ item.description }}</p>
					</div>
					<div class="card-footer">
						<NuxtLink :to="`/member/missions/edit/${item.code}`" class="btn btn-primary w-100">
							<span class="text-white"><i class="fa fa-edit"></i> Edit</span>
						</NuxtLink>
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
	layout: "member/mission",
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
				const { data: response } = await this.$axios.get(`member/missions/me`, {
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
