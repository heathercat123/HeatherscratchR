<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<?php if(isset($isFeatured ) && isset($image_name )):?>
<?php if($isFeatured ):?>
<?php echo $html->image('large_ribbon/'.$image_name,array('class'=>'project_ribbon'));?>
<?php endif; ?>
<?php endif; ?>

<div id="header" class="clearme">
    <div id="logo">
         <h1><a href="<?php echo $html->url('/')?>"></a></h1>
      <h2><?php ___('imagine'); ?> &bull; <?php ___('program'); ?> &bull; <?php ___('share'); ?></h2>
    </div>
<!-- |||||| Begin main menu ||||||| -->
    <ul id="nav" class="clearme">
	<li><a href="#main" class="hidden"><?php ___('Skip Navigation'); ?> </a></li>


<li style="float:right; margin-right:6px;">

<script type="text/javascript" language="JavaScript"><!--
function langm(d) {
if(d.length < 1) { return; }
if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
else { document.getElementById(d).style.display = "none"; }
}
--></script>

</li>
	
	 
      <li <?php if ($active_tab == "home"):?> id="active" <?php endif;?>>
	  
	  <a href=<?php echo $html->url('/')?>><?php ___('home'); ?></a>
	  </li>
      <li <?php if ($active_tab == "projects"):?> id="active" <?php endif;?>><a href="<?php echo $html->url(array('controller'=>'channel','action'=>'featured'))?>"><?php ___('projects'); ?></a></li>
      <li <?php if ($active_tab == "galleries"):?> id="active" <?php endif;?>><a href="<?php echo $html->url('/galleries/')?>"><?php ___('galleries'); ?></a></li>
	 
      <li <?php if ($this_controller_here === "/support"):?> id="active" <?php endif;?>><a href="/redirect/support"><?php ___('support'); ?></a></li> 
	 <?php if (!$isBanned): ?>
		<li <?php if ($this_controller_here === "/forums"):?> id="active" <?php endif;?>><a href="<?php echo $html->url(array('controller'=>'forums'))?>"><?php ___('forums'); ?></a></li>
	  <?php endif; ?>
	  <li <?php if ($this_controller_here === "/about"):?> id="active" <?php endif;?>><a href="<?php echo $html->url('/redirect/about')?>"><?php ___('about'); ?></a></li>
	  <li <?php if ($this_controller_here === "/"):?> id="active" <?php endif;?>><a href="<?php echo $html->url('/')?>"><?php ___('my stuff'); ?></a></li>
      
    </ul>
<!-- ////// End main menu ////// -->


<div id="searchbar-info">
<!-- Google CSE Search Box Begins  -->
<form action="/pages/results" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="010101365770046705949:gg_q9cry0mq" />
    <input type="hidden" name="cof" value="FORID:11" />
    <input type="text" name="q" size="20" />
    <input type="hidden" name="safe" value="active" />
    <input type="submit" class="search" name="sa" value="<?php ___('search'); ?> "/>
  </div>
</form>
<!-- Google CSE Search Box Ends -->
</div>

<?php
	echo $this->element('country_welcome', compact(array('isCustomizableCountry', 'ipCountry')));
?>
<?php
				
				if ($session->check('Message.flash')):
				echo "<div id='flash_error'>";
						$session->flash();
				echo "</div>";		
				endif;
				
?>
</div>
