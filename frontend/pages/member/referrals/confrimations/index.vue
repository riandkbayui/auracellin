<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Konfirmasi Pendaftaran" :pages="['Member Area']" />
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-primary">Informasi</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="d-inline-block mb-4">
                        <div class="wh-90 rounded-circle bg-success bg-gradient d-flex justify-content-center align-items-center">
                            <i class="mdi mdi-check fsz-42"></i>
                        </div>
                    </div>
                    <h5 class="text-primary">Pendaftaran Berhasil!</h5>
                    <div>Silahkan konfirmasi pendaftaran anggota baru dengan menghubungi admin dengan tombol di bawah ini.</div>
                </div>
            </div>
            <div class="card-footer">
                <a :href="`http://api.whatsapp.com/send/?phone=${$config('office_phone')}`" class="btn btn-success bg-success bg-gradient w-100"><i class="mdi mdi-whatsapp"></i> Hubungi Admin</a>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/default"
    }
</script>