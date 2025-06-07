<?php
	e($this->element('admin/admin_index', Array()));
?>
<div class="fullcontent">
<h5> Connected IP Info</h5>
<br/>
<div id="admin_banlist_results">
	<?php
		echo $this->element('admin/user_connected_ip_list');
	?>
</div>	
</div>