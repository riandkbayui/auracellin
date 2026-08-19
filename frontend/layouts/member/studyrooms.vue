<script type="text/javascript" setup>
    import AppHeader from '@/components/main/appheader'
    import AppFooter from '@/components/main/appfooter'
</script>

<template>
    <div>
        <AppHeader>
			<button type="button" v-on:click.prevent="btnToggle" class="btn btn-sm px-3 font-size-16 waves-effect" id="vertical-menu-btn">
				<i class="fa fa-fw fa-bars"></i>
			</button>
		</AppHeader>
        <div :class="['vertical-menu', sidebarState]">
			<div data-simplebar class="h-100">
				<div id="sidebar-menu">
					<ul class="metismenu list-unstyled" id="side-menu">
						<li class="menu-title text-primary" key="t-menu">
							Menu
						</li>
						<li v-on:click.prevent="hide">
							<NuxtLink class="waves-effect" to="/member/studyrooms/home">
								<div class="d-flex w-100 justify-content-between">
									<div>
										<i class="mdi mdi-book-open-variant me-2"></i>
										<span>Ruang Belajar</span>
									</div>
								</div>
							</NuxtLink>
						</li>
						<li v-if="$user(`group`)=='admin'" v-on:click.prevent="hide">
							<NuxtLink class="waves-effect" to="/member/studyrooms/create">
								<div class="d-flex w-100 justify-content-between">
									<div>
										<i class="mdi mdi-pencil me-2"></i>
										<span>Buat Baru</span>
									</div>
								</div>
							</NuxtLink>
						</li>
						<li v-if="$user(`group`)=='admin'" v-on:click.prevent="hide">
							<NuxtLink class="waves-effect" to="/member/studyrooms/me">
								<div class="d-flex w-100 justify-content-between">
									<div>
										<i class="mdi mdi-account-circle me-2"></i>
										<span>Milik Saya</span>
									</div>
								</div>
							</NuxtLink>
						</li>
						<li v-on:click.prevent="hide">
							<NuxtLink class="waves-effect" to="/member/studyrooms/favorites">
								<div class="d-flex w-100 justify-content-between">
									<div>
										<i class="mdi mdi-heart me-2"></i>
										<span>Favorit</span>
									</div>
								</div>
							</NuxtLink>
						</li>
					</ul>
				</div>
			</div>
		</div>
        <div class="container-fluid">
            <div class="row justify-content-center content-area">
                <div class="col-lg-4">
                    <nuxt />
                </div>
            </div>
        </div>
        <AppFooter />
    </div>
</template>

<script type="text/javascript">
    export default {
        middleware: ["auth"],
		data() {
			return {
				sidebarState: 'hide'
			}
		},
		mounted() {
			if(window.outerWidth >= 992) {
				this.sidebarState = "show"
			}
		},
		methods: {
			btnToggle() {
				this.sidebarState = this.sidebarState=="show" ? "hide" : "show";
			},
			hide() {
				if(window.outerWidth < 992) {
					this.sidebarState = "hide"
				}
			}
		}
    }
</script>