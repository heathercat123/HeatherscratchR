<?php
class NotificationsController extends AppController {
	
	var $name = 'Notifications';
	var $uses = array('Notification', 'FriendRequest');
	var $helpers = array('Ajax', 'Pagination', 'Template');
	var $components = array('Pagination');

	/**
	* Called before every controller action
	* Overrides AppController::beforeFilter()
	*/
    function beforeFilter() {
		$this->set('content_status', $this->getContentStatus());
    }
	
	function index() {
		$user_id = $this->Session->read('User.id');

		if(empty($user_id)) {
			$this->cakeError('error404');
		}
		
		$user_record = $this->User->find("id = $user_id");
		if(empty($user_record)) {
			$this->cakeError('error404');
		}

		$client_ip = $this->RequestHandler->getClientIP();
		$sql = "INSERT INTO `notification_histories` (`id`,`user_id`,`ipaddress`) VALUES"
                        ." (NULL, $user_id, INET_ATON('$client_ip'))";
        $this->Notification->query($sql);

	
		$username = $user_record['User']['username'];
		$notify_pcomment = $user_record['User']['notify_pcomment'];
		$notify_gcomment = $user_record['User']['notify_gcomment'];
		$this->set('username', $username);
		$this->set('notify_pcomment', $notify_pcomment);
		$this->set('notify_gcomment', $notify_gcomment);
		
		$options = array( 'show'=>25  );
		$this->Pagination->ajaxAutoDetect = false;
		list($order, $limit, $page) = $this->Pagination->init(null, null, $options,
												$this->Notification->countAll($user_id));
		$notifications = $this->Notification->getNotifications($user_id, $page, $limit);
		$this->set('notifications', $notifications);
		$this->set('notify_count', count($notifications));
		
		
		// For separate admin notifications
		$inot = $this->Notification->getInappropriateNotifications($user_id, $page, $limit);
        $inappropriate_notifications = array();
        $i = 0;
		foreach($inot as $inappropriate) {
		    if($inappropriate['Notification']['status'] == 'UNREAD' && $inappropriate['NotificationType']['is_admin'] == '1')
			$inappropriate_notifications[$i++]['0'] = array_merge($inappropriate['Notification'], $inappropriate['NotificationType'], $inappropriate['0']);
		}
		
		$this->set('inappropriate_notifications', $inappropriate_notifications);
		
        $rss_link = '/feeds/getNotificationFeeds/'.$this->encode($user_id);
        $this->set('rss_link', $rss_link);
		$this->set('title', "Scratch | Messages and notifications");

		$this->render('notifications');
	}
	
	function view($user_id){
		if(!$this->isAdmin()) {
			$this->cakeError('error404');
		}
		$user_record = $this->User->find("id = $user_id");
        if(empty($user_record)) {
            $this->cakeError('error404');
        }

        $username = $user_record['User']['username'];
        $this->set('username', $username);
		
		$i = 0;
		$options = array( 'show'=>25  );
		$this->Pagination->ajaxAutoDetect = false;
		list($order, $limit, $page) = $this->Pagination->init(null, null, $options,
												$this->Notification->countAllNotification($user_id));
		
		$inappropriate_notifications = array();
		$notifications = $this->Notification->getInappropriateNotifications_acp($user_id, $page, $limit);

	
		foreach($notifications as $notification) {
			$inappropriate_notifications[$i++]['0'] = array_merge($notification['Notification'], $notification['NotificationType'], $notification['0']);
		}
		
		$this->set('inappropriate_notifications', $inappropriate_notifications);
	}
	
	/* 
	 * AJAX-called
	 * marks the indicated notification as read
	 */
	function hide($nid) {
		 $this->autoRender = false;
		 $user_id = $this->getLoggedInUserID();
		 $this->Notification->recursive = -1;
		 $notification = $this->Notification->find('first', array('fields' => array('to_user_id'),
											'conditions' => array('id' => $nid)));
		 if(empty($notification)) {
			$this->cakeError('error404');
		 }
		 if($notification['Notification']['to_user_id'] != $user_id) {
			$this->cakeError('error404');
		 }
		 
		 $this->Notification->id = $nid;
		 $this->Notification->saveField('status','READ');
		 $this->Notification->clear_memcached_notifications($user_id);
		 $this->render('hide_notification_ajax', 'ajax');
	}
	
	/* 
	 * AJAX-called
	 * marks all user notification as read
	 */
	function hide_all() {
		 $this->autoRender = false;
		 $user_id = $this->getLoggedInUserID();
		 //notification update
		 $this->Notification->readAllExceptAdmin($user_id);
		 //friend request update
		 $this->FriendRequest->updateAll(array('FriendRequest.status' => '"declined"'), array('to_id' => $user_id));
		 $this->Notification->clear_memcached_notifications($user_id);
		 $this->render('hide_all_notification_ajax', 'ajax');
	}
	
	function pnotify() {
		 $this->autoRender = false;
		 $user_id = $this->Session->read('User.id');
		 $this->User->id = $user_id;
		 $this->User->saveField('notify_pcomment',1);
		 $user_record = $this->User->find("id = $user_id");
		 $notify_pcomment = $user_record['User']['notify_pcomment'];
		 $this->set('notify_pcomment', $notify_pcomment);
		 $this->render("pnotify_ajax", "ajax");	 
	}
	
	function unpnotify() {
		 $this->autoRender = false;
		 $user_id = $this->Session->read('User.id');
		 $this->User->id = $user_id;
		 $this->User->saveField('notify_pcomment',0);
		 $user_record = $this->User->find("id = $user_id");
		 $notify_pcomment = $user_record['User']['notify_pcomment'];
		 $this->set('notify_pcomment', $notify_pcomment);
		 $this->render("pnotify_ajax", "ajax");
	}
	
	function gnotify() {
		 $this->autoRender = false;
		 $user_id = $this->Session->read('User.id');
		 $this->User->id = $user_id;
		 $this->User->saveField('notify_gcomment',1);
		 $user_record = $this->User->find("id = $user_id");
		 $notify_gcomment = $user_record['User']['notify_gcomment'];
		 $this->set('notify_gcomment', $notify_gcomment);
		 $this->render("gnotify_ajax", "ajax");	 
	}
	
	function ungnotify() {
		 $this->autoRender = false;
		 $user_id = $this->Session->read('User.id');
		 $this->User->id = $user_id;
		 $this->User->saveField('notify_gcomment',0);
		 $user_record = $this->User->find("id = $user_id");
		 $notify_gcomment = $user_record['User']['notify_gcomment'];
		 $this->set('notify_gcomment', $notify_gcomment);
		 $this->render("gnotify_ajax", "ajax");
	}
}
?>
