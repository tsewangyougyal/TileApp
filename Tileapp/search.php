<?php

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



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if($_POST["searchTerm"] ===""){
  echo "<h5 style='margin:1rem;color:red'>plz enter an value to search</h5>";
 }
 else
 {
    $searchTerm = $_POST['searchTerm'];
    searchFiles('Upload/', $searchTerm);
}
}


function searchFiles($dir, $searchTerm)
{

$image_extensions_array = array('jpg','png','jpeg','gif');
$Audio_extensions_array = array('WAV', 'mp3', 'Vorbis', 'AAC');
$video_extensions_array = array('WebM','mp4', 'Theora','3gp');
$textfile_extensions_array=array('pdf','doc','txt','html','css','php','js','java','c','c#','json','log','sql');
$compression_extensions_array=array('7zip','zip','rar');
$software_extensions_array=array('exe','apk','xapk');






    $results = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if (!$file->isDir() && (stripos($file->getFilename(), $searchTerm) !== false || $file->getExtension() === $searchTerm)) {
            $filePath = str_replace('\\', '/', $file->getPathname());
            $results[] = [
                'name' => $file->getFilename(),
                'extension' => $file->getExtension(),
                'size' => $file->getSize(),
                'path' => $filePath
            ];
        }
    }

    if (empty($results)) {
        echo 'search item not found';
    } else {
        echo '<table id="myTable">';
        echo '<tr style="background-color:grey;height:50px;">
        <th><input type="checkbox" id="selectAll"></th>
        <th></th> 
        <th  id="nm">Name</th> 
        <th onclick="sortTable(1)" >Type</th>
        <th onclick="sortTable(2)" >Size</th> 
        <th>File Path</th>
        <th>...</th></tr>';



        echo '<tbody>';
        foreach ($results as $result) {

    if(in_array($result['extension'], $image_extensions_array)){    
    echo '<tr class="ltr">';
    echo '<td><input type="checkbox" class="fileCheckbox"></td>';
    echo '<td><img src="'. $result['path'] .'" alt="img" class="limg" onclick="view(this.id)" id="'.$result['path'].'"/></td>';
    echo '<td>' . $result['name'] . '</td>';
    echo '<td>' . $result['extension'] . '</td>';
    echo '<td>' .format_file_size( $result['size'] ). '</td>';
    echo '<td>' . $result['path'] . '</td>';

    echo '<td style="text-align:right;"><div class="dropdown">
          <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
          <i class="fa fa-ellipsis-v"></i></button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
            <a class="dropdown-item dropa" onclick="copy(id)" id="'.$result['path'].'">copy</a>
            <a class="dropdown-item dropa remove_file" name="'.$result['path'].'" id="'.$result['path'].'">delete</a>
          </div>
          </div> 
           </td>';
    echo '</tr>';
  }

   if(in_array($result['extension'], $video_extensions_array)){    
   echo '<tr class="ltr">';
   echo '<td><input type="checkbox" class="fileCheckbox"></td>';
   echo'<td><a href="'.$result['path'].'"target="_blank"><i class="fa fa-file-video-o"style="font-size:26px;color:#33C3FF"></i></a></td>';
   echo '<td>' . $result['name'] . '</td>';
   echo '<td>' . $result['extension'] . '</td>';
   echo '<td>' .format_file_size( $result['size'] ). '</td>';
   echo '<td>' . $result['path'] . '</td>';
       echo '<td style="text-align:right;"><div class="dropdown">
                  <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
                  <i class="fa fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
                    <a class="dropdown-item dropa" onclick="copy(id)" id="'.$result['path'].'">copy</a>
                    <a class="dropdown-item dropa remove_file" name="'.$result['path'].'" id="'.$result['path'].'">delete</a>
                  </div>
                  </div> 
                   </td>';
            echo '</tr>';
   }

   if(in_array($result['extension'], $Audio_extensions_array)){    
   echo '<tr class="ltr">';
   echo '<td><input type="checkbox" class="fileCheckbox"></td>';
   echo'<td><a href="'.$result['path'].'"target="_blank"><i class="fa fa-music"style="font-size:26px;color:#33C3FF"></i></a></td>';
   echo '<td>' . $result['name'] . '</td>';
   echo '<td>' . $result['extension'] . '</td>';
   echo '<td>' .format_file_size( $result['size'] ). '</td>';
   echo '<td>' . $result['path'] . '</td>';
       echo '<td style="text-align:right;"><div class="dropdown">
                  <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
                  <i class="fa fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
                    <a class="dropdown-item dropa" onclick="copy(id)" id="'.$result['path'].'">copy</a>
                    <a class="dropdown-item dropa remove_file" name="'.$result['path'].'" id="'.$result['path'].'">delete</a>
                  </div>
                  </div> 
                   </td>';
            echo '</tr>';
  }

   if(in_array($result['extension'], $textfile_extensions_array)){    
   echo '<tr class="ltr">';
   echo '<td><input type="checkbox" class="fileCheckbox"></td>';
   echo'<td><a href="'.$result['path'].'"target="_blank"><i class="fa fa-file-word-o"style="font-size:26px;color:#33C3FF"></i></a></td>';
   echo '<td>' . $result['name'] . '</td>';
   echo '<td>' . $result['extension'] . '</td>';
   echo '<td>' .format_file_size( $result['size'] ). '</td>';
   echo '<td>' . $result['path'] . '</td>';
      echo '<td style="text-align:right;"><div class="dropdown">
                  <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
                  <i class="fa fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
                    <a class="dropdown-item dropa" onclick="copy(id)" id="'.$result['path'].'">copy</a>
                    <a class="dropdown-item dropa remove_file" name="'.$result['path'].'" id="'.$result['path'].'">delete</a>
                  </div>
                  </div> 
                   </td>';
            echo '</tr>';
  }

   if(in_array($result['extension'], $compression_extensions_array)){    
   echo '<tr class="ltr">';
   echo '<td><input type="checkbox" class="fileCheckbox"></td>';
   echo'<td><a href="'.$result['path'].'" target="_blank" ><i class="fa fa-file-archive-o" style="font-size:26px;color:#33C3FF"></i></a></td>';
   echo '<td>' . $result['name'] . '</td>';
   echo '<td>' . $result['extension'] . '</td>';
   echo '<td>' .format_file_size( $result['size'] ). '</td>';
   echo '<td>' . $result['path'] . '</td>';
      echo '<td style="text-align:right;"><div class="dropdown">
                  <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
                  <i class="fa fa-ellipsis-v"></i></button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
                    <a class="dropdown-item dropa" onclick="copy(id)" id="'.$result['path'].'">copy</a>
                    <a class="dropdown-item dropa remove_file" name="'.$result['path'].'" id="'.$result['path'].'">delete</a>
                  </div>
                  </div> 
                   </td>';
            echo '</tr>';
  }


        }
        echo '</tbody>';
        echo '</table>';
    }
}


?>

