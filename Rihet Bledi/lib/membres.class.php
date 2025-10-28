<?php
 class Membre{
	public   $id;
	public   $pseudo;
	public   $email;
	public   $adresse;
	public   $pays;
	
	private  $serveur     = '',
			$bdd         = '',
             $identifiant = '',
             $mdp         = '',
		     $cnx         = '';
/* Constructeur de la classe*/ 
    public function __construct($serveur='localhost', $bdd='inscription' , $identifiant='root' , $mdp='' ){
        $this->serveur     = $serveur;
        $this->bdd         = $bdd;
        $this->identifiant = $identifiant;
        $this->mdp         = $mdp;
        try{
			$this->cnx = new PDO('mysql:host='.$this->serveur .';dbname='.$this->bdd, $this->identifiant, $this->mdp);
			} 
		catch (PDOException $e){
			print "Erreur ! :" . $e->getMessage() . "<br/>";
			die();
		} 
    }
// A compléter
	function Ajouter(){
		$sql="insert into membres(id,pseudo,email,adresse,pays) 
							values('',
							'$this->pseudo',
							'$this->email',
							'$this->adresse',
							'$this->pays'
							)";
		$res=$this->cnx->exec($sql);// MAJ (insert,update,delete)
		if($res) return true;
		else return false; 
	}
	function Modifier(){
		$sql="update membres set pseudo='$this->pseudo',email='$this->email',
		adresse='$this->adresse',pays='$this->pays' where id=$this->id";
		$res=$this->cnx->exec($sql);// MAJ (insert,update,delete)
		if($res) return true;
		else return false; 
	}
	function Afficher(){
		$sql="select * from membres order by pseudo ";
		$membres=$this->cnx->query($sql);
		$membres->setFetchMode(PDO::FETCH_ASSOC);
		if($membres){
     	echo '<table  border-"1" cellspacing="0" style="width:650px; margin:auto;">';
		echo'<tr>
				<th>ID</th>
				<th>Pseudo</th>
				<th>Email</th>
				<th>Adresse</th>
				<th>Pays</th>
			</tr>';
	 	foreach($membres as $membre):
			echo'<tr>'; 
				echo '<td>'.$membre['id'].'</td>';
				echo '<td>'.$membre['pseudo'].'</td>';
				echo '<td>'.$membre['email'].'</td>';
				echo '<td>'.$membre['adresse'].'</td>';
				echo '<td>'.$membre['pays'].'</td>';
			echo '</tr>';
	 	endforeach;
	 	echo'</table>';
		}
		else print 'Table vide ';
	}
	
	function Afficher_Toggle(){
		$sql="select * from membres order by pseudo ";
		$membres=$this->cnx->query($sql);
		$membres->setFetchMode(PDO::FETCH_ASSOC);
		if($membres){
     	echo '<ul>';
		
	 	foreach($membres as $membre):
			echo'<li>'.$membre['pseudo'].'</li>'; 
			echo '<div class="detail" id="'.$membre['id'].'">Details</div>';
			echo '<div id="detail_'.$membre['id'].'" style="display:none;">Email :'.$membre['email'].'
				<br />Adresse : '.$membre['adresse'].' <br />Pays : '.$membre['pays'].' </div>';	
			
	 	endforeach;
	 	echo'</ul>';
		}
		else print 'Table vide ';
	}
	
	function Afficher_Accordillion(){
		$sql="select * from membres order by pseudo ";
		$membres=$this->cnx->query($sql);
		$membres->setFetchMode(PDO::FETCH_ASSOC);
		if($membres){
     	echo '<ul id="paragraphe">';
		
	 	foreach($membres as $membre):
			echo'<li>';
				echo '<h2>'.$membre['pseudo'].'</h2>'; 
				echo '<span>+</span>'; 
				echo '<p>ID : '.$membre['id'].'</p>';
				echo '<p>Email : '.$membre['email'].'</p>';
				echo '<p>Adresse : '.$membre['adresse'].'</p>';
				echo '<p>Pays : '.$membre['pays'].'</p>';
			echo '</li>';
	 	endforeach;
	 	echo'</ul>';
		}
		else print 'Table vide ';
	}
	
  
	
	function Afficher_Accordillion2(){
		$sql="select * from membres order by pseudo ";
		$membres=$this->cnx->query($sql);
		$membres->setFetchMode(PDO::FETCH_ASSOC);
		if($membres){
     	echo '<div id="accordion" style="width:600px; margin:auto;">';
		
	 	foreach($membres as $membre):
			
				echo '<h3>'.$membre['pseudo'].'</h3>'; 
				echo '<div>'; 
				echo '<p>ID : '.$membre['id'].'</p>';
				echo '<p>Email : '.$membre['email'].'</p>';
				echo '<p>Adresse : '.$membre['adresse'].'</p>';
				echo '<p>Pays : '.$membre['pays'].'</p>';
				echo '</div>'; 
		
	 	endforeach;
	 	echo'</div>';
		}
		else print 'Table vide ';
	}
}
?>