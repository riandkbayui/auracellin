<?php

if (!function_exists('landing_url')) {
    function landing_url(string $url = ""): string {
        $base_url = rtrim(getenv("app.landingURL"), "/");
        $url = ltrim($url, "/");
        return $base_url . ($url ? "/" . $url : "");
    }
}

if (!function_exists('slugify')) {
	function slugify($text, $maxLength = 0, $divider = '-')
	{
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, $divider);
		$text = preg_replace('~-+~', $divider, $text);
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		if ($maxLength > 0){
			$text = character_limiter($text, $maxLength);
		}
		return $text;
	}
}

if (!function_exists('unslugify')) {
	function unslugify($text, $divider = '-')
	{
		$r = str_replace($divider," ",$text);
		$r = ucwords($r);
		return $r;
	}
}

if (!function_exists('phoneGen')) {
	function phoneGen()
	{
		$a1 = ["081", "082", "083", "085", "087", "089"];
		$a2 = $a1[rand(0, (count($a1) - 1))];
		$a3 = rand(100000000, 999999999);
		return $a2.$a3;
	}
}

if(!function_exists("isJson")) {
	function isJson($string) {
		json_decode($string);
		return json_last_error() === JSON_ERROR_NONE;
	}
}

if(!function_exists("alphanumeric")) {
	function alphanumeric($string) {
		// $clean = preg_replace('/\s+/', '', $string);
		// return  preg_replace('/[^0-9a-zA-Z\-]/', '', $clean);
		return preg_replace('/[<>"%;&+\\\]/', '', (string) $string);
	}
}

if(!function_exists("numeric")) {
	function numeric($string) {
		return  preg_replace('/[^0-9]/', '', $string);
	}
}

if(!function_exists("phoneId")) {
	function phoneId($phone) {
		$phone = preg_replace("/[^0-9]/", "", $phone);
		$front = substr($phone, 0, 2);
		if($front!=='62') {
			$phone='62'.substr($phone, 1);
		}
		return $phone;
	}
}

if(!function_exists("phoneCheck")) {
	function phoneIdCheck($phone) {
		$phone = preg_replace("[^0-9]", "", $phone);
		if(strlen($phone) < 10) throw new Exception("Jumlah nomor minimal 10 digit.");
		
		$regex = preg_match("/(^081)|(^082)|(^083)|(^085)|(^087)|(^088)|(^089)/", $phone);
		if(!$regex) throw new Exception("Format nomor telepon: 085xxxx");
		
		return $phone;
	}
}

if(!function_exists("nospace")) {
	function nospace($string) {
		return preg_replace('/\s+/', '', $string);
	}
}

if(!function_exists("str_contains")) {

	function str_contains(string $haystack, string $needle): bool {
		return '' === $needle || false !== strpos($haystack, $needle);
	}

}

if(!function_exists("inputUsername")) {
	function inputUsername(string $text) {
		return preg_replace('/[^0-9a-z]/', '', strtolower($text));
	}
}

if(!function_exists("inputEmail")) {
	function inputEmail(string $text) {
		return preg_replace('/[^0-9a-z\.\@\-]/', '', strtolower($text));
	}
}

if(!function_exists("inputDate")) {
	function inputDate(string $text) {
		try {
			return \DateTime::createFromFormat("d/m/Y", $text)->format("Y-m-d");
		} catch (\Throwable $e) {
			return null;
		}
	}
}

if(!function_exists("inputPassword")) {
	function inputPassword(string $text) {
		try {
			return password_hash($text, PASSWORD_DEFAULT);
		} catch (Exception $e) {
			return null;
		}
	}
}

if(!function_exists("notnull")) {
	function notnull(&$string) {
		return $string ?? "";
	}
}

if(!function_exists("breadcrumb")) {
	function breadcrumb($title, $pages) {
		return view("partials/breadcrumb", compact("title", "pages"));
	}
}

if(!function_exists("is_selected")) {
	function is_selected($b) {
		return $b ? "selected=\"\"" : "" ;
	}
}

if(!function_exists("is_checked")) {
	function is_checked($b) {
		return $b ? "checked=\"\"" : "" ;
	}
}

if(!function_exists("vars")) {
	function vars(&$v, ...$keys) {
		try {
			$data = (object) $v;

			foreach ($keys as $key) {
				$data = $data->{$key};
			}

			return $data;
		} catch (\Throwable $th) {
			return '';
		}
	}
}


if(!function_exists("str_rand")) {
	function str_rand($prefix="") {
		$str = bin2hex(pack('N', time()) . random_bytes(6));
		return "{$prefix}{$str}";
	}
}

if (!function_exists('youtube_embed')) {
	function youtube_embed(string $url) {
		$videoId = null;

		// Coba parse URL
		$parts = parse_url($url);

		if (!isset($parts['host']) || !isset($parts['path'])) {
			throw new Exception("URL tidak valid");
		}

		$host = $parts['host'];
		$path = trim($parts['path'], '/');

		if (strpos($host, 'youtube.com') !== false) {
			// Format: https://www.youtube.com/watch?v=...
			if (isset($parts['query'])) {
				parse_str($parts['query'], $query);
				if (isset($query['v'])) {
					$videoId = $query['v'];
				}
			}

			// Format: https://www.youtube.com/embed/...
			if (!$videoId && preg_match('#^embed/([a-zA-Z0-9_-]{11})$#', $path, $matches)) {
				$videoId = $matches[1];
			}
		} elseif (strpos($host, 'youtu.be') !== false) {
			// Format: https://youtu.be/...
			if (preg_match('#^([a-zA-Z0-9_-]{11})$#', $path, $matches)) {
				$videoId = $matches[1];
			}
		}

		if (!$videoId || strlen($videoId) !== 11) {
			throw new Exception("Video ID tidak valid");
		}

		$embedUrl = "https://www.youtube.com/embed/{$videoId}";
		return $embedUrl;
	}

}

if(!function_exists("extract_var")) {
	function extract_var(&$v, ...$keys) {
		$v = (object) $v;
		$data = new \stdClass();
		
		try {
			foreach ($keys as $key) {
				$data->{$key} = $v->{$key};
			}
		} catch (\Throwable $th) {
			// skip
		}

		return $data;
	}
}

if(!function_exists("nestArray")) {
	function nestArray(array $data, bool $asObject = false, string $delimiter = '__') {
		$result = [];

		foreach ($data as $row) {
			$nestedRow = [];

			foreach ($row as $key => $value) {
				if (strpos($key, $delimiter) === false) {
				// Tidak mengandung delimiter, langsung simpan
					$nestedRow[$key] = $value;
					continue;
				}

				$parts = explode($delimiter, $key);
				$ref = &$nestedRow;

				foreach ($parts as $i => $part) {
					if ($i === count($parts) - 1) {
						$ref[$part] = $value;
					} else {
						if (!isset($ref[$part]) || !is_array($ref[$part])) {
							$ref[$part] = [];
						}
						$ref = &$ref[$part];
					}
				}
			}

			$result[] = $asObject ? json_decode(json_encode($nestedRow)) : $nestedRow;
		}

		return $result;
	}

}

if (!function_exists("nestObject")) {
	function nestObject(array $data, bool $asObject = false, string $delimiter = '__') {
		$nested = [];

		foreach ($data as $key => $value) {
			if (strpos($key, $delimiter) === false) {
				$nested[$key] = $value;
				continue;
			}

			$parts = explode($delimiter, $key);
			$ref = &$nested;

			foreach ($parts as $i => $part) {
				if ($i === count($parts) - 1) {
					$ref[$part] = $value;
				} else {
					if (!isset($ref[$part]) || !is_array($ref[$part])) {
						$ref[$part] = [];
					}
					$ref = &$ref[$part];
				}
			}
		}

		return $asObject ? json_decode(json_encode($nested)) : $nested;
	}
}


if(!function_exists("unset_var")) {
	function unset_var($data, ...$keys) {
		$data = (object) $data;
		
		try {
			foreach ($keys as $key) {
				unset($data->{$key});
			}
		} catch (\Throwable $th) {
			// skip
		}

		return $data;
	}
}

if(!function_exists("isset_vars")) {
	function isset_vars($data, ...$keys) {
		$data = (object) $data;
		
		foreach ($keys as $key) {
			if (!isset($data->{$key}) || $data->{$key} === '') {
				return false;
			}
		}

		return true;
	}
}

if(!function_exists("display_date")) {
	function display_date($dateString) {
		// Set locale to Indonesian
		$locale = 'id_ID';
		
		// Create a DateTime object from the input date string
		$date = new DateTime($dateString);

		// Create an IntlDateFormatter object
		$formatter = new IntlDateFormatter(
			$locale,
			IntlDateFormatter::LONG, // Date format style (can be changed to FULL, MEDIUM, SHORT)
			IntlDateFormatter::NONE // Time format style (NONE means no time will be formatted)
		);

		// Format the date
		return $formatter->format($date);
	}
}

if(!function_exists("display_datetime")) {
	function display_datetime($dateString) {
		// Set locale to Indonesian
		$locale = 'id_ID';
		
		// Create a DateTime object from the input date string
		$date = new DateTime($dateString);

		// Create an IntlDateFormatter object for date and time
		$formatter = new IntlDateFormatter(
			$locale,
			IntlDateFormatter::LONG, // Date format style (can be changed to FULL, MEDIUM, SHORT)
			IntlDateFormatter::LONG // Time format style (can be changed to FULL, MEDIUM, SHORT)
		);

		// Format the date and time
		return $formatter->format($date);
	}
}

if(!function_exists("faker")) {
	function faker($str1, ...$str2) {
		if($str1=="phoneId") {
			$phone = "081";
			$phone .= rand(111111111, 999999999);
			return $phone;
		}
		$faker = \Faker\Factory::create('id_ID');
		return $faker->{$str1}($str2);
	}
}

if(!function_exists("monthsh")) {
	function monthsh($id, $y="", $sep="-") {
		try {
			$data = [
				1 => "Jan",
				"Feb", "Mar", "Apr", "Mei", "Jun", "Jul",
				"Agu", "Sep", "Okt", "Nov", "Des"
			];
			
			$m = [];
			$m[] = $data[$id];

			if($y) {
				$m[] = $y;
			}

			return implode($sep, $m);
		} catch (Exception $e) {
			return "-";
		}
	}
}

if(!function_exists("monthlg")) {
	function monthlg($id, $y="", $sep="-") {
		try {
			$data = [
				1 => "Januari",
				"Februari", "Maret", "April", "Mei", "Juni", "Juli",
				"Agustus", "September", "Oktober", "November", "Desember"
			];
			
			$m = [];
			$m[] = $data[$id];

			if($y) {
				$m[] = $y;
			}

			return implode($sep, $m);
		} catch (Exception $e) {
			return "-";
		}
	}
}

if(!function_exists("display_day")) {
	function display_day($tgl) {
		try {
			$hari = date ("D", strtotime($tgl));
			switch($hari){
				case 'Sun':
				$hari_ini = "Minggu";
				break;

				case 'Mon':			
				$hari_ini = "Senin";
				break;

				case 'Tue':
				$hari_ini = "Selasa";
				break;

				case 'Wed':
				$hari_ini = "Rabu";
				break;

				case 'Thu':
				$hari_ini = "Kamis";
				break;

				case 'Fri':
				$hari_ini = "Jumat";
				break;

				case 'Sat':
				$hari_ini = "Sabtu";
				break;
				
				default:
				$hari_ini = "Tidak di ketahui";		
				break;
			}

			return $hari_ini;
		} catch (Exception $e) {
			return "-";
		}
	}
}

if (!function_exists('convert_image_to_base64')) {
	/**
	 * Mengonversi gambar menjadi string base64 dengan filter kontras.
	 * 
	 * @param string $imagePath Path lengkap ke gambar.
	 * @param int $contrast Nilai kontras yang ingin diterapkan (default -100).
	 * @return string|false Base64 string gambar, atau false jika gagal.
	 */
	function convert_image_to_base64(string $imagePath, int $contrast = 0)
	{
		// Mengecek apakah file gambar ada
		if (!file_exists($imagePath)) {
			// return false; // Gambar tidak ditemukan
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Gambar tidak ditemukan");
		}

		// Menentukan ekstensi gambar
		$type = pathinfo($imagePath, PATHINFO_EXTENSION);

		// Membuka gambar sesuai dengan formatnya
		if ($type == 'jpg' || $type == 'jpeg') {
			$image = imagecreatefromjpeg($imagePath);
		} elseif ($type == 'png') {
			$image = imagecreatefrompng($imagePath);
		} else {
			return false; // Format gambar tidak didukung
		}

		// Terapkan filter kontras pada gambar
		if ($image) {
			if($contrast) {
				imagefilter($image, IMG_FILTER_CONTRAST, $contrast);
			}

			// Menyimpan gambar yang telah diproses ke output buffer
			ob_start();
			if ($type == 'jpg' || $type == 'jpeg') {
				imagejpeg($image);
			} elseif ($type == 'png') {
				imagepng($image);
			}
			$data = ob_get_contents();
			ob_end_clean();

			// Meng-encode gambar ke base64
			$base64 = 'data:image/'.$type.';base64,'.base64_encode($data);

			// Hancurkan objek gambar setelah selesai
			imagedestroy($image);

			return $base64;
		}

		return false; // Jika ada masalah dengan pemrosesan gambar
	}
}

if(!function_exists("sitemaper")) {
	function sitemaper() {
		$sitemap = new class {
			protected $urls = [];

			public function addUrl($loc, $lastmod = null, $changefreq = 'weekly', $priority = '0.8')
			{
				$this->urls[] = [
					'loc' => $loc,
					'lastmod' => $lastmod,
					'changefreq' => $changefreq,
					'priority' => $priority,
				];
				return $this;
			}

			public function generate()
			{
				$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
				$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

				foreach ($this->urls as $url) {
					$sitemap .= '<url>';
					$sitemap .= '<loc>' . esc($url['loc']) . '</loc>';
					if (!empty($url['lastmod'])) {
						$sitemap .= '<lastmod>' . esc($url['lastmod']) . '</lastmod>';
					}
					$sitemap .= '<changefreq>' . esc($url['changefreq']) . '</changefreq>';
					$sitemap .= '<priority>' . esc($url['priority']) . '</priority>';
					$sitemap .= '</url>';
				}

				$sitemap .= '</urlset>';
				return $sitemap;
			}
		};
		return $sitemap;
	}
}

if(!function_exists("atomTimeFormat")) {
	function atomTimeFormat($str) {
		$date = new DateTime($str, new DateTimeZone('Asia/Jakarta'));
		return $date->format(DateTime::ATOM); // atau 'c' -> hasil sama
	}
}
