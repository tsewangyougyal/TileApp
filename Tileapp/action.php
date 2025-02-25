<?php

$dir_path =$_POST['fdname'];


$folder_extensions_array=array('');
$image_extensions_array = array('jpg','png','jpeg','gif');
$Audio_extensions_array = array('WAV', 'mp3', 'Vorbis', 'AAC');
$video_extensions_array = array('WebM','mp4', 'Theora');
$textfile_extensions_array=array('pdf','doc','txt','html','css','php','js','java','c','c#','json','log','sql');
$compression_extensions_array=array('7zip','zip','rar');
$software_extensions_array=array('exe','apk');


function format_file_size($size)
{
 if ($size >= 1073741824){
  $size = number_format($size / 1073741824, 2) . ' GB';
 }
    elseif ($size >= 1048576){
        $size = number_format($size / 1048576, 2) . ' MB';
    }

    elseif ($size >= 1024) {
        $size = number_format($size / 1024, 2) . ' KB';
    }

    elseif ($size > 1){
        $size = $size . ' bytes';
    }

    elseif ($size == 1){
        $size = $size . ' byte';
    }

    else {
        $size = '0 bytes';
    }
 return $size;
}



function get_folder_size($folder_name){
 $total_size = 0;
 $file_data = scandir($folder_name);
 foreach($file_data as $file)
 {
  if($file === '.' or $file === '..')
  {
   continue;
  }
  else
  {
   $path = $folder_name . '/' . $file;
   $total_size = $total_size + filesize($path);
  }
 }
 return format_file_size($total_size);
}




echo"<table class='table'>
  <tr style='background-color:grey;'>
  <td style='width:10%;' class='tdcheckbox'><input type='checkbox'> All</td>
  <td style='width:5%;' id='uploads/' onclick='faction(id)'><i class='fa fa-folder-open' style='font-size:26px;''></i></td>
  <td style='width:40%;'><text style='margin-left:1em;'>$dir_path</text></td>
  <td style='width:10%;'>Size</td><td style='width:10%;'>Type</td>
  <td style='text-align:right;width:15%;'>
  <a class='gridview mo' id='copyfile'><i class='fa fa-clipboard' style='color:orange;'></i></a>
  <a class='gridview mo'><i class='fa fa-trash-o' style='color:red;'></i></a>
  <a class='gridview mo' onclick='hideshow()'><i class='fa fa-th-list'></i></a>
  </td></tr>";


if(is_dir($dir_path)){

    $files = scandir($dir_path);
    for($i = 0; $i < count($files); $i++)
    {
        if($files[$i] !='.' && $files[$i] !='..')
        {         
         
         
            $extension = pathinfo($files[$i], PATHINFO_EXTENSION);
            $filepath =$dir_path.'/'.$files[$i];
            $filename= $files[$i];
            $sz= filesize($filepath);

 if(in_array($extension, $image_extensions_array)){      

echo"<tr>
     <td class='tdcheckbox'><input type='checkbox' name='$filepath' id='$filepath'></td>
     <td><i data-name='$filepath' class='fa fa-file-image-o' style='font-size:26px;color:#66d7e5'></i></td>
     <td >$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='mov(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa' onclick='dele(id)' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='view(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 

     </td>
    </tr>
    ";
}

if(in_array($extension, $textfile_extensions_array)){

echo" <tr>
     <td class='tdcheckbox'><input type='checkbox' name='$filepath' id='$filepath'></td>
     <td><i data-name='$filepath' class='fa fa-file-word-o' style='font-size:26px;color:green'></i></td>
     <td>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='mov(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa' onclick='dele(id)' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='view(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 

     </td>
    </tr>
    ";





}

if(in_array($extension, $folder_extensions_array)){

echo"<tr>
     <td class='tdcheckbox'><input type='checkbox' name='$filepath' id='$filepath'></td>
     <td id='$filepath' onclick='faction(id);'><i class='fa fa-folder-o' style='font-size:26px;color:orange'></i></td>
     <td >$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='mov(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa' onclick='dele(id)' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='faction(id);' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 
</td></tr>";
}


   }
  }
}


?>










