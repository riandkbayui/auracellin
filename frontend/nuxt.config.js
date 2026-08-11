const configs = {
	base_url: "http://auracellin.test",
}

const environment = "development";

if(environment=="production") {
	configs.base_url = "https://auracellin.staginglab.my.id";
}

const meta = {
	url: configs.base_url,
	title: "AURA CELLIN",
	description: "AURA CELLIN Sehatkan sel mu, pancarkan auramu. Temukan produk berkualitas, peluang usaha dengan modal ringan, sistem otomatis modern, pendampingan langsung, dan menuju hidup baru yang lebih sehat dan sejahtera.",
	image: `${configs.base_url}/assets/images/logo-meta.jpg`,
	icon: `${configs.base_url}/assets/images/logo.png`,
};

export default {
	// Global page headers: https://go.nuxtjs.dev/config-head
	head: {
		title: meta.title,
		htmlAttrs: {
			lang: "id",
		},
		meta: [
			{ charset: "utf-8" },
			{ name: "viewport", content: "width=device-width, initial-scale=1" },
			{ hid: "description", name: "description", content: meta.description },
			{ hid: "author", name: "author", content: meta.title },

			// Open Graph / Facebook
			{ hid: "og:title", property: "og:title", content: meta.title },
			{ hid: "og:description", property: "og:description", content: meta.description },
			{ hid: "og:image", property: "og:image", content: meta.image },
			{ hid: "og:url", property: "og:url", content: meta.url },
			{ hid: "og:type", property: "og:type", content: "website" },

			// Twitter
			{ hid: "twitter:card", name: "twitter:card", content: "summary_large_image" },
			{ hid: "twitter:title", name: "twitter:title", content: meta.title },
			{ hid: "twitter:description", name: "twitter:description", content: meta.description },
			{ hid: "twitter:image", name: "twitter:image", content: meta.image },
			{ hid: "twitter:site", name: "twitter:site", content: meta.url },

			{ hid: "base:url", name: "base:url", content: configs.base_url },
			{ hid: "api:url", name: "api:url", content: configs.base_url },
		],
		link: [
			{ rel: "icon", type: "image/x-icon", href: meta.icon },
			{ href: "/assets/css/bootstrap.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/css/icons.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/libs/select2/css/select2.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/libs/sweetalert2/sweetalert2.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/libs/datatables/datatables.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/libs/aos/aos.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/css/app.min.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/css/fontsizes.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/css/custom.css", type: "text/css", rel: "stylesheet" },
			{ href: "/assets/css/landing.css", type: "text/css", rel: "stylesheet" },
		],
		script: [
			{ src: "/assets/libs/jquery/jquery.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/bootstrap/js/bootstrap.bundle.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/metismenu/metisMenu.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/simplebar/simplebar.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/node-waves/waves.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/loadingoverlay/loadingoverlay.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/moment/moment.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/select2/js/select2.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/sweetalert2/sweetalert2.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/datatables/datatables.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/aos/aos.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/qrcode.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/tinymce/tinymce.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/tinymce/jquery.tinymce.min.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/utils.js", body: true, type: "text/javascript" },
			{ src: "/assets/libs/custom.js", body: true, type: "text/javascript" },
		],
	},

	// Global CSS: https://go.nuxtjs.dev/config-css
	css: [],

	// Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
	plugins: ["./plugins/helpers.js", "./plugins/axios.js"],

	router: {
		extendRoutes(routes, resolve) {
			routes.push({
				name: "homePage",
				path: "/",
				component: resolve(__dirname, "pages/ref/_slug/index.vue"),
			});
			routes.push({
				name: "missionPage",
				path: "/member/missions",
				component: resolve(__dirname, "pages/member/missions/home/index.vue"),
			});
			routes.push({
				name: "studyRoomsPage",
				path: "/member/studyrooms",
				component: resolve(__dirname, "pages/member/studyrooms/home/index.vue"),
			});
		},
	},

	// Auto import components: https://go.nuxtjs.dev/config-components
	components: false,

	// Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
	buildModules: [],

	// Modules: https://go.nuxtjs.dev/config-modules
	modules: [
		// https://go.nuxtjs.dev/axios
		"@nuxtjs/axios",
	],

	// Axios module configuration: https://go.nuxtjs.dev/config-axios
	axios: {
		// Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
		baseURL: `${configs.base_url}/api`,
		credentials: true,
	},

	// Build Configuration: https://go.nuxtjs.dev/config-build
	build: {},

	dir: {
		static: "public",
	},

	ssr: false,
	telemetry: false,
	target: "static",
};
