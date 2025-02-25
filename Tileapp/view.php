<?php

$dpath=$_POST['dpath'];
$fpath=$_POST['fdname'];
$filename = basename($fpath);




  echo"<table><tr style='background-color:grey;'>
  <td style='width:5%;' data-name='$fpath'><i class='fa fa-folder-open' style='font-size:30px;color:orange;'></i></td>
  <td style='width:40%;'><text style='margin-left:1em;' id='fd_path'>$fpath</text></td>
  <td style='width:10%;'></td>
  <td style='width:10%;'></td>
  <td style='text-align:right;width:20%;padding-right:3em;'>
  <button class='btn btn-sm btn-success' id='$dpath' onclick='fsub(id)'><i class='fa fa-undo'></i></button>
  </td>
  </tr></table>";

echo "<div style='width:90%;height:90%;margin:1em;'><img src='$fpath' class='vimg'></div>";
echo "<p style='margin:1em;'>$filename</p>";
?>