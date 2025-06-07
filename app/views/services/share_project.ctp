<div  id="main">
<div  class="container">
<h3><?php ___('Upload project'); ?></h3>

    <?php
				echo "<div id='error_message'>";
				if ($session->check('Message.flash')):
						$session->flash();
				endif;
				echo "</div>";
?>
<?php echo $form->create('Services', array('action' => 'share_project', 'type' => 'file')); ?>
<!--<form id="create_gallery" action="<?php echo $html->url('/services/share_project/')?>" method="post" enctype='multipart/form-data'>-->s
<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Scratch file'); ?></label>
	</div>
	<div class = "project_share_item_right">
	<?php echo $form->file('binary_file',array('name'=>'data[form][binary_file]'))?>
		
	</div>
</div>

<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Preview image'); ?></label>
	</div>
	<div class = "project_share_item_right">
	<?php echo $form->file('priview_image',array('name'=>'data[form][priview_image]'))?>
		
	</div>
</div>

<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Project name'); ?></label>
	</div>
	<div class = "project_share_item_right">
	<?php echo $form->text('Project.project_name',array('size'=>'42'))?>
		
	</div>
</div>

<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Project notes'); ?></label>
	</div>
	<div class = "project_share_item_right">
	<?php echo $form->textarea('Project.project_description',array('rows'=>15,'cols'=>30))?>
		
	</div>
</div>

<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Version date'); ?></label>
	</div>
	<div class = "project_share_item_right">
	<?php $version_array = array('2008-09-21'=>'2008-09-21','2008-09-11'=>'2008-09-11','2008-09-02'=>'2008-09-02')?>
	<?php echo $form->select('Project.version_date',$version_array,null,array(),false)?>
		
	</div>
</div>
<div class = "project_share_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('Tags'); ?></label>
	</div>
	<div class = "project_share_item_right">
	
	<div class="input select"><label for="ProjectTags"></label><input type="hidden" name="data[Project][tags]" value="" />
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Animation" id="ProjectTagsAnimation" /><label for="ProjectTagsAnimation">Animation</label></div>
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Art" id="ProjectTagsArt" /><label for="ProjectTagsArt">Art</label></div>
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Game" id="ProjectTagsGame" /><label for="ProjectTagsGame">Game</label></div>
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Music" id="ProjectTagsMusic" /><label for="ProjectTagsMusic">Music</label></div>
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Simulation" id="ProjectTagsSimulation" /><label for="ProjectTagsSimulation">Simulation</label></div>
<div class="checkbox"><input type="checkbox" name="data[Project][tags][]" value="Story" id="ProjectTagsStory" /><label for="ProjectTagsStory">Story</label></div>
</div>
	</div>
</div>

<div class = "gallery_create_form">
	<div class = "project_share_item_left">
		<label for="create_gallery_name"><?php ___('More Tags'); ?></label>
	</div>
	<div class = "project_tag">
	<?php echo $form->text('Project.more_tags1')?>
		
	</div>
	<div class = "project_tag">
	<?php echo $form->text('Project.more_tags2')?>
		
	</div>
	<div class = "project_tag">
	<?php echo $form->text('Project.more_tags3')?>
		
	</div>
	<div class = "project_tag">
	<?php echo $form->text('Project.more_tags4')?>
		
	</div>
</div>

<div class = "gallery_create_submit">
	<?php 
		echo $form->submit(___('Upload', true), Array("class" => "button"));
	?>
</div>
</form>
</div><!--container-->
</div><!--main-->
