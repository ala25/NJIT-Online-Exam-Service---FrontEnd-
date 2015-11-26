function examTest() {
    var radios = document.getElementsByName('radios');
    var blank = document.getElementsByName('blank');
    var code = document.getElementsByName('code');
    var xmlhttp, text;
    xml = new XMLHttpRequest();
    xml.open("POST", "grade_exam.php", true);
    xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xml.onreadystatechange = function() {
        if (xml.readyState == 4 && xml.status == 200) {
            console.log(xml.responseText);
        }
    }
    var answer = [];
    var parser = document.createElement('a');
    parser.href = window.location.href;
    var examId = parser.search;
    var examIdArr = examId.split("=");
    for (var x = 0; x < radios.length; x++) {
        for (var j = 0; j < radios[x].childNodes.length; j++) {
            if (radios[x].childNodes[j].checked) {
                if (radios[x].childNodes[j].name.indexOf("ToF") != -1) {
                    if (radios[x].childNodes[j].value == "true") {
                        answer.push({
                            answer: true,
                            question_id: radios[x].childNodes[j].getAttribute('questId')
                        });
                    } else if (radios[x].childNodes[j].value == "false") {
                        answer.push({
                            answer: false,
                            question_id: radios[x].childNodes[j].getAttribute('questId')
                        });
                    }
                } else {
                    answer.push({
                        answer: radios[x].childNodes[j].value,
                        question_id: radios[x].childNodes[j].getAttribute('questId')
                    });
                }

            }
        }
    }
    for (var l = 0; l < blank.length; l++) {
        answer.push({
            answer: blank[l].value,
            question_type: 2,
            question_words: blank[l].getAttribute('question'),
            question_id: blank[l].getAttribute("questId")
        });
    }
    [].forEach.call(code,function(val){
        if(val.nodeName == "TEXTAREA"){
            answer.push({
                answer: val.value,
                question_id: val.getAttribute("questId")
            });
        }
    });
    


    xml.send(JSON.stringify({
        answers: answer,
        username: getUsername(),
        exam_id: examIdArr[1]
    }));

    xml.addEventListener("load", function (event) {
            if(event.srcElement.status == 200){
                window.location= "student.php";
            }
         });
    return false;
};

function releaseGrade() {
    var xmlhttp, text;
    xml = new XMLHttpRequest();
    xml.open("POST", "release_grade.php", true);
    xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    var parser = document.createElement('a');
    parser.href = window.location.href;
    var examId = parser.search;
    var examIdArr = examId.split("=");
    xml.send(JSON.stringify({
        username: getUsername(),
        exam_id: examIdArr[1]
    }));

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