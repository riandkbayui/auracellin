<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
        <Breadcrumb title="Buka Misi" :pages="['Member Area', 'Misi']" />

		<div class="card">
			<div class="card-header">
				<div class="d-flex gap-2 justify-content-between text-primary">
					<div>
						<img :src="user.photo" class="avatar-sm ar-1-1 rounded-circle border border-3 img-cover-center" />
					</div>
					<div class="flex-grow-1">
						<div class="fsz-16">{{ user.name }}</div>
						<div class="fw-bold">{{ user.username }}</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<h5 class="text-primary">{{ data.name }}</h5>
				<p class="text-prewrap">{{ data.description }}</p>
			</div>
            <div class="card-footer">
                <a :href="data.url" target="_blank" class="btn btn-primary w-100"><i class="mdi mdi-link"></i> Kunjungi Link</a>
            </div>
		</div>

        <form method="post" ref="form" v-on:submit.prevent="form_submit" action="">
			<div class="card">
				<div class="card-header">
					<div class="card-title">Formulir</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Bukti Misi</label>
						<img :src="sub.photo" id="img-preview" class="w-100 mb-2 rounded ar-16-9 img-cover-center">
						<input type="file" name="photo" accept=".jpg,.jpeg,.png" class="form-control">
						<span validation-for="photo"></span>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="description" v-model="sub.description" placeholder="Masukkan deskripsi" class="form-control" rows="6" required></textarea>
						<span validation-for="description"></span>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary w-100"><i class="fa fa-save"></i> Submit</button>
				</div>
			</div>
		</form>
	</div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/mission",
        async asyncData({$axios, params, error}) {
            try {
                const { data: response } = await $axios.get(`member/missions/open/${params.slug}`);
                return {
                    data: response.data,
                    user: response.user,
                    sub: response.sub,
                }
            } catch (err) {
                console.log(err);
                let err_msg = "";
                if (err.response) {
                    err_msg = err.response.data.message;
                } else {
                    err_msg = err.toString();
                }
                error({statusCode: 404, message: err_msg});
            }
        },
        mounted() {
            if(typeof jQuery !== 'undefined') {
                $(document).ready(function () {
                    $(`input[type="file"][name="photo"]`).previewImgTo(`#img-preview`);
                });
            }
        },
        methods: {
            async form_submit() {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        const formData = new FormData(this.$refs.form);

                        let url = `member/missions/submit/${this.data.code}`;
                        if(this.sub.hasOwnProperty(`status`)) {
                            url = `member/missions/updatesub/${this.data.code}`;
                        }

                        const { data: response } = await this.$axios.post(url, formData, {
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
                            this.$router.push('/member/missions');
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
    }
</script>
