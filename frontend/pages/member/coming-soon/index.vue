<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Segera Hadir" :pages="['Member Area']" />

		<div class="card">
			<div class="card-body">
				<div class="d-flex flex-column justify-content-center align-items-center text-center">
					<div class="display-1 text-secondary mb-3">🚧</div>
					<h2 class="h5 fw-semibold text-white mb-2">Coming Soon!</h2>
					<p class="text-white">Fitur ini sedang kami kembangkan. Mohon ditunggu ya!</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/default",
};
</script>
