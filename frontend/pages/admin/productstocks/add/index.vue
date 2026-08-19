<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Tambah Mutasi" :pages="['Admin Area', 'Mutasi Stok']" />

        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Formulir</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Produk</label>
                        <select name="product_id" class="form-control" required style="width: 100%;">
                            <option value="">-- Pilih Produk --</option>
                            <option v-for="product in products" :value="product.id" :key="product.id">{{ product.name }}</option>
                        </select>
                        <span validation-for="product_id"></span>
                    </div>
                    <div class="form-group">
                        <label>Tipe Mutasi</label>
                        <select name="type" class="form-control" required>
                            <option value="in">Masuk (In)</option>
                            <option value="out">Keluar (Out)</option>
                        </select>
                        <span validation-for="type"></span>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input name="qty" placeholder="Masukkan jumlah" value="" class="form-control" type="number" autocomplete="off" required>
                        <span validation-for="qty"></span>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" placeholder="Masukkan deskripsi" class="form-control" rows="6" required></textarea>
                        <span validation-for="description"></span>
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
                products: []
            }
        },
        mounted() {
            this.getProducts();
        },
        methods: {
            async getProducts() {
                try {
                    const { data: response } = await this.$axios.get(`admin/products?limit=100`);
                    this.products = response.results;

                    this.$nextTick(() => {
                        $('select[name="product_id"]').select2({
                            placeholder: "-- Pilih Produk --",
                            width: '100%'
                        });
                    });
                } catch (err) {
                    console.log(err);
                }
            },
            async form_submit(e) {
                if (typeof jQuery !== "undefined") {
                    try {
                        $.LoadingOverlay("show");
                        const formData = new FormData(e.target);
                        const { data: response } = await this.$axios.post(`admin/productstocks/add`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ya',
                        }).then((result) => {
                            this.$router.push('/admin/productstocks');
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
