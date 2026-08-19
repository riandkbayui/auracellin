<script type="text/javascript" setup>
    import Breadcrumb from '@/components/main/breadcrumb';
    import PkgLink from "@/components/member/PkgLink";
</script>

<template>
    <div>
        <Breadcrumb title="Chapter" :pages="['Member Area', 'Ruang Belajar']" />
        <div class="card overflow-hidden">
            <div class="card-header p-0">
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe 
                        :src="data.url" 
                        frameborder="0" 
                        allowfullscreen 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    >
                    </iframe>
                </div>
            </div>
            <div class="card-body">
                <h5 class="text-primary">{{ data.name }}</h5>
                <p class="text-prewrap">{{ data.description }}</p>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between text-primary gap-2">
                    <div>
                        <img :src="user.photo" class="avatar-sm ar-1-1 rounded-circle border border-3 img-cover-center" />
                    </div>
                    <div class="flex-grow-1">
                        <div class="fsz-16">{{ user.name }}</div>
                        <div class="fw-bold">{{ user.username }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fw-bold fsz-18 mb-3 text-primary">Chapter Lainnya :</div>

        <ul class="list-unstyled p-0 m-0 mb-3">
			<li v-for="(item, index) in subs" :key="index">
				<PkgLink :to="`/member/studyrooms/subs/${item.code}`" :pkg_id="item.package_id" class="align-items-center waves-effect mb-2 p-3 rounded bg-secondary shadow d-flex gap-2">
					<div class="p-2 ar-1-1 bg-danger rounded-circle d-flex justify-content-center align-items-center">
						<span class="fa fa-video text-white"></span>
					</div>
					<div class="w-100 d-flex gap-2">
						<div :class="['flex-grow-1 text-body fsz-14']">{{ item.name }}</div>
                        <div>
							<div class="bg-primary px-2 py-1 fsz-10 text-secondary d-inline-block rounded fw-bold"><i class="mdi mdi-shield-account"></i> {{ item.package_name }}</div>
						</div>
					</div>
				</PkgLink>
			</li>
		</ul>

    </div>
</template>

<script type="text/javascript">
    export default {
        layout: "member/studyrooms",
        async asyncData({$axios, params, error}) {
            try {
                const { data: response } = await $axios.get(`member/studyrooms/subs/${params.slug}`);
                return {
                    data: response.data,
					user: response.user,
					subs: response.subs,
                }
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