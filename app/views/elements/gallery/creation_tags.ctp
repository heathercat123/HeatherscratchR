<?php
	foreach($predefined_tags as $tag) {
		echo $this->element('gallery/creation_tag_row', Array("tag" => $tag));
	}
?>