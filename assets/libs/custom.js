if (typeof jQuery !== "undefined") {
	$(function() {
		$.ajaxSetup({
			xhrFields: {
				withCredentials: true
			},
			beforeSend: function (jqXHR, settings) {
				if (!/^https?:\/\//i.test(settings.url)) {
					settings.url = $nuxt.$api_url(settings.url);
				}
			}
		});
	});
}