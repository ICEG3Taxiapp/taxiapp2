
<?php
	include "tableaccess.php";
	$driver_id = $_SESSION['userId'];
	$driver_name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <script type="text/javascript" src="js/Functions.js"></script>
    <title>Taxi-app Driver Home</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="css/simple-sidebar.css" rel="stylesheet">


<script type="text/javascript">

  
  function loadAvailableRequests(){
	document.getElementById("content").innerHTML='<object type="text/html" data="availableHires.php" style="width:1000px; height:3000px; overflow:auto;border:5px  "></object>';
  }	
  
   function loadMyHires(){
	document.getElementById("content").innerHTML='<object type="text/html" data="myHires.php" style="width:1000px; height:3000px; overflow:auto;border:5px  "></object>';
  }	
  
</script>

  </head>

  <body>
	  

    <!-- Fixed navbar -->
   <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <img src="Images/taxilogo.png"  height="50" width="50">
          <a class="navbar-brand" href="#">Taxi-App</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>

          </ul>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="footer.php">
            <button type="submit" class="btn btn-danger">Sign Out</button>
          </form>
          
          <!--form class="navbar-form navbar-right" action="CallFunction.php" method ="post" >
				<input type="hidden" name="driver_id" value="<?=$driver_id?>" />
				<a><font color="white">Availability</font></a> 
				<input type="submit" class="btn btn-danger" value = "<?php echo getAvailability($GLOBALS["driver_id"]) ?>"/>
          </form-->
          
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    
     <div id="wrapper">
		 
    <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav" style="padding-top:60px;">
				<li>
                    <a href="#"  onclick="loadMyHires()">My Hires</a>
                </li>
                <li>
                    <a href="#" onclick="loadAvailableRequests()">Hire Requests</a>
                </li>
                <li>
                    <a href="#"  onclick="">inbox</a>
                </li>
			</ul>
		</div>
	</div>
    <!-- sidebar end -->
    
     <div id="page-content-wrapper" style="padding-left:150px;">
		<div id ="content" style="padding-left:0px;">
			<object type="text/html" data="MyHires.php"  style="width:1000px; height:3000px; overflow:auto;border:5px "></object>
		</div>
	</div>
 


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
  </body>
</html>




