<template>
	<div v-if="items.length > 0" class="card">
		<div class="card-header">
			<h5 class="card-title text-white">
				<i class="mdi mdi-bullhorn"></i>
				Informasi Penting
			</h5>
		</div>
		<div class="card-body p-0">
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<div v-for="(item, index) in items" :key="index" :class="['carousel-item', index == 0 && 'active']">
						<img :src="item.photo" class="d-block w-100" />
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>
		<div class="card-footer"></div>
	</div>
</template>

<script type="text/javascript">
export default {
	data() {
		return {
			items: [],
		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		async getData() {
			try {
				const { data: response } = await this.$axios.get(`member/slideshows`);
				this.items = response.items;
			} catch (err) {
				console.log(err);
				let err_msg = "";
				if (err.response) {
					err_msg = err.response.data.message;
				} else {
					err_msg = err.toString();
				}
				console.log(err_msg);
			}
		},
	},
};
</script>
