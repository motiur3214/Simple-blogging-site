<?php
include('navbar.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sample Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


	<link rel="stylesheet" type="text/css" href="mystyle.css">



</head>
<body >

	<div class="container-fluid ">
		<div class="row">
			<div class="col-sm-10" id="showAllStory" style="padding-right: 2%;">
				
			</div>
			
			<div class="col-sm-2">


				<div id="selectSection"></div>



			</div>

		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src=https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js" integrity="sha256-vucLmrjdfi9YwjGY/3CQ7HnccFSS/XRS1M/3k/FDXJw=" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


		<script type="text/javascript">
			$(document).ready(function() 
			{

				
				storyDetails();
				storySection();
				$("#sectionSelection").select2();

			});
			

//Show All Story
function storyDetails(){

	$.ajax({  
		url:"backend_afterlogin.php",  
		method:"post",  
		data:{
			flagreq:'getAllStoryData',
			contentType: false,
			cache: false,
			processData: false,  
		},  

		success:function(data){  

			$('#showAllStory').html(data);  
			var maxLength = 300;
			$(".show-read-more").each(function() {
				var myStr = $(this).text();
				if ($.trim(myStr).length > maxLength) {
					var newStr = myStr.substring(0, maxLength);
					var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
					$(this).empty().html(newStr);
					$(this).append(' <p class="read-more">read more...</p>');
					
				}
			});

			$('#showAllStoryForComment').DataTable(
			{
				"lengthChange": false,
				"ordering": false,
				"bInfo" : false,
				"searching": false,
				"pageLength": 9,
			}); 

		}
		
	});
};

//DETAILS SHOWINGS
$(document).on('click','.showForComment', function(){  
	{

		var id=$(this).attr("id");
		window.open( "view-story?storyNo="+id,'_blank');
		
	}
});

//get section data
function storySection(){

	$.ajax({  
		url:"backend_afterlogin.php",  
		method:"post",  
		data:{
			flagreq:'getAllSectionData',
			contentType: false,
			cache: false,
			processData: false,  
		},  

		success:function(data){  

			$('#selectSection').html(data);  
			$("#sectionSelection").select2();
			
		}
	});
};

//Get selected Section Story

function selectedSection() {
	var sectionId=document.getElementById('sectionSelection').value;

	$.ajax({  
		url:"backend_afterlogin.php",  
		method:"post",  
		data:{
			flagreq:'getSelectedStory',
			sectionId:sectionId,
			contentType: false,
			cache: false,
			processData: false,  
		},  

		success:function(data){  
			
			$('#showAllStory').html(data);  
			var maxLength = 300;
			$(".show-read-more").each(function() {
				var myStr = $(this).text();
				if ($.trim(myStr).length > maxLength) {
					var newStr = myStr.substring(0, maxLength);
					var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
					$(this).empty().html(newStr);
					$(this).append(' <p class="read-more">read more...</p>');
					
				}
			});

			$('#sectionStory').DataTable(
			{
				"lengthChange": false,
				"ordering": false,
				"bInfo" : false,
				"searching": false,
				"pageLength": 9,
			}); 

		}
		
	});
};


function searchAction(){

	var search=document.getElementById('search').value;
	
	$.ajax({  
		url:"backend_afterlogin.php",  
		method:"post",  
		data:{
			flagreq:'getSearchResult',
			search:search,
			contentType: false,
			cache: false,
			processData: false,  
		}, 
		success:function(data)
		{    $('#showAllStory').html(data);  
		document.getElementById("search").value=' ';
		var maxLength = 300;
		$(".show-read-more").each(function() {
			var myStr = $(this).text();
			if ($.trim(myStr).length > maxLength) {
				var newStr = myStr.substring(0, maxLength);
				var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
				$(this).empty().html(newStr);
				$(this).append(' <p class="read-more">read more...</p>');
				
			}
		});
		$('#searchTable').DataTable(
		{
			"lengthChange": false,
			"ordering": false,
			"bInfo" : false,
			"searching": false,
			"pageLength": 9,
		});
		
	}
});
}
</script>


</body>
</html>