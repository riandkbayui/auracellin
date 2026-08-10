<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Detail" :pages="['Member Area', 'Webinar']" />
        <div class="card overflow-hidden">
            <div class="card-header p-0">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe :src="item.url" frameborder="0" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%" />
                </div>
            </div>
            <div class="card-body">
                <h5 class="text-primary">{{ item.name }}</h5>
                <p class="text-prewrap">{{ item.description }}</p>
            </div>
        </div>
	</div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/default",
        async asyncData({$axios, params, error}) {
            try {
                const { data: response } = await $axios.get(`member/webinars/open/${params.slug}`);
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
        }
    }
</script>