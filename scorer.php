<?php
include_once('includes/connect.php');

$res=$sql->query("SELECT *, COUNT(email), concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM quiz_results where taken_at >= CURRENT_DATE - INTERVAL 7 DAY  GROUP BY email HAVING COUNT(email) > 1 order by CAST(percentage AS unsigned) desc, RAND() LIMIT 10");
$score[]=array();
				$total_subject=$res->num_rows;
				if($total_subject>0){ $i=0;
					while ($data=$res->fetch_assoc()) { 
						$percent=str_replace('%','',$data['percentage']);
						$result=objectToArray(json_decode($data['result']));
						$sub=$sql->query("SELECT subject_name from subject su JOIN topics t ON t.subject_id=su.id where t.id=".$result['topic_id']);
						$subject=$sub->fetch_array();
						$score[$i]['percent']=$data['percentage'];
						$score[$i]['subject']=$subject['subject_name'];
						$score[$i]['name']=substr($data['name'],0,14);
						$i++;
					}
				}

top_scorer($score);
function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
		
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
function top_scorer($score){
	
		  $name_len=strlen($name);
		  $subject = strtoupper($subject);
          if ($subject) {
          $font_size_subject = 10;
          }
		  //designed certificate picture

          $createimage = imagecreatefrompng();
          $filename = "topscore".time().".png";
          //this is going to be created once the generate button is clicked
          $output = "../images/topscore/".$filename;

          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          $white = imagecolorallocate($createimage, 205, 245, 255);
          $black = imagecolorallocate($createimage, 0, 0, 0);
		  $red = imagecolorallocate($createimage, 255, 0, 0);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name
          $origin_x = 170;
          $origin_y=200;

          //we then set the x and y axis to fix the position of our text subject
          $origin1_x = 170;
          $origin1_y= 310;
		  
		  //we then set the x and y axis to fix the position of our text subject
          $origin2_x = 250;
          $origin2_y= 370;
		  
		  $origin3_x = 490;
          $origin3_y= 265;
		  
          //we then set the differnet size range based on the lenght of the text which we have declared when we called values from the form
		  if($name_len<=7){
            $font_size = 25;
            $origin_x = 190;
          }
          elseif($name_len<=12){
            $font_size = 30;
          }
          elseif($name_len<=15){
            $font_size = 26;
          }
          elseif($name_len<=20){
             $font_size = 18;
          }
          elseif($name_len<=22){
            $font_size = 15;
          }
          elseif($name_len<=33){
            $font_size=11;
          }
          else {
            $font_size =10;
          }

          //font directory for name
          $drFont = $_SERVER['DOCUMENT_ROOT']."/jbktest/fonts/developer.ttf";

          // font directory for subject name
          $drFont1 = $_SERVER['DOCUMENT_ROOT']."/jbktest/fonts/Gotham-Black.ttf";

          //function to display name on certificate picture
         // $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $black,$drFont, $name);

          //function to display subject name on certificate picture
          $text2 = imagettftext($createimage, $font_size_subject, $rotation, $origin1_x+2, $origin1_y, $black, $drFont1, "<table><tr><td>test</td><td>sfdsdfs sdfsdf</td></tr></table");

          imagepng($createimage,$output,3);
		  return $filename;
}
?>