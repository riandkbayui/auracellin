<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Landing Page" :pages="['Member Area']" />
        <form action="" v-on:submit.prevent="formSubmit" method="post">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-white">Formulir</h5>
                </div>
                <div class="card-body">
                    <div>
                        <div class="text-primary"><i class="mdi mdi-chevron-right"></i> SECTION 6 – PRODUK BERNILAI, HASIL TERBUKTI</div>
                        <div class="form-group">
                            <label>Testimoni</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-youtube"></i></span>
                                <input name="section6[testimoni]" v-model="pages['section6.testimoni']" placeholder="Masukkan link youtube" value="" class="form-control" type="text" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-primary"><i class="mdi mdi-chevron-right"></i> SECTION 7 – SISTEM YANG MENGANGKATMU</div>
                        <div class="form-group">
                            <label>Testimoni Mitra</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-youtube"></i></span>
                                <input name="section7[testimoni]" v-model="pages['section7.testimoni']" placeholder="Masukkan link youtube" value="" class="form-control" type="text" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-primary"><i class="mdi mdi-chevron-right"></i> SECTION 9 – CARA GABUNG & AKTIVASI</div>
                        <div class="form-group">
                            <label>Testimoni Member Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-youtube"></i></span>
                                <input name="section9[testimoni]" v-model="pages['section9.testimoni']" placeholder="Masukkan link youtube" value="" class="form-control" type="text" autocomplete="off" required>
                            </div>
                        </div> 
                    </div>
                    <div>
                        <div class="text-primary"><i class="mdi mdi-chevron-right"></i> SECTION 10 – JANGAN TUNGGU WAKTU YANG “TEPAT”</div>
                        <div class="form-group">
                            <label>Testimoni Perubahan Hidup</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-youtube"></i></span>
                                <input name="section10[testimoni]" v-model="pages['section10.testimoni']" placeholder="Masukkan link youtube" value="" class="form-control" type="text" autocomplete="off" required>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/default",
        async asyncData({$axios, error, redirect}) {
            try {
                const { data: response } = await $axios.get(`member/landing-pages`);
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
        components: {
            UploadPhoto: {
                props: {
                    label: {
                        required: true,
                        type: String,
                        default: ""
                    },
                    image: {
                        required: true,
                        type: String,
                        default: ""
                    },
                    inputName: {
                        required: true,
                        type: String,
                        default: ""
                    }
                },
                methods: {
                    uploadImg(e) {
                        try {
                            const [file] = e.srcElement.files;
                            this.image = URL.createObjectURL(file);
                        } catch (error) {
                            console.log(error);
                        }
                    }
                },
                computed: {
                    imageUrl() {
                        if(String(this.image) != '') {
                            return this.image;
                        } else {
                            return '/assets/images/placeholder.jpg';
                        }
                    }
                },
                render() {
                    return (
                        <div class="form-group">
                            <label>{this.label}</label>
                            <div class="mb-2">
                                <img src={this.imageUrl} class="ar-1-1 w-100 rounded img-cover-center" />
                            </div>
                            <input name={this.inputName} onChange={this.uploadImg} placeholder="Pilih gambar" accept=".jpg,.jpeg,.png" value="" class="form-control" type="file" autocomplete="off" />
                        </div>
                    )
                }
            }
        },
        methods: {
            async formSubmit(e) {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        $(`span[validation-for`).text('');
                        const formData = new FormData(e.target);
                        const { data: response } = await this.$axios.post(`member/landing-pages`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        Swal.fire('Berhasil!', response.message, 'success');
                    } catch (err) {
                        console.log(err);
                        let err_msg = '';
                        if (err.response) {
                            err_msg = err.response.data.message;
                            if (err.response.status == 400) {
                                $.each(err.response.data.errors, function(index, val) {
                                    $(`span[validation-for="${index}"]`).text(val);
                                });
                            }
                        } else {
                            err_msg = err.toString();
                        }
                        Swal.fire('Maaf!', err_msg, 'error');
                    } finally {
                        $.LoadingOverlay("hide");
                    }
                }
            }
        }
    }
</script>