<?php
	$params = Array('isThemeOwner' => $isThemeOwner, 'gallery_projects' => $theme_projects, 'session_username' => $session_username);
	e($this->element('gallery/projectlist', $params));
?>