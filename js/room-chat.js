// Login To Chat
let loginMsg = 1;
const xhttp = new XMLHttpRequest();
xhttp.open("GET", "chat/login-chat.php");
xhttp.send();

let logedChattersDOM = document.querySelector('.loged-chatters')
let logedChatters = [];
let aChatter, userText;
let isAlreadyIn = false;
let isOnline = false;
let i, j;

function reloadChatters() {    
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        logedChatters = JSON.parse(this.responseText);
        
        if(logedChattersDOM.children.length != 0) {
            for (i = 0; i < logedChatters.length; i++) {
                isAlreadyIn = false;
                for (j = 0; j < logedChattersDOM.children.length; j++) {
                    if(logedChattersDOM.children[j].id == logedChatters[i]["id"]) {
                        isAlreadyIn = true;
                    }
                }

                if(!isAlreadyIn) {
                    aChatter = document.createElement("div");
                    aChatter.classList.add("loged-chatters__login");
                    aChatter.classList.add(logedChatters[i]["login"]);
    
                    userText = logedChatters[i]["login"];
                    userText = userText.concat(" is <span class='loged-chatters__login-online'>Online</span>");
    
                    aChatter.id = logedChatters[i]["id"];
                    aChatter.innerHTML = userText;
                    logedChattersDOM.appendChild(aChatter);
                }
            }

            for (i = 0; i < logedChattersDOM.children.length; i++) {
                isOnline = false;

                for (j = 0; j < logedChatters.length; j++) {
                    if(logedChattersDOM.children[i].id == logedChatters[j]["id"]) {
                        isOnline = true;
                    }
                }
                if(!isOnline){
                    logedChattersDOM.removeChild(logedChattersDOM.childNodes[i]);
                }
            }
        } else {

            for (i = 0; i < logedChatters.length; i++) {
                aChatter = document.createElement("div");
                aChatter.classList.add("loged-chatters__login");
                aChatter.classList.add(logedChatters[i]["login"]);

                userText = logedChatters[i]["login"];
                userText = userText.concat(" is <span class='loged-chatters__login-online'>Online</span>");

                aChatter.id = logedChatters[i]["id"];
                aChatter.innerHTML = userText;
                logedChattersDOM.appendChild(aChatter);
            }
        }
    }
    xhttp.open("GET", "chat/reload-chatters.php");
    xhttp.send();
}

reloadChatters();
setInterval(function() {
    reloadChatters();
}, 1500)



// const xhttp = new XMLHttpRequest();
// xhttp.open("GET", "chat/load-chaters.php");
// xhttp.send();



// let numberChat = 0;
// let count = 0;
// const xhttp = new XMLHttpRequest();
// xhttp.onload = function() {
//     numberChat = JSON.parse(this.responseText);
//     count += numberChat;
//     console.log(count);
// }
// xhttp.open("GET", "chat/reload-chat.php");
// xhttp.send();

// setInterval(function() {
//     const xhttp = new XMLHttpRequest();
//     xhttp.onload = function() {
//         numberChat = JSON.parse(this.responseText);
//         count += numberChat;
//         console.log(count);
//     }
//     xhttp.open("GET", "chat/reload-chatters.php");
//     xhttp.send();
// }, 1500)