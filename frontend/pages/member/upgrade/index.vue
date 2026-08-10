<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Upgrade" :pages="['Member Area']" />
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center text-primary">Informasi</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="d-inline-block mb-3">
                        <div class="wh-74 ar-1-1 rounded-circle d-flex bg-primary-gradient justify-content-center align-items-center">
                            <i class="mdi mdi-shield-account fsz-32 text-secondary"></i>
                        </div>
                    </div>
                    <p class="text-primary fsz-14">Silahkan upgrade akun anda untuk menikmati fitur sepenuhnya.</p>
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