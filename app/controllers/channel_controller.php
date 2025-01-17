<?php
Class ChannelController extends AppController {
    var $helpers = array('Pagination');
    var $components = array('Pagination');
    var $uses = array("IgnoredUser", "Project", "FeaturedProject", "Gallery", "Notification");
	var $feed_links = array ();
	
	 /**
     * Called before every controller action
	 * Overrides AppController::beforeFilter()
     */
    function beforeFilter() {
		$limit = 10;
		$url = env('SERVER_NAME');
		$url = strtolower($url);
		
		$this->Pagination->show = $limit;
        $obscured_uid = $this->encode($this->getLoggedInUserID());
        $this->feed_links = array (
            'recent' => "/feeds/getNewestProjects",
            'featured' => "/feeds/getFeaturedProjects",
            'topviewed' => "/feeds/getTopViewedProjects",
            'toploved' => "/feeds/getTopLovedProjects",
            'remixed' => "/feeds/getTopRemixedProjects",
            'friends_latest' => "/feeds/getFriendsLatestProjects/".$obscured_uid
        );
		$this->set('feed_links', $this->feed_links);
		$this->set('content_status', $this->getContentStatus());
        $this->set('isLoggedIn', $this->isLoggedIn());
    }
	
    function recent() {
        $this->redirect(array('controller' => 'latest', 'action' => 'shared'));
    }
	
    function featured() {
		$this->layout = 'scratchr_explorer';
		$this->pageTitle = ___("Scratch | Featured projects", true);
        $this->modelClass = "FeaturedProject";
		$options = array("sortByClass" => "FeaturedProject", "sortBy"=>"timestamp", "direction" => "DESC");
		
		//Listing deleted user   
 		   $deleted_users = $this->User->find('list', 
 		                array('conditions' =>  "User.status = 'delbyadmin' OR User.status = 'delbyusr'", 
 		                'fields' => 'id'));
		   $deleted_users_id = implode(',' ,$deleted_users);
		   
        $key = 'channel-featured-';
        $ttl = CHANNEL_FEATURED_CACHE_TTL;
//        $projects_count = $this->_getProjectsCount('proj_visibility = "visible"  AND status != "notsafe"',
//                                               $key, $ttl, 0);

	// Limit to 200 projects
	$projects_count = 200;
        list($order, $limit, $page) = $this->Pagination->init(null, array(),
                                            $options, $projects_count);
                                        
        $this->Project->mc_connect();
        $mc_key = $key.$limit.'-'.$page;
        $final_projects = $this->Project->mc_get($mc_key);
        if ($final_projects === false) {
            $this->Project->unbindModel(
                array('hasMany' => array('GalleryProject'))
            );
            $final_projects = $this->FeaturedProject->findAll("Project.proj_visibility = 'visible' AND Project.status != 'notsafe' AND Project.user_id NOT IN (".$deleted_users_id.")", NULL, $order, $limit, $page, 2, $this->getContentStatus());
			if(SHOW_RIBBON ==1){
			$i = 0;
				foreach($final_projects as $project){
					$current_project_id = $project['Project']['id'];
					$project['Project']['ribbon_name'] = $this->set_ribbon($current_project_id);
					$final_projects[$i++] = $project; 
				}
				
			}	
            $this->Project->mc_set($mc_key, $final_projects, false, $ttl);
        }
		
        $this->set('data', $final_projects);
        $this->Project->mc_close();

        $this->set('heading', ___("featured projects", true));
        $this->set('option', 'featured');
		$this->set('rss_link', $this->feed_links['featured']);
		$this->render('explorer');
    }

    function topviewed() {
		if (! $this->isLoggedIn()) { 
           $this->cakeError('error404');
        }
        $this->layout = 'scratchr_explorer';
        $this->pageTitle = ___("Scratch | Top viewed projects", true);
        $this->modelClass = "Project";
        $options = array("sortBy"=>"views", "direction" => "DESC");
		$moreconditions = "(User.status != 'delbyadmin' AND User.status != 'delbyusr')";

        $key = 'channel-topviewed-';
        $ttl = CHANNEL_TOPVIEWED_CACHE_TTL;
#        $projects_count = $this->_getProjectsCount('proj_visibility = "visible"  AND status != "notsafe"',
#                                                $key, $ttl);

	$projects_count = 200;
        list($order, $limit, $page) = $this->Pagination->init(null, array(),
                                            $options, $projects_count);
                                            
        $this->Project->mc_connect();
        $mc_key = $key.$limit.'-'.$page;
        $final_projects = $this->Project->mc_get($mc_key);
        if ($final_projects === false) {
            $this->Project->unbindModel(
                array('hasMany' => array('GalleryProject'))
            );
            $final_projects = $this->Project->findAll("Project.proj_visibility = 'visible' AND Project.status != 'notsafe' AND $moreconditions", NULL, $order, $limit, $page, NULL, $this->getContentStatus());
            $final_projects = $this->set_projects($final_projects);
            $this->Project->mc_set($mc_key, $final_projects, false, $ttl);
        }
        $this->set('data', $final_projects);
        $this->Project->mc_close();
	
        $this->set('heading', ___("top viewed", true));
		$this->set('option', 'topviewed');
		$this->set('rss_link', $this->feed_links['topviewed']);
        $this->render('explorer');
    }

    function toploved() {
		if (! $this->isLoggedIn()) { 
           $this->cakeError('error404');
        }
        $this->layout = 'scratchr_explorer';
        $this->pageTitle = ___("Scratch | Top loved projects", true);
        $this->modelClass = "Project";
        $options = array("sortBy"=>"loveit", "direction" => "DESC");
		$moreconditions = "(User.status != 'delbyadmin' AND User.status != 'delbyusr')";

        $key = 'channel-toploved-';
        $ttl = CHANNEL_TOPLOVED_CACHE_TTL;
#        $projects_count = $this->_getProjectsCount(
#                    'loveitsuniqueip > 0 AND proj_visibility = "visible" AND status != "notsafe"',
#                    $key, $ttl);
	# Limit to 200 top loved projects to eliminate a nasty query
	$projects_count = 200;
        list($order, $limit, $page) = $this->Pagination->init(null, array(),
                                            $options, $projects_count);

        $this->Project->mc_connect();
        $mc_key = $key.$limit.'-'.$page;
        $final_projects = $this->Project->mc_get($mc_key);
        if ($final_projects === false) {
            $this->Project->unbindModel(
                array('hasMany' => array('GalleryProject'))
            );
            $final_projects = $this->Project->findAll("Project.loveitsuniqueip > 0 AND Project.proj_visibility = 'visible' AND Project.status != 'notsafe' AND $moreconditions", NULL, $order, $limit, $page, NULL, $this->getContentStatus());
            $final_projects = $this->set_projects($final_projects);
            $this->Project->mc_set($mc_key, $final_projects, false, $ttl);
        }
        $this->set('data', $final_projects);
        $this->Project->mc_close();

        $this->set('heading', ___("top loved", true));
        $this->set('option', 'toploved');
        $this->set('rss_link', $this->feed_links['toploved']);
        $this->render('explorer');
    }


    function oldest() {
		$this->layout = 'scratchr_explorer'; 
		$this->pageTitle = "Scratch | Oldest projects";
        $this->modelClass = "Project";
        list($order,$limit,$page) = $this->Pagination->init("Project.proj_visibility = 'visible'");
        $this->Project->bindUser();
        $this->set('data', $this->Project->findAll("Project.proj_visibility = 'visible'",  NULL, "Project.id ASC", $limit, $page));
        $this->set('heading', ___("new projects",true));
        $this->render('explorer');
    }


    function untitled() {
		$this->layout = 'scratchr_explorer'; 
        $this->pageTitle = "Scratch | Oldest projects";
        $this->modelClass = "Project";
        list($order,$limit,$page) = $this->Pagination->init();
        $this->Project->bindUser();
        $this->set('data', $this->Project->findAll("name = 'Untitled'",  NULL, "Project.id ASC", $limit, $page));
        $this->set('heading', ___("new projects",true));
        $this->render('explorer');
    }

    function remixed() {
		if (! $this->isLoggedIn()) { 
           $this->cakeError('error404');
        }
		$this->layout = 'scratchr_explorer'; 
		$this->pageTitle = ___("Scratch | Most Remixed projects", true);
        $this->modelClass = "Project";
        $options = array("sortBy"=>"remixer", "direction" => "DESC");
		$moreconditions = "(User.status != 'delbyadmin' AND User.status != 'delbyusr')";

        $key = 'channel-remixed-';
        $ttl = CHANNEL_REMIXED_CACHE_TTL;        
#        $projects_count = $this->_getProjectsCount('remixer > 0 AND proj_visibility = "visible"  AND status != "notsafe"',
#                                                $key, $ttl);
	$projects_count = 200;
        list($order, $limit, $page) = $this->Pagination->init(null, array(),
                                            $options, $projects_count);

		$this->Project->mc_connect();
        $mc_key = $key.$limit.'-'.$page;
        $final_projects = $this->Project->mc_get($mc_key);
        if ($final_projects === false) {
            $this->Project->unbindModel(
                array('hasMany' => array('GalleryProject'))
            );
            $final_projects = $this->Project->findAll("remixer > 0 AND Project.proj_visibility = 'visible' AND Project.status != 'notsafe' AND $moreconditions", NULL, $order, $limit, $page, NULL);
            $final_projects = $this->set_projects($final_projects);
            $this->Project->mc_set($mc_key, $final_projects, false, $ttl);
        }
        $this->set('data', $final_projects);
        $this->Project->mc_close();

        $this->set('data', $final_projects);
        $this->set('heading', ___("top remixed", true));
		$this->set('option', 'remixed');
		$this->set('rss_link', $this->feed_links['remixed']);
        $this->render('explorer');
    }
	
	
 /* Methods to show surprise project(10 random projects)
 *
 * @author	Ashok gond
 */
    function surprise() {
	$this->layout = 'scratchr_explorer'; 
	$this->pageTitle = ___("Scratch | Surprise projects", true);
        $this->modelClass = "Project";
       	$moreconditions = "(User.status != 'delbyadmin' AND User.status != 'delbyusr')"; 
		
	$result = $this->Project->query("SELECT MAX(projects.id) AS maxid FROM projects");
	# To avoid full table scans which can occur due to Project.id being anywhere between 1 and MAX 
	# we'll use a range ie. random to random +/- 500.  
        $random = rand(1, $result[0][0]['maxid']);
	$randomplus = $random + 500;
        $query = "Project.id BETWEEN $random AND $randomplus AND Project.status <> 'notsafe' AND Project.proj_visibility = 'visible' AND $moreconditions";
        $count = $this->Project->findCount($query);
        if ($count < 10) {
	  $randomminus = $random - 500; 
	  $query = "Project.id BETWEEN $randomminus AND " .($random+$count)." AND Project.status <> 'notsafe' AND Project.proj_visibility = 'visible' AND $moreconditions";
	}

        $this->Project->unbindModel(
                array('hasMany' => array('GalleryProject'))
        );
        $final_projects = $this->Project->findAll($query, NULL, "Project.id", 10, 1, NULL);
		
	$final_projects = $this->set_projects($final_projects);
		
	$this->set('data', $final_projects);
        $this->set('heading', ___("surprise", true));
	$this->set('option', 'surprise');
	$this->render('surprise');
    }
	
    
    function friends_latest() {
        $this->layout = 'scratchr_explorer';
        $this->pageTitle = "Scratch | My Friends' Latest Projects";
        $this->modelClass = "Project";
        $user_id = $this->getLoggedInUserID();
        if(!$user_id) {
            $this->cakeError('error404');
            return false;
        }
        
        $projects_count = $this->Project->getMyFriendsLatestProjectsCount($user_id);
        list($order, $limit, $page) = $this->Pagination->init(null, array(),
                                            array(), $projects_count);
       
        $projects = $this->Project->getMyFriendsLatestProjects(
                                    $user_id, $page, $limit);
        if(SHOW_RIBBON ==1){
			$i = 0;
				foreach($projects as $project){
					$current_project_id = $project['Project']['id'];
					$project['Project']['ribbon_name'] = $this->set_ribbon($current_project_id);
					$projects[$i++] = $project; 
				}
				
			}	
		$this->set('data', $projects);
        
        $this->set('rss_link', $this->feed_links['friends_latest']);
        $this->set('heading', ___("friends' latest projects",true));
        $this->set('option', 'friends_latest');
        $this->render('explorer');
    }

    
	function set_projects($projects) {
		$isLogged = $this->isLoggedIn();
		$user_id = $this->getLoggedInUserID();
		$return_projects = Array();
		
		foreach ($projects as $project) {
			$temp_project = $project;
			$current_user_id = $temp_project['Project']['user_id'];
			$current_project_id = $temp_project['Project']['id'];
			$temp_project['Project']['ignored'] = false;
			if ($isLogged) {
				$ignore_count = $this->IgnoredUser->findCount("IgnoredUser.blocker_id = $user_id AND IgnoredUser.user_id = $current_user_id");
				if ($ignore_count > 0) {
					$temp_project['Project']['ignored'] = true;
				} else {
					$temp_project['Project']['ignored'] = false;
				}
			}
			if(SHOW_RIBBON ==1){
			$temp_project['Project']['ribbon_name'] = $this->set_ribbon($current_project_id);
			
			}
			array_push($return_projects, $temp_project);
		}
		return $return_projects;
	}

   function set_ribbon($current_project_id) {
		$feature_projects = $this->FeaturedProject->find("FeaturedProject.project_id = $current_project_id");
		$image_name = '';
				if ($feature_projects) {
					$text =$this->convertDate($feature_projects['FeaturedProject']['timestamp']);
			 		$image_name =$this->ribbonImageName($feature_projects['FeaturedProject']['timestamp']);
			 		$this->Thumb->generateThumb($ribbon_image='ribbon.gif',$text,$dir="small_ribbon",$image_name,$dimension='40x30',125,125);
					}
					return $image_name;
	}
   
    function _getProjectsCount($condition, $key, $ttl, $recursion = -1) {
        $this->Project->mc_connect();
        $model_class = $this->modelClass;
        $mc_key = $key.'count';
        $projects_count = $this->Project->mc_get($mc_key);
        if($projects_count === false) {
            $projects_count = $this->$model_class->findCount($condition, $recursion, 'all', true);
            $this->Project->mc_set($mc_key, $projects_count, false, $ttl);
        }
        $this->Project->mc_close();
        return $projects_count;
    }
}
?>
