<?php if($style == 2008):?>
<h1><?php ___('Sorry, no such page...Scratch on!'); ?></h1>
<?php else:?>
<?PHP
$this->pageTitle = '404 - Page Not Found - Our server is Scratch\'ing its head'; 
?>
<style type="text/css">

.error404{
background:#D5DDF3 none repeat scroll 00;
color:#000000;
padding:5px 1px 4px;
margin:5px 0px 5px;
border-top:1px solid #3366CC;
}
#sd{
font-weight:bold;
} 

</style>
<div class="error404">
	<span id="sd"><?php ___('404 - Page Not Found - Our server is Scratch\'ing its head')?> </span>
</div>
	
<?php
$messages = array(
			"project_flaged" => ___('Thanks for helping us monitor the website. Someone will review this project. Scratch on!', true),
			"account_disabled" => ___('This account has been disabled by the Scratch Team.', true),
            "project_delbyusr" => ___('This project has been deleted by its author.', true),
            "project_delbyadmin" => ___('This project has been deleted by an administrator.', true),
			"project_censbyadmin" => ___('This project was considered inappropriate for the Scratch community.', true),
			"project_censbycomm" => ___('This project was considered inappropriate for the Scratch community.', true),
			"project_censbyadmin_logged_in" => ___('The Scratch Team has removed this project because it was considered inappropriate for the Scratch community.', true),
            "project_not_found" => ___('Project Not Found.', true),
            "comment_not_found" => ___('This comment does not exist.', true),
            "comment_delbyadmin" => sprintf(___('This comment has been deleted by an administrator. Please read the <a href="%s">Community Guidelines</a>.', true), TOS_URL),
            "comment_censbycomm" => sprintf(___('This comment has been deleted because the Scratch community considered it to be inappropriate. Please read the <a href="%s">Community Guidelines</a>.', true), TOS_URL),
            "comment_censbyadmin" => sprintf(___('This comment has been deleted by a Scratch administrator because it was considered inappropriate. Please read the <a href="%s">Community Guidelines</a>.', true), TOS_URL),
            "comment_delbyparentcomment" => ___('This comment is not available because its parent comment was deleted.', true),
            "comment_suspended" => ___('This comment is not available because the poster\'s account has been suspended.', true),
            "comment_delbyusr_project" => ___('This comment has been deleted by the author of this project.', true),
            "comment_delbyusr_gallery" => ___('This comment has been deleted by the creator of this gallery.', true),
            );

if(isset($messages[$message])) {
    $message = $messages[$message];
}
else {
    $message = ___('The page', true) . '<strong> - ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
               . ' - </strong>' . ___('cannot be found. Try again later or search for something else:', true);
}

echo $message;
?>


<style type="text/css">
#goog-wm { }
#goog-wm h3.closest-match { }
#goog-wm h3.closest-match a { }
#goog-wm h3.other-things { }
#goog-wm ul li { }
#goog-wm li.search-goog { display: block; }
</style>
<script type="text/javascript">
var GOOG_FIXURL_LANG = 'en';
var GOOG_FIXURL_SITE = 'http://scratch.mit.edu/';
</script>
<script type="text/javascript" src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>

<p align="center">
<img src="/img/404.png" alt="Page not found by DavidTy">
<br />
image by DavidTy
</p>
<br />
<br />
<?php endif ?>