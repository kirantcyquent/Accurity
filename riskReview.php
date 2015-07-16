<?php
	if(isset($_SESSION['results']['matchResult'])){
		$results=unserialize(urldecode($_SESSION['results']['matchResult']));			
		
	}
	else{
	?>
	<script>
	/*	var currentPage="index";
			$.ajax({
				type: "GET",
				url: "home.php?page="+currentPage+"&set_page=index",
				success: function(data){	
				$("#pageContent").html(data);
				$('.nav-stacked li').removeClass('active')
				$(".nav-stacked li:first").addClass("active");
				}
				});*/
				window.location ='index.php';
	</script>
	<?php
	}
?>
<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 15px 30px; color:#000;">
		<span style="font-size:12px; font-weight:bold; padding-bottom:10px; ">Automated Tools Used</span><br/><br/>
		<select name="" style="width:200px; ">
		<option value="Yes">Accurity Comp Tracker</option>		
		</select>
		</div>
		</div>
		<div style="border-top:1px solid #e2e2e2; margin:0px 80px 0px 15px;"></div>
		<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 0px 30px;">
		<span style="font-size:14px; font-weight:bold; color:#6a6a6a;">Comparable Sales</span>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-10" style="padding:10px 0px 0px 30px;">
		<form action="" method="post" id="riskForm">
			<table class="table borderless">
		    <thead>
				<th>Address</th>
				<th>Utilized</th>
				<th>Reason </th>
				<th>Notes (Required)</th>
			</thead>

			<tbody>
			<?php
				foreach($results as $row){
					echo '<tr><td>'.$row['address'].'</td>';
					echo '<input type="hidden" class="addRisk" name="addRisk[]" value="'.$row['address'].'"/>';
					echo '<td><select class="utilRisk" name="utilRisk[]"><option value="Yes">Yes</option><option value="No">No</option></select></td>';
					echo '<td><select class="reasonRisk" name="reasonRisk[]"><option value="1">Poor Condition of Subject/Good Condition of Comp</option><option value="2">None</option></select></td>';
					echo '<td><select  class="noteRisk" name="noteRisk[]"><option value="1">I didn\'t use this property because</option><option value="2">None</option></select></td>';
					echo '</tr>';
				}
			?>
			</tbody>
		</table>
		
		</div>
		</div>
		<div class="row">
		<div class="col-sm-8">
		<ul style="list-style-type:none; padding:10px 0px 0px 30px; color:#000; line-height:25px;">
		<li><b>Number of Automated Sales Matched in Appraisal Report</b></li>
		<li>If answer is 0, 1 or 2 could EMV be perceived to be inflated?</li>
		<li>Overall, the best available comps have been utilized in the report?</li>
		<li>Are search parameters used for both Appraisal and Model reasonable?</li>
		</ul>
		</div>
		<div class="col-sm-4">
		<ul style="list-style-type:none; padding:10px 0px 0px 30px; color:#000; line-height:30px;">
		<li><b>4</b></li>
		<li>
		<select name="">
		<option value="Yes">Yes</option>		
		</select>
		</li>
		<li>
		<select name="">
		<option value="Yes">Yes</option>		
		</select>
		</li>
		<li>
		<select name="">
		<option value="Yes">Yes</option>		
		</select>
		</li>
		</ul>
		</div>
		</div>
		<div class="row" style="padding:0px 0px 30px 30px;">
		<button type="button" class="btn btn-success" >Go Back</button>
		<button type="button" class="btn btn-success" id="riskBtn">Continue to Data Quality Review</button>

		</form>
		</div>

		<script type="text/javascript">
			$('#riskBtn').click(function() { 
				
				var currentPage="results";
				var matchResult = $("#matchResult").val();
				var addRisk = document.getElementsByName('addRisk[]');				
				
				var addRisk=$('.addRisk').map(function(){
					return encodeURIComponent($(this).val())
				}).get();
				
				var utilRisk=$('.utilRisk').map(function(){
					return encodeURIComponent($(this).val())
				}).get();

				var reasonRisk=$('.reasonRisk').map(function(){
					return encodeURIComponent($(this).val())
				}).get();

				var noteRisk=$('.noteRisk').map(function(){
					return encodeURIComponent($(this).val())
				}).get();
				
				
				dataString = "&addRisk="+addRisk+"&utilRisk="+utilRisk+"&reasonRisk="+reasonRisk+"&noteRisk="+noteRisk;
				$.ajax({
				type: "POST",
				data: dataString,
				url: "home.php?page=report&set_page=riskReview",
				success: function(data){	
				$("#pageContent").html(data);
				$('.nav-stacked li').removeClass('active')
				$(".nav-stacked li:nth-child(5)").addClass("active");
				}
				});
			});		
		</script>