<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Buat Baru" :pages="['Member Area', 'Form']" />
        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Nama
                        </label>
                        <input name="name" v-model="name" placeholder="Masukkan nama" value="" class="form-control" type="text" autocomplete="off" required />
                        <span validation-for="name"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Link
                        </label>
                        <input name="slug" v-model="link" placeholder="Masukkan link" value="" class="form-control" type="text" autocomplete="off" required />
                        <span validation-for="slug"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Kata Pembuka
                        </label>
                        <textarea name="text_start" placeholder="Masukkan kata pembuka" class="form-control" required="" rows="4"></textarea>
                        <span validation-for="text_start"></span>
                    </div>
                    <div class="form-group">
                        <label>Kata Penutup</label>
                        <textarea name="text_end" placeholder="Masukkan kata penutup" class="form-control" rows="4"></textarea>
                        <span validation-for="text_end"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Nomor Telepon
                        </label>
                        <textarea name="phones" placeholder="Masukkan nomor telepon" class="form-control" required="" rows="4"></textarea>
                        <small class="text-warning">* Nomor lebih dari satu pisahkan dengan tanda ( ; ).</small>
                        <span validation-for="phones"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Bidang
                        </label>
                        <input name="fields[]" placeholder="Masukkan nama bidang" value="" class="form-control" type="text" autocomplete="off" required />
                        <ul id="contents" class="my-3 list-unstyled p-0">
                            <li v-for="(item, index) in fields" :key="index">
                                <div class="input-group mb-3">
                                    <input v-model="fields[index]" name="fields[]" placeholder="Masukkan nama bidang" value="" class="form-control" type="text" autocomplete="off" required>
                                    <button type="button" v-on:click.prevent="remFields(index)" class="btn btn-danger btn-rem"><i class="bx bx-trash"></i></button>
                                </div>
                            </li>
                        </ul>
                        <button id="btn-add" v-on:click.prevent="addFields" type="button" class="btn btn-outline-primary w-100">
                            <i class="bx bx-plus-circle"></i>
                            Tambah Bidang
                        </button>
                        <span validation-for="fields"></span>
                    </div>
                    <div class="form-group">
                        <label>
                            <span class="text-warning">*</span>
                            Status
                        </label>
                        <select name="status" class="form-control" required="">
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                        <span validation-for="status"></span>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bx bx-save"></i>
                        Simpan
                    </button>
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
            fields: [],
            name: '',
            link: ''
        }
    },
    watch: {
        name(val) {
            console.log(val);
            this.link = String(val)
                .toLocaleLowerCase()
                .replace(/[^0-9a-z]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    },
    methods: {
        addFields() {
            this.fields.push('');
        },
        remFields(index) {
            this.fields.splice(index, 1);
        },
        async form_submit(e) {
            if (typeof jQuery !== "undefined") {
                try {
                    $.LoadingOverlay("show");
                    const formData = new FormData(e.target);
                    const { data: response } = await this.$axios.post(`member/forms/add`, formData, {
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
                        this.$router.push('/member/forms');
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
};
</script>
