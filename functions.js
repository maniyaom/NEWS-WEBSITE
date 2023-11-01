function showHidePassword(elementId){
    let element = document.getElementById(elementId);
    if(element.children[0].type === "password"){
        element.children[0].type = "text";
        element.children[1].setAttribute("style","display : none");
        element.children[2].setAttribute("style","display : block");
    }
    else{
        element.children[0].type = "password";
        element.children[1].setAttribute("style","display : block");
        element.children[2].setAttribute("style","display : none");
    }
}