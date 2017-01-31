<div id="footer">
	<?php
		if($rank>=1 && $admin == 0){ 
	?>
			<ul>
				<li><a href="admin.php">Admin Panel</a></li>
			</ul>
	<?php	}
		if($rank>=1 && $admin == 1){ 
	?>
			<ul>
				<li><a href="admin.php">User Panel</a></li>
			</ul>
	<?php	}
	?>
</div>
