<?php

/**
 * @author zauberfisch
 */
class BetterGDBackend extends GDBackend {
	public function croppedResize($width, $height, $originX = 'center', $originY = 'center') {
		if (!$this->gd) {
			return false;
		}

		$width = round($width);
		$height = round($height);

		// Check that a resize is actually necessary.
		if ($width == $this->width && $height == $this->height) {
			return $this;
		}

		$newGD = imagecreatetruecolor($width, $height);

		// Preserves transparency between images
		imagealphablending($newGD, false);
		imagesavealpha($newGD, true);

		// We can't resize a 0 image
		if ($this->width > 0 && $this->height > 0) {

			$destAR = $width / $height;
			$srcAR = $this->width / $this->height;

			if ($destAR < $srcAR) {
				// Destination narrower than the source
				$srcHeight = $this->height;
				$srcWidth = round($this->height * $destAR);

			} else {
				// Destination shorter than the source
				$srcWidth = $this->width;
				$srcHeight = round($this->width / $destAR);
			}

			$offset = [
				'x' => [
					'left' => 0,
					'center' => $destAR < $srcAR ? round(($this->width - $srcWidth) / 2) : 0,
					'right' => $destAR < $srcAR ? $this->width - $srcWidth : 0,
				],
				'y' => [
					'top' => 0,
					'center' => $destAR > $srcAR ? round(($this->height - $srcHeight) / 2) : 0,
					'bottom' => $destAR > $srcAR ? $this->height - $srcHeight : 0,
				],
			];
			if (!isset($offset['x'][$originX]) || !isset($offset['y'][$originY])) {
				throw new InvalidArgumentException("Invalid origin '$originX $originY' given.");
			}
			imagecopyresampled($newGD, $this->gd, 0, 0, $offset['x'][$originX], $offset['y'][$originY], $width, $height, $srcWidth, $srcHeight);
		}
		$output = clone $this;
		$output->setImageResource($newGD);
		return $output;
	}
}
