<?php


class ResizePictures {

  private $width;
  private $height;
  private $fileName;
  private $imagePath;
  private $serverUrl;
  private $folderSize;

function __construct() {
  $this->width = $_SERVER['width'];
  $this->height = $_SERVER['height'];
  $this->fileName = $_SERVER['file_name'];
  $this->folderSize = $_SERVER['folder_size'];
  $this->serverUrl = 'https://img.toledo24.pro/';
  $this->imagePath = __DIR__ . '/images/' . $this->folderSize . '/' . $this->fileName;

  echo "111<pre>";
  print_r($_SERVER);
  }

function uploadImage(): string {
  $fullPathImage = $this->serverUrl . $this->fileName;
  $contentImage = file_get_contents($fullPathImage);
  return $contentImage;
}

function resizeImage() {
  $image = imagecreatefromstring(file_get_contents($this->imagePath));

  list($originalWidth, $originalHeight) = getimagesize($this->imagePath);

  $newWidth = $this->width;
  $newHeight = $this->height;

  $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
  imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

  header('Content-Type: image/png'); // Или image/png, image/gif
  imagepng($resizedImage);

  imagedestroy($image);
  imagedestroy($resizedImage);
}

function saveImage($contentImage) {
  file_put_contents($this->imagePath, $contentImage);
}

function getImage() {

  if (file_exists($this->imagePath)) {
    header('Content-type: image/png'); // Или другой тип
    readfile($this->imagePath);
  } else {
    header('HTTP/1.1 404 Not Found');
    echo 'Изображение не найдено.';
  }

  }

}

$resizePictures = new ResizePictures();
$contentImage = $resizePictures->uploadImage();
$resizePictures->saveImage($contentImage);
$resizePictures->resizeImage();
$resizePictures->getImage();

?>
