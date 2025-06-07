<?php
	e($this->element('admin/admin_index', Array()));
?>
<div class="fullcontent">
<div id="admin_project_header">
	<h3> All users using <?php e($ip); ?> </h3>
	</div>
	<div id="admin_project_content">
	<?php
		echo $this->element('admin/user_list', Array('data' => $data));
	?>
    </div>
</div>