<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Icon from "@/components/member/dashboard/icon";
import Carousels from "@/components/member/dashboard/carousels";
import PkgLink from "@/components/member/PkgLink";
</script>

<template>
	<div>
		<Breadcrumb title="Beranda" :pages="['Member Area']" />

		<div class="card">
			<div class="card-header">
				<h5 class="card-title text-white">
					<i class="mdi mdi-account-circle"></i>
					Profil
				</h5>
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center text-white">
					<div class="flex-grow-1">
						<div class="fw-bold">{{ $user(`username`) }}</div>
						<div class="fsz-16 mb-2">{{ $user(`name`) }}</div>
						<div>
							<span class="fsz-10 bg-primary fw-bold rounded px-2 py-1"><i class="mdi mdi-shield-account"></i> {{ $user(`package_name`) }}</span>
						</div>
					</div>
					<div>
						<img :src="$user(`photo`)" class="wh-64 ar-1-1 rounded-circle border border-3 img-cover-center" />
					</div>
				</div>
			</div>
			<div class="card-footer">
				<label class="text-white">Link Referral</label>
				<div class="input-group">
					<div class="form-control bg-body">{{ referral_url }}</div>
					<button v-on:click="copyReferralUrl" class="btn btn-primary"><i class="fa fa-copy"></i></button>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header text-center">
						<h4 class="card-title text-white"><i class="mdi mdi-account-circle"></i> Anggota AURA CELLIN</h4>
					</div>
					<div class="card-body">
						<div class="text-center">
							<h3 class="text-warning" v-html="count.users"></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-header text-center">
						<h4 class="card-title text-white"><i class="mdi mdi-book-open"></i> Ruang Belajar</h4>
					</div>
					<div class="card-body">
						<div class="text-center">
							<h3 class="text-warning" v-html="count.studyrooms"></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-header text-center">
						<h4 class="card-title text-white"><i class="mdi mdi-flag-checkered"></i> Total Misi</h4>
					</div>
					<div class="card-body">
						<div class="text-center">
							<h3 class="text-warning" v-html="count.missions"></h3>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div v-if="$user('group') == 'admin'" class="card">
			<div class="card-header">
				<h5 class="card-title text-white">
					<i class="mdi mdi-shield-account"></i>
					Admin Toolkit
				</h5>
			</div>
			<div class="card-body pb-0">
				<div class="row row-cols-4">
					<NuxtLink to="/admin/users" class="waves-effect">
						<Icon label="Pengguna" className="bx bxs-user-circle" />
					</NuxtLink>
					<NuxtLink to="/admin/itbs" className="waves-effect">
						<Icon label="ITB" className="bx bxs-megaphone" />
					</NuxtLink>
					<NuxtLink to="/admin/slideshows" className="waves-effect">
						<Icon label="Slideshow" className="bx bxs-image-alt" />
					</NuxtLink>
					<NuxtLink to="/admin/events" className="waves-effect">
						<Icon label="Event" className="bx bx-calendar-event" />
					</NuxtLink>
					<NuxtLink to="/admin/tutorials" className="waves-effect">
						<Icon label="Tutorial" className="bx bxs-help-circle" />
					</NuxtLink>
					<NuxtLink to="/admin/webinars" className="waves-effect">
						<Icon label="Webinar" className="bx bxs-video" />
					</NuxtLink>
					<NuxtLink to="/admin/merchandises" className="waves-effect">
						<Icon label="Merchandise" className="bx bxs-t-shirt" />
					</NuxtLink>
					<NuxtLink to="/admin/configs" className="waves-effect">
						<Icon label="Konfigurasi" className="bx bxs-cog" />
					</NuxtLink>
					<NuxtLink to="/member/landing-page" className="waves-effect">
						<Icon label="Landing Page" className="mdi mdi-home-account" />
					</NuxtLink>
					<NuxtLink to="/admin/whatsapp" className="waves-effect">
						<Icon label="Whatsapp" className="mdi mdi-whatsapp" />
					</NuxtLink>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title text-white">
					<i class="mdi mdi-toolbox"></i>
					Member Toolkit
				</h5>
			</div>
			<div class="card-body pb-0">
				<div class="row row-cols-4">
					<NuxtLink to="/member/cek-resi" class="waves-effect">
						<Icon label="Cek Resi" className="mdi mdi-truck-fast" />
					</NuxtLink>
					<NuxtLink to="/member/events" className="waves-effect">
						<Icon label="Event" className="mdi mdi-calendar" />
					</NuxtLink>
					<PkgLink to="/member/tutorials" :pkg_id="2" className="waves-effect">
						<Icon label="Tutorial" className="mdi mdi-help" />
					</PkgLink>
					<PkgLink to="/member/forms" :pkg_id="2" className="waves-effect">
						<Icon label="Form" className="mdi mdi-text-box" />
					</PkgLink>
					<NuxtLink to="/member/official" className="waves-effect">
						<Icon label="Official" className="mdi mdi-shield-check" />
					</NuxtLink>
					<NuxtLink to="/member/starter-kit" className="waves-effect">
						<Icon label="Starter Kit" className="mdi mdi-toolbox" />
					</NuxtLink>
					<NuxtLink to="/member/testimoni" class="waves-effect">
						<Icon label="Testimoni" className="mdi mdi-comment-quote" />
					</NuxtLink>
					<NuxtLink to="/member/webinars" class="waves-effect">
						<Icon label="Webinar" className="mdi mdi-video" />
					</NuxtLink>
					<NuxtLink to="/member/itbs" className="waves-effect">
						<Icon label="ITB" className="mdi mdi-bullhorn" />
					</NuxtLink>
					<NuxtLink to="/member/merchandises" class="waves-effect">
						<Icon label="Marchandise" className="mdi mdi-tshirt-crew" />
					</NuxtLink>
					<NuxtLink to="/member/coming-soon" class="waves-effect">
						<Icon label="Ads" className="mdi mdi-account-details" />
					</NuxtLink>
					<NuxtLink to="/member/scripts" class="waves-effect">
						<Icon label="Skrip" className="mdi mdi-script-text-outline" />
					</NuxtLink>
					<NuxtLink to="/member/coming-soon" class="waves-effect">
						<Icon label="Dream Plan" className="mdi mdi-calendar-check" />
					</NuxtLink>
					<NuxtLink to="/member/coming-soon" class="waves-effect">
						<Icon label="Kontes" className="mdi mdi-trophy" />
					</NuxtLink>
				</div>
			</div>
		</div>

		<Carousels />

		<div class="card overflow-hidden">
			<div class="card-header">
				<h5 class="card-title text-white"><i class="mdi mdi-account-circle"></i> Anggota</h5>
			</div>
			<div class="card-body p-0">
				<img src="/assets/images/team-mate.jpeg" class="w-100 ar-16-9 img-cover-center" />
			</div>
			<div class="card-footer">
				<div class="d-flex gap-2">
					<NuxtLink to="/member/referrals" class="btn btn-primary w-100">
						<i class="mdi mdi-account-multiple"></i>
						Sponsor
					</NuxtLink>
					<NuxtLink to="/member/referrals/register" class="btn bg-success bg-gradient w-100 text-white">
						<i class="mdi mdi-account-plus"></i>
						Aktivasi
					</NuxtLink>
				</div>
			</div>
		</div>

		<div class="card overflow-hidden">
			<div class="card-header">
				<h5 class="card-title text-white"><i class="mdi mdi-headset"></i> Customer Service</h5>
			</div>
			<div class="card-body p-0">
				<img src="/assets/images/customer-service.jpeg" class="w-100 ar-16-9 img-cover-center" />
			</div>
			<div class="card-footer">
				<a :href="`http://api.whatsapp.com/send/?phone=${$config('office_phone')}`" class="btn bg-success bg-gradient text-white w-100"><i class="mdi mdi-whatsapp"></i> Hubungi Admin</a>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	layout: "member/default",
	data() {
		return {
			referral_url: '-',
			count: {
				users: '<i class="fa fa-spinner fa-spin"></i>',
				studyrooms: '<i class="fa fa-spinner fa-spin"></i>',
				missions: '<i class="fa fa-spinner fa-spin"></i>',
			}
		}
	},
	mounted() {
		this.referral_url = `${location.origin}/ref/${this.$user('username')}`;
		this.getData();
	},
	methods: {
		async getData() {
			try {
				const { data: response } = await this.$axios.get(`member/dashboard`);
				this.count = response.count;
			} catch (err) {
				console.log(err);
				let err_msg = '';
				if (err.response) {
					err_msg = err.response.data.message;
				} else {
					err_msg = err.toString();
				}
				this.err = err_msg;
			}
		},
		async copyReferralUrl() {
			try {
				await navigator.clipboard.writeText(this.referral_url);
				Swal.fire('Berhasil!', `Link referral disalin.`, 'success');
			} catch (error) {
				console.log(error);
			}
		}
	}
};
</script>
