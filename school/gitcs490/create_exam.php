<!DOCTYPE>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="createQuest.css">
</head>

<body>
    <div class="container">
    <?php
        $datastring = $_COOKIE['ucid'];
        $link = "https://web.njit.edu/~srm56/cs490/questions.php?username=".$datastring;
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
            ?>
        <form name="test" method="post" onsubmit="return prQ();return false;">
            <?php 
            
            if(!isset($_GET['title'])){
                    ?>
                     <div>
                <h1>Name your Exam:</h1>
            </div>
                <?php }
            
            ?>
           
              <?php 
                if(isset($_GET['title'])){
                    ?>
                    <div>
                        <h1> <?php echo $_GET['title']; ?> </h1>
                    </div>
                <?php }
              ?>
            <div></div>
            <div>
                <input type="text" name="ExamTitle">
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="row">
                <h2>First lets choose what type of Question you would like to add:</h2>
                <ul>
                    <li><input type="radio" name='question' onchange="selectQuestionType(1)">Multiple Choice</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(2)">Fill In the blanks</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(3)">True Or False</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(4)">Code</li>
                </ul>
                </div>
                <div class="hideThat" id="mult">
                    
                    <ul class="list-group">
                    <?php
                        foreach ($info['questions'] as $key) {
                        
                            if($key['question_type'] == 1){ ?>
                                <li class="list-group-item" questId="<?php echo $key['question_id'] ?>"  onclick="addQuest(this);return false;"> <?php echo $key['question']; ?> </li>  
                            <?php } ?>
                        
                            
                        <?php } ?>
                    
                         
                         </ul>
                </div>
                <div class="hideThat" id="tof">
                    <ul class="list-group">
                    <?php
                        foreach ($info['questions'] as $key) {
                        
                            if($key['question_type'] == 3){ ?>
                                <li class="list-group-item" questId="<?php echo $key['question_id'] ?>" onclick="addQuest(this);return false;"> <?php echo $key['question']; ?> </li>  
                            <?php } ?>
                        
                            
                        <?php } ?>
                    
                         
                         </ul>
                </div>
                <div class="hideThat" id="fill">
                    <ul class="list-group">
                    <?php
                        foreach ($info['questions'] as $key) {
                        
                            if($key['question_type'] == 2){ ?>
                                <li class="list-group-item" questId="<?php echo $key['question_id'] ?>" onclick="addQuest(this);return false;"> <?php echo implode(" ",$key['question_words']) ; ?> </li>  
                            <?php } ?>
                        
                            
                        <?php } ?>
                    
                         
                         </ul>
                </div>
                <div class="hideThat" id="code">

                   <ul class="list-group">
                    <?php
                        foreach ($info['questions'] as $key) {
                        
                            if($key['question_type'] == 4){ ?>
                                <li class="list-group-item" questId="<?php echo $key['question_id'] ?>" onclick="addQuest(this);return false;"> <?php echo $key['question']; ?> </li>  
                            <?php } ?>
                        
                            
                        <?php } ?>
                    
                         
                         </ul>
                </div>
                    
                    
                    
                    
                    
                    
                    
                </div>
                <div class="col-md-6">
                    <h1> Questions Chosen </h1>
                    <div class='exam'>
                        <ul class="list-group" id="questionsAdded">
                            
                         <ul>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
 
                
        </form>
        </div>
    <script src="create_exam.js"></script>
</body>

</html>