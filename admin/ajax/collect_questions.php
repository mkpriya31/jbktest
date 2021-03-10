<?php
session_start();ob_start();
## Database configuration
include_once('../../includes/connect.php');

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value'];

if($_SESSION['user_role']!=3){
## Custom Field value
$searchByTitle = $_POST['searchByTitle'];
}

$whereq='';
$join='';
//echo $_SESSION['user_role'];
if($_SESSION['user_role']==3){
	if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
		$join.=" and q.status=1 and q.is_reviewed=1";
	}	
	$whereq='WHERE q.created_by='.$_SESSION['id'].$join;
}

if($_SESSION['user_role']==2){
	$join='';
	if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
		$join.=" and q.status=1 and q.is_reviewed=1 and q.created_by!=".$_SESSION['id'];
		$whereq='WHERE q.reviewed_by='.$_SESSION['id'].$join;
	}elseif(isset($_REQUEST['show'])&&($_REQUEST['show']=='needtoapprove')){
		$whereq=" WHERE (q.status=0 and q.is_reviewed=0) or (q.status=0 and q.is_reviewed=-1)";
	}else{
		$whereq='WHERE q.created_by='.$_SESSION['id'];
	}
}

if($_SESSION['user_role']==1){
	$join='';
	if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
		$join.="q.status=1 and q.is_reviewed=1";
		$whereq='WHERE '.$join;
	}
	
	if(isset($_REQUEST['show'])&&($_REQUEST['show']=='inactive')){
		$join.="(q.status=0 and q.is_reviewed=0) or (q.status=0 and q.is_reviewed=-1)";
		$whereq='WHERE '.$join;
	}
}



## Search   && $searchbytitle!= ''
$searchQuery = " ";

if(isset($searchByTitle) && $searchByTitle != '' && $_SESSION['user_role']!=3){
   $_SESSION['searchtitle']=$searchByTitle;
   $searchQuery .= " and (t.topic like '%".$searchByTitle."%' ) ";
}

if($searchValue != ''){
   $_SESSION['searchval']=$searchValue;
   if($whereq==''){
	   $connect=' WHERE';
   }else{
	   $connect=' and';
   }
	$searchQuery .= "$connect (t.topic like '%".$searchValue."%' or 
        q.question like '%".$searchValue."%' ) ";
  
}

## Total number of records without filtering
$result = $sql->query("SELECT * FROM questions q $whereq");
$totalRecords=$result->num_rows;

## Total number of record with filtering
#echo "SELECT q.*, t.topic as topic_name FROM questions q JOIN topics t on t.id=q.topic_id $whereq $searchQuery";

$result = $sql->query("SELECT q.*, t.topic as topic_name FROM questions q JOIN topics t on t.id=q.topic_id $whereq $searchQuery");
$totalRecordwithFilter=$result->num_rows;

## Fetch records
#echo "SELECT q.*, t.topic as topic_name FROM questions q JOIN topics t on t.id=q.topic_id $whereq ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$dataQuery = $sql->query("SELECT q.*, t.topic as topic_name FROM questions q JOIN topics t on t.id=q.topic_id $whereq ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);
#$dataQuery = $sql->query("SELECT q.*, t.topic as topic_name FROM questions q JOIN topics t on t.id=q.topic_id and (t.topic like '%Log 4j%' ) WHERE (t.topic like '%d%' or q.question like '%d%' ) order by topic_name asc limit 0,10");
$tData=array();
while ($data = $dataQuery->fetch_assoc()) {
 
   ## Topic Name
   $where="WHERE id=".$data['topic_id'];
   $top=$sql->query("SELECT * FROM topics $where");
   $topic=$top->fetch_array();
   $topic_name = (isset($topic['topic'])?$topic['topic']:'');
   
   ## Created By Username
   if($_SESSION['user_role']!=3){
   $where="WHERE q.created_by=".$data['created_by'];
   $res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.created_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
   $created_by=$res->fetch_array();
   
   ## Modified By Username
   $where="WHERE q.modified_by=".$data['modified_by'];
   $res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.modified_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
   $modified_by=$res->fetch_array();
   
   ## Status
   $enable="question?id=".$data['question_number']."&action=enable";
   $disable="question?id=".$data['question_number']."&action=disable";
   if($data['status']=='1') { $status = '<span class="active" ><a href="'.$disable.'" style="color:#090 !important;"><span class="glyphicon glyphicon-ok-sign"></span></a></span>'; } 
   else { $status= '<span class="deactive"><a href="'.$enable.'" style="color:#F00 !important;"><span class="glyphicon glyphicon-remove-sign"></span></a></span>'; }
   
   ## Reviewed By Username
   $where="WHERE q.reviewed_by=".$data['reviewed_by'];
   $res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.reviewed_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
   $reviewed_by=$res->fetch_array();
   }
   ## Reviewed Status
   if($data['is_reviewed']==0){ $is_reviewed= 'Waiting for Review'; }
   else if($data['is_reviewed']==1){ $is_reviewed='Approved'; } 
   else if($data['is_reviewed']==-1){ $is_reviewed= 'Not Approved'; }
    
   	
   ## Delete Action
   $deleteaction='';
   if($_SESSION['user_role']!=3){                                               
   $deleteaction='<a href="question?id='.$data['question_number'].'&action=delete" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
   }
   
   if($_SESSION['user_role']!=3){											
   $tData[] = array( 
      "topic_name"=>$topic_name,
      "question"=>substr(strip_tags($data['question']),0,70),
      "created_by"=>($created_by['name']!='')?$created_by['name']." (".$created_by['role'].")":'',
      "modified_by"=>($modified_by['name']!='')?$modified_by['name']." (".$modified_by['role'].")":'',
	  "created_at"=>date('d M Y, H:ia', strtotime($data['created_at'])),
	  "modified_at"=>date('d M Y, H:ia', strtotime($data['modified_at'])),
	  "status" => $status,
	  "reviewed_by" => ($reviewed_by['name']!='')?$reviewed_by['name']." (".$reviewed_by['role'].")":'',
	  "is_uploaded" => ($data['is_uploaded']==1)?"Yes":"No",
	  "is_reviewed" => $is_reviewed,    
	  "action" => '<a href="question?id='.$data['question_number'].'&action=edit"><i class="fa fa-edit"></i></a>' .$deleteaction     
   );
   }else{
	  $tData[] = array( 
      "topic_name"=>$topic_name,
      "question"=>substr(strip_tags(addslashes($data['question'])),0,70),
	  "is_reviewed" => $is_reviewed,
	  "action" => '<a href="question?id='.$data['question_number'].'&action=edit"><i class="fa fa-edit"></i></a>' .$deleteaction     
   ); 
   }
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $tData
);
//print_r($tData);
echo json_encode($response);
?>