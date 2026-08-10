<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Packages from "@/components/forms/packages";
</script>

<template>
	<div>
		<Breadcrumb title="Edit" :pages="['Admin Area', 'Pengguna']" />

		<form id="form" action="" ref="form" v-on:submit.prevent="form_submit" method="post">
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<div class="card-title">Foto Profil</div>
						</div>
						<div class="card-body">
							<div class="text-center mb-2">
								<img id="preview-img" :src="user.photo" class="w-100 img-cover-center ar-1-1 rounded" alt="foto profil" />
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
								<input name="name" v-model="user.name" placeholder="Masukkan nama pengguna" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="name"></span>
							</div>
							<div class="form-group">
								<label>Username</label>
								<input name="username" v-model="user.username" placeholder="Masukkan username" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="username"></span>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input name="email" v-model="user.email" placeholder="Masukkan email" class="form-control" type="text" autocomplete="off" required />
								<span validation-for="email"></span>
							</div>
							<div class="form-group">
								<label>Telp (WA)</label>
								<input name="phone" v-model="user.phone" placeholder="" class="form-control" type="number" autocomplete="off" required />
								<span validation-for="phone"></span>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<textarea name="address" v-html="user.address" placeholder="" class="form-control" rows="4"></textarea>
								<span validation-for="address"></span>
							</div>
                            <div class="form-group">
								<label>Paket</label>
								<Packages name="package_id" class="form-control" v-model="user.package_id" />
								<span validation-for="package"></span>
							</div>
                            <div class="form-group">
								<label>Grup</label>
								<select name="group" class="form-control" v-model="user.group" required>
                                    <option value="">-- Pilih Grup --</option>
                                    <option value="admin">Admin</option>
                                    <option value="member">Member</option>
                                </select>
								<span validation-for="group"></span>
							</div>
                            <div class="form-group">
								<label>Status</label>
								<select name="status" class="form-control" v-model="user.status" required>
                                    <option value="">-- Pilih Grup --</option>
                                    <option value="pending">Pending</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
								<span validation-for="status"></span>
							</div>
							<p class="text-warning">* Kosongkan jika tidak ingin mengubah kata sandi.</p>
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
    async asyncData({$axios, params, error}) {
        try {
            const { data: response } = await $axios.get(`admin/users/edit/${params.slug}`);
            return response;
        } catch (err) {
            console.log(err);
            let err_msg = '';
            if (err.response) {
                err_msg = err.response.data.message;
            } else {
                err_msg = err.toString();
            }
            error({statusCode: 404, message: err_msg});
        }
    },
    mounted() {
        this.address = this.$user("address");
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
                    const {slug} = this.$route.params;
                    const formData = new FormData(this.$refs.form);
                    const { data: response } = await this.$axios.post(`admin/users/edit/${slug}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: false,
                        confirmButtonText: 'Ya',
                    }).then((result) => {
                        this.$router.push('/admin/users');
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
