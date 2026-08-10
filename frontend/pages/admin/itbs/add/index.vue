<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Tambah" :pages="['Admin Area', 'Iklan Terima Beres']" />

        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" placeholder="Masukkan nama" value="" class="form-control" type="text" autocomplete="off" required>
                        <span validation-for="name"></span>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input name="phone" placeholder="Masukkan nomor telepon" value="" class="form-control" type="number" autocomplete="off" required>
                        <span validation-for="phone"></span>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" placeholder="Masukkan deskripsi" class="form-control" rows="6"></textarea>
                        <span validation-for="description"></span>
                    </div>
                    <div class="form-group">
                        <label>Member</label>
                        <select name="user_id" id="user_id" class="form-control"></select>
                        <span validation-for="user_id"></span>
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
        mounted() {
            if(typeof jQuery !== 'undefined') {
                $(`#user_id`).select2({
                    placeholder: 'Pilih Member',
                    allowClear: true,
                    ajax: {
                        url: "admin/users/select2",
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                            };
                        },
                        success: data => {
                            $(`#user_id`).empty();
                        },
                        cache: true
                    },
                    minimumInputLength: 3,
                });
            }
        },
        methods: {
            async form_submit(e) {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        const {slug} = this.$route.params;
                        const formData = new FormData(e.target);
                        const { data: response } = await this.$axios.post(`admin/itbs/add`, formData, {
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
                            this.$router.push(`/admin/itbs`);
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