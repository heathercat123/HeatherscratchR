<?php
	echo $this->element('gallery/create', Array('isCreated'=>$isCreated, 'errors'=>$errors, 
																	'gallery_id'=>$gallery_id, 'gallery_name'=>$gallery_name));
?>