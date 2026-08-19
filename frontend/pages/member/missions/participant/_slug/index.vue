<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
        <Breadcrumb title="Detail Partisipan" :pages="['Member Area', 'Misi']" />

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
		</div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail</div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Bukti Misi</label>
                    <img :src="sub.photo" id="img-preview" class="w-100 mb-2 rounded ar-16-9 img-cover-center">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <div class="form-control h-100 text-prewrap">{{sub.description}}</div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-control h-100 text-prewrap">{{sub.status}}</div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <button v-on:click.prevent="acceptOrReject('reject')" class="btn btn-danger flex-fill"><i class="fa fa-times-circle"></i> Tolak</button>
                    <button v-on:click.prevent="acceptOrReject('accept')" class="btn btn-success flex-fill"><i class="fa fa-check-circle"></i> Terima</button>
                </div>
            </div>
        </div>
	</div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/mission",
        async asyncData({$axios, params, error}) {
            try {
                const { data: response } = await $axios.get(`member/missions/participant/${params.slug}`);
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
            async acceptOrReject(type) {
                try {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: `Anda akan ${type=="accept" ? "menerima" : "menolak"} submit misi dari partisipan?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: false,
                        cancelButtonColor: false,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya',
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            if(typeof jQuery !== 'undefined') {
                                try {
                                    $.LoadingOverlay("show");
                                    const {slug} = this.$route.params;
                                    const data = new URLSearchParams();
                                    data.append('type', type);
                                    const { data: response } = await this.$axios.post(`member/missions/participant/${slug}`, data, {
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
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
                                        this.$router.push(`/member/missions/participants`)
                                    });
                                } catch (err) {
                                    console.log(err);
                                    let err_msg = "";
                                    if (err.response) {
                                        err_msg = err.response.data.message;
                                    } else {
                                        err_msg = err.toString();
                                    }
                                    Swal.fire('Maaf!', err_msg, 'error');
                                } finally {
                                    $.LoadingOverlay("hide");
                                }
                            }
                        }
                    });
                } catch (err) {
                    console.log(err);
                    let err_msg = "";
                    if (err.response) {
                        err_msg = err.response.data.message;
                    } else {
                        err_msg = err.toString();
                    }
                    Swal.fire('Maaf!', err_msg, 'error');
                } finally {
                    if(typeof jQuery !== 'undefined') {
                        $.LoadingOverlay("hide");
                    }
                }
            }
        }
    }
</script>
