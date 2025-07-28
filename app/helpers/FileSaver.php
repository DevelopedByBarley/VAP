<?php

/*
  ?How to use?
  required_once app/helpers/FileSaver.php;
  $fileSaver = new FileSaver();
  $fileSaver->saver($_FILE["files"], "/path", null || "asdwasdasd.jpg" || [
    asdsadadasd.jpg, asdasds.jpg
  ]) 
*/

class FileSaver
{

  public function saver($files, $path, $prevImages, $whiteList = null)
  {

    $whiteList = $whiteList ?? [
      'application/pdf',
      'application/msword',
      'image/png',
      'image/jpeg',
    ];


    if (empty($files["name"])) return false;

    if (is_array($files["name"])) {
      return $this->saveMultipleFiles($files, $path, $whiteList, $prevImages);
    }

    return $this->save($files, $path, $whiteList, $prevImages);
  }

  private function saveMultipleFiles($files, $path, $whiteList, $prevImages)
  {
    $ret = [];
    $fileNames = [];


    foreach ($files as $fieldName => $fields) {

      foreach ($fields as $index => $field) {
        $ret[$index][$fieldName] = $fields[$index];
      }
    }

    foreach ($ret as $file) {
      $fileName =  $this->save($file, $path, $whiteList, $prevImages);
      $fileNames[] = $fileName;
    }


    return $fileNames;
  }

  private function save($file, $path, $whiteList, $prevImages)
  {
    $fileType = mime_content_type($file["tmp_name"]);

    if (!in_array($fileType, $whiteList)) {
      return false;
      exit;
    }

    $rand = uniqid(rand(), true);
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $originalFileName =  $rand . '.' . $ext;
    $directoryPath = "./public/assets/$path/";
    
    $destination = $directoryPath . $originalFileName;
    move_uploaded_file($file["tmp_name"], $destination);
    
    $this->unlinkPrevImages($prevImages, $path);
    
    setcookie("prevContent", "", time() - 1, "/");  
    return $originalFileName;
  }

  private function unlinkPrevImages($prevImages, $path)
  {
    if (isset($prevImages)) {
      if (is_array($prevImages)) {
        foreach ($prevImages as $images) {
          var_dump($images);
          unlink("./public/assets/$path/" . $images);
        }
        exit;
      } else {
        unlink("./public/assets/$path/" . $prevImages);
      }
    };
  }

  public function deleteDeclinedFiles($documents) {
    if(is_array($documents)) {
      foreach($documents as $document) {
        $document ? unlink("./public/assets/uploads/documents/users/$document") : '';
      }
    }
  }
}
