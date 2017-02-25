window.onresize = function(){
	var clientWith = document.documentElement.clientWidth;
	if(clientWith<1064){
			$('#header_top').css('width',1064);
			$('#header').css('width',1064);
			//$('#content').css('width',1064);
			//$('#footer').css('width',1064);
			
	}else{
		    $('#header_top').css('width','auto');
			$('#header').css('width','auto');
			//$('#content').css('width',clientWith);
			//$('#footer').css('width','auto');
	}
	
	
	

};