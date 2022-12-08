<html>
<head>
	<title>Requête PGSQL</title>
	<style>
		table ,th ,td {
		   border-collapse: collapse;
		   border: 1px solid black;
		   padding: 5px;
		}
	</style>
</head>
<body>
	<?php
		if(isset($_POST['valider'])){
			$dept = $_POST['dept'];
			echo '<h1>Les parcs éoliens du département '.$dept.' :</h1>';
			try {
				$user = "sigma22";
				$pass = "6tA8ZBAzjE4GJT44";
				$dbh = new PDO('pgsql:host=193.55.175.126;port=2002;dbname=sigma22', $user, $pass);
				$stmt = $dbh->prepare("SELECT * FROM toulouse);
				$stmt->bindParam('dept', $dept);
				$stmt->execute();
				$lignes = $stmt->fetchAll();

				if (count($lignes) == 0) {
					echo "<p>Pas de réponse !</p>";
				}
				echo "<table><tr><th>ID</th><th>Nom</th><th>Exploitant</th><th>État</th></tr>";
				foreach($lignes as $ligne) {
					echo '<tr>';
					echo '<td>'.$ligne['id_parc'].'</td>';
					echo '<td>'.$ligne['nom_parc'].'</td>';
					echo '<td>'.$ligne['exploitant'].'</td>';
					echo '<td>'.$ligne['etat_parc'].'</td>';
					echo '</tr>';
				}
				echo "</table>";
				echo '<br>Source : RTE Occitanie, 2020';
				
				$dbh = null; //Pour éviter une fuite mémoire, on vide l'objet de connexion.
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
		} else {
			echo '<h2>Les parcs éoliens d\'Occitanie</h2>';
			echo '<form name="inscription" method="post" action="formulaire_pgsql.php">';
			echo '    Entrez le code du département recherché : <input type="text" name="dept"/><br/>';
			echo '    <input type="submit" name="valider" value="OK"/>';
			echo '</form>';
		}
	?>
</body>
</html>