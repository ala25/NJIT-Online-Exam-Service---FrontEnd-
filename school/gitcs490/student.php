<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
        $datastring = $_COOKIE['ucid'];
        $link = "https://web.njit.edu/~srm56/cs490/exam_list.php?username=".$datastring;
        if(strlen($datastring) > 0){
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
        }else{
        echo "Are you". $datastring;
        }
        ?>
        <div class="contianer">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <ul class="list-group">
                        <?php foreach($info["exams"] as $exam){
                            ?>
                        
                            <?php if($exam["taken"] == false): ?>
                                <button type="button" class="list-group-item">
                                    <a href="exam.php?id=<?php echo $exam["exam_id"] ?>">
                                        <?php echo $exam["title"]; ?>
                                    </a>
                                </button>

                                <?php else: ?>
                                    <button type="button" class="list-group-item">
                                        
                                         <?php 
                                         if($exam["grade_released"] == 1): ?>
                                        <a href="gradedExam.php?id=<?php echo $exam["exam_id"] ?>" title="Check out Your Grade">
                                            <?php echo $exam["title"];?>
                                        </a>
                                        <?php echo "<span class=\"badge green\"><span class=\"glyphicon glyphicon-ok\"></span></span>";?>
                                        <?php else: ?>
                                                    <a href="gradedExam.php?id=<?php echo $exam["exam_id"] ?>" title=" Grades N/A">
                                            <?php echo $exam["title"];?>
                                        </a>
                                        <?php echo "<span class=\"badge red\"><span class=\"glyphicon glyphicon-remove\"></span></span>";?>
                                        <?php endif ; ?>
                                    </button>

                                    <?php endif ; ?>


                                        <?php } ?>
                    </ul>

                </div>
                <div class="col-md-3"></div>
            </div>

        </div>
        
        
       
</body>

</html>