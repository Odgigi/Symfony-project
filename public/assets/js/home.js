function resizeImage(cardImage,largeur)
{
    var prop = parseInt(document.getElementById(id).style.height)/parseInt(document.getElementById(id).style.width);
    var hauteur = largeur*prop;
    document.getElementById(id).style.height=hauteur+'px';
    document.getElementById(id).style.width=largeur+'px';
}


// function permut(){ var a=document.getElementsByTagName("img"); var x=a[0].src; a[0].src=a[1].src; a[1].src=a[2].src; a[2].src=x;}