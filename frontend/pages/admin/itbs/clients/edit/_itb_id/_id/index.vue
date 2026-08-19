<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Edit Client" :pages="['Admin Area', 'Iklan Terima Beres']" />

        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" v-model="form.name" placeholder="Masukkan nama" value="" class="form-control" type="text" autocomplete="off" required>
                        <span validation-for="name"></span>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input name="phone" v-model="form.phone" placeholder="Masukkan nomor telepon" value="" class="form-control" type="number" autocomplete="off" required>
                        <span validation-for="phone"></span>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <select name="city_id" id="city_id" class="form-control">
                            <option :value="form.city_id" selected>{{ form.city_name }}</option>
                        </select>
                        <span validation-for="city_id"></span>
                    </div>
                    <div class="form-group">
                        <label>Notifikasi</label>
                        <div class="input-group">
                            <select name="is_notified" v-model="form.is_notified" id="is_notified" class="form-control">
                                <option value="0">Pending</option>
                                <option value="1">Terkirim</option>
                            </select>
                            <button id="btn-notify" type="button" class="btn btn-success bg-success bg-gradient"><i class="mdi mdi-whatsapp"></i> Kirim Info</button>
                        </div>
                        <span validation-for="is_notified"></span>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-secondary-gradient border-primary">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">Kirim Informasi</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="text-primary">Pesan</label>
                            <textarea name="message" id="message" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button id="btn-send" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/default",
        async asyncData({$axios, params, error}) {
            try {
                const {itb_id, id} = params;
                const { data: response } = await $axios.get(`admin/itbs/client-edit/${itb_id}/${id}`);
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
            if(typeof jQuery !== 'undefined') {
                const itb_name = this.form.itb_name;
                const itb_phone = this.form.itb_phone;

                $(`#city_id`).select2({
                    placeholder: 'Pilih Member',
                    allowClear: true,
                    ajax: {
                        url: "member/areas/cities-select2",
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                            };
                        },
                        success: data => {
                            $(`#city_id`).empty();
                        },
                        cache: true
                    },
                    minimumInputLength: 3,
                });

                $(`#btn-notify`).click(function (e) { 
                    e.preventDefault();
                    const name = $(`input[name="name"]`).val();
                    const phone = $(`input[name="phone"]`).val();
                    const city = $(`select[name="city_id"] option[selected]`).text();
                    const message = `Semangat terus Bos 💪
*${itb_name}* 
Ada mitra baru nih di STARCOM 🚀

Nama : ${name} 
No WA : ${phone} 
Kota : ${city}

Segera difollow up ya Bos, biar makin solid timnya 🙌🔥
`;
                    $(`#message`).val(message);
                    $(`#exampleModal`).modal("show");
                });

                $(`#btn-send`).click(function (e) { 
                    e.preventDefault();
                    $(`#exampleModal`).modal("hide");
                    const message = $(`#message`).val();
                    const encodedMessage = encodeURIComponent(message);
                    const link = `https://api.whatsapp.com/send/?phone=${itb_phone}&text=${encodedMessage}`;
                    location.href = link;
                });
            }
        },
        methods: {
            async form_submit(e) {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        const {itb_id, id} = this.$route.params;
                        const formData = new FormData(e.target);
                        const { data: response } = await this.$axios.post(`admin/itbs/client-edit/${itb_id}/${id}`, formData, {
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
                            this.$router.push(`/admin/itbs/clients/${itb_id}`);
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