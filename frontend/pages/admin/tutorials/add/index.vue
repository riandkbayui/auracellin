<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Tambah Baru" :pages="['Admin Area', 'Tutorial']" />

        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir</div>
                </div>
                <div class="card-body">
                    <img :src="image_url" class="w-100 ar-16-9 img-cover-center rounded mb-2">
                    <div class="form-group">
                        <label>Upload Gambar</label>
                        <input name="photo" v-on:change.prevent="upload_img" placeholder="Pilih Gambar" value="" class="form-control" type="file" accept=".jpg,.jpeg,.png" autocomplete="off">
                        <span validation-for="photo"></span>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" placeholder="Masukkan nama" value="" class="form-control" type="text" autocomplete="off" required>
                        <span validation-for="name"></span>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" placeholder="Masukkan deskripsi" class="form-control" rows="6"></textarea>
                        <span validation-for="description"></span>
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="mdi mdi-youtube"></i></div>
                            <input name="url" placeholder="Masukkan url" value="" class="form-control" type="text" autocomplete="off" required>
                        </div>
                        <span validation-for="url"></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                        <span validation-for="status"></span>
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
        data() {
            return {
                image_url: '/assets/images/placeholder.jpg'
            }
        },
        methods: {
            upload_img(e) {
                try {
                    const [file] = e.target.files;
                    this.image_url = URL.createObjectURL(file);
                } catch (error) {
                    console.log(error);
                }
            },
            async form_submit(e) {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        const formData = new FormData(e.target);
                        const { data: response } = await this.$axios.post(`admin/tutorials/add`, formData, {
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
                            this.$router.push('/admin/tutorials');
                        });
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