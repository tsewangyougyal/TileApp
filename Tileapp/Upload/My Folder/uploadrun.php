<?php

$dir_path = 'uploads/tsewang/';

if(!empty($_FILES))
{
	if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
	{
		sleep(1);
		$source_path = $_FILES['uploadFile']['tmp_name'];
		$target_path ='uploads/tsewang/' . $_FILES['uploadFile']['name'];
		if(move_uploaded_file($source_path, $target_path))
		{
					  
			echo '<img src="'.$target_path.'" class="img-thumbnail" width="300" height="250" /><br>';
			echo $dir_path.'<br>';
            echo $target_path;
		}
	}
}

?>

