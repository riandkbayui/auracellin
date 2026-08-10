<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Edit" :pages="['Member Area', 'Misi']" />
		<form action="" v-on:submit.prevent="form_submit" ref="form" method="post">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label>Judul</label>
						<input name="name" value="" v-model="form.name" placeholder="Masukkan judul" class="form-control" type="text" autocomplete="off" required />
						<span validation-for="name"></span>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="description" placeholder="Masukkan deskripsi" class="form-control" rows="4" v-model="form.description" required></textarea>
						<span validation-for="description"></span>
					</div>
					<div class="form-group">
						<label>Link Tujuan</label>
						<div class="input-group">
							<div class="input-group-text"><i class="fa fa-link"></i></div>
							<input name="url" value="" v-model="form.url" placeholder="Masukkan link" class="form-control" type="text" autocomplete="off" required />
						</div>
						<span validation-for="url"></span>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary w-100">
						<i class="fa fa-save"></i>
						Simpan
					</button>
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
            const { data: response } = await $axios.get(`member/missions/edit/${params.slug}`);
            return { form: response.form }
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
    methods: {
        async form_submit() {
            if (typeof jQuery !== "undefined") {
                try {
                    $.LoadingOverlay("show");
                    const {slug} = this.$route.params;
                    const formData = new FormData(this.$refs.form);
                    const { data: response } = await this.$axios.post(`member/missions/edit/${slug}`, formData, {
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
                        this.$router.push("/member/missions/me");
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
