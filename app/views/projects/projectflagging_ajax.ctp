<?php
    e($this->element('flag'));
?>
<?php if (!empty($just_flagged)):?>
	<script>
	$('loveitDiv').toggle();
	$('favoriteDiv').toggle();
	</script>
<?php endif;?>
