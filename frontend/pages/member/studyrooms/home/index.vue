<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
import PkgLink from "@/components/member/PkgLink";
</script>

<template>
	<div>
		<Breadcrumb title="Ruang Belajar" :pages="['Member Area', 'Ruang Belajar']" />

        <ul v-if="results.length>0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div class="card overflow-hidden">
					<div class="card-header p-0">
						<img :src="item.photo" class="w-100 ar-16-9 img-cover-center">
					</div>
					<div class="card-body">
                        <h5 :class="['text-primary']">{{ item.name }}</h5>
						<p class="text-prewrap text-ellipsis-3">{{ item.description }}</p>
						<div>
							<div class="bg-primary px-2 py-1 fsz-10 text-white d-inline-block rounded fw-bold"><i class="mdi mdi-shield-account"></i> {{ item.package_name }}</div>
						</div>
					</div>
					<div class="card-footer">
                        <div class="d-flex gap-2">
                            <PkgLink :to="`/member/studyrooms/open/${item.code}`" :pkg_id="item.package_id" class="btn btn-primary flex-grow-1">
                                <span class="text-white"><i class="fa fa-user-graduate"></i> Belajar Sekarang</span>
                            </PkgLink>
                            <button v-on:click="fav(item)" :class="['btn', (item.is_fav == '0' ? 'btn-pink' : 'btn-danger')]"><i class="text-white fa fa-heart"></i></button>
                        </div>
					</div>
				</div>
			</li>
		</ul>

        <button v-if="!loadingNext && has_next" class="w-100 btn btn-warning" v-on:click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-300"></div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/studyrooms",
	data() {
		return {
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
				const { data: response } = await this.$axios.get(`member/studyrooms`, {
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
        async fav(item) {
            try {
                const formData = new FormData();
                formData.set('code', item.code);
                const {data: response} = await this.$axios.post(`member/studyrooms/fav`, formData);
                item.is_fav = response.fav_status == "active" ? "1" : "0";
            } catch(err) {
                if (err.response) {
                    this.err = err.response.data.message;
                    Swal.fire('Maaf!', err.response.data.message, 'error');
                } else {
                    this.err = err.toString();
                    Swal.fire('Maaf!', err.toString(), 'error');
                }
            }
        },
        isFav(item) {
            console.log(`${item.name}: `, item.is_fav);
            return item.is_fav == "0" ? "btn-pink" : "btn-danger";
        },
	},
};
</script>
