//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateFormEliminaAuto();
});

function isNumber(value){
    try{
        if(isNaN(value)){
            return false;
        }
        return true;
    }
    catch(error){
        console.log("An error occurred: ", error.message);
    }
}

function validateFormEliminaAuto(){
    let form = document.getElementById('eliminaAutoFormAdmin');
    if(form){
        form.addEventListener('submit', function (event){
            let div = document.getElementsByClassName("form_errors")[2];
            div.innerHTML = "";
            let msg = "";
            let ok = true;
            if(!validateAuto()){
                msg+="<p>L'auto non è valida.</p>";
                ok = false;
            }
            if(!validateEmptyAuto()){
                msg+="<p>Selezionare un'auto da eliminare.</p>";
                ok = false;
            }
            if(!ok){
                div.innerHTML += msg;
                event.preventDefault();
            }
        });
    }
}

function validateEmptyAuto(){
    var auto = document.getElementById("eliminaAutoAdmin").value;
    if(auto == ""){
        return false;
    }
    return true;
}

function validateAuto(){
    var auto = document.getElementById("eliminaAutoAdmin").value;
    const validChars = /^[A-Za-z0-9\-\s]+$/;
    if(auto.split("-")[0] != "" &&  (!validChars.test(auto) || !isNumber(auto.split("-")[0]))){
        return false;
    }
    return true;
}

