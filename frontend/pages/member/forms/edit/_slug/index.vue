<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
</script>

<template>
	<div>
		<Breadcrumb title="Edit" :pages="['Member Area', 'Form']" />
		<form action="" v-on:submit.prevent="form_submit" method="post">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Nama
						</label>
						<input name="name" v-model="form.name" placeholder="Masukkan nama" value="" class="form-control" type="text" autocomplete="off" required />
						<span validation-for="name"></span>
					</div>
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Link
						</label>
						<div class="input-group">
							<input name="slug" v-model="form.slug" placeholder="Masukkan link" value="" class="form-control" type="text" autocomplete="off" required />
							<button type="button" v-on:click.prevent="copyToClipboard" class="btn btn-primary"><i class="mdi mdi-content-copy"></i></button>
						</div>
						<span validation-for="slug"></span>
					</div>
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Kata Pembuka
						</label>
						<textarea name="text_start" v-model="form.text_start" placeholder="Masukkan kata pembuka" class="form-control" required="" rows="4"></textarea>
						<span validation-for="text_start"></span>
					</div>
					<div class="form-group">
						<label>Kata Penutup</label>
						<textarea name="text_end" v-model="form.text_end" placeholder="Masukkan kata penutup" class="form-control" rows="4"></textarea>
						<span validation-for="text_end"></span>
					</div>
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Nomor Telepon
						</label>
						<textarea name="phones" v-model="form.phones" placeholder="Masukkan nomor telepon" class="form-control" required="" rows="4"></textarea>
						<small class="text-primary">* Nomor lebih dari satu pisahkan dengan tanda ( ; ).</small>
						<span validation-for="phones"></span>
					</div>
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Bidang
						</label>
						<ul id="contents" class="my-3 list-unstyled p-0">
							<li v-for="(item, index) in form.fields" :key="index">
								<div class="input-group mb-3">
									<input v-model="form.fields[index]" name="fields[]" placeholder="Masukkan nama bidang" value="" class="form-control" type="text" autocomplete="off" required />
									<button type="button" v-on:click.prevent="remFields(index)" class="btn btn-danger btn-rem"><i class="bx bx-trash"></i></button>
								</div>
							</li>
						</ul>
						<button id="btn-add" v-on:click.prevent="addFields" type="button" class="btn btn-primary w-100">
							<i class="bx bx-plus-circle"></i>
							Tambah Bidang
						</button>
						<span validation-for="fields"></span>
					</div>
					<div class="form-group">
						<label>
							<span class="text-warning">*</span>
							Status
						</label>
						<select v-model="form.status" name="status" class="form-control" required="">
							<option value="active">Aktif</option>
							<option value="inactive">Tidak Aktif</option>
						</select>
						<span validation-for="status"></span>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary w-100" type="submit">
						<i class="bx bx-save"></i>
						Simpan
					</button>
				</div>
			</div>
		</form>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/default",
	async asyncData({ $axios, params, error }) {
		try {
			const { data: response } = await $axios.get(`member/forms/edit/${params.slug}`);
			return response;
		} catch (err) {
			console.log(err);
			let err_msg = "";
			if (err.response) {
				err_msg = err.response.data.message;
			} else {
				err_msg = err.toString();
			}
			error({ statsuCode: 404, message: err_msg });
		}
	},
	watch: {
		"form.name"(val) {
			console.log(val);
			this.form.slug = String(val)
				.toLocaleLowerCase()
				.replace(/[^0-9a-z]+/g, "-")
				.replace(/^-+|-+$/g, "");
		},
	},
	methods: {
		addFields() {
			this.form.fields.push("");
		},
		remFields(index) {
			this.form.fields.splice(index, 1);
		},
		async copyToClipboard() {
			const text = `${location.origin}/form/${this.form.slug}`;
			if (navigator.clipboard && window.isSecureContext) {
				try {
					await navigator.clipboard.writeText(text);
					Swal.fire("Berhasil!", `Link disalin!`, "success");
				} catch (error) {
					Swal.fire("Maaf!", String(error), "error");
				}
			} else {
				// Fallback untuk browser lama atau non-HTTPS
				try {
					const textArea = document.createElement("textarea");
					textArea.value = text;
					textArea.style.position = "fixed";
					document.body.appendChild(textArea);
					textArea.focus();
					textArea.select();
					const successful = document.execCommand("copy");
					document.body.removeChild(textArea);
					if (successful) {
						Swal.fire("Berhasil!", `Link disalin!`, "success");
					} else {
						throw new Error("Gagal menyalin link");
					}
				} catch (error) {
					Swal.fire("Maaf!", "Browser Anda tidak mendukung fitur salin otomatis.", "error");
				}
			}
		},
		async form_submit(e) {
			if (typeof jQuery !== "undefined") {
				try {
					$.LoadingOverlay("show");
					const { slug } = this.$route.params;
					const formData = new FormData(e.target);
					const { data: response } = await this.$axios.post(`member/forms/edit/${slug}`, formData, {
						headers: {
							"Content-Type": "multipart/form-data",
						},
					});
					Swal.fire({
						title: "Berhasil!",
						text: response.message,
						icon: "success",
						showCancelButton: false,
						confirmButtonColor: false,
						confirmButtonText: "Ya",
					}).then((result) => {
						this.$router.push("/member/forms");
					});
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
	},
};
</script>
