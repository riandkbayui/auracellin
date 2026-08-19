<template>
	<NuxtLink :to="computedTo">
		<slot />
	</NuxtLink>
</template>

<script>
export default {
	props: {
		to: {
			type: String,
			required: true,
		},
		pkg_id: {
			type: [String, Number],
			required: true, // minimal package ID yang diperbolehkan
		},
		fallback: {
			type: String,
			default: "/member/upgrade",
		},
	},
	computed: {
		computedTo() {
			const userPkgId = parseInt(this.$user("package_id"), 10);
			const minPkgId = parseInt(this.pkg_id, 10);

			return userPkgId >= minPkgId ? this.to : this.fallback;
		},
	},
};
</script>
