<template>
	<div>
		<form id="form" ref="form" v-on:submit.prevent="form_submit">
			<div class="card">
				<div class="card-header text-center">
					<h5 class="text-primary mb-0">Lupa Kata Sandi</h5>
				</div>
				<div class="card-body">
					
					<div class="text-center mb-3">
						<div class="d-inline-block mb-2">
							<div class="wh-72 rounded-circle bg-warning bg-soft d-flex justify-content-center align-items-center">
								<i class="bx bxs-star fsz-32 text-primary"></i>
							</div>
						</div>

						<div class="text-primary">AURA CELLIN</div>
					</div>

					<div class="form-group">
						<label for="username">Username</label>
						<input name="username" placeholder="Masukkan username" value="" class="form-control" type="text" autocomplete="off" required />
						<span validation-for="username"></span>
					</div>
					<div class="form-group">
						<div class="text-end mb-2">
							<nuxt-link to="/auth/login">Ingat Sandi?</nuxt-link>
						</div>
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
		if(typeof jQuery !== 'undefined') {
			$(document).ready(function () {
				$(`#pwd`).passwordToggle();
			});
		}
	},
	methods: {
		async form_submit() {
			if (typeof jQuery !== "undefined") {
				try {
					$.LoadingOverlay("show");
					const formData = new FormData(this.$refs.form);
					const { data: response } = await this.$axios.post(`auth/forgot`, formData);
					Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: false,
                        confirmButtonText: 'Ya',
                    }).then((result) => {
                        this.$router.push('/auth/login');
                    });
				} catch (err) {
					console.log(err);
					if (err.response) {
						this.err = err.response.data.message;
						if (err.response.status == 400) {
							$.each(err.response.data.errors, function(index, val) {
								$(`span[validation-for="${index}"]`).text(val);
							});
						}
					} else {
						this.err = err.toString();
					}
					Swal.fire('Maaf!', this.err, 'error');
				} finally {
					$.LoadingOverlay("hide");
				}
			}
		}
	}
};
</script>
