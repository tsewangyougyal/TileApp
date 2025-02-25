 <?php 
 if($_POST["action"] == "remove_file"){

  if(file_exists($_POST["path"])){
   unlink($_POST["path"]);
   echo 'File Deleted';
  }

 }



 if($_POST["action"] == "delete"){

   $dir=$_POST["folder_name"];
  if (!is_dir($dir)) {
        echo "The directory does not exist.";
        return;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
        $todo($fileinfo->getRealPath());
    }

    rmdir($dir);
    echo "The directory has been deleted.";
}
 



 if($_POST["action"] == "change_file_name"){
  $old_name = $_POST["folder_name"] . '/' . $_POST["old_file_name"];
  $new_name = $_POST["folder_name"] . '/' . $_POST["new_file_name"];
  if(rename($old_name, $new_name))
  {
   echo 'File name change successfully';
  }
  else
  {
   echo 'There is an error';
  }
 }



 if($_POST["action"] == "create"){

 $fpath=$_POST["fdpath"];
 $fname=$_POST["fdname"];
 
if (is_dir($fpath . '/' . $fname)) {
    echo "The folder '$fname' already exists.";
}


 else if(preg_match('/[^a-zA-Z0-9_\-]/', $fname)) {
    echo "Folder name contains special characters. no special character are allowed on the folder name";
}

  else{
   mkdir($fpath.'/'.$fname, 0777, true);
   echo 'Folder '.$fname.' Created';  
  }

 }




if($_POST["action"] == "upload"){

 $fpath=$_POST["fdpath"];
 $filename=$_POST["flname"];
 $base_name = basename($filename);


if(!empty($_POST['flname'])){ 
 
  if(is_uploaded_file($_FILES['flname']['tmp_name']))
  {
    sleep(1);
    $source_path = $_FILES['flname']['tmp_name'];
    $target_path = 'Upload/' . $_FILES['flname']['name'];
    if(move_uploaded_file($source_path, $target_path))
    {
      echo "<img src='$target_path' class='img-thumbnail' width='300' height='250' />";
    }
      else {echo "file upload error";} 
  }

  else {echo "malicious file upload attempt";} 

}

else{ echo "plz select a file"; }

}






  if($_POST["action"] == "view_files"){
  $file_src= $_POST["file_name"];

  $file = file_get_contents($file_src, true);
  echo $file;
 }










if ($_POST["action"] == "file_paste") {
    $sourcePath = $_POST["spath"];
    $destinationDir = $_POST["dpath"];

    // Function to recursively copy all contents
    function copyDirectory($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    copyDirectory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    // Check if the source path exists
    if (!file_exists($sourcePath)) {
        echo "Source path does not exist.";
        return false;
    }

    // Create the destination directory if it doesn't exist
    if (!is_dir($destinationDir)) {
        if (!mkdir($destinationDir, 0777, true)) {
            echo "Failed to create destination directory.";
            return false;
        }
    }

    // Determine if the source path is a file or directory
    if (is_dir($sourcePath)) {
        // It's a directory
        $folderName = basename($sourcePath);
        $destinationPath = $destinationDir . '/' . $folderName;
        copyDirectory($sourcePath, $destinationPath);
        echo "Directory has been copied from $sourcePath to $destinationPath.";
    } else {
        // It's a file
        $fileName = basename($sourcePath);
        $destinationPath = $destinationDir . '/' . $fileName;
        if (copy($sourcePath, $destinationPath)) {
            echo "File has been copied from $sourcePath to $destinationPath.";
        } else {
            echo "Failed to copy the file.";
            return false;
        }
    }
    return true;
}



 

if($_POST["action"] == "file_move") {


     // Check if the source file exists
    if (!file_exists($_POST["spath"],)) {
        echo "Source file does not exist.";
        return false;
    }

   $sourcePath=$_POST["spath"];
   $destinationDir= $_POST["dpath"];
    
    // Create the destination directory if it doesn't exist
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }

    // Determine the file name from the source path
    $fileName = basename($sourcePath);

    // Full destination path
    $destinationPath = $destinationDir . '/' . $fileName;

    // Move the file
    if (rename($sourcePath, $destinationPath)) {
        echo "File has been moved from $sourcePath to $destinationPath.";
        return true;
    } else {
        echo "Failed to move the file.";
        return false;
    }
}




?>