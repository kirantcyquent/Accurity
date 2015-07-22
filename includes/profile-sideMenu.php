<?php 
if($user_type==0){
	include('adminMenu.php');
} else if($user_type!=3){ ?>
<div class="col-sm-2" style="padding:10px 0px 30px 0px; ">
<ul class="nav nav-pills nav-stacked" style="width:150px; ">
        <li class="<?php if(isset($x) && $x=="profile"){ echo 'active';} ?>" style="width:150px;"><a href="profile.php">Personal Information</a></li>		
				
		<li class="<?php if(isset($x) && $x=="complete"){ echo 'active';} ?>" style="width:150px;"><a href="completed.php">Completed Searches</a></li>
		<li class="<?php if(isset($x) && $x=="incomplete"){ echo 'active';} ?>"><a href="incomplete.php" style="width:150px;">Incomplete Searches</a></li>
		
		</ul>
</div>
<?php } else if($user_type==3){
	include('lendingMenu.php');
	} ?>