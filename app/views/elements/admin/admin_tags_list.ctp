<?php
	foreach ($admin_tags as $tag) {
		echo $this->element('admin/admin_tags_row', Array('tag'=>$tag));
	}
?>