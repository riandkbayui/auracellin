<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Aktivasi" :pages="['Member Area']" />

		<form id="form" action="" ref="form" v-on:submit.prevent="form_submit" method="post">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="card-title">Foto Profil</div>
						</div>
						<div class="card-body">
							<div class="text-center mb-2">
								<img id="preview-img" src="/assets/images/user.png" class="w-100 img-cover-center ar-1-1 rounded" alt="foto profil" />
							</div>
							<div class="form-group">
								<label>Upload Foto</label>
								<input name="photo" class="form-control" type="file" accept=".jpg,.jpeg,.png" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="card-title">Biodata Pengguna</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input name="name" placeholder="Masukkan nama pengguna" value="" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="name"></span>
							</div>
							<div class="form-group">
								<label>Username</label>
								<input name="username" placeholder="Masukkan username" value="" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="username"></span>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input name="email" placeholder="Masukkan email" value="" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="email"></span>
							</div>
							<div class="form-group">
								<label>Telp (WA)</label>
								<input name="phone" placeholder="Masukkan telp (wa)" value="" class="form-control" type="number" autocomplete="off" required />
								<span validation-for="phone"></span>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<textarea name="address" placeholder="Masukkan alamat" class="form-control" rows="4"></textarea>
								<span validation-for="address"></span>
							</div>
							<div class="form-group">
								<label>Kata sandi</label>
								<div class="input-group">
									<input name="password" placeholder="Masukkan kata sandi" value="" class="form-control" type="password" autocomplete="off" />
									<button type="button" class="btn btn-pw btn-outline-primary"><i class="fa fa-eye"></i></button>
								</div>
								<span validation-for="password"></span>
							</div>
							<div class="form-group">
								<label>Konfirmasi sandi</label>
								<div class="input-group">
									<input name="password_confrimation" placeholder="Masukkan konfirmasi sandi" value="" class="form-control" type="password" autocomplete="off" />
									<button type="button" class="btn btn-pw btn-outline-primary"><i class="fa fa-eye"></i></button>
								</div>
								<span validation-for="password_confrimation"></span>
							</div>
						</div>
						<div class="card-footer">
							<button class="w-100 btn btn-primary">
								<i class="fa fa-save"></i>
								Simpan Perubahan
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/default",
    mounted() {
        if(typeof jQuery !== 'undefined') {
            $(document).ready(function () {
                $(`.btn-pw`).passwordToggle();
                $(`input[name="username"]`).inputUsername();
                $(`input[name="email"]`).inputEmail();
                $(`input[name="phone"]`).inputOnlyNumber();
                $(`input[name="photo"]`).previewImgTo(`#preview-img`);
            });
        }
    },
    methods: {
        async form_submit() {
            if (typeof jQuery !== "undefined") {
                try {
                    $.LoadingOverlay("show");
                    const formData = new FormData(this.$refs.form);
                    const { data: response } = await this.$axios.post(`member/referrals/register`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    Swal.fire('Berhasil!', response.message, 'success');
					this.$router.push(`/member/referrals/confrimations`);
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
