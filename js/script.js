

function openMe(){
        console.log(event.target.src);
        overlay = document.querySelector(".overlay");
        overlayContent = document.querySelector(".overlay-content");
        console.log(overlayContent)
        img = document.createElement("img");
        if(event.target.tagName=="IMG"){
            img.src = event.target.src;
            //img.alt = "certificate"
            overlayContent.prepend(img)
            overlay.style.display="block";
        }
        else if(event.target.tagName=="SPAN"){
            overlayContent.removeChild(overlayContent.childNodes[0])
            overlay.style.display='none';
        }   
        else {
            
        }
}

