<template>
	<div class="row d-print-none">
		<div class="col-12 pb-3">
			<div class="page-title-box pb-0 align-items-center justify-content-between">
				<h4 class="mb-sm-0 font-size-18 text-dark">{{ title }}</h4>

				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li v-for="(val, key) in pages" :key="key" class="breadcrumb-item">
							{{ val }}
						</li>
						<li class="breadcrumb-item text-dark">{{ title }}</li>
					</ol>
				</div>
			</div>
			<slot />
		</div>
	</div>
</template>

<script>
export default {
	props: {
		pages: Array,
		title: String,
	},
};
</script>
