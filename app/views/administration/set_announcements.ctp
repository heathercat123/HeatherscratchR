<?php
	e($this->element('admin/admin_index', Array()));
?>
<div class="fullcontent">
	<div id="admin_project_header">
	</div>
	<div id="admin_project_content">
	<div id="announcement_list">
		<?php
			$params = array('a_1' => $a_1, 'a2' => $a_2, 'a3' => $a_3);
			e($this->element('admin/announcement_list'), $params);
		?>
	</div>
	<div id="announcement_toggle">
		<?php
			$params = array('isAnnouncementOn', $isAnnouncementOn);
			e($this->element('admin/announcement_toggle'), $params);
		?>
	</div>
	</div>
</div>