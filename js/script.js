
// var cusorFire=document.getElementById("cusorFire");

// document.addEventListener("mousemove",function(e){

//     cusorFire.style.top=e.clientY +"px";
//     cusorFire.style.left=e.clientX+"px";

// });

var mainItem=Array.from(document.querySelectorAll(".main img"));
var lightboxContainer=document.getElementById("lightboxContainer");
var lightBoxItem= document.getElementById("lightBoxItem");
var next=document.getElementById("next");
var prev =document.getElementById("prev");
var close =document.getElementById("close");
var imgIndex=0;

for(var i=0;i<mainItem.length;i++){

    mainItem[i].addEventListener("click",function(eventinfo){

        
        lightboxContainer.style.display="flex";
        var imgSrc =eventinfo.target.getAttribute("src");
        console.log(eventinfo.target );
        lightBoxItem.style.backgroundImage="url("+imgSrc+")";
        imgIndex=mainItem.indexOf(eventinfo.target);
        
        console.log(imgIndex);
    

     

    })
}

function nextSlide(){
    imgIndex++;
    if(imgIndex== mainItem.length){
        imgIndex=0;
    }
    var imgSrc =mainItem[imgIndex].getAttribute("src");
    lightBoxItem.style.backgroundImage="url("+imgSrc+")";
    console.log(imgSrc);
    


}

function prevSlide(){
    imgIndex--;
    if(imgIndex== mainItem.length){
        imgIndex=0;
    }else if(imgIndex < 0){
        imgIndex=mainItem.length-1;
    }
    var imgSrc =mainItem[imgIndex].getAttribute("src");
    lightBoxItem.style.backgroundImage="url("+imgSrc+")";
    console.log(imgSrc);
    


}

function closeSlide(){
    lightboxContainer.style.display="none"

}
close.addEventListener("click", closeSlide);
prev.addEventListener("click",prevSlide);
next.addEventListener("click",nextSlide);

document.addEventListener("keydown",function(e){

    if(e.keyCode==39){
        nextSlide();
    }
});


document.addEventListener("keydown",function(e){

    if(e.keyCode==37){
        prevSlide();
    }
});


document.addEventListener("keydown",function(e){

    if(e.keyCode==27){
        closeSlide();
    }
});




