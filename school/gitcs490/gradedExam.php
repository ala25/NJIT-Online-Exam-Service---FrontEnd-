<?php
$id =$_GET["id"];
    $cookie = $_COOKIE['ucid'];
    $link = "https://web.njit.edu/~srm56/cs490/graded_exam.php?username=".$cookie."&exam_id=".$id;
$curl = curl_init();
        // Set the url path we want to call
            curl_setopt($curl, CURLOPT_URL, $link );
            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // Send the request
            $result = curl_exec($curl);
           $info = json_decode($result, true);
            // Free up the resources $curl is using
            curl_close($curl);

            $grade = $info["overall_score"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Grades</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="gradedExam.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php
            if($info['grade_released'] == true):
            if ($grade <65){?>
    
                <?php 
                echo "<div> Your Grade:".$grade."</div><br>";
                } else{
                echo "<div> Your Grade:".$grade."</div><br>"; 
            }
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
  <?php
    foreach($info['questions'] as $quest){
            ?>
            <div>
            <?php
                if($quest["question_type"] == 2){
                    $count = $quest["blank"];
                    $size = count($quest["question_words"]);
                    for ($x = 0; $x < $size ; $x++) {
                        if( $x == $count){
                            $blank = $quest["question_words"][$x];
                            echo "<input type=\"text\" name=\"blank\" questId=".$quest["question_id"].">"."&nbsp";
                        }else{
                            echo $quest["question_words"][$x]."&nbsp";
                        } 
                    }
                    if($quest["correct"]){
                        echo "<div style=\"color:green\">Correct</div><br>";
                    }else{
                        echo "<div style=\"color:red\">InCorrect</div><br>";
                    }
                    // echo "<div> Your Answer: ".$quest['given_answer']."</div>";
                    // echo "<div style=\"color:green;\"> Correct Answer: ".$quest['correct_answer']."</div>";
                    // echo "<br>";
                }else if($quest["question_type"] == 3){
                    echo $quest["question"];
                    echo "<div name=\"radios\">";
                        echo "<input type=\"radio\" name=\"ToF\" value=\"true\" questId=".$quest["question_id"].">True<br>";
                        echo "<input type=\"radio\" name=\"ToF\" value=\"false\" questId=".$quest["question_id"].">False<br>";
                    echo "</div>";
                    
                    if($quest['correct']){
                         if( $quest['correct_answer'] == 1){
                             echo "<div style=\"color:green\"> Your Answer: True </div>";
                            echo "<div style=\"color:green\"> Correct Answer: True </div>";
                            echo "<br>";
                        }else{
                            echo "<div style=\"color:green\"> Your Answer: False </div>";
                            echo "<div style=\"color:green\"> Correct Answer: False </div>";
                            echo "<br>";
                         }   
                    }else{
                        if( $quest['correct_answer'] == 1){
                             echo "<div style=\"color:red\"> Your Answer: True </div>";
                            echo "<div style=\"color:green\"> Correct Answer: True </div>";
                            echo "<br>";
                        }else{
                            echo "<div style=\"color:red\"> Your Answer: False </div>";
                            echo "<div style=\"color:green\"> Correct Answer: False </div>";
                            echo "<br>";
                         } 
                    }
                    

                    
                }else if($quest["question_type"] == 4){
                ?>
                <div>
                    <?php 
                    echo "<p>". $quest["question"]."</p>";
                    ?>
                </div>
                <textarea name="code" questid="<?php echo $quest["question_id"]?>"></textarea>
                <div>
                    
                    <?php

                        echo "<div>Your Answer:" .$quest['given_answer']."</div>";
                        if($quest['correct']){
                            echo "<div style=\"color:green\"> Correct </div>";;
                        }else{
                            echo "<div style=\"color:red\"> Incorrect </div>";;
                        }


                    ?>

                </div>
                <?php }
                else{
                    echo $quest['question']."<br>";
                    $sizeOpt = count($quest["options"]);
                    if ($quest['options']){
                        echo "<div name=\"radios\">";
                        for ($x = 0; $x < $sizeOpt ; $x++){
                        if($x == 0 ){
                            echo "A <input type=\"radio\" name=\"option\" value=\"A\" questId=".$quest["question_id"].">".$quest["options"][A]."<br>";
                        }else if($x == 1){
                            echo "B <input type=\"radio\" name=\"option\" value=\"B\" questId=".$quest["question_id"].">".$quest["options"][B]."<br>";
                        }else if($x == 2){
                            echo "C <input type=\"radio\" name=\"option\" value=\"C\" questId=".$quest["question_id"].">".$quest["options"][C]."<br>";
                        }else{
                            echo "D <input type=\"radio\" name=\"option\" value=\"D\" questId=".$quest["question_id"].">".$quest["options"][D]."<br>";
                        }
                    }
                        
                    }
                       if($quest['given_answer'] == $quest['correct_answer']){
                            echo "<div style=\"color:green\"> Your Answer: ".$quest['given_answer']."</div>";
                            echo "<div style=\"color:green\"> Correct Answer: ".$quest['correct_answer']."</div>";
                            echo "<br>";       
                       }else{
                           echo "<div style=\"color:red\"> Your Answer: ".$quest['given_answer']."</div>";
                            echo "<div style=\"color:green\"> Correct Answer: ".$quest['correct_answer']."</div>";
                            echo "<br>";
                       }
                    

                    
                }
            }

?>
</div>
</div>
</div>
</div>
</div>
 <?php else: ?>
            <img src="2887282.jpg">
            <h1> BUT ... </h1>
            <h1>You Grade isn't Ready ... Hold On</h1>
    <?php 
        endif ;
    ?>
</body>
</html>