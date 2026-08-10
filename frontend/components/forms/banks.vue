<template>
	<div class="form-group">
		<label>Bank</label>
		<select ref="bank" class="form-control" v-model="value" name="bank_id" :required="required">
			<option value="">-- Pilih Bank --</option>
			<option v-for="(item, key) in items" :key="key" :value="item.id">{{ item.name }}</option>
		</select>
		<span validation-for="bank_id"></span>
	</div>
</template>

<script type="text/javascript">
export default {
	props: {
		selected: String,
		required: {
			default: true,
			type: Boolean,
		},
	},
	data() {
		return {
			items: [],
			value: "",
		};
	},
	watch: {
		selected(val) {
			this.value = val;
		},
	},
	mounted() {
		this.$axios
			.get(`member/banks`)
			.then((response) => {
				this.items = response.data;
				this.value = this.selected;
				if (typeof jQuery !== "undefined") {
					$(this.$refs.bank).select2({
						width: "100%",
					});
				}
			})
			.catch((err) => console.log(err));
	},
};
</script>
