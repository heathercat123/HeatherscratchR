<?php
    $params = array('data' => $data, 'project_id' => $project_id);
    if ($option == "comments") {
         	e($this->element('adminprojectcomments', $params));
       }
    if ($option == "dcomments") {
         	e($this->element('adminprojectdcomments', $params));
     }
    if ($option == "fcomments") {
         	e($this->element('adminprojectfcomments', $params));
    }
	if ($option == "administration") {
		e($this->element('adminprojectadmins', $params));
	}
?>