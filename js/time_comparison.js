//이벤트
    var Target = document.getElementById("clock");
    let interval = setInterval(clock, 1000); // 1초마다 실행

    function clock() {
        var time = new Date();
        var if_time = "2023-06-26 13:51:00";

        var year = time.getFullYear();
        var month = time.getMonth()+1;
        month = month >= 10 ? month : "0" + month;
        var date = time.getDate();
        date = date >= 10 ? date : "0" + date;

        var hours = time.getHours();
        var minutes = time.getMinutes();
        var seconds = time.getSeconds();

        var today = year+'-'+month+'-'+date+' '+ hours +":"+minutes+":"+seconds;
        var now = new Date(today).getTime();
        var if_day = new Date(if_time).getTime();

        //time comparison
        if(now >= if_day) {
            clearInterval(interval); //Stop to clock()
        }
    }
