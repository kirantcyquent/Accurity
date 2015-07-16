<div class="col-sm-2" style=" padding:10px 0px 30px 0px; ">
		<ul class="nav nav-pills nav-stacked" style="line-height:5px; list-style-type:circle; font-weight:bold; width:153px;">
        <li class="active"><a href="#" id="index">Homepage</a></li>
        <?php if($user_type!=2){  ?>
		<li><a href="#" id="refineSearch">Refine Search</a></li>
		<?php } ?>
        <li><a href="#" id="results">Results</a></li>
     <!--   <li ><a href="#" id="riskReview">Risk Review</a></li>-->
		<!--<li ><a href="#" id="dataQuality">Data Quality</a></li>
		<li ><a href="#" id="adjustments">Adjustments</a></li>-->
		<li  ><a href="#" id="report">Report</a></li>
		<!--<li ><a href="#" id="litigationDefense">Litigation Defense</a></li>-->
		<li ><a href="#" id="appraiselReview">Review</a></li>
		</ul>
</div>
<script type="text/javascript">
$(".nav-stacked li a").click(function() {
    $(this).parent().addClass('active').siblings().removeClass('active');
    });
</script>
