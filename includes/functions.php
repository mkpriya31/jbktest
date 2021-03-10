<?php
function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return '' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}


function tease($body, $sentencesToDisplay = 2) {
    $nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
    $sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);

    if (count($sentences) <= $sentencesToDisplay)
        return $nakedBody;

    $stopAt = 0;
    foreach ($sentences as $i => $sentence) {
        $stopAt += strlen($sentence);

        if ($i >= $sentencesToDisplay - 1)
            break;
    }

    $stopAt += ($sentencesToDisplay * 2);
    return trim(substr($nakedBody, 0, $stopAt));
}

function eventstartdate($sdate){
	$jsondate=explode('-',$sdate); 
	$date=explode(' ',$jsondate[0]);
	$month=date("m", strtotime($date[1]));
	if(isset($date[3]))
		$time=date("G:i", strtotime($date[3]));
	else 
		$time=date("G:i", strtotime($date[2]));
	$startdate=date("Y").'-'.$month.'-'.$date[0];
	return $startdate;
}

function eventenddate($edate){
	$enddate=date('Y-m-d', strtotime("+2 months", strtotime($edate)));
	return $enddate;
}

function eventschema($description,$sitename,$logourl,$siteurl,$courseurl,$sdate){
	$startdate=eventstartdate($sdate);
	$enddate=eventenddate($startdate);
                         return '<div style="display:none;">
                                    <span itemprop="description">'.$description.'</span>
                                    <span itemprop="performer">'.$sitename.'</span>
                                    <span itemprop="image">'.$logourl.'</span>
                                    <div itemprop="location" itemscope itemtype="http://schema.org/Place">
                                      <span itemprop="name">'.$sitename.'</span>
                                      <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                        <span itemprop="name">'.$sitename.'</span>
                                        <span itemprop="streetAddress">4th Floor,Park Plaza,Above Birla Super Market, Near State Bank nagar,</span>
                                        <span itemprop="addressLocality">Pune</span>
                                        <span itemprop="postalCode">411052</span>
                                        <span itemprop="addressCountry">IN</span>
                                      </div>
                                    </div>
                                    
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
                                        <span itemprop="lowPrice">5000</span>
                                        <span itemprop="url">'.$siteurl.$courseurl.'</span>
                                        <span itemprop="availability">InStock</span>
                                        <span itemprop="validFrom">'.$startdate.'</span>
                                        <span itemprop="price">15000</span>
                                        <span itemprop="priceCurrency">&#8377;</span>
                                    </div>
                                    
                                    <meta itemprop="startDate" content="'.$startdate.'">
                                    <meta itemprop="endDate" content="'.$enddate.'">
                                </div>'	;
}

/*function insertAtPosition($string, $insert, $position) {
    return implode($insert, str_split($string, $position));
}*/
	function get_experience_list($exp){
		echo "<option value=\"0\" ".(($exp=="0")?"selected":"").">Fresher</option>";
		echo "<option value=\"1\" ".(($exp=="1")?"selected":"").">1 Year</option>";
		echo "<option value=\"2\" ".(($exp=="2")?"selected":"").">2 Years</option>";
		echo "<option value=\"3\" ".(($exp=="3")?"selected":"").">3 Years</option>";
		echo "<option value=\"4\" ".(($exp=="4")?"selected":"").">4 Years</option>";
		echo "<option value=\"5\" ".(($exp=="5")?"selected":"").">5 Years</option>";
	}
	
	
		  
	function get_aggregate_list($aggregate){
		echo "<option value=\"50\" ".(($aggregate=="50")?"selected":"").">Above 50%</option>";
		echo "<option value=\"60\" ".(($aggregate=="60")?"selected":"").">Above 60%</option>";
		echo "<option value=\"70\" ".(($aggregate=="70")?"selected":"").">Above 70%</option>";
		echo "<option value=\"80\" ".(($aggregate=="80")?"selected":"").">Above 80%</option>";
		echo "<option value=\"90\" ".(($aggregate=="90")?"selected":"").">Above 90%</option>";
	}
	
		  
	function get_skill_list($sql,$skill){
		$get_skills = $sql->query("SELECT * FROM skills WHERE active = 1 ORDER BY name ASC");
		if ($get_skills->num_rows>0) {
			while ($skills = $get_skills->fetch_array()) {
				echo "<option value=\"".$skills['id']."\" ".(($skill==$skills['id'])?"selected":"").">".$skills['name']."</option>";
			}
		}
	}

	function get_skill_name($sql,$skill_id){
		if ($skill_id == "") {
			$skill_name = "N/A";
		} else {
			$result=$sql->query("SELECT name FROM skills WHERE id = ".$skill_id);
			$skill_name = $result->fetch_array();
			$skill_name = $skill_name['name'];
		}
		return $skill_name;
	}

	function display_experience($experience){
		if ($experience == "") {
			$experience = "N/A";
		} elseif ($experience == 0) {
			$experience = "Fresher";
		} elseif ($experience == 1) {
			$experience = "1 Year";
		} else {
			$experience = $experience." Years";
		}
		return $experience;
	}

	function resume_download($resume){
		if ($resume == "") {
			$download_link = "N/A";
		} else {
			$resume_folder = "portal/uploads/resume/";
			$download_link = "<a href=\"".$resume_folder."".$resume."\" download>Download Resume</a>";
		}
		return $download_link;
	}
	
	
	function resume_download_icon($resume){
		if ($resume == "") {
			$download_link = "N/A";
		} else {
			$resume_folder = "../portal/uploads/resume/";
			$download_link = "<a href=\"".$resume_folder."".$resume."\" download><i class=\"fa fa-download\"></i></a>";
		}
		return $download_link;
	}
	function get_seeker_info($seeker){
		echo "<tr><td>".$seeker['name']."</td>";
		echo "<td>".$seeker['email']."</td>";
		echo "<td>".$seeker['phone']."</td>";
		echo "<td>".display_experience($seeker['experience'])."</td>"; 
		echo "<td>";
			$skills = explode(",", $seeker['skills']);
			$count = 1;
			foreach ($skills as $skill_id) {
				echo get_skill_name($skill_id, $count)." ";
				$count++;
			}
			//echo "<td>".$tenthpy['tenthpy']."<td>";
			//echo "<td>".$tenthpercen['tenthpercen']."<td>";
			echo "<td>".$seeker['passoutyear']."</td>";
			echo "<td>".$seeker['aggrigate']."</td>";
			//echo "<td>".$branch['branch']."</td>";
		echo "<td>".resume_download($seeker['resume'])."</td></tr>";
	}

	function get_pagination($count){
		$pages = ceil($count / 5);
		echo "<ul class=\"pagination\">";
			for ($i=1; $i <= $pages; $i++) { 
				echo "<li><a href=\"#\">".$i."</a></li>";
			}
		echo "</ul>";
	}
	
	function get_query_string(){
		$parsed = parse_url($_SERVER['REQUEST_URI']);
		$query = $parsed['query'];
		parse_str($query, $params);
		unset($params['page']);
		return $string = http_build_query($params);
	}
	
	function formatDate($date){
		date("Y/m/d H:i:s");
		return $string = http_build_query($params);
	}
	
	function seo_url($vp_string)

    {

        $vp_string = trim($vp_string);

        $vp_string = html_entity_decode($vp_string);

        $vp_string = strip_tags($vp_string);

        $vp_string = strtolower($vp_string);

        $vp_string = preg_replace('~[^ a-z0-9_]~', ' ', $vp_string);

        $vp_string = preg_replace('~ ~', '-', $vp_string);

        $vp_string = preg_replace('~-+~', '-', $vp_string);
		
		$vp_string = rtrim($vp_string,'-');

        return $vp_string;

    }	
	function url_get_contents ($Url) {
		if (!function_exists('curl_init')){ 
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
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
	function obfuscate_email($email)
	{
		$em   = explode("@",$email);
		$name = implode(array_slice($em, 0, count($em)-1), '@');
		$len  = floor(strlen($name)/2);

		return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);   
	}
	
	function create_certificate($name,$subject,$percentage,$message){
		  $name_len=strlen($name);
		  $occupation = strtoupper($subject);
          if ($occupation) {
          $font_size_occupation = 10;
          }
		  //designed certificate picture
          $image = "../images/certi.png";

          $createimage = imagecreatefrompng($image);
          $filename = "certificate".time().".png";
          //this is going to be created once the generate button is clicked
          $output = "../images/certificate/".$filename;

          //then we make use of the imagecolorallocate inbuilt php function which i used to set color to the text we are displaying on the image in RGB format
          $white = imagecolorallocate($createimage, 205, 245, 255);
          $black = imagecolorallocate($createimage, 0, 0, 0);
		  $red = imagecolorallocate($createimage, 255, 0, 0);

          //Then we make use of the angle since we will also make use of it when calling the imagettftext function below
          $rotation = 0;

          //we then set the x and y axis to fix the position of our text name
          $origin_x = 170;
          $origin_y=200;

          //we then set the x and y axis to fix the position of our text occupation
          $origin1_x = 170;
          $origin1_y= 310;
		  
		  //we then set the x and y axis to fix the position of our text occupation
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

          // font directory for occupation name
          $drFont1 = $_SERVER['DOCUMENT_ROOT']."/jbktest/fonts/Gotham-black.otf";

          //function to display name on certificate picture
          $text1 = imagettftext($createimage, $font_size, $rotation, $origin_x, $origin_y, $black,$drFont, $name);

          //function to display subject name on certificate picture
          $text2 = imagettftext($createimage, $font_size_occupation, $rotation, $origin1_x+2, $origin1_y, $black, $drFont1, $subject);
		  
		  //function to display percentage on certificate picture
          $text3 = imagettftext($createimage, 16, $rotation, $origin3_x, $origin3_y, $black, $drFont, $percentage);
		  
		  //function to display message on certificate picture
          $text4 = imagettftext($createimage, 30, $rotation, $origin2_x, $origin2_y, $red, $drFont, $message);

          imagepng($createimage,$output,3);
		  return $filename;
	}
?>