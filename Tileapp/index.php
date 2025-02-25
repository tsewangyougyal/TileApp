<!DOCTYPE html>
<html>
 <head>
  <title>PHP Filesystem with Ajax JQuery</title>
  <meta name="viewport" content="width=device-width, initial-scale=0.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.17.0/video.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/tablesort.js"></script>
  

  <style type="text/css">
body {
  font-family: Arial;
  font-size:12px; 
  margin: 0;
} 

.header {
  padding:1em;
  text-align:;
  background: #1abc9c;
  color: white;
  font-size:20px;
}

.content {
width:80%;
margin:auto;
}


.lpanel{
width:20%;
height:800px;
padding:0.5em; 
float:left;
background-color:#1c2833;
color:white;  
}

.rpanel{
width:80%;
height:800px;
float:right;
background-color:#EAEDED;
color:black; 
 overflow-y: scroll;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;   
}

.rpanel::-webkit-scrollbar { 
   width: 0;
    height: 0;
}


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  cursor:pointer;
}


th, td{
  text-align:;
  padding:8px;
}

.ltr:hover{
background-color:#B5B4B4;
color:white;   
}

.btr:hover{
color:#33FFE5;   
}



.dropa{
display:block;
padding:0.5em;
text-decoration:none;
background-color:white;    
}
.drop i{
color:black;  
}

.dropa:hover{
background-color:#00bcd4; 
text-decoration: none;
color:white;  
}
.dropa i{
margin:5px 15px 5px 5px;  
}

.mo i{
font-size:16px;  
margin:5px; 
color:#33c9dd;
}

.mo i:hover{
color:white;  
transition:all 0.01s ease-in-out;
transform:scale(1.1);
}

.limg{height:40px;
      width:40px; 
      }

.vimg{height:100%;
      width:100%; 
      }

@media screen and (max-width:720px) {
  .content {width:100%;}
  .lpanel{width:100%;}
  .rpanel{width:100%;}
}


</style>


<script>



function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (n === 4) { // If sorting by size
                    if (convertToBytes(x.innerHTML) > convertToBytes(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            } else if (dir == "desc") {
                if (n === 4) { // If sorting by size
                    if (convertToBytes(x.innerHTML) < convertToBytes(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function convertToBytes(sizeStr) {
    var size = parseFloat(sizeStr);
    var unit = sizeStr.replace(size, '').trim().toLowerCase();
    switch (unit) {
        case 'kb':
            return size * 1024;
        case 'mb':
            return size * 1024 * 1024;
        case 'gb':
            return size * 1024 * 1024 * 1024;
        default:
            return size; // assuming bytes if no unit
    }
}




let savepath;

function fsub(id){
var value={'fdname':id};
$.ajax({
    type:"POST",
     url:"flist.php",
   data:value,
 success:function(response){        
  $("#table-panel").html(response);
}
});
}

function undo(id){
var backpath=id.substring(0, id.lastIndexOf('/'));
var value={'fdname':backpath};

$.ajax({
    type:"POST",
     url:"flist.php",
   data:value,
 success:function(response){        
  $("#table-panel").html(response);
}
});

}


function copy(id){
savepath=id;
alert(savepath);
}




function move(id){
var action = "file_move";
var cpath=id;
var value={'dpath':id, 'spath':savepath, 'action':action};
if(confirm("Are you sure you want to paste it here?")){
$.ajax({
    type:"POST",
     url:"operator.php",
    data:value,
   success:function(response){        
  $("#table-panel").html(response);
}
   
});
} 
 fsub(cpath);
}


function paste(id){
var action = "file_paste";
var cpath=id;
var value={'dpath':id, 'spath':savepath, 'action':action};
if(confirm("Are you sure you want to paste it here?")){
$.ajax({
    type:"POST",
     url:"operator.php",
    data:value,
   success:function(response){        
  $("#table-panel").html(response);
}
   
});
} 
 if(confirm("reload page")){fsub(cpath);}
}




function view(id){
    var dpath=id.substring(0, id.lastIndexOf('/'));
var value={'fdname':id, 'dpath':dpath};
$.ajax({
    type:"POST",
     url:"view.php",
    data:value,
   success:function(response){        
  $("#table-panel").html(response);
}
});
} 


 $(document).on('click', '.remove_file', function(){
  var path = $(this).attr("id");
  var fdpath = $(this).attr("name");
  var action = "remove_file";
  if(confirm("Are you sure you want to remove this file?"))
  {
   $.ajax({
    url:"operator.php",
    method:"POST",
    data:{path:path, action:action},
    success:function(data)
    {
     alert(data);
     $('#filelistModal').modal('hide');

    fsub(fdpath);
    }
   });
  }
 });


 $(document).on("click", ".delete", function(){
  var folder_name = $(this).data("name");
  var fdpath = $(this).attr("name");
  var action = "delete";
  if(confirm("Are you sure you want to remove it?"))
  {
   $.ajax({
    url:"operator.php",
    method:"POST",
    data:{folder_name:folder_name, action:action},
    success:function(data)
    {
     alert(data);
     fsub(fdpath);
    }
   });
  }
 });


  $(document).on('click', '#create_folder', function(){
   var fdir=$('#fd_path').html();
   $('#fptext').text(fdir);
  $('#folderModal').modal('show');
  });

  $(document).on('click', '#file_upload', function(){
    var fdpath=$('#fd_path').html();
   $('#uptext').text(fdpath);
  $('#uploadModal').modal('show');
  });



  $(document).on('click', '#fn_submit', function(){
    var action='create';
    var fdpath=$('#fd_path').html();
    var fdname=$('#fd_name').val();
  if(fdname != ''){
   $.ajax({
    url:"operator.php",
    method:"POST",
    data:{fdpath:fdpath, fdname:fdname, action:action},
    success:function(data)
    {
     $('#folderModal').modal('hide');
     alert(data);
     fsub(fdpath);
    }
   });
  }
  else
  {
   alert("Enter Folder Name");
  }
});



$(document).on('blur', '.change_file_name', function(){
  var fdpath=$('#fd_path').html();
  var folder_name = $(this).data("folder_name");
  var old_file_name = $(this).data("file_name");
  var new_file_name = $(this).text();
  var action = "change_file_name";
  $.ajax({
   url:"operator.php",
   method:"POST",
   data:{folder_name:folder_name, old_file_name:old_file_name, new_file_name:new_file_name, action:action},
   success:function(data)
   {
    alert(data);
    fsub(fdpath);
   }
  });
 });






</script>

</head>
<body>

<div class="content">

<div class="header"><a href="index.php"><i class="fa fa-hdd-o" style="color:white;font-size:38px;"></i></a></div>

<div class="lpanel">

<div style="width:95%;margin:0.5em;"><form id="searchForm">
      <div class="input-group col-md-12">
        <input type="text" id="searchTerm" class="form-control searchbar" placeholder="Search here...">
        <div class="input-group-btn" >
        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
    </div>   </form>
  </div>
</div> 

 
<hr>
<table>
<?php

$dir_path = "Upload/";
echo "<tr onclick='fsub(id);' id='$dir_path' class='btr'>
<td width='20%'><i class='fa fa-folder-open' style='font-size:26px;color:#FF9933;'></i></td>
<td width='80%'>$dir_path</td></tr>";
if(is_dir($dir_path))
{
$files = opendir($dir_path);
{
if($files){
          while(($file_name = readdir($files)) !== FALSE) {
          if($file_name != '.' && $file_name != '..'){
            $file_path=$dir_path.$file_name;

echo " <tr onclick='fsub(id);' id='$file_path' class='btr'>
<td width='20%'><i class='fa fa-folder' style='font-size:26px; color:#FEC907; padding-left:0.5em;'></i></td>
<td width='80%'>$file_name</td></td>
</tr>";

} } 
}
}
}
?>
</table> 
<hr>
<?php
function getFileSizeByExtension($dir, $extensions) {
    $totalSize = 0;
    $fileCount = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) {
            $totalSize += $file->getSize();
            $fileCount++;
        }
    }
    return ['size' => $totalSize, 'count' => $fileCount];
}

function formatSize($size) {
    if ($size >= 1073741824) {
        $sizeFormatted = number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        $sizeFormatted = number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        $sizeFormatted = number_format($size / 1024, 2) . ' KB';
    } else {
        $sizeFormatted = $size . ' bytes';
    }
    return $sizeFormatted;
}

$dir = 'Upload/';
$imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$videoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
$audioExtensions = ['mp3', 'acc', 'wav'];

$imageData = getFileSizeByExtension($dir, $imageExtensions);
$videoData = getFileSizeByExtension($dir, $videoExtensions);
$audioData = getFileSizeByExtension($dir, $audioExtensions);
$otherSize = 0;
$otherCount = 0;

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    if (!in_array($extension, array_merge($imageExtensions, $videoExtensions, $audioExtensions))) {
        $otherSize += $file->getSize();
        $otherCount++;
    }
}

$totalSize = $imageData['size'] + $videoData['size'] +$audioData['size']+ $otherSize;
$totalCount = $imageData['count'] + $videoData['count'] +$audioData['count']+ $otherCount;

$data = [
    '<button onclick="fetchFiles(id)" id="picture" class="btn btn-sm btn-info"><i class="fa fa-file-image-o fa-2x"></i></button>' => ['size'=> $imageData['size'], 'count'=> $imageData['count']],
    '<button onclick="fetchFiles(id)" id="video" class="btn btn-sm btn-primary"><i class="fa fa-file-video-o fa-2x"></i></button>' => ['size'=> $videoData['size'], 'count'=> $videoData['count']],
    '<button onclick="fetchFiles(id)" id="audio" class="btn btn-sm btn-danger"><i class="fa fa-music fa-2x" ></i></button>' => ['size'=> $audioData['size'], 'count'=> $audioData['count']],
    '<button onclick="fetchFiles(id)" id="other" class="btn btn-sm btn-warning"><i class="fa fa-file-o fa-2x"></i></button>' => ['size'=> $otherSize, 'count'=> $otherCount]
];

echo "<table class=''>";

foreach ($data as $type => $info) {
    $progress = ($info['size'] / $totalSize) * 100;
    echo "<tr>
            <td >$type</td>
            <td >{$info['count']}</td>
            <td><div style='width: 100%; background-color:#696969;'>
                <div style='width: $progress%; background-color: #4CAF50;'>". formatSize($info['size']) ."</div>
            </div></td>
        </tr>";
}

echo '<tr><td colspan="3"><hr></td></tr>';
echo '<tr><td><button onclick="fetchFiles(id)" id="all" class="btn btn-sm btn-primary">Total</button></td><td>' . $totalCount . '</td><td>' . formatSize($totalSize) . '</td></tr>';
echo "</table>";
?>


</div>




<div class="rpanel">
<div id="table-panel" class="" style='margin-bottom:5em;'> </div>

</div> 

</div>

<div id='folderModal' class='modal fade' role='dialog'>
 <div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h4 class='modal-title'><span id='change_title'>Upload file</span></h4>
   </div>
   <div class='modal-body'>
   <table><tr>
   <td><i class='fa fa-folder' style='font-size:28px;color:#FEC907;'></i></td>
   <td><h6 id='fptext'>folderpath</h6></td> 
   <td><input type='text' class='form-control' id='fd_name' placeholder='Enter Folder Name..'></td>
   <td><button class='btn btn-info' id='fn_submit'>Submit</button></td>
   </tr></table> 
   </div>

   <div class='modal-footer'>
   <button class='btn btn-danger' data-dismiss='modal'>Close</button>
   </div>

 </div>
</div>
</div>

 


<div id='uploadModal' class='modal fade' role='dialog'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h4 class='modal-title'><span id='change_title'>Upload file</span></h4>
   </div>


   <div class='modal-body'>

      <form action="upload.php" method="post" enctype="multipart/form-data">
         <table><tr>
         <td><i class='fa fa-folder' style='font-size:28px;color:#FEC907;'></i></td>
         <td><h4 id='uptext'>folderpath</h4></td> 
         <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
         <td><input type="button" value="Upload Image" onclick="uploadfile();" id=""></td>
        </tr></table>
      </form>
  <div id="uploadmsg" style="width:95%;height:100px;padding:1em;background-color:orange;margin:auto;"></div>
 </div>

   <div class='modal-footer'>
    <button class='btn btn-danger' data-dismiss='modal'>Close</button>
   </div>
  </div>
 </div>
</div>


<script type="text/javascript">

function uploadfile(){

 var fdpath = $('#uptext').html();
 var fileToUpload = $('#fileToUpload').val();

 if(fileToUpload == ''){
 alert('Please select a file to upload');
 return;
 }

 var formData = new FormData();
 formData.append('fileToUpload', $('#fileToUpload')[0].files[0]);
 formData.append('fdpath', fdpath);

$.ajax({
    type:"POST",
    url:"upload.php",
    data:formData,
    processData: false,
  contentType: false,
  type: 'POST',
 success:function(response){        
  $("#uploadmsg").html(response);
fsub(fdpath);
}
});

}

  

document.getElementById('searchForm').addEventListener('submit', function(event) {
  event.preventDefault();
  const searchTerm = document.getElementById('searchTerm').value;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'search.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById('table-panel').innerHTML = xhr.responseText;
      }
  };
  xhr.send('searchTerm=' + encodeURIComponent(searchTerm));
});
  




function fetchFiles(type) { 
    $.ajax({ url: 'list_files.php', method: 'GET',
     data: { type: type },
     dataType: 'html', success: function(data) {
      $('#table-panel').html(data); }, error: function(xhr, status, error) {
       console.error('Error fetching files:', error); }
        });
 }

$(document).ready(function() { 
    $(document).on('click', '#selectAll', function() {
     const isChecked = $(this).prop('checked');
      $(".fileCheckbox").prop('checked', isChecked);
       });
        $(document).on('click', '.fileCheckbox', function() {
         if (!this.checked) { 
            $("#selectAll").prop('checked', false); 
        }
       if ($(".fileCheckbox:checked").length === $(".fileCheckbox").length) {
        $("#selectAll").prop('checked', true);
         } 
     }); 
    });

</script> 


</body>
</html>
