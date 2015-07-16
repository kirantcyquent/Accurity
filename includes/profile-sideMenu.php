<div class="col-sm-12" style=" padding:10px 0px 30px 0px; ">
		<ul class="nav nav-pills nav-stacked" style=" ">
        <li class="active"><a href="profile.php">Personal Information</a></li>		
<?php

if($user_type!=3){ ?>		
		<li ><a href="completed.php">Completed Searches</a></li>
		<li ><a href="incomplete.php">Incomplete Searches</a></li>
		<?php } ?>
		</ul>
</div>

