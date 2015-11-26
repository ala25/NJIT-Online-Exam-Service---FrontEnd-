<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
        $info;
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
        <div class="Examlist">
            <?php foreach($info["exams"] as $exam){ ?>
                    <div>
                        <a href="exam.php?id=<?php echo $exam["exam_id"] ?>"><?php echo $exam["title"]; ?></a>
            </div>
                    <?php } ?>
        </div>
        <button><a href="create_exam.php">Create a New Exam</a></button>
        <button><a href="createQuest.php">Create A Question</a></button>
        <script src=""></script>
</body>

</html>