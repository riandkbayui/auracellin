<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
    <div>
        <Breadcrumb title="Starter Kit" :pages="['Member Area']" />

        <div class="card">
            <div class="card-body" v-html="html">
        
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/default",
        async asyncData({$axios, error}) {
            try {
                const { data: html } = await $axios.get(`member/toolkits/starter-kit`);
                return {html};
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
        }
    }
</script>