<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){

	$form = file_get_contents('php://input');
	echo $form;
    $curl = curl_init();
  	// You can also set the URL you want to communicate with by doing this:
  	// $curl = curl_init('http://localhost/echoservice');
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  	// We POST the data
  	curl_setopt($curl, CURLOPT_POST, 1);
  	// Set the url path we want to call
  	curl_setopt($curl, CURLOPT_URL, 'https://web.njit.edu/~srm56/cs490/questions.php');
  	// Make it so the data coming back is put into a string
  	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  	// Insert the data
  	curl_setopt($curl, CURLOPT_POSTFIELDS, $form);

  	// You can also bunch the above commands into an array if you choose using: curl_setopt_array

  	// Send the request
  	$result = curl_exec($curl);
  	// Get some cURL session information back
  	$info = curl_getinfo($curl);
  	// Free up the resources $curl is using
  	curl_close($curl); 



		exit();
	}else{
         $datastring = $_COOKIE['ucid'];
        $link = "https://web.njit.edu/~srm56/cs490/questions.php?username=".$datastring;
            $curl = curl_init();
            // Set the url path we want to call
            curl_setopt($curl, CURLOPT_URL, $link );
            // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // Send the request
            $httpcode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
            
            $result = curl_exec($curl);
           $info = json_decode($result, true);
            // Free up the resources $curl is using
            curl_close($curl);

    }

?>
<html>
	<head>
		<title></title>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link rel="stylesheet" type="text/css" href="createQuest.css">
	</head>
	<body>
        <div class="container">
            <form method="post" onsubmit=" return addQuestion() ">
                <div class="row">
                <h2>First lets choose what type of Question you would like to add:</h2>
                <ul>
                    <li><input type="radio" name='question' onchange="selectQuestionType(1)">Multiple Choice</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(2)">Fill In the blanks</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(3)">True Or False</li>
                    <li><input type="radio" name='question' onchange="selectQuestionType(4)">Code</li>
                </ul>
                </div>
                <div class="hideThat row" id="mult">
                    <div class="col-md-6">
                        <h2> Grrrreat! Enter the phrase you would like to ask.</h2>
                        <textarea class="form-control multp" rows="2"></textarea>
                        <h3>Awesome Question now enter the choices for your question</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
                                <div class="input-group">
                                    <div class="input-group-addon option">A</div><li><input class="form-control multp choicesA" type="text"></li>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">B</div><li><input class="form-control multp choicesB" type="text"></li>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">C</div><li><input class="form-control multp choicesC" type="text"></li>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">D</div><li><input class="form-control multp choicesD" type="text"></li>
                                </div>
                            </ul>
                        </div>
                    </div>
                        <h3> How many points is this question worth?</h3>
                        <input class="form-control multp point" type="text">
                        <h3>The Correct Answer :</h3>
                        <input class="form-control multp corr" type="text">
                        <h4>When you are done hit <b>Add</b></h4>
                        <button class="btn btn-success" type='submit'>Add</button>
                    </div>
                    <div class="col-md-6">
                        <h1> Mult Choice Questions already made </h1>
                        <ul class="list-group">
                            <?php 
                                    foreach($info['questions'] as $k){
                                        if($k['question_type'] == 1){ ?>
                                            
                                            <li class="list-group-item"><?php echo $k['question']; ?> </li>
                                        <?php    
                                        }
                                    }                                        
                                     
                             ?>
                        </ul>
                    </div>
                        
                </div>
                <div class="hideThat row" id="tof">
                    <div class="col-md-6">
                        <h2> Nice! Enter that Tricky True or False Question that everyone loves to see on an Exam ;)</h2>
                    <input class="form-control tof" type="text" placeholder="Your Question goes here">
                    <h3> The Correct Answer :</h3>
                    <select name="trfa">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                    <h3>How many points is this question worth?</h3>
                    <input class="form-control tofPts" type="text">
                    <h4>When you are done hit <b>Add</b></h4>
                    <button class="btn btn-success" type='submit'>Add</button>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <h1> True and False Questions already made </h1>
                        <ul class="list-group">
                            <?php 
                                    foreach($info['questions'] as $k){
                                        if($k['question_type'] == 3){ ?>
                                            
                                            <li class="list-group-item"><?php echo $k['question']; ?> </li>
                                        <?php    
                                        }
                                    }                                        
                                     
                             ?>
                        </ul>
                        
                    </div>
                    
                </div>
                <div class="hideThat row" id="fill">
                    <div class="col-md-6">
                        
                    <h2> Enter your Fill in the blank Question</h2>
                    <input class="form-control fill" type="text">
                    <h3> And what is the answer that you want blanked</h3>
                    <input class="form-control fillAns" name="blank" class="blank" placeholder=" Your Question Goes Here" type="text">
                    <h3>How many points is this question worth?</h3>
                    <input class="form-control fillPts" type="text">
                    <h4>When you are done hit <b>Add</b></h4>
                    <button class="btn btn-success" type='submit'>Add</button>
                        
                    </div>
                    <div class="col-md-6">
                        
                        <h1> Fill In the Blanks Questions already made </h1>
                        <ul class="list-group">
                            <?php 
                                    foreach($info['questions'] as $k){
                                        if($k['question_type'] == 2){ 
                                            foreach($k['question_words'] as $r){
                                                $word .= $r." " ;                                                
                                            }?>
                                             <li class="list-group-item"><?php echo $word; ?> </li>
                                        <?php   
                                        $word = ""; 
                                        }
                                    }                                        
                                     
                             ?>
                        </ul>
                    </div>
                    
                </div>
                <div class="hideThat row" id="code">
                    <div class="col-md-6">
                        
                        <h2> Enter your Question or Instructions</h2>
                    <textarea class="form-control fn" placeholder=" Your Question Goes Here"></textarea>
                    <h3> Next Enter the Function Name </h3>
                    <input class="form-control fnName" type="text" placeholder="function name">
                    <h2>Test Cases</h2>
                    <div class="first">
                        <h4> Enter the Arguments your function will take </h4>
                        <h5> ***Note: If you have more than one argument seperate your arguments by commas.</h5>
                        <input class="form-control arg" type="text">
                        <h3>Also tell us what it should return</h3>
                        <input class="form-control ans" type="text">
                        <br>
                    </div>

                    <div class="sec" id='sec'>
                        <button class='btn btn-primary' id="buttons" onclick="addTestCase();return false;">+</button>
                    </div>

                    <h3>How many points is this question worth?</h3>
                    <input class="form-control pts" type="text">
                    <h4>When you are done hit <b>Add</b></h4>
                    <button class="btn btn-success" type='submit'>Add</button>
                </div>
                
                <div class="col-md-6">
                        
                        <h1> Coding Questions already made </h1>
                        <ul class="list-group">
                            <?php 
                                    foreach($info['questions'] as $k){
                                        if($k['question_type'] == 4){ ?>
                                            
                                            <li class="list-group-item"><?php echo $k['question']; ?> </li>
                                        <?php    
                                        }
                                    }                                        
                                     
                             ?>
                        </ul>
                        
                    </div>
                        
                    </div>
                    
                    
            </form>
        </div>    
		<script type="text/javascript" src="createQuest.js" ></script>
	</body>
</html>