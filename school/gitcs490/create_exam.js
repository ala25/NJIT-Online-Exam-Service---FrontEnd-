var questId;
var questionId = [];
var ifArr = [];
function addQuest(e){
     questionId.push(e.getAttribute('questId'));
     var ulList= document.getElementById('questionsAdded');
     var list = document.createElement('li');
     list.appendChild(document.createTextNode(e.innerText));
     list.setAttribute("class","list-group-item");
     list.setAttribute("onclick","takeOut(this); return false;");
     list.setAttribute("questId",e.getAttribute('questId'));
     ulList.appendChild(list);
}

function takeOut(e){
    var ulList= document.getElementById('questionsAdded');
    var ind = questionId.indexOf(e.getAttribute('questId'));

     questionId.splice(ind,1);
     
    ulList.removeChild(e);
}

function prQ(){
     var xml,examTitle;
     examTitle  = document.getElementsByName('ExamTitle');
    xml = new XMLHttpRequest();
    xml.open("POST", "createFin.php", true);
    xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xml.send(JSON.stringify({
        username: getUsername(),
        title: examTitle[0].value,
        questions: questionId
    }));
    xml.addEventListener("load", function (event) {
        if(event){
            window.location = "prof.php";
        };
    });
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

function createExam() {
    var checkboxes = document.getElementsByName('quest');
    var title = document.getElementsByName('ExamTitle');
    var xmlhttp, text;
    xml = new XMLHttpRequest();
    xml.open("POST", "createFin.php", true);
    xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    var questions = []
    var examTitle = title[0].value;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked == true) {
            questions.push(checkboxes[i].getAttribute('questid'));
        }
    }
    xml.send(JSON.stringify({
        username: getUsername(),
        title: examTitle,
        questions: questions
    }));

    xml.addEventListener("load", function (event) {
        if(event){
            window.location = "prof.php";
        };
    });
    

    return false;
}

function getUsername(){

    var arr = document.cookie.split(';');
    var arr2 = []
    for(var i =0; i<arr.length;i++){
        arr2.push(arr[i].split('='));
    }
    for(var i =0; i<arr2.length;i++){
        if(arr2[i][0] == 'ucid'){
            return arr2[i][1];
        }else return "did not work";
    }

}