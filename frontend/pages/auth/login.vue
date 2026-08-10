<template>
	<div>
		<form id="form" ref="form" v-on:submit.prevent="form_submit">
			<div class="card">
				<div class="card-header text-center">
					<h5 class="text-primary mb-0">Selamat Datang</h5>
				</div>
				<div class="card-body">
					
					<div class="text-center mb-3">
						<div class="d-inline-block mb-2">
							<div class="wh-72 rounded-circle bg-warning bg-soft d-flex justify-content-center align-items-center">
								<img src="/assets/images/logo.png" alt="AURA CELLIN" class="w-100 p-1">
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
						<label for="password">Kata Sandi</label>
						<div class="input-group">
							<input name="password" placeholder="Masukkan password" value="" class="form-control" type="password" autocomplete="off" required />
							<button type="button" id="pwd" class="btn btn-password btn-outline-primary">
								<i class="fa fa-eye"></i>
							</button>
						</div>
						<span validation-for="password"></span>
					</div>
					<div class="form-group">
						<div class="text-end mb-2">
							<nuxt-link to="/auth/forgot">Lupa Sandi?</nuxt-link>
						</div>
						<button class="btn btn-primary w-100">Masuk</button>
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
					const { data: response } = await this.$axios.post(`auth/login`, formData);
					this.$router.push('/member/dashboard');
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
