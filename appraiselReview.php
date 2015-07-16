<?php
session_start();
if(!isset($_SESSION['results'])){
echo '<script>window.location ="index.php";</script>';
}
?>
			<div class="row">
		<div class="col-sm-12" style="padding:20px 0px 0px 30px;">
		<span style="font-size:16px; font-weight:bold; color:#6a6a6a;">Appraisal Review</span>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-4" style="padding:20px 0px 0px 30px;">
		<span style="font-size:14px; font-weight:bold; color:#000;">
		Adjusments / Market Conditions
		</span>
		</div>
		<div class="col-sm-5" style="padding:20px 0px 0px 30px;">
		<span style="font-size:14px; font-weight:bold; color:#000;">
		Appraisel Comments / Recommendations
		</span>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-2" style="padding:10px 0px 0px 0px;">
		<ul class="acc_list" style="list-style-type:none; padding:0px 0px 0px 30px;">
		<li>Best Comps Utilized</li>
		<li>Reconcilation</li>
		<li>Data Integrity</li>
		<li>Adjustments</li>
		<li>Overall Risk Score</li>
		
		</ul>
		</div>
		<div class="col-sm-2" style="padding:10px 0px 0px 0px;">
		<ul class="acc_list" style="list-style-type:none; padding:0px 0px 0px 30px;">
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
		<div class="col-sm-3" style="padding:10px 0px 0px 30px; color:#000">
		<div class="form-group">
		<textarea class="form-control" rows="5" style="width:300px; padding-left:5px; font-size:12px;" >This appraisel is good enough</textarea>
		</div>
		<b></b>CU/Loan Safe Risk score&nbsp;&nbsp;&nbsp;<input type="text" size="4"/>
		</div>
		</div>
		<div class="row">
		<div class="col-sm-4" style="padding:20px 0px 0px 30px;">
		<span style="font-size:14px; font-weight:bold; color:#6a6a6a;">
		Appraiser's Report Flags
		</span>
		</div>
		</div>
		<div class="row" style="padding:20px 0px 0px 0px;">
		<div class="col-sm-1" >
		<span style="font-size:12px; font-weight:bold; color:#000; padding-left:35px;">
		Flags
		</span>
		</div>
		<div class="col-sm-3">
		<span style="font-size:12px; font-weight:bold; color:#000; padding:20px 0px 0px 20px;">
		Effect on Value
		</span>
		</div>
		</div>
	    <div class="row">
		<div class="col-sm-1" style="padding:0px; line-height:18px;">
		<div style="color:#000; padding:10px 0px 0px 30px;">
		<label>&nbsp;&nbsp;Subject</label>
		<label>&nbsp;&nbsp;Comp1</label>
		<label>&nbsp;&nbsp;Comp1</label>
		<label>&nbsp;&nbsp;Comp1</label>
		<label>&nbsp;&nbsp;Comp1</label>
		<label>&nbsp;&nbsp;Comp1</label>
		</div>
		</div>
		
		<div class="col-sm-2">
		<div style="color:#000; padding:10px 0px 0px 22px;">
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Significant</label>
		</div>
		</div>
		<div class="col-sm-2">
		<div style="color:#000; padding:10px 0px 0px 22px;">
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Insignificant</label>
		</div>
		</div>
		<div class="col-sm-2">
		<div style="color:#000; padding:10px 0px 0px 22px;">
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 1</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 2</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 2</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 2</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 2</label>
		<label><input type="checkbox" class="input-checkbox">&nbsp;&nbsp;Option 2</label>
		</div>
		</div>
		</div>
		<div class="row" style="color:#000; font-size:12px; padding:20px 0px 30px 30px;">
		<div class="col-sm-6">Property eligible for accurity CU service warranty</div>
		<div class="col-sm-2">
		<select name="">
		<option value="Yes">Yes</option>		
		</select>
		</div>
		</div>
		<div class="row" style="color:#000; font-size:12px; font-weight:bold; padding:0px 0px 20px 30px;">
		<div class="col-sm-3">Appraised value  $<input type="text" size="4"/></div>		
		</div>
		<div class="row" style="color:#000; font-size:12px; padding:0px 0px 20px 30px;">
		<div class="col-sm-6" style="font-weight:bold;">Reviewers Comments / Recommendations</div>	<br/>
		<textarea cols="80" rows="8" style="margin:10px 0px 0px 0px;">This Appraisel is good enough</textarea>
		</div>
		<div class="row" style="padding:0px 0px 30px 30px;">
		<button type="button" class="btn btn-success" >Go Back</button>
		<button type="button" class="btn btn-success" >Continue to Report</button>
		</div>
