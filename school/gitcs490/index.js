function ruLogined() {
    var form = document.getElementsByName('login');
    var xmlhttp, text;
    xml = new XMLHttpRequest();
    xml.open("POST", "login.php", true);
    xml.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xml.send(JSON.stringify({
        name: document.getElementsByName("name")[0].value,
        pass: document.getElementsByName("pass")[0].value
    }));
    xml.addEventListener("load", function (event) {
        if(event.srcElement.status  === 401){
            alert("Wrong Creds Dummy!");
            return;
        };
        text = JSON.parse(event.srcElement.responseText);
        console.log(text.type + " " + (text.type === 1));
        if (text.type === 1) {
            var auth = function () {
                document.cookie = 'ucid=' + text.ucid;
                window.location = "student.php";

            }
            auth();
        } else if (text.type === 2) {
            var profauth = function () {
                document.cookie = 'ucid=' + text.ucid;
                window.location = "prof.php";

            }
            profauth();
        }
    });

    return false;
}