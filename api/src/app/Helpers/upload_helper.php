<?php 

if(! function_exists('upload_img')) {
	function upload_img($file, $path, $configs=[]) {
		if ($file && $file->isValid() && !$file->hasMoved()) {
			$quality = 40;
			$newName = $file->getRandomName();
			$randomName = pathinfo($newName, PATHINFO_FILENAME) . '.jpeg';
			$ds = DIRECTORY_SEPARATOR;
			$rootPath = dirname(FCPATH);
			$path = preg_replace("/\/+/", "/", "{$rootPath}/{$path}/");

			try {
				
				if(!is_dir($path)) {
					mkdir($path, 0777, true);
					
				}

	            $image = \Config\Services::image();
                $image->withFile($file);

				if(is_callable($configs)) {
					$configs($image);
				} elseif (is_array($configs)) {
					foreach ($configs as $v) {
						try {
							$fun = $v[0]; unset($v[0]);
							if(is_callable($fun)) {
								$fun($image);
							} else {
								$params = $v;
								$image->{$fun}(...$params);
							}
						} catch (Exception $e) {
	
						}
					}
				}

                try {
					$exif = exif_read_data($file, 'IFD0');
					if($exif && $exif['Model'] && $exif['Orientation'] > 1) {
						$image->rotate(270);
					}
			    } catch (Exception $e) {
			    	//do nothing
			    }
			    $image->convert(IMAGETYPE_JPEG);
                $image->save("{$path}{$randomName}", $quality);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());

			}
			return $randomName;
		}
	}
}