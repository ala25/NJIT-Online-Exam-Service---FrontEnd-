 var questType;
 var textarea = document.getElementsByTagName('textarea'); 
 var inputs = document.getElementsByTagName('input');
 var options = document.getElementsByTagName('options');
 
 function addTestCase(){
     var questionNode = document.getElementById('sec');
      var button = document.getElementById('buttons'); 
     var code = '<h3> Enter the Arguments your function will take </h3><h5> ***Note: If you have more than one argument seperate your arguments by commas.</h5><input class=\"form-control arg\" type=\"text\"><h3>Also tell us what it should return</h3><input class=\"form-control ans\" type=\"text\"><br>';
      document.getElementById('first').innerHTML += code;
      document.getElementById('sec').appendChild(button);
      
      
     
 }

 function selectQuestionType(questId) {
     questType = questId;
     var hideArr = document.getElementsByClassName('hideThat');
     for (var x = 0; x < hideArr.length; x++) {
         hideArr[x].style.display = "none";
     }
     if (questType == 1) {
         document.getElementById('mult').style.display = "block";

     } else if (questType == 2) {
         document.getElementById('fill').style.display = "block";
     } else if (questType == 3) {
         document.getElementById('tof').style.display = "block";
     } else if (questType == 4) {
         document.getElementById('code').style.display = "block";
     }

 }

 function addQuestion() {
    //  var textarea = document.getElementsByTagName('textarea'); 
    //  var inputs = document.getElementsByTagName('input');
    //  var options = document.getElementsByTagName('options');
     var question = {};
     var xml, text;
     xml = new XMLHttpRequest();
     xml.open("POST", "createQuest.php", true);
     xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
     //for multiple choice
     if (questType == 1) {
         var sent;
         var ans;
         var points;
         var optionsQ = {};
         [].forEach.call(textarea, function(e){
             if(e.classList[1] == "multp"){
                 sent = e.value;
             }
             
         });
         [].forEach.call(inputs,function(q){
             if(q.classList[1] == "multp"){
                [].forEach.call(q.classList ,function(e) {
                    if(e == "choicesA"){
                        optionsQ.A = q.value;
                    }else if(e == "choicesB"){
                        optionsQ.B = q.value;
                    }else if(e == "choicesC"){
                         optionsQ.C = q.value;
                    }else if(e == "choicesD"){
                         optionsQ.D = q.value;
                    }else if(e == "point"){
                        points = q.value;
                    }else if(e == "corr"){
                        ans = q.value;
                    }
                });
               }
         });
         
         //console.log(optionsQ);
         xml.send(JSON.stringify({
             username: getUsername(),
             question: {
                 question_type: questType,
                 question: sent,
                 options: optionsQ,
                 answer: ans,
                 points: points
             }
         }));

         xml.addEventListener("load", function (event) {
             if (event.srcElement.status == 200) {
                 window.location = "prof.php";
             }
         });



     } else if (questType == 2) {

         var sent;
         var ans;
         var points;
         var questionNode = document.getElementById('fill').childNodes;
         var blankNodes = document.getElementsByClassName('blank').childNodes;
         console.log(inputs);
         [].forEach.call(inputs,function(q){
             if(q.classList[1] == "fill"){
                sent = q.value;
               }else if(q.classList[1] == "fillAns"){
                   ans = q.value;
               }else if(q.classList[1] == "fillPts"){
                   points = q.value;
               }   
           });
         xml.send(JSON.stringify({
             username: getUsername(),
             question: {
                 question_type: questType,
                 question: sent,
                 blank: ans,
                 points: points,
                 answer: ans
             }
         }));

         xml.addEventListener("load", function (event) {
             if (event.srcElement.status == 200) {
                 window.location = "prof.php";
             }
         });

     } else if (questType == 3) {
         var sent;
         var ans;
         var points;
         var questionNode = document.getElementById('tof').childNodes;
         var select = document.getElementsByName('trfa');
         
         if(select[0].selectedIndex == 0 ){
             ans = true;
         }else if(select[0].selectedIndex == 1){
             ans = false;
         }    
         
         [].forEach.call(inputs,function(q){
             if(q.classList[1] == "tof"){
                sent = q.value;
               }else if(sent == 1){
                   sent = false;
               }else if(sent == 0){
                   sent = true;
               }else if(q.classList[1] == "tofPts"){
                   points = q.value;
               }
                   
               
         });     

     


         xml.send(JSON.stringify({
             username: getUsername(),
             question: {
                 question_type: questType,
                 question: sent,
                 answer: ans,
                 points: points
             }
         }));

         xml.addEventListener("load", function (event) {
             if (event.srcElement.status == 200) {
                 window.location = "prof.php";
             }
         });

     } else if (questType == 4) {

         var sent;
         var points;
         var fn;
         var questionNode = document.getElementById('code').childNodes;
         var args = [];
         var answers = [];
         var test_cases = [];
         console.log(questionNode);

        [].forEach.call(textarea, function(e){
             if(e.classList[1] == "fn"){
                 sent = e.value;
             }
          });
         [].forEach.call(inputs,function(q){
             if(q.classList[1] == "fnName"){
                fn = q.value;
               }else if(q.classList[1] == "arg"){
                   args.push(q.value);
               }else if(q.classList[1] == "ans"){
                   answers.push(q.value);
               }else if(q.classList[1] == "pts"){
                   points = q.value;
               }
                   
               
         }); 
         
         for(var i =0;i<args.length;i++){
             var obj = {"arguments":args[i],"return_value":answers[i]};
             test_cases.push(obj);
         }


         xml.send(JSON.stringify({
             username: getUsername(),
             question: {
                 question_type: questType,
                 question: sent,
                 test_cases: test_cases,
                 function_name: fn,
                 points: points
             }
         }));
         xml.addEventListener("load", function (event) {
             if (event.srcElement.status == 200) {
                 window.location = "prof.php";
             }
         });

     }

     return false;
 }

 function getUsername() {

     var arr = document.cookie.split(';');
     var arr2 = []
     for (var i = 0; i < arr.length; i++) {
         arr2.push(arr[i].split('='));
     }
     for (var i = 0; i < arr2.length; i++) {
         if (arr2[i][0] == 'ucid') {
             return arr2[i][1];
         } else return "did not work";
     }

 } 

 function addMore() {
     var form = document.getElementById('create');
     console.log(form);



     var code = "<br><h3>Test Case </h3<h3> Enter the Arguments your function will take </h3><h5> ***Note: If you have more than one argument please seperate your arguments by commas.</h5><input class=\"form-control arg\" type=\"text\"><h3>Also tell us what it should return</h3><input class=\"form-control ans\" type=\"text\">";
     var div = document.createElement("div");

     div.innerHTML = code;
     form.appendChild(div);
 }
 