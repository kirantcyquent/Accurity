<?php
$myurl = basename($_SERVER['PHP_SELF']);
?>
<div class="col-sm-2" style="height:305px; padding-left:0px;">
		<ul class="nav nav-pills nav-stacked" style="line-height:5px; list-style-type:circle; font-weight:bold; width:153px;">
        <li <?php if($myurl=='index.php') { ?> class="active" <?php } ?> ><a href="index.php">Homepage</a></li>
		<li <?php if($myurl=='refineSearch.php') { ?> class="active" <?php } ?>><a href="refineSearch.php">Refine Search</a></li>
        <li <?php if($myurl=='results.php') { ?> class="active" <?php } ?>><a href="results.php">Results</a></li>
        <li <?php if($myurl=='riskReview.php') { ?> class="active" <?php } ?>><a href="riskReview.php">Risk Review</a></li>
		<li <?php if($myurl=='dataQuality.php') { ?> class="active" <?php } ?>><a href="dataQuality.php">Data Quality</a></li>
		<li <?php if($myurl=='adjustments.php') { ?> class="active" <?php } ?>><a href="adjustments.php">Adjustments</a></li>
		<li <?php if($myurl=='report.php') { ?> class="active" <?php } ?>><a href="report.php">Report</a></li>
		<li <?php if($myurl=='litigationDefense.php') { ?> class="active" <?php } ?>><a href="litigationDefense.php">Litigation Defense</a></li>
		<li <?php if($myurl=='appraiselReview.php') { ?> class="active" <?php } ?>><a href="appraiselReview.php">Review</a></li>
		</ul>
</div>
<script type="text/javascript">
$(".nav li a").click(function() {
    $(this).parent().addClass('active').siblings().removeClass('active');

    });
</script>