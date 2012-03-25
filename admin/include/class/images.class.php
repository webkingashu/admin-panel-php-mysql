<?php

class Images {
	
	/**
	 *	$img = new Images($oldImagePath);
	 *	$img->resize($width, $height, $action, $type);
	 *	$img->save($newImagePath);
	 */
	
	protected $_filePath;
	protected $_newImage;
	protected $_type;
	
	public function __construct($filePath = null) {
		if ($filePath) { $this->open($filePath); }
	}
	
	public function __destruct() {
		if ($this->_newImage) {
			/* Free memory */
			imagedestroy($this->_newImage);
		}
	}
	
	public function open($filePath) {
		if (!file_exists($filePath)) {
			$this->error('Specified file does not exist.');
		}
		$this->_filePath = $filePath;
	}
	
	public function resize($maxWidth = 0, $maxHeight = 0, $action = 'none', $type = 'jpg') {
		if (file_exists($this->_filePath)) {
			if ((int) $maxWidth == 0 && (int) $maxHeight == 0) {
				$this->error('Invalid parameters specified.');
			}
			
			$fileInfo    = getimagesize($this->_filePath);
			$this->_type = in_array($type, array('jpg', 'png', 'gif')) ? $type : 'jpg';
			
			switch ($fileInfo['mime']) {
				case'image/jpeg': $oldImage = imagecreatefromjpeg($this->_filePath); break;
				case'image/gif': $oldImage = imagecreatefromgif($this->_filePath); break;
				case'image/png': $oldImage = imagecreatefrompng($this->_filePath); break;
				default: $this->error('File must be a image.');
			}
			
			$oldWidth = $fileInfo[0];
			$oldHeight = $fileInfo[1];
			$sliceVer = $sliceHor = $oldRatio = $newRatio = 0;
			
			if ((int) $maxWidth && (int) $maxHeight) { 
				$oldRatio = $oldWidth / $oldHeight;
				$newRatio = $maxWidth / $maxHeight;
			} else {
				$singleSize = true;
			}
			
			if ($action == 'zc') {
				if ($oldRatio >= $newRatio) {
					$newHeight = round($maxHeight);
					$newWidth  = round($oldWidth / ($oldHeight / $newHeight));
					
					$sliceHor = ($oldWidth - $oldHeight * ($newWidth / $newHeight)) / 2;
				} else {
					$newWidth  = round($maxWidth);
					$newHeight = round($oldHeight / ($oldWidth / $newWidth));
					
					$sliceVer = ($oldHeight - $oldWidth * ($newHeight / $newWidth)) / 2;
				}
				
				$im = imagecreatetruecolor($maxWidth, $maxHeight);
			} else if ($action == 'limit') { /* Not working properly */
				if ($maxWidth >= $oldWidth && $maxHeight >= $oldHeight) {
					$newWidth  = $oldWidth;
					$newHeight = $oldHeight;
				} else if ($oldWidth / $oldHeight > $maxWidth / $maxHeight) {
					$newWidth  = $maxWidth;
					$newHeight = round($oldHeight / ($oldWidth / $newWidth));
				} else {
					$newHeight = $maxHeight;
					$newWidth  = round($oldWidth / ($oldHeight / $newHeight));
				}
				
				$im = imagecreatetruecolor($newWidth, $newHeight);
			} else {
				if (
					isset($singleSize) && (int) $maxWidth || 
					$oldRatio >= $newRatio
					) {
					$newWidth  = round($maxWidth);
					$newHeight = round($oldHeight / ($oldWidth / $maxWidth));
				} else {
					$newHeight = round($maxHeight);
					$newWidth  = round($oldWidth / ($oldHeight / $maxHeight));
				}
				
				$im = imagecreatetruecolor($newWidth, $newHeight);
			}
			
			if ($type == 'png') {
				imagecolortransparent($im, imagecolorallocatealpha($im, 0, 0, 0, 127));
				imagealphablending($im, false);
				imagesavealpha($im, true);
			}
			
			imagecopyresampled($im, $oldImage, 0, 0, $sliceVer, $sliceHor, $newWidth, $newHeight, $oldWidth, $oldHeight);
			
			if ($action == 'far') {
				$newImage = imagecreatetruecolor($maxWidth, $maxHeight);
				$color = imagecolorallocate($newImage, 255, 255, 255);
				imagefill($newImage, 0, 0, $color);
				
				$posX = ($maxWidth - $newWidth) / 2;
				$poxY = ($maxHeight - $newHeight) / 2;
				
				imagecopymerge($newImage, $im, $posX, $poxY, 0, 0, $newWidth, $newHeight, 100);
				$this->_newImage = &$newImage;
				
				/* Free memory */
				imagedestroy($im);
			} else {
				$this->_newImage = &$im;
			}
		}
	}
	
	public function roundCorners($radius = null, $cornerColor = null) {
		if ((int) $radius && $this->_newImage) {
			$width  = imagesx($this->_newImage);
			$height = imagesy($this->_newImage);
			
			/* Create corner */
			$cornerImage = imagecreatetruecolor($radius, $radius);
			$clearColour = imagecolorallocate($cornerImage, 127, 127, 127);
			if (!$cornerColor) { // Transparent
				$continue = true;
				while ($continue) {
					$r = rand(0, 255);
					$g = rand(0, 255);
					$b = rand(0, 255);
				   
					if (imagecolorexact($this->_newImage, $r, $g, $b) != -1) {
						$continue = false;
					}
				}
				
				$solidColor = imagecolorallocate($cornerImage, $r, $g, $b);
				imagecolortransparent($this->_newImage, $solidColor);
				
				if ($this->_type != 'gif') { $this->_type = 'png'; }
			} else {
				$rgb = $this->hex2dec($cornerColor);
				$solidColor = imagecolorallocate($cornerImage, $rgb['red'], $rgb['green'], $rgb['blue']);
			}
			
			imagecolortransparent($cornerImage, $clearColour);
			imagefilledellipse($cornerImage, $radius, $radius, $radius * 2, $radius * 2, $clearColour);
			imagefill($cornerImage, 0, 0, $solidColor);
			
			/* Position corners */
			imagecopymerge($this->_newImage, $cornerImage, 0, 0, 0, 0, $radius, $radius, 100);
			$cornerImage = imagerotate($cornerImage, 90, 0);
			imagecopymerge($this->_newImage, $cornerImage, 0, $height - $radius, 0, 0, $radius, $radius, 100);
			$cornerImage = imagerotate($cornerImage, 90, 0);
			imagecopymerge($this->_newImage, $cornerImage, $width - $radius, $height - $radius, 0, 0, $radius, $radius, 100);
			$cornerImage = imagerotate( $cornerImage, 90, 0 );
			imagecopymerge($this->_newImage, $cornerImage, $width - $radius, 0, 0, 0, $radius, $radius, 100);
			
			/* Free memory */
			imagedestroy($cornerImage);
		}
	}
	
	public function hex2dec($hex) {
		if (preg_match('/^#?([0-9a-f]{3}|[0-9a-f]{6})$/i', trim($hex), $match)) {
			$hex = '';
			for ($i = 0;$i < strlen($match[1]);$i++) {
				if (strlen($match[1]) == 3) {
					$hex .= $match[1]{$i} . $match[1]{$i};
				} else {
					$hex .= $match[1]{$i};
				}
			}
			return array(
				'red'   => hexdec(substr($hex, 0, 2)),
				'green' => hexdec(substr($hex, 2, 2)),
				'blue'  => hexdec(substr($hex, 4, 2)),
			);
		} else {
			$this->error('Invalid hexadecimal code.');
		}
	}
	
	public function error($message, $width = 300, $height = 100) {
		$this->_newImage = imagecreatetruecolor($width, $height);
		$textColor = imagecolorallocate($this->_newImage, 255, 255, 255);
		imagestring($this->_newImage, 3, 12, 10, $message, $textColor);
		
		$this->render();
		die;
	}
	
	public function save($fileName = null, $quality = 100) {
		if ($this->_newImage) {
			switch ($this->_type) {
				case'gif': 
					if (!$fileName) { header('Content-type: image/gif'); }
					imagegif($this->_newImage, $fileName);
					break;
				case'png':
					if (!$fileName) { header('Content-type: image/png'); }
					imagepng($this->_newImage, $fileName);
					break;
				default: 
					if (!$fileName) { header('Content-type: image/jpeg'); }
					imagejpeg($this->_newImage, $fileName, $quality);
			}
		}
	}
	
	public function render() {
		$this->save();
	}
}