<?php 
	$errors = "";
	
	$db = mysqli_connect('localhost', 'root', 'raspberry', 'todo');
	if(isset($_POST['submit'])){
		$task = $_POST['task'];
		if(empty($task)){
				$errors = "Inserisci qualcosa nel campo";
			} else {
				mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
				header('location: index.php');
				}
		}
		
		if(isset($_GET['del_task'])){
			$id = $_GET['del_task'];
			mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
			header('location: index.php');
			}
		
		$tasks = mysqli_query($db, "SELECT * FROM tasks");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cosa bisogna fare?</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" type="image/png" href="favicon.png"/>
	
	<script language="JavaScript">
function set_interval() {
  //the interval 'timer' is set as soon as the page loads  
  var timeoutMins = 1000 * 1 * 5; // 15 seconds
  var timeout1Mins = 1000 * 1 * 13; // 13 seconds
  itimer=setInterval("auto_logout()",timeoutMins);

}

function reset_interval() {
  var timeoutMins = 1000 * 1 * 15; // 15 seconds 
  var timeout1Mins = 1000 * 1 * 13; // 13 seconds
  //resets the timer. The timer is reset on each of the below events:
  // 1. mousemove   2. mouseclick   3. key press 4. scrolling
  //first step: clear the existing timer
  clearInterval(itimer);
  clearInterval(atimer);
  window.location.reload(false); 
  //second step: implement the timer again
  itimer=setInterval("auto_logout()",timeoutMins);
 
}


function auto_logout() {
  //this function will redirect the user to the logout script
  window.location.reload(true); 
}
</script>
	
</head>
<body onLoad="set_interval(); document.form1.exp_dat.focus();" onKeyPress="reset_interval();" onmousemove="reset_interval();" onclick="reset_interval();" onscroll="reset_interval();">
	<div class="header">
		<h2>Cosa bisogna fare?</h2>
	</div>
	<form method="POST" action="index.php">
		<?php if(isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
			<?php } ?>
		<input type="text" name="task" class="task_input">
		<button type="submit" class="add_btn" name="submit">Aggiungi Compito</button>
	</form>
	
	<table>
		<thead>
			<tr>
				<th>N</th>
				<th>Compito</th>
				<th>Azione</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
				
				<tr>
					<td><?php echo $i; ?></td>
					<td class="task"><?php echo $row['task']; ?></td>
					<td class="delete">
					<a href="index.php?del_task=<?php echo $row['id']; ?>">X</a>
				</td>
			</tr>
			
			<?php $i++; } ?>
			
		</tbody>
	</table>
	
</body>
</html>
