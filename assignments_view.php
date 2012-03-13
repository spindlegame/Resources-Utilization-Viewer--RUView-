<?php
// This script and data application were generated by AppGini 4.70
// Download AppGini for free from http://bigprof.com/appgini/download/

	$d=dirname(__FILE__);
	include("$d/defaultLang.php");
	include("$d/language.php");
	include("$d/lib.php");
	@include("$d/hooks/assignments.php");
	include("$d/assignments_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('assignments');
	if(!$perm[0]){
		echo StyleSheet();
		echo "<div class=\"error\">".$Translation['tableAccessDenied']."</div>";
		echo '<script language="javaScript">setInterval("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "assignments";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV=array(
		"`assignments`.`Id`" => "Id",
		"`projects1`.`Name` /* Project */" => "ProjectId",
		"if(char_length(`projects1`.`StartDate`) || char_length(`projects1`.`EndDate`), concat_ws('', if(`projects1`.`StartDate`,date_format(`projects1`.`StartDate`,'%d/%m/%Y'),''), ' <b>to</b> ', if(`projects1`.`EndDate`,date_format(`projects1`.`EndDate`,'%d/%m/%Y'),'')), '') /* Project Duration */" => "ProjectDuration",
		"`resources1`.`Name` /* Resource */" => "ResourceId",
		"`assignments`.`Commitment`" => "Commitment",
		"if(`assignments`.`StartDate`,date_format(`assignments`.`StartDate`,'%d/%m/%Y'),'')" => "StartDate",
		"if(`assignments`.`EndDate`,date_format(`assignments`.`EndDate`,'%d/%m/%Y'),'')" => "EndDate"
	);
	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV=array(
		"`assignments`.`Id`" => "Id",
		"`projects1`.`Name` /* Project */" => "ProjectId",
		"if(char_length(`projects1`.`StartDate`) || char_length(`projects1`.`EndDate`), concat_ws('', if(`projects1`.`StartDate`,date_format(`projects1`.`StartDate`,'%d/%m/%Y'),''), ' <b>to</b> ', if(`projects1`.`EndDate`,date_format(`projects1`.`EndDate`,'%d/%m/%Y'),'')), '') /* Project Duration */" => "ProjectDuration",
		"`resources1`.`Name` /* Resource */" => "ResourceId",
		"`assignments`.`Commitment`" => "Commitment",
		"if(`assignments`.`StartDate`,date_format(`assignments`.`StartDate`,'%d/%m/%Y'),'')" => "StartDate",
		"if(`assignments`.`EndDate`,date_format(`assignments`.`EndDate`,'%d/%m/%Y'),'')" => "EndDate"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters=array(
		"`assignments`.`Id`" => "ID",
		"`projects1`.`Name` /* Project */" => "Project",
		"if(char_length(`projects1`.`StartDate`) || char_length(`projects1`.`EndDate`), concat_ws('', if(`projects1`.`StartDate`,date_format(`projects1`.`StartDate`,'%d/%m/%Y'),''), ' <b>to</b> ', if(`projects1`.`EndDate`,date_format(`projects1`.`EndDate`,'%d/%m/%Y'),'')), '') /* Project Duration */" => "Project Duration",
		"`resources1`.`Name` /* Resource */" => "Resource",
		"`assignments`.`Commitment`" => "Commitment",
		"`assignments`.`StartDate`" => "Start Date",
		"`assignments`.`EndDate`" => "End Date"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS=array(
		"`assignments`.`Id`" => "Id",
		"`projects1`.`Name` /* Project */" => "ProjectId",
		"if(char_length(`projects1`.`StartDate`) || char_length(`projects1`.`EndDate`), concat_ws('', if(`projects1`.`StartDate`,date_format(`projects1`.`StartDate`,'%d/%m/%Y'),''), ' <b>to</b> ', if(`projects1`.`EndDate`,date_format(`projects1`.`EndDate`,'%d/%m/%Y'),'')), '') /* Project Duration */" => "ProjectDuration",
		"`resources1`.`Name` /* Resource */" => "ResourceId",
		"`assignments`.`Commitment`" => "Commitment",
		"if(`assignments`.`StartDate`,date_format(`assignments`.`StartDate`,'%d/%m/%Y'),'')" => "StartDate",
		"if(`assignments`.`EndDate`,date_format(`assignments`.`EndDate`,'%d/%m/%Y'),'')" => "EndDate"
	);

	$x->QueryFrom="`assignments` LEFT JOIN `projects` as projects1 ON `assignments`.`ProjectId`=projects1.`Id` LEFT JOIN `resources` as resources1 ON `assignments`.`ResourceId`=resources1.`Id` ";
	$x->QueryWhere='';
	$x->QueryOrder='';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowPrintingMultiSelection = 0;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 3;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "assignments_view.php";
	$x->RedirectAfterInsert = "assignments_view.php?SelectedID=#ID#";
	$x->TableTitle = "Assignments";
	$x->PrimaryKey = "`assignments`.`Id`";

	$x->ColWidth   = array(150, 150, 150, 150, 150);
	$x->ColCaption = array("Project", "Resource", "Commitment", "Start Date", "End Date");
	$x->ColNumber  = array(2, 4, 5, 6, 7);

	$x->Template = 'templates/assignments_templateTV.html';
	$x->SelectedTemplate = 'templates/assignments_templateTVS.html';
	$x->ShowTableHeader = 1;
	$x->ShowRecordSlots = 0;
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	if($perm[2]==1){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `assignments`.`Id`=membership_userrecords.pkValue and membership_userrecords.tableName='assignments' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `assignments`.`Id`=membership_userrecords.pkValue and membership_userrecords.tableName='assignments' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`assignments`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}

	// handle date sorting correctly
	if($_POST['SortField']=='6' || $_POST['SortField']=='`assignments`.`StartDate`' || $_POST['SortField']=='assignments.StartDate'){
		$_POST['SortField']='`assignments`.`StartDate`';
		$SortFieldNumeric=6;
	}
	if($_GET['SortField']=='6' || $_GET['SortField']=='`assignments`.`StartDate`' || $_GET['SortField']=='assignments.StartDate'){
		$_GET['SortField']='`assignments`.`StartDate`';
		$SortFieldNumeric=6;
	}
	if($_POST['SortField']=='7' || $_POST['SortField']=='`assignments`.`EndDate`' || $_POST['SortField']=='assignments.EndDate'){
		$_POST['SortField']='`assignments`.`EndDate`';
		$SortFieldNumeric=7;
	}
	if($_GET['SortField']=='7' || $_GET['SortField']=='`assignments`.`EndDate`' || $_GET['SortField']=='assignments.EndDate'){
		$_GET['SortField']='`assignments`.`EndDate`';
		$SortFieldNumeric=7;
	}
	// end of date sorting handler

	// hook: assignments_init
	$render=TRUE;
	if(function_exists('assignments_init')){
		$args=array();
		$render=assignments_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: assignments_header
	$headerCode='';
	if(function_exists('assignments_header')){
		$args=array();
		$headerCode=assignments_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include("$d/header.php"); 
	}else{
		ob_start(); include("$d/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: assignments_footer
	$footerCode='';
	if(function_exists('assignments_footer')){
		$args=array();
		$footerCode=assignments_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include("$d/footer.php"); 
	}else{
		ob_start(); include("$d/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>