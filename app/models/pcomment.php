<?php
class Pcomment extends AppModel {
    var $name = 'Pcomment';
    var $belongsTo = array('User' => array('className' => 'User'), 'Project' => array ('className' => 'Project'));
	
	/**
     * The following set of functions are overloaded cakePHP functions which
     * simply add the condition of proj_visibility='visible' to all sql queries.
     */
    function find($conditions=null, $fields=null, $order=null, $recursive=null, $safe="all")
    {
        return parent::find($conditions, $fields, $order, $recursive);
    }

    function read($fields=null, $id=null) 
    {
        return parent::read($fields, $id);
    }

    function findAll($conditions=null, $fields=null, $order=null, $limit=null, $page=1, $recursive=null, $safe="all", $admin = 0, $allowAll = false)
    {
        return parent::findAll($this->check($conditions, $safe, $admin, $allowAll),
                                $fields,$order,$limit,$page,$recursive);
    }

    function findCount($conditions=null, $recursive=0, $safe="all")
    {
       return parent::findCount($this->check($conditions, $safe), $recursive);
    }

    function addVisCheck($conditions = null, $admin = 0) 
    {	
		if ($admin == 1) {
			return $conditions;
		} else {
			$mycond = "(`proj_visibility`='visible' OR `proj_visibility`='censbycomm' OR `proj_visibility`='censbyadmin')" ;
			if (is_string($conditions) && strlen($conditions) > 0) 
				$mycond .= "AND $conditions";
			else if (is_array($conditions)) {
				foreach ($conditions as $key => $value) {
					if (is_string($value)) $mycond .= " AND `$key`='$value'";
					else $mycond .= " AND `$key`=$value";
				}
			}
			return $mycond;	
		}
	}

	function check($conditions = null, $safe, $admin = 0, $allowAll = false) {
        //use allowAll to bypass
        if($allowAll) {
            return $conditions;
        }
        
        $temp_conditions = $this->addVisCheck($conditions, $admin);
        $return_cond = $this->addSafeCheck($temp_conditions, $safe);
        return $return_cond;
	}
	
	function addSafeCheck($conditions = null, $content_level = "safe") {
		$isSafe=$this->getContentStatus();
		
		if ($content_level == "overload") {
			$content_level = "all";
		} else {
			if ($isSafe == "all") {
				$content_level = "all";
			} else {
				$content_level = "safe";
			}
		}
		if ($content_level == "all") {
			return $conditions;
		} else {
			$mycond = "`Project.status` ='safe'";
			if (is_string($conditions) && strlen($conditions) > 0) 
				$mycond .= "AND $conditions";
				else if (is_array($conditions)) {
				foreach ($conditions as $key => $value) {
					if (is_string($value)) $mycond .= " AND `$key`='$value'";
					else $mycond .= " AND `$key`=$value";
				}
			}
			return $mycond;
		}
	}

    function deleteCommentsFromMemcache($project_id) {
        $this->mc_connect();
        for($i=1; $i<=PCOMMENT_CACHE_NUMPAGE; $i++) {
            $mc_key = $project_id.'__'.$i;
            $this->mc_delete('pcomments', $mc_key);
            $mc_key = $project_id.'_1_'.$i;
            $this->mc_delete('pcomments', $mc_key);
        }
        //clear count cache
        $this->mc_delete('total_pcomments', $project_id);
        $this->mc_close();
    }
	
    function bindUser($conditions = null, $order = null) {
        $this->bindModel(array(
        'belongsTo' => array(
            'User' =>
                array('className' => 'User'))));
                   /*'conditions' => $conditions,
                    'order' => $order,
                    'foreignKey' => 'user_id'
                     ))));*/
    }
    
    function bindProject($conditions = null, $order = null) {
        $this->bindModel(array(
        'belongsTo' => array(
            'Project' =>
                array('className' => 'Project'))));
    }
	
	function bindMpcomment($conditions = null, $order = null) {
        $this->bindModel(array(
        'hasMany' => array(
            'Mpcomment' =>
                array('className' => 'Mpcomment',
					  'foreignKey' => 'comment_id'
				))));
    }
}
?>