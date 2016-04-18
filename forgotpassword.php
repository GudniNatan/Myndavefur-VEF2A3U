<?php
    //Starts session and checks timeout
	require_once './includes/session_timeout.php';
	require_once './includes/dbcon.php';
	if (isset($_SESSION['username'])) {
		header("Location: userpage.php");
	}
	require_once'./includes/formprocess.php'
 ?>
<?php include'./includes/title.php';?>
<!DOCTYPE html>
<?php  include("./includes/head.php");?>
<body>
    <?php include("./includes/header.php") ?>
    <?php include("./includes/menu.php") ?>
<div class="containall">
    <main>
    <?php if (!isset($_POST['username']) && !isset($_SESSION['valid'])): ?>
	    	<form class="form-group" id="usernameinput">
    			<p class="warning" style="display: none;" id="wronguser">Wrong username</p>
	    		<label>Fylltu inn notendanafn</label>
	        	<p for="username">Notendanafn:
				<?php if ($missing && in_array('username', $missing)) { ?>
				<span class="warning">Filla þarf út þennan reit</span>
				<?php } ?>
				</p>
	           	<input type="text" style="color: black" name="username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" id="username">
    	     	<button name="sendusername" id="sendusername" type="submit">Senda</button>
	        </form>
	        <div id="questions">
	        	
	        </div>
    <?php endif ?>
    </main>
</div>
<?php include("./includes/footer.php") ?>
    <script>
    	$(document).ready(function(){
    		$("#wronguser").hide();
		    $("#usernameinput").submit(function( event ) {
    			$("#wronguser").hide();
		    	var username = $("#username").val();
				jQuery.ajax({
			        url: 'checkusername.php',
			        type: 'POST',
			        data: {
			            username: username,
			        },
			        dataType : 'json',
			        success: function(data, textStatus, xhr) {
			            if (data == null) {
			            	$("#wronguser").show();
			            	console.log("Incorrect username");
			            }
			            else{
			            	$("#questions").load('./securityquestions.php');
			            	console.log("Correct username");
			            }
			        },
			        error: function(xhr, textStatus, errorThrown) {
			            console.log("Error");
			        }
			    });
			    
			    event.preventDefault();
		    });
		});
    </script>
</body>
</html>
