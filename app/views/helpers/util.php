<?php
class UtilHelper extends Helper {
    function username($username, $role, $possesive = false) {
        $asterisk = "";
		$ellipses ="";
		$full_username = $username;
		$short_username = $username;
		if (strlen($username) >= 16) {
			$short_username = substr($username, 0, 13);
			$ellipses ="&#0133;";
		}
        if($role=='admin') {
            $asterisk = "<a  class='asterisk' href=" .INFO_URL. '/Admins' ." >*</a>";

        }
        
		if($role == 'cm')
		{
         	$cm = "<a class='asterisk' href='" . CM_URL . "'>&deg;</a>";
		}
		
		$extra = $possesive ? ___("'s", true) : '';
        return "<a href=\"/users/{$full_username}\">{$short_username}</a>{$ellipses}{$extra}{$asterisk}{$cm} ";
    }
    
   /**
	* Helper for setting up auto html links for urls in comments
	**/
    function linkify($content) {
        $pattern = '/\b(https?:\/\/)?(www.)?[A-Z0-9.]*('
                    . WHITELISTED_URL_PATTERN
                    . ')[-A-Z0-9+&@#()\/%?=~_|!:,.;]*/i';

        return preg_replace_callback(
                $pattern, array( &$this,'linkify_cb'),
                $content
	);
	/*
	$content = preg_replace('/awesome/i','<a href="http://www.cornify.com" onclick="cornify_add();return false;">awesome</a><script type="text/javascript" src="http://www.cornify.com/js/cornify.js"></script>',$content);
	$content = preg_replace('/friday/i','<a href="http://scratch.mit.edu/redirect/url?link=http%3A%2F%2Fscratch.mit.edu%2Ffriday.html">FRIDAY</a>',$content);
	$content = preg_replace('/april/i','<a href="http://scratch.mit.edu/redirect/url?link=http%3A%2F%2Fscratch.mit.edu%2Ffriday.html">APRIL</a>',$content);
	 */
    }

    /**
     * Callback function for linkify's preg_replace
     **/
    function linkify_cb($matches) {
        $url = $text = $matches[0];
        $url_texts = array(
            TOPLEVEL_URL.'/projects' => ___('link to project', true),
            TOPLEVEL_URL.'/galleries' => ___('link to gallery', true),
            TOPLEVEL_URL.'/forums' => ___('link to forums', true),
			WIKI_URL =>__('link to wiki', true)
        );
        foreach($url_texts as $u => $t) {
            if(strpos($url, $u) !== false) {
                $text = '('.$t.')';
                break;
            }
        }
        if(strpos($url, "http://") !== 0) { $url = "http://" . $url; }

        return "<a href=\"{$url}\">{$text}</a>";
    }
	
	/*
	Check if gallery description contains a whitelist url 
	*/
	 function check_url($url){
		if (preg_match('/(https?:\/\/)?(www.)?([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
   		$pattern = '/\b(https?:\/\/)?(www.)?[A-Z0-9.]*('
                    . WHITELISTED_URL_PATTERN
                    . ')[-A-Z0-9+&@#()\/%?=~_|!:,.;]*/i';
			if (preg_match ($pattern, $url)) 
			{
				return true;
			}else{
			return false;
			}
		} else {
	   return true;
		}
	}//function
}
?>
