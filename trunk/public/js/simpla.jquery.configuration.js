$(document).ready(function(){
		$('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows
   
   //Minimize Content Box
		
		//$(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
		//$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
		//$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
		
		$(".content-box-header h3").click( // When the h3 is clicked...
			function () {
			  $(this).parent().next().toggle(); // Toggle the Content Box
			  $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
			  $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			}
		);
});
  
  
  