<?php
include_once('../includes/connect.php');
include_once('../includes/functions.php');
session_start();
//print_r($_POST);
$ques="";
$answer="";
$output='';
if($_POST)
{
	$from_email ="javabykiran@gmail.com";
	$count=isset($_POST['count'])?$_POST['count']:'';
	$topic=isset($_POST['topic_id'])?$_POST['topic_id']:'';
	$demand_test=isset($_POST['demand_test'])?$_POST['demand_test']:'';
	$name=isset($_POST['name'])?$_POST['name']:'';
	$email=isset($_POST['email'])?$_POST['email']:'';
	
	if($_POST['type']=='start'){
		if($demand_test==1){
			$where_test="WHERE test_id=$topic";
			$get_topics_for_test=$sql->query("SELECT * FROM on_demand_test $where_test");
			$topics_for_test=$get_topics_for_test->fetch_array();			
			$test_topics_array=explode(",",$topics_for_test['topics']);
			$topics_str="";
			$i=0;
			$num_topics=count($test_topics_array);
			foreach($test_topics_array as $tt){
			if($i==0){
					$topics_str="(";
			}else{
				$topics_str.=" OR ";
			}	
				
			$topics_str.="topic_id=".$tt;
			$i++;
			if($i==$num_topics){
				$topics_str.=")";
			}
				
			}
			$where="WHERE $topics_str and status=1 and is_reviewed=1 ORDER by RAND() LIMIT $count";	
		}else{
			$where="WHERE topic_id=$topic and status=1 and is_reviewed=1 ORDER by RAND() LIMIT $count";	
		}
		//echo "SELECT * FROM questions $where";
		$res=$sql->query("SELECT * FROM questions $where");
		$total=$res->num_rows;
		$i=1;
		$v=0;
		if($demand_test==1){
			$quiz_topic=$topics_for_test['test_name'];
		}else{
			$where="WHERE id=$topic";
			$top=$sql->query("SELECT * FROM topics $where");
			$topic=$top->fetch_array();
			$quiz_topic=$topic['topic'];
		}
		$ques.='<h3 class="modal-title text-danger text-center p-0  mb-3" id="quizheading">'.$quiz_topic .' Quiz</h3>';
		if($total>0){
			unset($_SESSION['rquestions']);
			while($questions=$res->fetch_assoc()){ 
			    $_SESSION['rquestions'][$v]=$questions;
				$strip_question=str_replace("div", 'p', $questions['question']);
				$strip_question=str_replace("h2", 'p', $strip_question);
				//$strip_question=str_replace("span", 'p', $strip_question);				
				$strip_question = str_replace("</p>", "</p><br />", $strip_question);
				$strip_question = strip_tags($strip_question, '<br><pre><code><span>'); // REMOVE ALL TAGS EXCEPT A FEW
				$replaced_question=preg_replace('/^(<br\s*\/?>)*|(<br\s*\/?>)*$/i', '', $strip_question);
				//$quizquestion = str_replace("-n", "- <br />", stripslashes($replaced_question)); 
				$quizquestion = str_replace('\n', '', $replaced_question); 
				$ques.='<div class="quizquestion" id="q-'.$questions['question_number'].'"><div>'.$i.') '.stripslashes($quizquestion).'</div><ul class="choices" id="choices">';
				$where="WHERE question_number=".$questions['question_number'];				
				$choices=$sql->query("SELECT * FROM choices $where");
				$total=$choices->num_rows;
				$t=0;
				if($questions['answer_type']==2){
					$type='type="checkbox"';
				}
				else{
					$type='type="radio"';
				}
				while($ch = $choices->fetch_assoc()){
					$_SESSION['rquestions'][$v]['rchoices'][$t] = $ch;
					if($ch['text']!=''){
						$ques.='<li><input name="choice['.$questions['question_number'].'][]" class="form-check-input" '.$type.' value="'.$ch['id'].'"/>'.stripslashes($ch['text']).'</li>';
						$t++;
					}
				}
				$ques.='</ul></div>';
				$v++;
				$i++;
				//print_r($_SESSION['rquestions']);
			}
			$output = json_encode(array('type'=>'success', 'result' => $ques));
	   }else{
		  $output = json_encode(array('type'=>'error', 'msg' => "<h3 class='text-danger text-center'>Sorry!!! No Questions Found </h3><p class='text-danger text-center'>Please try another topic</p>")); 
	   }
	}elseif($_POST['type']=='finish'){
		// print_r($_SESSION['rquestions']);
		$score=0;
		$i=1; $youranswer='';
		$count=count($_SESSION['rquestions']);
		$result=array();
			if(count($_SESSION['rquestions'])>0){
				//print_r($_SESSION['rquestions']);
				foreach($_SESSION['rquestions'] as $quest){ 
					$strip_question=str_replace("div", 'p', $quest['question']);
					$strip_question=str_replace("h2", 'p', $strip_question);
					//$strip_question=str_replace("span", 'p', $strip_question);				
					$strip_question = str_replace("</p>", "</p><br />", $strip_question);
					$strip_question = strip_tags($strip_question, '<br><pre><code><b><i><u><span>'); // REMOVE ALL TAGS EXCEPT A FEW
					$replaced_question=preg_replace('/^(<br\s*\/?>)*|(<br\s*\/?>)*$/i', '', $strip_question);
					//$ansquizquestion = str_replace("-n", "- <br />", stripslashes($replaced_question));
					$ansquizquestion = str_replace('\n', '', $replaced_question); 
                   // print_R($quest);			    
					$answer.='<div class="question mb-4"><div class="font-weight-bold text-dark">'.$i.') '.stripslashes($ansquizquestion).'</div><ol class="choices" id="choices">';
					$qid=$quest['question_number'];
					$j=1;
					$correctanswer = array();
					$youranswer = array();
					//print_r($_POST['choice'][$qid]);
					foreach($quest['rchoices'] as $choice){
						//print_r($_POST['choice'][$qid]);
						$class='';
						if($choice['text']!=''){
							$answer.='<li>'.stripslashes($choice['text']).'</li>';
						}
						if(isset($_POST['choice'][$qid])&&(in_array($choice['id'],$_POST['choice'][$qid]))){
							$youranswer[]=$j;
						}
						
						if($choice['is_correct']==1){
							$correctanswer[]=$j;							
						}
						$j++;
					}
					$coans =serialize($correctanswer);
					$yrans =serialize($youranswer);
					if ($coans == $yrans){
						$class="text-success";
					}else{
						$class="text-danger";
					}
					$qno=$quest['question_number'];
					$result['questions'][$qno]=implode(",",$youranswer);
					$answer.='</ol><p class="'.$class.'">Your Answer: '.implode(",",$youranswer).'</p> <p class="text-success">Correct Answer: '.implode(",",$correctanswer).'</p> ';
					if($quest['explanation']!=''){
					$answer.='<p class="text-secondary"><span class="font-weight-bold">Explanation: </span> <br/>'.$quest['explanation'].'</p>';
					}
					$answer.='</div>';
					$i++;
				}
			}
		if(isset($_POST['choice'])){
			$choices=$_POST['choice'];
			foreach($choices as $ch => $ans_array){
				$answercount=count($ans_array);
				//print_r($ans_array);
				$where="WHERE question_number=".$ch." AND is_correct = 1";
				$correctchoice=$sql->query("SELECT id FROM choices $where");
				$cho_array=array();
				while($cc=$correctchoice->fetch_assoc()){
					$cho_array[]=$cc['id'];
				}
				//print_r($cho_array);
				$cho =serialize($cho_array);
				$ans =serialize($ans_array);
				if ($cho == $ans){
					++$score;
				}
			}
			if($score==$count){
				$msg="<h3 class='text-success text-center'>Congrats!!! Excellent!!!</h3><p> You have successfully answered all the questions</p>";
			}elseif($score>0){
				$msg="<h3 class='text-warning text-center'>Average!!!</h3><p>You have few more questions to clear</p>";
			}else{
				$msg="<h3 class='text-danger text-center'>Sorry!!!</h3><p>You have Failed. Please try again. you need grooming on this topic. Please <a href='https://javabykiran.com'>join us</a> for detailed training on this. </p>";
			}
			//unset($_SESSION['rquestions']);
			$result['marks']=$score;
			$result['total']=$count;
			
			if($demand_test==1){
				$where_test="WHERE test_id=$topic";
				$get_topics_for_test=$sql->query("SELECT * FROM on_demand_test $where_test");
				$topics_for_test=$get_topics_for_test->fetch_array();
				$result['test_id']=$topic;
				$test_topic=$topics_for_test['test_name'];
			}else {
				$result['topic_id']=$topic;
				$gtop=$sql->query("SELECT * FROM topics WHERE id=".$result['topic_id']);
				$gettopic=$gtop->fetch_array();
				
				$gsub=$sql->query("SELECT * FROM subject WHERE id=".$gettopic['subject_id']);
				$getsubject=$gsub->fetch_array();
				$test_topic=$gettopic['topic'].' - '.$getsubject['subject_name'];
			}
			$percentage=($score/$count)*100;
			$certificate = create_certificate($name,$test_topic,$percentage,'Good Job');
			$output = json_encode(array('type'=>'success', 'score' => $score, 'msg' => $msg, 'total' => $count, 'answer'=> $answer ,'certificate' => $certificate));
		}else {
			$result['marks']=$score;
			$result['total']=$count;
			if($demand_test==1){
				$result['test_id']=$topic;
			}
			else{
				$result['topic_id']=$topic;
			}
			$msg="<h3 class='text-danger text-center'>Sorry!!!</h3><p>You have Failed. Please try again. you need grooming on this topic. Please <a href='https://javabykiran.com'>join us</a> for detailed training on this. </p>";
			$output = json_encode(array('type'=>'error', 'score' => $score, 'msg' => $msg, 'total' => $count, 'answer'=> $answer));
	    }
		
		$res=$sql->query("INSERT INTO `quiz_results` (`name`,`email`, `result`, `is_demand_test`) VALUES ('".$name."','".$email."','".json_encode($result)."',".$demand_test.")");
		$result_id=$sql->insert_id;

		if($demand_test==1){
			$result['test_id']=$topic;
			$test_topic=$topics_for_test['test_name'];
		}else {
			$result['topic_id']=$topic;
			$gtop=$sql->query("SELECT * FROM topics WHERE id=".$result['topic_id']);
			$gettopic=$gtop->fetch_array();
				
			$gsub=$sql->query("SELECT * FROM subject WHERE id=".$gettopic['subject_id']);
			$getsubject=$gsub->fetch_array();
			$test_topic=$gettopic['topic'].' - '.$getsubject['subject_name'];
		}
		
		
		$msg = "<h3 style='text-align:center; color: #252733 !important;font-size: 26px;font-weight: 600;border-bottom: 1px dashed #ccc;padding: 0.5rem !important;'>Result</h3><div style='text-align:center'>".$msg."<p>Marks obtained by you <span>".$score."</span> out of <span>".$count."</span> </p></div>
		<div style='text-align:center'> ".$name.", Please check your answer.</div><br/><div class='text-center font-weight-bold'>".$test_topic."</div><br/><img src='https://www.jbktest.com/images/certificate/'".$certificate."><br/><div style='color: #007bff;  background-color: transparent; background-image: none; border-color: #007bff; padding: .375rem .75rem; font-size: 0.75rem; text-align:center'><a href='https://www.jbktest.com/online-exam?id=".$result_id."&view=answer'>View Answer</a></div>";
		$sub = "Quiz Results - JBKTEST";
		$head = "MIME-Version: 1.0" . "\r\n";
		$head .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$head .= 'From: '.$from_email.'' . "\r\n";
		$head .= 'Reply-To: '.$from_email.'' . "\r\n";
		$head .= 'X-Mailer: PHP/' . phpversion();
		//$send_mail = mail($email, $sub, $msg, $head);
		unset($_SESSION['rquestions']);
	}elseif($_POST['type']=='recheck'){
		$quizres=array();
		$where="WHERE id=".$_POST['id'];			
		$res=$sql->query("SELECT * FROM quiz_results $where");
		$quizresult=$res->fetch_array();
		$quizres=objectToArray(json_decode($quizresult['result']));
		//print_r($quizres);
		$i=1; 
		$ans='';$youranswer='';
		if(isset($quizres['questions'])&&(count($quizres['questions'])>0)){
			foreach($quizres['questions'] as $que => $value){
                $where="WHERE question_number=$que";	
				//echo "SELECT * FROM questions $where";
				$res=$sql->query("SELECT * FROM questions $where");
				$quer=$res->fetch_array();
				//print_r($quer);
				$ans.='<div class="question mb-4"><div class="font-weight-bold text-dark">'.$i.') '.$quer['question'].'</div><ol class="choices" id="choices">';
				
				$where="WHERE question_number=".$quer['question_number'];				
				$choices=$sql->query("SELECT * FROM choices $where");
				$total=$choices->num_rows;
				if($total>0){
					
					$j=1;
					while($ch = $choices->fetch_assoc()){
						$class='';
						if($ch['text']!=''){
							$ans.='<li>'.$ch['text'].'</li>';
						}
						
						if(isset($value)&&($j==$value)){
							$youranswer=$value;	
							$class="text-success";
						}else{
							$class="text-danger";
						}
						if($ch['is_correct']==1){
							$correctanswer=$j;							
						}
						$j++;
					}
				}
				$ans.='</ol><p class="'.$class.'">Your Answer: '.$youranswer.'</p> <p class="text-success">Correct Answer: '.$correctanswer.'</p>';
				if($quest['explanation']!=''){
				$ans.='<p class="text-secondary"><span class="font-weight-bold">Explanation: </span> <br/>'.$quest['explanation'].'</p>';
				}
                $ans.='</div>';
				
			}
			$output = json_encode(array('type'=>'success', 'answer'=> $ans));
		}else{
			$output = json_encode(array('type'=>'error', 'msg' => "<p class='text-danger text-center'>Sorry!!! No Records Found</p>"));
		}
	}else {
		$output = json_encode(array('type'=>'error', 'result' => 'Sorry!!! No Records Found'));
	}
	die($output);	
}
?>