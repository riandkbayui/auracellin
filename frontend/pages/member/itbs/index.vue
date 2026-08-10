<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Iklan Terima Beres" :pages="['Member Area']" />

		<ul v-if="results.length>0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
                <div v-on:click.prevent="openChat(item.phone)" class="card waves-effect w-100 mb-2">
                    <div class="card-body">
                        <div class="d-flex gap-2 align-items-center">
                            <div>
                                <div class="avatar-md rounded-circle ar-1-1 bg-primary-gradient d-flex justify-content-center align-items-center">
                                    <i class="mdi mdi-account-box fsz-32 text-secondary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="text-primary mb-1">{{ item.name }}</h5>
                                <div class="text-primary d-flex justify-content-between g-2">
                                    <div><i class="mdi mdi-pin"></i> {{item.city}}</div>
                                    <div><i class="mdi mdi-whatsapp"></i> {{ item.phone }}</div>
                                </div>
                            </div>
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
			<div class="skeleton skeleton-card ht-100"></div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/default",
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
        openChat(phone) {
            try {
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                const baseUrl = isMobile ? 'https://api.whatsapp.com/send/' : 'https://web.whatsapp.com/send';
                const url = `${baseUrl}?phone=${phone}`;
                location.href = url;
            } catch (error) {
                Swal.fire('Maaf!', String(error), 'error');
            }
        },
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`member/itbs`, {
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
