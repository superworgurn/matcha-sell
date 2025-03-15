// const username_input= document.getElementById("username")
// const password = document.getElementById("password")
// console.log(username_input);

// document.getElementById("submit-btn").addEventListener("click", function() {
//     alert("คุณคลิกปุ่มนี้โดยใช้ addEventListener!");
// });
const popup = document.getElementById("popup");
const poptittle = document.getElementById("popuptitle");
const popdetails = document.getElementById("popdetails");
const overlay = document.getElementById("overlay");

const checkuser = (username_input,password) =>{
    if(username_input === "" || password ===""){
        poptittle.innerText="ERROR";
        poptittle.style.color="red";
        popdetails.innerText="กรุณากรอกข้อมูล";
        popup.style.display="block";
        overlay.style.display="block";
    }else if (username_input != "admin" || password != "admin1234"){
        alert("ข้อมูลไม่ถูกต้อง");
        alert("Useradmin/Password admin1234");

        
    }else{
        poptittle.innerText="SUCCESS";
        poptittle.style.color="green";
        popdetails.innerText="welcome";
        popup.style.display="block";
        overlay.style.display="block";
    }
};

const login = () =>{
    const username_input = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    console.log("username" + username_input);
    console.log("password" + password);

    checkuser(username_input, password);

};

const closepopup = () =>{
    popup.style.display="none";
    overlay.style.display="none";
}




// const hello2 = () =>{
//     const password = document.getElementById("password").value;
//     console.log("Hello" + password);
// };