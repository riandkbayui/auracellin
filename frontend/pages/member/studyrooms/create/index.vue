<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Package from "@/components/forms/packages";
</script>

<template>
	<div>
		<Breadcrumb title="Buat Baru" :pages="['Member Area', 'Ruang Belajar']" />

		<form action="" ref="form" v-on:submit.prevent="form_submit" method="post">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label>Thumbnail</label>
						<img id="preview-img" :src="photo_url" class="mb-2 rounded ar-16-9 w-100 img-cover-center" />
						<input type="file" ref="photo" accept=".jpg,.jpeg,.png" v-on:change.prevent="change_photo" name="photo" class="form-control" />
						<span validation-for="photo"></span>
					</div>
					<div class="form-group">
						<label>Judul</label>
						<input name="name" value="" placeholder="Masukkan judul" class="form-control" type="text" autocomplete="off" required />
						<span validation-for="name"></span>
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="description" placeholder="Masukkan deskripsi" class="form-control" rows="4" required></textarea>
						<span validation-for="description"></span>
					</div>
					<div class="form-group">
						<label>Paket</label>
						<Package name="package_id" v-model="package_id" required/>
						<span validation-for="package_id"></span>
					</div>
				</div>
			</div>

			<ul class="list-unstyled m-0 p-0">
				<li v-for="(item, index) in fields" :key="index">
					<div class="card">
						<div class="card-header">
							<div class="card-title">Chapter</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Judul</label>
								<input v-model="item.name" :name="`chapter[${index}][name]`" value="" placeholder="Masukkan judul" class="form-control" type="text" autocomplete="off" required />
								<span :validation-for="`chapter[${index}][name]`"></span>
							</div>
							<div class="form-group">
								<label>Link Youtube</label>
								<div class="input-group">
									<div class="input-group-text"><span class="fab fa-youtube"></span></div>
									<input v-model="item.url" :name="`chapter[${index}][url]`" value="" placeholder="Masukkan link youtube" class="form-control" type="text" autocomplete="off" required />
								</div>
								<span :validation-for="`chapter[${index}][url]`"></span>
							</div>
							<div class="form-group">
								<label>Deskripsi</label>
								<textarea v-model="item.description" :name="`chapter[${index}][description]`" placeholder="Masukkan deskripsi" class="form-control" rows="4" required></textarea>
								<span :validation-for="`chapter[${index}][description]`"></span>
							</div>
							<div class="form-group">
								<label>Paket</label>
								<Package v-model="item.package_id" :name="`chapter[${index}][package_id]`" required/>
								<span :validation-for="`chapter[${index}][package_id]`"></span>
							</div>
						</div>
						<div class="card-footer">
							<button type="button" v-on:click.prevent="removeField(index)" class="btn btn-danger w-100">
								<i class="fa fa-trash-alt"></i>
								Hapus Chapter
							</button>
						</div>
					</div>
				</li>
			</ul>

			<div class="d-block mb-4">
				<button type="button" v-on:click.prevent="addField" class="btn btn-outline-success w-100">
					<i class="fa fa-plus-circle"></i>
					Tambah Chapter
				</button>
			</div>

			<div class="card">
				<div class="card-body">
					<button type="submit" class="btn btn-primary w-100">
						<i class="fa fa-save"></i>
						Simpan
					</button>
				</div>
			</div>
		</form>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/studyrooms",
	data() {
		return {
			photo_url: "/assets/images/placeholder.jpg",
			package_id: "1",
			fields: [{
				name: "",
				description: "",
				url: "",
				package_id: "1",
			}],
		};
	},
	methods: {
		change_photo(e) {
			try {
				const [file] = e.target.files;
				this.photo_url = URL.createObjectURL(file);
			} catch (error) {
				console.log(error);
			}
		},
		addField() {
			this.fields.push({
				name: "",
				description: "",
				url: "",
				package_id: "1",
			});
		},
		removeField(index) {
			this.fields.splice(index, 1);
		},
		async form_submit(e) {
			if (typeof jQuery !== "undefined") {
				try {
					$.LoadingOverlay("show");
					const formData = new FormData(e.target);
					const { data: response } = await this.$axios.post(`member/studyrooms/create`, formData, {
						headers: {
							"Content-Type": "multipart/form-data",
						},
					});
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: false,
                        confirmButtonText: 'Ya',
                    }).then((result) => {
                        this.$router.push('/member/studyrooms/me')
                    });
				} catch (err) {
					console.log(err);
					if (err.response) {
						this.err = err.response.data.message;
						if (err.response.status == 400) {
							$.each(err.response.data.errors, function (index, val) {
								$(`span[validation-for="${index}"]`).text(val);
							});
						}
					} else {
						this.err = err.toString();
					}
					Swal.fire("Maaf!", this.err, "error");
				} finally {
					$.LoadingOverlay("hide");
				}
			}
		},
	},
};
</script>
