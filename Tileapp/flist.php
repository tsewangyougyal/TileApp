<?php

$dir_path =$_POST['fdname'];


$folder_extensions_array=array('');
$image_extensions_array = array('jpg','png','jpeg','gif');
$Audio_extensions_array = array('WAV', 'mp3', 'Vorbis', 'AAC');
$video_extensions_array = array('WebM','mp4', 'Theora','3gp');
$textfile_extensions_array=array('pdf','doc','txt','html','css','php','js','java','c','c#','json','log','sql');
$compression_extensions_array=array('7zip','zip','rar');
$software_extensions_array=array('exe','apk','xapk');


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



function calculateFolderSize($dir)
{
    $size = 0;

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS));

    foreach ($iterator as $file) {
        $size += $file->getSize();
    }

    return $size=format_file_size($size);
}




echo"<table class='zui-table' id='myTable'>
  <tr style='background-color:grey;'>

  <td style='width:5%;' data-name='$dir_path'><i class='fa fa-folder-open' style='font-size:30px;color:orange;'></i></td>
  <td onclick='sortTable(0)'><text style='margin-left:1em;' id='fd_path'>$dir_path</text></td>
  <td style='width:10%;' onclick='sortTable(1)'>Size</td>
  <td style='width:10%;'onclick='sortTable(2)'>Type</td>
  
  <td style='text-align:right'>
  <div class=''>
  <button class='btn btn-sm btn-success' id='$dir_path' onclick='paste(id)'>Paste here</button>
  <button class='btn btn-sm btn-alert' id='$dir_path' onclick='move(id)'>Move here</button>
  <button class='btn btn-sm btn-warning' id='create_folder'>New <i class='fa fa-folder-o'></i></button>
  <button class='btn btn-sm btn-info' id='file_upload' onclick='faction(id)'>Upload <i class='fa fa-upload'></i></button>
  <button class='btn btn-sm btn-success' id='$dir_path' onclick='undo(id);'><i class='fa fa-undo'></i></button>
  </div> 
  </td>

  </tr>";


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

echo"<tr class='ltr'>
     <td onclick='view(id)' id='$filepath'><img src='$filepath' class='limg' ></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa remove_file' name='$dir_path' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='view(id,name)' name='$dir_path' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 

     </td>
    </tr>
    ";
}

if(in_array($extension, $textfile_extensions_array)){

echo" <tr class='ltr'>
     <td><a href='$filepath' target='_blank'><i class='fa fa-file-word-o' style='font-size:26px;color:green'></i></a></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa remove_file' name='$dir_path' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='download(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 

     </td>
    </tr>
    ";
  }


if(in_array($extension, $Audio_extensions_array)){

echo" <tr class='ltr'>
     <td><a href='$filepath' target='_blank'><i class='fa fa-music' style='font-size:26px;color:#FF337A'></i></a></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
  <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa remove_file' name='$dir_path' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='download(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 
  </td>
  </tr>";
}


if(in_array($extension, $video_extensions_array)){

echo" <tr class='ltr'>
     <td><a href='$filepath' target='_blank'><i class='fa fa-file-video-o' style='font-size:26px;color:#33C3FF'></i></a></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
  <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa remove_file' name='$dir_path' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='download(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 
  </td>
  </tr>";
}



if(in_array($extension, $compression_extensions_array)){

echo" <tr class='ltr'>
     <td><i class='fa fa-file-archive-o' style='font-size:26px;color:#581845'></i></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".format_file_size($sz)."</td>
     <td>$extension</td>
  <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa remove_file' name='$dir_path' id='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='download(id)' id='$filepath'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 
  </td>
  </tr>";
}

if(in_array($extension, $folder_extensions_array)){

echo"<tr class='ltr'>
     <td id='$filepath' name='$dir_path' onclick='fsub(id, name)'><i class='fa fa-folder' style='font-size:26px;color:#FEC907;'></i></td>
     <td contenteditable='true' data-folder_name='$dir_path'  data-file_name = '$filename' class='change_file_name'>$filename</td>
     <td>".calculateFolderSize($filepath)."</td>
     <td>$extension</td>
     <td style='text-align:right;'><div class='dropdown'>
  <button class='dropdown-toggle btn btn-default' id='dropdownMenuButton' data-toggle='dropdown'>
  <i class='fa fa-ellipsis-v'></i></button>
  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton' style='padding:0px;'>
    <a class='dropdown-item dropa' onclick='copy(id)' id='$filepath'>copy</a>
    <a class='dropdown-item dropa editbtn' onclick='edit(id)' id='$filepath'>edit</a>
    <a class='dropdown-item dropa delete'  name='$dir_path' data-name='$filepath'>delete</a>
    <a class='dropdown-item dropa' onclick='fsub(id, name);' id='$filepath' name='$dir_path'>view</a>
    <a class='dropdown-item dropa' href='download.php?file=$filepath'>download</a>
  </div>
  </div> 
</td></tr>";
}


}  
}
}
echo "</table>";
?>










