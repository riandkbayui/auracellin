<template>
	<header id="page-topbar">
		<div class="navbar-header">
			<div class="d-flex">
				<div class="ms-2 align-items-center d-flex ms-2">
					<slot />
					<NuxtLink to="/member/dashboard" class="d-inline-block">
						<img src="/assets/images/logo-land.png" class="avatar-sm w-auto" alt="Logo" />
					</NuxtLink>
				</div>
			</div>
			<div class="d-flex">
				<div class="dropdown d-inline-block">
					<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<img class="rounded-circle ar-1-1 img-cover-center header-profile-user" :src="$user(`photo`)" alt="Header Avatar" />
						<span class="d-none d-xl-inline-block ms-1 fw-bold" key="t-username">{{ $user(`username`) }}</span>
						<i class="mdi mdi-chevron-down d-none d-xl-inline-block" />
					</button>
					<div class="dropdown-menu dropdown-menu-end">
						<NuxtLink class="dropdown-item" to="/member/account">
							<i class="bx bx-user font-size-16 align-middle me-1" />
							<span key="t-profile">Akun Saya</span>
						</NuxtLink>
						<div class="dropdown-divider" />
						<NuxtLink class="dropdown-item" to="/auth/logout">
							<i class="bx bx-power-off font-size-16 align-middle me-1" />
							<span key="t-logout">Keluar</span>
						</NuxtLink>
					</div>
				</div>
			</div>
		</div>
	</header>
</template>
