(function ($) {
	function createAjaxify(settings) {
		const $target = $(settings.target)
		const $bar = $(settings.loadingBarSelector)
		const excludeRegexes = settings.exclude.map((pattern) => new RegExp('^' + pattern.replace(/\*/g, '.*') + '$'))

		function isExcluded(href) {
			return excludeRegexes.some(rx => rx.test(href)) || href.includes('#')
		}

		function showBar() {
			$bar.stop(true).css({ width: '0%', opacity: 1 }).show()
			setTimeout(() => $bar.css('width', '80%'), 100)
		}

		function hideBar() {
			$bar.css('width', '100%')
			setTimeout(() => {
				$bar.css('opacity', 0)
				setTimeout(() => $bar.hide().css('width', '0%'), 300)
			}, 200)
		}

		function loadContent(url, push = true) {
			showBar()
			if (typeof settings.onStart === 'function') settings.onStart()

			$.ajax({
				url,
				method: 'GET',
				dataType: 'html',
				success(response, _, xhr) {
					const match = response.match(/<title>(.*?)<\/title>/i)
					if (match) document.title = match[1]

					const $html = $('<div>').html(response)
					const content = $html.find(settings.target).length ? $html.find(settings.target).html() : response
					$target.html(content)

					if (settings.scrollToTop) window.scrollTo({ top: 0, behavior: 'smooth' })
					if (push && settings.pushState) {
						history.pushState({ url, ajaxified: true }, '', url)
					}
				},
				complete(xhr) {
					hideBar()
					if (typeof settings.onFinish === 'function') settings.onFinish()

					const redirect = xhr.getResponseHeader('X-Redirect')
					if (xhr.status === 302 || redirect) {
						location.href = redirect || '/login'
					}

					if (xhr.status >= 400) {
						$target.html(`
							<div style="padding:1em; text-align:center; color:red;">
								Gagal memuat konten. <button onclick="location.reload()">Muat Ulang</button>
							</div>`)
					}
				}
			})
		}

		// expose loadContent if needed
		settings._loadContent = loadContent

		// klik link intercept
		$(document).on('click', settings.linkSelector, function (e) {
			const href = $(this).attr('href')
			if (!href || href.startsWith('#') || href.startsWith('javascript:') || isExcluded(href)) return
			e.preventDefault()
			loadContent(href, true)
		})

		// popstate back/forward
		window.addEventListener('popstate', function (e) {
			const state = e.state
			if (state && state.ajaxified) {
				loadContent(state.url, false)
			} else {
				location.reload()
			}
		})

		// initial state
		if (!history.state || !history.state.ajaxified) {
			history.replaceState({ url: location.pathname, ajaxified: true }, '', location.pathname)
		}
	}

	// Plugin jQuery: $(document).ajaxify({...})
	$.fn.ajaxify = function (options) {
		const settings = $.extend({
			target: '#content',
			linkSelector: 'a[href^="/"]:not([target]):not([data-no-ajax])',
			loadingBarSelector: '#ajaxify-loading-bar',
			pushState: true,
			scrollToTop: true,
			onStart: null,
			onFinish: null,
			exclude: [],
		}, options)
		createAjaxify(settings)
		return this
	}

	// Versi non-elemen: $.ajaxify({ to: "/some/path", ... })
	$.ajaxify = function (options) {
		const settings = $.extend({
			target: '#content',
			linkSelector: 'a[href^="/"]:not([target]):not([data-no-ajax])',
			loadingBarSelector: '#ajaxify-loading-bar',
			pushState: true,
			scrollToTop: true,
			onStart: null,
			onFinish: null,
			exclude: [],
		}, options)

		createAjaxify(settings)

		// langsung load konten jika ada "to"
		if (options.to) {
			settings._loadContent(options.to, true)
		}
	}
})(jQuery)