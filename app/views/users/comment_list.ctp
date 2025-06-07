<div id="comment_list_wrapper">
	<?php
		echo $this->element('users/comment_list_content', Array('final_comments' => $final_comments, 'option' => $option));
	?>
</div>