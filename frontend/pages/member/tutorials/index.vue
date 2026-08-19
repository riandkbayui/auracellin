<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Tutorial" :pages="['Member Area']" />

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card overflow-hidden waves-effect w-100">
                    <div class="card-header p-0">
                        <img :src="item.photo" class="img-cover-center ar-16-9 w-100">
                    </div>
					<div class="card-body">
						<h5 class="text-primary">{{ item.name }}</h5>
                        <p class="text-prewrap text-ellipsis-3">{{ item.description }}</p>
					</div>
                    <div class="card-footer">
						<NuxtLink :to="`/member/tutorials/open/${item.code}`" class="btn btn-primary w-100"><i class="mdi mdi-video"></i> Lihat Tutorial</NuxtLink>
                    </div>
				</div>
			</li>
		</ul>

		<button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" v-on:click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-280"></div>
		</div>
	</div>
</template>

<script type="text/javascript">
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
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`member/tutorials`, {
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
