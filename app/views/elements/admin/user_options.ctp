<?php
			if ($option == "comments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminusercomments', array('user_id' => $user_id, 'data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
        	if ($option == "gcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('admin/user_gallery_comments', array('user_id' => $user_id, 'data'=> $data, 'show_hidden' => false)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "dpcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminuserdcomments', array('user_id' => $user_id, 'data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "dPparentcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminuserdparentcomments', array('user_id' => $user_id, 'data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "dgcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('admin/user_gallery_comments', array('user_id' => $user_id, 'data'=> $data, 'show_hidden' => true)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "dGparentcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('admin/user_parent_dcomments', array('user_id' => $user_id, 'data'=> $data, 'show_hidden' => true)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "mpcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminuserdcomments', array('user_id' => $user_id, 'data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "mgcomments") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('admin/flagged_gallery_comments', array('user_id' => $user_id, 'data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
        	if ($option == "projects") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminuserprojects', array('data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
        	if ($option == "cprojects") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminusercprojects', array('data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
        	if ($option == "lprojects") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('adminuserlprojects', array('data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
			if ($option == "notifications") {
		 		e($ajax->div("admin_project_comments"));
         			e($this->element('admin/notifications_list', array('data'=> $data)));
        	 	e($ajax->divEnd("admin_project_comments"));
        	}
?>