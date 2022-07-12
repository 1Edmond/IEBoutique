document.getElementById("Inscription").addEventListener("submit", function(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    var data = new FormData(this);
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            console.log(this.response);
            var res = this.response;
            if(res.success){
                
            }
            else{
                // Affectation des champs aux label ;
            }
        }
        else if(this.readyState == 4)
            alert("Une erreur est survenue...");
    }
    xhr.open("POST","", true);
    xhr.send(data);
    return false;
});