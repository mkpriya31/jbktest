<?php
session_start();
include_once('../includes/connect.php');
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$topic="";
switch($action){
	
	case "deletetopic":
		 $where="where id =".$id." limit 1";
		 $res=$sql->query("delete from topics $where ");
		 $output=json_encode(array('status'=>'success'));
		 break;	
    case "updatetopic":
	     $where="where id =".$id." limit 1";
		 $res=$sql->query("Update topics set topic='".$_REQUEST['topic']."',modified_at=NOW(),modified_by='".$_SESSION['id']."' $where ");
		 $output=json_encode(array('status'=>'success'));
		 break;	
    case "gettopics":
	     $where="where subject_id =".$id." ORDER by id asc";		
		 $res=$sql->query("SELECT * FROM topics $where");
		 $numrows=$res->num_rows;
		 $topic='<option value="">--Please Select Topic--</option>';
		 if($numrows>0){
			 while($topics=$res->fetch_assoc()){
				$topic.='<option value="'.$topics['id'].'">'.$topics['topic'].'</option>';
			 }
		 }
		 $output=json_encode(array('status'=>"success",'topic'=>$topic));
		 break;	
}
die($output);

?>