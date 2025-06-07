<?php
	$params = array('isLocked' => $isLocked, $pid => $pid);
	e($this->element('projects/project_lock', $params));
?>