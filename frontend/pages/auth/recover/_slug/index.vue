<template>
	<div>
		<form id="form" ref="form" v-on:submit.prevent="form_submit">
			<div class="card">
				<div class="card-header text-center">
					<h5 class="text-white mb-0">Atur Kata Sandi</h5>
				</div>
				<div class="card-body">
					<div class="text-center mb-3">
						<div class="d-inline-block mb-2">
							<div class="wh-72 rounded-circle bg-warning bg-soft d-flex justify-content-center align-items-center">
								<img src="/assets/images/logo.png" alt="AURA CELLIN" class="w-100 p-1">
							</div>
						</div>

						<div class="text-primary h5">AURA CELLIN</div>
					</div>

					<div class="form-group">
						<label>Kata sandi</label>
						<div class="input-group">
							<input name="password" placeholder="Masukkan kata sandi" value="" class="form-control" type="password" autocomplete="off" />
							<button type="button" class="btn btn-pw btn-primary"><i class="fa fa-eye"></i></button>
						</div>
						<span validation-for="password"></span>
					</div>
					<div class="form-group">
						<label>Konfirmasi sandi</label>
						<div class="input-group">
							<input name="password_confrimation" placeholder="Masukkan konfirmasi sandi" value="" class="form-control" type="password" autocomplete="off" />
							<button type="button" class="btn btn-pw btn-primary"><i class="fa fa-eye"></i></button>
						</div>
						<span validation-for="password_confrimation"></span>
					</div>

					<div class="form-group">
						<button class="btn btn-primary w-100">Submit</button>
					</div>
				</div>
				<div class="card-footer">
					<div class="text-center">&copy; {{ $moment().format("YYYY") }} AURA CELLIN</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	layout: "auth",
	mounted() {
		if (typeof jQuery !== "undefined") {
			$(document).ready(function () {
				$(`.btn-pw`).passwordToggle();
			});
		}
	},
	methods: {
		async form_submit() {
			if (typeof jQuery !== "undefined") {
				try {
					$.LoadingOverlay("show");
                    const {slug} = this.$route.params;
					const formData = new FormData(this.$refs.form);
					const { data: response } = await this.$axios.post(`auth/recover/${slug}`, formData);
					this.$router.push("/member/dashboard");
				} catch (err) {
					console.log(err);
					if (err.response) {
						this.err = err.response.data.message;
						if (err.response.status == 400) {
							$.each(err.response.data.errors, function (index, val) {
								$(`span[validation-for="${index}"]`).text(val);
							});
						}
					} else {
						this.err = err.toString();
					}
					Swal.fire("Maaf!", this.err, "error");
				} finally {
					$.LoadingOverlay("hide");
				}
			}
		},
	},
};
</script>
