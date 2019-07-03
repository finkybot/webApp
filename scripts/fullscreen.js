function toggleFullscreen(elmt) 
{
	elmt = elmt || document.documentElement;
	
	if (!document.fullscreenElement && !document.mozFullScreenElement && 
			!document.webkitFullscreenElement && !document.msFullscreenElement)
	{
		if(elmt.webkitRequestFullscreen) {elmt.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);}	
		else if(elmt.requestFullscreen){elmt.requestFullscreen();} 
		else if(elmt.msRequestFullscreen){elmt.msRequestFullscreen();} 
		else if(elmt.mozRequestFullScreen){elmt.mozRequestFullScreen();} 
	} 
	else 
	{
		if (document.webkitExitFullscreen){document.webkitExitFullscreen();}
		else if (document.exitFullscreen){document.exitFullscreen();} 
		else if (document.msExitFullscreen){document.msExitFullscreen();}
		else if (document.mozCancelFullScreen){document.mozCancelFullScreen();}
	}
}

document.getElementById('toggleFullscreen').addEventListener('click', function(){toggleFullscreen();});

