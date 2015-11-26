<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
    
   $id =$_GET["id"];
    $cookie = $_COOKIE['ucid'];
    $link = "https://web.njit.edu/~srm56/cs490/exam.php?username=".$cookie."&exam_id=".$id;
    $curl = curl_init();
    $blank;
            // Set the url path we want to call
            curl_setopt($curl, CURLOPT_URL, $link );
            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // Send the request
            $result = curl_exec($curl);
           $info = json_decode($result, true);
            // Free up the resources $curl is using
            curl_close($curl);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                <div class="panel panel-default">
                    <?php
                    if($info["user_type"] == 2){
                        echo "<form name=\"test\" method=\"post\" onsubmit=\"return releaseGrade()\">";
                    }else{
                        echo "<form name=\"test\" method=\"post\" onsubmit=\"return examTest()\">";
                    } 
                    ?>
                    <?php 
                    foreach($info['questions'] as $quest){?>
                    <?php   if($quest["question_type"] == 2){
                            $count = $quest["blank"];
                            $size = count($quest["question_words"]);
                            for ($x = 0; $x < $size ; $x++) {
                                if( $x == $count){
                                    $blank = $quest["question_words"][$x];
                                    echo "<input class=\"form-control\" type=\"text\" name=\"blank\" questId=".$quest["question_id"]." question=".implode(' ', $quest['question_words']).">"."&nbsp";
                                }else{
                                    echo $quest["question_words"][$x]."&nbsp";
                                } 
                            }
                            if($info["user_type"] == 2){
                                    echo "Answer is :".$blank."<br>";
                                }
                            echo "<br>";
                        }else if($quest["question_type"] == 3){
                            echo $quest["question"];
                            echo "<div name=\"radios\">";
                            ?>
                            <input class="form-control" type="radio" name="ToF<?php echo $quest['question_id'] ?>" value="true" questId="<?php  echo $quest["question_id"]; ?>" >True<br>
                            <input class="form-control" type="radio" name="ToF<?php echo $quest['question_id']?>" value="false" questId="<?php echo $quest["question_id"]; ?>">False<br>
                                <!--echo "<input class=\"form-control\" type=\"radio\" name=\"ToF"$quest['question_id']." "." \" value=\"true\" questId="." ".$quest["question_id"].">True<br>";
                                echo "<input class=\"form-control\" type=\"radio\" name=\"ToF2 echo $quest['question_id']\"value=\"false\" questId="." ".$quest["question_id"].">False<br>";-->
                                <?php
                            echo "</div>";
                        }else if($quest["question_type"] == 4){
                        ?>
                        <div>
                            <?php 
                            echo $quest["question"];
                            ?>
                        </div>
                        <textarea class="form-control" name="code" questid="<?php echo $quest['question_id']?>"></textarea>
                        <?php }
                        else{
                            echo $quest['question']."<br>";
                            $sizeOpt = count($quest["options"]);
                            if ($quest['options']){
                                echo "<div name=\"radios\">";
                                for ($x = 0; $x < $sizeOpt ; $x++){
                                if($x == 0 ){
                                    echo "A <input class=\"form-cotnrol\" type=\"radio\" name=\"option".$quest['question_id']."\" value=\"A\" questId=".$quest["question_id"].">"." ".$quest["options"][A]."<br>";
                                }else if($x == 1){
                                    echo "B <input class=\"form-cotnrol\" type=\"radio\" name=\"option".$quest['question_id']."\" value=\"B\" questId=".$quest["question_id"].">"." ".$quest["options"][B]."<br>";
                                }else if($x == 2){
                                    echo "C <input class=\"form-cotnrol\" type=\"radio\" name=\"option".$quest['question_id']."\" value=\"C\" questId=".$quest["question_id"].">"." ".$quest["options"][C]."<br>";
                                }else{
                                    echo "D <input class=\"form-cotnrol\" type=\"radio\" name=\"option".$quest['question_id']."\" value=\"D\" questId=".$quest["question_id"].">"." ".$quest["options"][D]."<br>";
                                }
                            }
                                echo "</div>";
                                
                            }
                            
                        }
                        echo "<br>";
                        if($info["user_type"] == 2){
                            echo "Answer is :".$quest["answer"]."<br>";
                        }                        
                   } 
        
                    if($info["user_type"] == 2){
                            echo "<button type=\"submit\" class=\"btn btn-primary\">Release Grades</button>";
                        }else{
                            echo "<button type=\"submit\" class=\"btn btn-primary\"> Submit exam</button>";
                        }
        
        
                echo "</form>"
                
        
        ?>
         <button type="button" class="btn btn-primary"><a href="create_exam.php?title=<?php echo $info['title']; ?>">Edit</a></button>
                </div>
                </div>
                <div class="col-md-2"></div>
              </div>
        </div>
        <script src="exam.js"></script>
    <script>
</body>

</html>