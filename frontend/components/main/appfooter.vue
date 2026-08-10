<script type="text/javascript" setup>
import PkgLink from "@/components/member/PkgLink";
</script>

<template>
	<ul id="bottom-nav" class="list-unstyled bg-secondary-gradient d-print-none">
		<li class="waves-effect">
			<NuxtLink to="/member/studyrooms" class="w-100">
				<div>
					<div><i class="mdi mdi-book-open-variant" /></div>
					<div class="fsz-12">Belajar</div>
				</div>
			</NuxtLink>
		</li>
		<li class="waves-effect">
			<PkgLink to="/member/missions" :pkg_id="2" class="w-100">
				<div>
					<div><i class="mdi mdi-flag-checkered" /></div>
					<div class="fsz-12">Misi</div>
				</div>
			</PkgLink>
		</li>
		<li class="waves-effect">
			<NuxtLink to="/member/dashboard" class="w-100">
				<div>
					<div><i class="mdi mdi-home" /></div>
					<div class="fsz-12">Home</div>
				</div>
			</NuxtLink>
		</li>
		<li class="waves-effect">
			<NuxtLink to="/member/account" class="w-100">
				<div>
					<div><i class="mdi mdi-account-circle" /></div>
					<div class="fsz-12">Akun</div>
				</div>
			</NuxtLink>
		</li>
		<li class="waves-effect">
			<NuxtLink to="/auth/logout" class="w-100">
				<div>
					<div><i class="mdi mdi-logout" /></div>
					<div class="fsz-12">Keluar</div>
				</div>
			</NuxtLink>
		</li>
	</ul>
</template>

<script type="text/javascript">
	export default {
		mounted() {
			Waves.init();

			if(typeof jQuery !== 'undefined') {
				const BASE_URL = this.$axios.defaults.baseURL;
				$.ajaxSetup({
					xhrFields: {
						withCredentials: true
					},
					beforeSend: function (jqXHR, settings) {
						if (!/^https?:\/\//i.test(settings.url)) {
							settings.url = `${BASE_URL}/${settings.url}` ;
						}
					}
				});
			}
		}
	}
</script>