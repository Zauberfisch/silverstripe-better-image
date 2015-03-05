<?php

/**
 * @author zauberfisch
 * @property Image owner
 */
class BetterImage extends DataExtension {
	public function SetCroppedSize($width, $height, $originX = 'center', $originY = 'center') {
		return $this->owner->isSize($width, $height) && !Config::inst()->get('Image', 'force_resample')
			? $this
			: $this->owner->getFormattedImage('BetterCroppedImage', $width, $height, $originX, $originY);
	}

	public function generateBetterCroppedImage(Image_Backend $backend, $width, $height, $originX, $originY) {
		return $backend->croppedResize($width, $height, $originX, $originY);
	}

	public function SetMaxRatioSize($width, $height) {
		return $this->owner->SetRatioSize(min($width, $this->owner->getWidth()), min($height, $this->owner->getHeight()));
	}

	public function SetQuality($quality) {
		return $this->owner->getFormattedImage('QualityVariantImage', $quality);
	}

	public function generateQualityVariantImage(Image_Backend $backend, $quality) {
		$new = clone $backend;
		$new->setQuality($quality);
		return $new;
	}

	public function SetGreyscale($r = 38, $g = 36, $b = 26) {
		return $this->owner->getFormattedImage('GreyscaleImage', $r, $g, $b);
	}

	public function generateGreyscaleImage(Image_Backend $gd, $r, $g, $b) {
		return $gd->greyscale($r, $g, $b);
	}

	public function GetAsDataURI() {
		$filename = $this->owner->getFilename();
		$path = BASE_PATH . '/' . $filename;
		if ($filename && $filename != ASSETS_DIR . '/' && is_file($path)) {
			list($width, $height, $type, $attr) = getimagesize($path);
			if (!isset($type) || !$type) {
				$ext = explode('.', $filename);
				$ext = strtolower($ext[count($ext) - 1]);
				switch ($ext) {
					case "gif":
						$type = IMAGETYPE_GIF;
						break;
					case "jpeg":
					case "jpg":
					case "jpe":
						$type = IMAGETYPE_JPEG;
						break;
					default:
						$type = IMAGETYPE_PNG;
						break;
				}
			}
			switch ($type) {
				case IMAGETYPE_GIF:
					$mime = 'image/gif';
					break;
				case IMAGETYPE_JPEG:
					$mime = 'image/jpg';
					break;
				default:
					$mime = 'image/png';
					break;
			}
			return "data:$mime;base64," . base64_encode(file_get_contents($path));
		}
	}
}
