<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Konfigurasi" :pages="['Admin Area']" />

		<ul v-if="results.length > 0" class="list-unstyled m-0 p-0 mb-3">
			<li v-for="(item, index) in results" :key="index">
				<div v-on:click.prevent="editForm(item)" class="card w-100 mb-2 waves-effect">
					<div class="card-body">
						<div class="d-flex gap-2 align-items-center text-white">
							<div class="avatar-md ar-1-1 rounded-circle bg-primary d-flex justify-content-center align-items-center">
								<i class="mdi mdi-pencil text-white fsz-24"></i>
							</div>
							<div class="flex-grow-1">
								<div>{{ item.description }} :</div>
								<div class="fw-bold">{{ item.value }}</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>

		<button v-if="!loadingNext && has_next" class="w-100 btn btn-success" @click.prevent="next">Berikutnya</button>

		<Error v-if="err != ''">
			<p class="text-white m-0">{{ err }}</p>
		</Error>

		<div v-if="loadingNext">
			<div class="skeleton skeleton-card ht-100"></div>
		</div>

		<form action="" v-on:submit.prevent="formSubmit" method="post">
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm modal-dialog-centered">
					<div class="modal-content bg-secondary-gradient text-white border-primary">
						<div class="modal-header">
							<h5 class="text-white">Formulir</h5>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>{{ form.description }} :</label>
								<textarea v-model="form.value" name="value" rows="4" class="form-control"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	layout: "member/default",
	data() {
		return {
			results: [],
			page: 1,
			has_next: false,
			err: "",
			loadingNext: true,
			form: {
				id: "",
				description: "",
				value: "",
			},
		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		async editForm(item) {
			this.form.id = item.id;
			this.form.description = item.description;
			this.form.value = item.value;
			if (typeof jQuery !== "undefined") {
				$(`#exampleModal`).modal("show");
			}
		},
		async formSubmit(e) {
			if (typeof jQuery !== "undefined") {
				try {
					$.LoadingOverlay("show");
					const formData = new FormData(e.target);
					formData.set("id", this.form.id);
					const { data: response } = await this.$axios.post(`admin/configs/update`, formData, {
						headers: {
							"Content-Type": "multipart/form-data",
						},
					});

					if (typeof jQuery !== "undefined") {
						$(`#exampleModal`).modal("hide");
					}

					Swal.fire("Berhasil!", response.message, "success");
					this.reload();
				} catch (err) {
					console.log(err);
					let err_msg = "";
					if (err.response) {
						err_msg = err.response.data.message;
						if (err.response.status == 400) {
							$.each(err.response.data.errors, function (index, val) {
								$(`span[validation-for="${index}"]`).text(val);
							});
						}
					} else {
						err_msg = err.toString();
					}
					Swal.fire("Maaf!", err_msg, "error");
				} finally {
					$.LoadingOverlay("hide");
				}
			}
		},
		async getData() {
			try {
				this.loadingNext = true;
				const { data: response } = await this.$axios.get(`admin/configs`, {
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
		reload() {
			this.results = [];
			this.page = 1;
			this.getData();
		},
	},
};
</script>
