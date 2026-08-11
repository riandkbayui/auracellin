<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
    <div>
        <Breadcrumb title="Clients" :pages="['Admin Area', 'Iklan Terima Beres']" />

        <div class="mt-2 mb-3 text-end">
            <NuxtLink class="btn btn-success bg-success bg-gradient" :to="`/admin/itbs/clients/add/${slug}`"><i class="mdi mdi-plus-circle"></i> Buat Baru</NuxtLink>
        </div>

        <ul v-if="results.length>0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
                <NuxtLink :to="`/admin/itbs/clients/edit/${item.itb_id}/${item.id}`">
                    <div class="card waves-effect w-100 mb-2">
                        <div class="card-body">
                            <div class="d-flex gap-2 align-items-center">
                                <div>
                                    <div class="avatar-md rounded-circle ar-1-1 bg-primary d-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-account-box fsz-32 text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="text-white mb-1">{{ item.name }}</h5>
                                    <div class="text-white d-flex justify-content-between g-2">
                                        <div><i class="mdi mdi-whatsapp"></i> {{ item.phone }}</div>
                                        <div><i class="mdi mdi-pin"></i> {{ item.city || "-" }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </NuxtLink>
			</li>
		</ul>

		<button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" v-on:click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-100"></div>
		</div>
    </div>
</template>

<script type="text/javascript">
    export default {
	layout: "member/default",
	data() {
        const {slug} = this.$route.params;
		return {
            slug,
			results: [],
			page: 1,
			has_next: false,
			err: "",
			loadingNext: true,
		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		async getData() {
			try {
				this.loadingNext = true;
                const {slug} = this.$route.params;
				const { data: response } = await this.$axios.get(`admin/itbs/clients/${slug}`, {
					params: {
						page: this.page,
					},
				});

				this.err = "";
                this.results = [...this.results, ...response.results];
				this.has_next = response.has_next;
			} catch (err) {
				console.log(err);
				if (err.response) {
					this.err = err.response.data.message;
				} else {
					this.err = err.toString();
				}
			} finally {
				this.loadingNext = false;
			}
		},
		next() {
			this.page++;
			this.getData();
		},
	},
};
</script>
