<?php

function format_file_size($size)
{
    if ($size >= 1073741824) {
        return number_format($size / 1073741824, 2) . ' GB';
    } elseif ($size >= 1048576) {
        return number_format($size / 1048576, 2) . ' MB';
    } elseif ($size >= 1024) {
        return number_format($size / 1024, 2) . ' KB';
    } elseif ($size > 1) {
        return $size . ' bytes';
    } elseif ($size == 1) {
        return $size . ' byte';
    } else {
        return '0 bytes';
    }
}

function searchFiles($dir, $fileExtensions, $searchAll = false)
{
    $results = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if (!$file->isDir()) {
            $fileExtension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
            if ($searchAll || in_array($fileExtension, $fileExtensions)) {
                $filePath = str_replace('\\', '/', $file->getPathname());
                $results[] = [
                    'name' => $file->getFilename(),
                    'extension' => $fileExtension,
                    'size' => $file->getSize(),
                    'formatted_size' => format_file_size($file->getSize()),
                    'path' => $filePath
                ];
            }
        }
    }

    return $results;
}

$image_extensions = ['jpg', 'png', 'jpeg', 'gif'];
$audio_extensions = ['wav', 'mp3', 'vorbis', 'aac'];
$video_extensions = ['webm', 'mp4', 'theora', '3gp'];

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $files = [];

    if ($type === 'all') {
        $files = searchFiles('Upload/', [], true);
    } else {
        switch ($type) {
            case 'video':
                $files = searchFiles('Upload/', $video_extensions);
                break;
            case 'audio':
                $files = searchFiles('Upload/', $audio_extensions);
                break;
            case 'picture':
                $files = searchFiles('Upload/', $image_extensions);
                break;
            case 'other':
                $all_extensions = array_merge($image_extensions, $audio_extensions, $video_extensions);
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('Upload/'));
                foreach ($iterator as $file) {
                    if (!$file->isDir() && !in_array(pathinfo($file->getFilename(), PATHINFO_EXTENSION), $all_extensions)) {
                        $filePath = str_replace('\\', '/', $file->getPathname());
                        $files[] = [
                            'name' => $file->getFilename(),
                            'extension' => pathinfo($file->getFilename(), PATHINFO_EXTENSION),
                            'size' => $file->getSize(),
                            'formatted_size' => format_file_size($file->getSize()),
                            'path' => $filePath
                        ];
                    }
                }
                break;
            default:
                $files = [];
        }
    }

    if (empty($files)) {
        echo '<h5 style="margin:1rem;color:red">No files found.</h5>';
    } else {
        echo '<table id="myTable">';
        echo '<thead>';
        echo '<tr style="background-color:grey;height:50px;">
        <th><input type="checkbox" id="selectAll"></th>
        <th>Icon</th>
        <th onclick="sortTable(2)" style="cursor:pointer">Name</th> 
        <th onclick="sortTable(3)" style="cursor:pointer">Type</th>
        <th onclick="sortTable(4)" style="cursor:pointer">Size</th> 
        <th>File Path</th>
        <th>Actions</th></tr>';
        echo '</thead>';
        
        echo '<tbody>';
        foreach ($files as $file) {
            $icon = '';
            if (in_array($file['extension'], $image_extensions)) {
                $icon = '<img src="'. $file['path'] .'" class="limg">';
            } elseif (in_array($file['extension'], $video_extensions)) {
                $icon = '<i class="fa fa-file-video-o" style="font-size:26px;color:#33C3FF" onclick="playMedia(id)" value="'.$file['path'].'"></i>';
            } elseif (in_array($file['extension'], $audio_extensions)) {
                $icon = '<i class="fa fa-music" style="font-size:26px;color:#33C3FF"></i>';
            } else {
                $icon = '<i class="fa fa-file-o" style="font-size:26px;color:#33C3FF"></i>';
            }

            echo '<tr>';
            echo '<td><input type="checkbox" class="fileCheckbox"></td>';
            echo '<td id="movieThumbnail" >' . $icon . '</td>';
            echo '<td>' . $file['name'] . '</td>';
            echo '<td>' . $file['extension'] . '</td>';
            echo '<td data-size="' . $file['size'] . '">' . $file['formatted_size'] . '</td>';
            echo '<td>' . $file['path'] . '</td>';
            echo '<td>
                <div class="dropdown">
                    <button class="dropdown-toggle btn btn-default" id="dropdownMenuButton" data-toggle="dropdown">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding:0px;">
                        <a class="dropdown-item dropa" onclick="copy(id)" id="'.$file['path'].'">Copy</a>
                        <a class="dropdown-item dropa remove_file" name="'.$file['path'].'" id="'.$file['path'].'">Delete</a>
                        <a class="dropdown-item dropa" onclick="view(id)" id="'.$file['path'].'">view</a>
                        <a class="dropdown-item dropa" href="download.php?file='.$file['path'].'">download</a>
                    </div>
                </div>
            </td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}
?>

<script>
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
                if (n === 4) { // If sorting by size
                    if (parseInt(x.getAttribute("data-size")) > parseInt(y.getAttribute("data-size"))) {
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
                    if (parseInt(x.getAttribute("data-size")) < parseInt(y.getAttribute("data-size"))) {
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
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
</script>
