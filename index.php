<?php

// Toutes les fois où on doit faire un choix, on le met en aléatoire (choix du personnage, choix de la difficulté, deviner si le nombre de billes est pair
// ou impair, pareil pour le bonus on rend le choix aléatoire)


// la première chose qu'on veut avoir c'est une classe jeu
//             On va devoir créer les héros
//             Choix du héros (aléatoire)
//             Choix de la difficulté (aléatoire)
//             On va devoir créer les ennemis
//             On va devoir gérer les rencontres
//             On va avoir une méthode qui lance les combats
//             On va avoir une méthode qui permet de rejouer 


// On peut créer les ennemis et les héros avec des boucles 

// ce qui va revenir souvent, c'est le choix
// à chaque fois il y'aura un chiffre aléatoire à générer


// donc on peut faire une class (on appelle ça une classe utils) (cette class sera abstraite)
//             On va avoir une méthode qui va s'appeler "generateRandomNumber" qui va générer un chiffre aléatoire  (on va la rendre static) (utils::generate...)


// on veut une classe héros
//             On va avoir un bonus
//             On va avoir un malus
//             Il peut choisir si il triche ou pas (public)
//             Il va choisir pair ou impair (aléatoire) (public) (la méthode du dessous sera appelé par celle ci)
//             On vérifie si il a gagné ou perdu (check si pair ou impair, true or false) (private)


// on veut une classe ennemi
//             On va avoir un age



// On veut une classe caractère avec les points communs des héros et des ennemis (abstrait)
//             On va avoir le nom
//             On va avoir le nombre de billes
//             Les deux vont gagner et perdre (l'ennemi quand il gagne il double ses billes)




// Ici on créé la class Utils qui va nous permettre de générer un nombre aléatoire à chaque fois qu'on en aua besoin (notamment pour le choix du héros, le pair ou impair, de la difficulté, etc...)
abstract class Utils {
    public static function generateRandomNumber($min, $max) {   // On met la fonction en public pour pouvoir la réutiliser partout dans le code
        return rand($min, $max);
    }
}

// Ici on créé la class Game qui va nous permettre de gérer toute la logique du jeu
class Game {

    // Création de nos propriétés qu'on va utiliser dans notre class Game
    private $heros;
    private $ennemis = [];
    // on fait un tableau ici qui va stocker les difficultés
    private $difficulte = [
        "Facile" => 5,
        "Difficile" => 10,
        "Impossible" => 20
    ];
    private $aleatoireNumber;

    // Ici j'ai mis des getters et des setters au cas où j'aurai besoin de les utiliser
    public function getHeros() {
        return $this->heros;
    }

    public function setHeros($heros) {
        $this->heros = $heros;
    }

    public function getEnnemis() {
        return $this->ennemis;
    }

    public function setEnnemis($ennemis) {
        $this->ennemis = $ennemis;
    }

    public function getDifficulte() {
        return $this->difficulte;
    }

    public function setDifficulte($difficulte) {
        $this->difficulte = $difficulte;
    }

// Ici je fais ma fonction pour générer une difficulté au hasard
    public function choixDifficulte(){
        // La je vais générer un chiffre à alétoire entre 0 et 2 puisqu'on a 3 difficultés
        $aleatoireNumber = Utils::generateRandomNumber(0, 2);
        // La je recupère les clés de mon tableau difficulté c'est à dire "Facile", "Difficile" et "Impossible"
        $keys = array_keys($this->difficulte);
        // La je prend la difficulté qui correspond à la clé aléatoire générée
        $difficulteChoisie = $keys[$aleatoireNumber];
        // je récupère ici le nombre de manches qui correpsond à la difficulté choisie
        $nombreManches = $this->difficulte[$difficulteChoisie];
        // je retourne tout ça dans ce tableau
        return [
            'nombreManches' => $nombreManches,
            'difficulte' => $difficulteChoisie
        ];
    }

// Je fais cette fonction qui va stocker toutes les fonctions nécessaires au lancement du jeu
    public function startGame(){
        $this->createHeros();
        $this->choixDifficulte();
        $this->createEnnemi();
        $this->aleatoireEnnemi();
    }

    // Ici je fais mon constructeur qui va lancer le jeu grâce à la fonction startGame juste au dessus
    public function __construct() {
        $this->startGame(); 
    }

    // Là je créé mes 3 héros avec les propriétés qui ont été donné dans la consigne, donc le nom, le nombre de billes, le bonus et le malus
    public function createHeros (){
        $herosDispo = [
            new Heros("Seong Gi-hun", 15, 1, 2),
            new Heros("Kang Sae-byeok", 25, 2, 1),
            new Heros("Cho Sang-woo", 35, 3, 0)
        ];

        //Ensuite on veut choisir le héros au hasard donc je génère un chiffre entre 0 et 2 (puisqu'on a 3 héros) 
        $aleatoireNumber = Utils::generateRandomNumber(0, 2);
        // Ensuite je récupère le héros qui correspond à la clé aléatoire générée
        $herosChoisi = $herosDispo[$aleatoireNumber];
        // et enfin je stocke le héros dans la propriété heros
        $this->heros = $herosChoisi;
        // Et après on fait un echo pour dire quel héros a été choisi
        echo "Vous avez choisi le héros " . $herosChoisi->getNom() . " qui a " . $herosChoisi->getBilles() . " billes.";
        echo "<br>";
    }


// Maintenant on attaque la création des ennemis
    public function createEnnemi(){
        // je fais un tableau avec 20 prenoms
        $nomEnnemi = ["Hermione", "Antoine", "Dimitri", "Leo", "Louca", "Alyssia", "Timothée", "Yanni", "Leora", "Fiona", "Aurore", "Annam", "Allia", "Philippe", "Joshua", "Clement", "Carla", "Elodie", "Nina", "Noah"];
        // Et là je dis que pour chaque noms du tableau, on lui donne un nombre de billes aléatoire et un age aléatoire (on part du principe qu'ils sont majeurs)
        foreach ($nomEnnemi as $nom){
            $billes = Utils::generateRandomNumber(1, 20);
            $age = Utils::generateRandomNumber(18, 100);
            // Et ensuite on stocke tout ça dans le tableau ennemis
            $this->ennemis[] = new Ennemi($nom, $billes, $age);
        }
    }

// Je fais une fonction séparée pour sélectionner les ennemis aléatoirement 
    public function aleatoireEnnemi(){
        // On stocke dans la propriété aleatoireNumber un chiffre aléatoire entre 0 et le nombre d'ennemis qu'il reste (0 - (20-1))
        $this->aleatoireNumber = Utils::generateRandomNumber(0, count($this->ennemis) - 1);
        // on récupère l'ennemi correspondant et on le stocke dans la variable ennemiChoisi
        $ennemiChoisi = $this->ennemis[$this->aleatoireNumber];
        return $ennemiChoisi;
    }
    

// Maintenant on fait une grosse fonction qui va gérer les rencontres entre le héros et les ennemis
    public function rencontre(){
        // On comment par faire un echo du nombre de billes qu'on a
        echo "Vous avez actuellement " . $this->heros->getBilles() . " billes.";
        echo "<br>";
        // On execute la fonction aleatoireEnnemi pour récupérer un ennemi aléatoire
        $adversaire = $this->aleatoireEnnemi();
        // On fait un echo pour dire de quel ennemi il s'agit et on donne des infos sur lui (nom, nombre de billes et age)
        echo "Vous avez rencontré " . $adversaire->getNom() . " qui a " . $adversaire->getBilles() . " billes et qui a " . $adversaire->getAge() . " ans.";
        echo "<br>";
        // Ensuite on execute la fonction PairOuImpair qui va nous permettre de choisir si on dit que le nombre de billes de l'ennemi est pair ou impair. 
        //Cette fonction est réalisé dans la class Heros en dessous
        $supposition = $this->heros->PairOuImpair();
        echo "Vous avez choisi " . $supposition . ".";
        echo "<br>";
        // On récupère le nombre de billes de l'adversaire et on regarde si il est pair ou impair
        $pair = $adversaire->getBilles() % 2 == 0;
        // On fait la condition qui dit si la supposition était égale à pair ET que le résultat était pair OU si la supposition était égale à impair ET que le résultat était impair
        if (($supposition == 'pair' && $pair) || ($supposition == 'impair' && !$pair)){
            // alors on va echo qu'on a gagné 
            echo "L'adversaire avait bien " . $adversaire->getBilles() . " billes, et vous avez dit que le nombre était " . $supposition . ". Vous avez gagné !";
            // On va mettre a jour le nombre de billes du héros avec ce calcul : nombre de billes du héros + bonus du héros + nombre de billes de l'adversaire
            $nouveauNombreDeBilles = $this->heros->getBilles() + $this->heros->getBonus() + $adversaire->getBilles();
            // On met à jour le nombre de billes du héros 
            $this->heros->setBilles($nouveauNombreDeBilles);
            echo "<br>";    
            echo "Vous avez désormais " . $this->heros->getBilles() . " billes.";
            // On retire l'ennemi du tableau ennemis en réutilisant la variable aleatoireNumber qui contient le chiffre aléatoire qui a été généré
            unset($this->ennemis[$this->aleatoireNumber]);
            // on réindexe le tableau pour éviter de faire des trous 
            $this->ennemis = array_values($this->ennemis);
        } else {
            // Sinon on echo qu'on a perdu
            echo "L'adversaire avait " . $adversaire->getBilles() . " billes, et vous avez dit que le nombre était " . $supposition . ". Vous avez perdu !";
            echo "<br>";
            // on met à jour le nombre de billes du héros avec ce calcul : nombre de billes du héros - malus du héros - nombre de billes de l'adversaire
            $nouveauNombreDeBilles = $this->heros->getBilles() - ($this->heros->getMalus() + $adversaire->getBilles());
            // on met à jour le nombre de billes du héros
            $this->heros->setBilles($nouveauNombreDeBilles);
            // Et si le héros n'a plus de billes
            if ($this->heros->getBilles() <= 0) {
                // alors on echo qu'il en a plus pour éviter de dire qu'il a -21 billes...
                echo "Vous n'avez plus de billes...";
            } else {
                // sinon on met à jour le nombre de billes des ennemis avec ce calcul : nombre de billes de l'ennemi fois 2
                $nouveauxNombreDeBillesEnnemi = $adversaire->getBilles() *2;
                $adversaire->setBilles($nouveauxNombreDeBillesEnnemi);
                // on echo le nombre de billes du héros
                echo "Vous avez désormais " . $this->heros->getBilles() . " billes.";
                echo "<br>";
                // On echo le nouveau nombre de billes de l'adversaire
                echo $adversaire->getNom() . " a désormais " . $adversaire->getBilles() . " billes.";
            }
        }
    }

}

// Ici on créé la class Caractere qui va nous permettre de gérer les points communs entre les héros et les ennemis
abstract class Caractere {
    // Donc les points communs qu'on a entre les héros et les ennemis c'est le nom et le nombre de billes
    private $nom;
    private $nbrBilles;

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
    public function getBilles() {
        return $this->nbrBilles;
    }

    public function setBilles($nbrBilles) {
        $this->nbrBilles = $nbrBilles;
    }

    public function __construct($nom, $nbrBilles) {
        $this->nom = $nom;
        $this->nbrBilles = $nbrBilles;
    }
}


// On fait la class heros qui va hériter de la class caractere
class Heros extends Caractere {
    
    // On va rajouter au héros le bonus et le malus
    private $bonus;
    private $malus;

    public function getBonus() {
        return $this->bonus;
    }

    public function setBonus($bonus) {
        $this->bonus = $bonus;
    }

    public function getMalus() {
        return $this->malus;
    }

// On va créer ici la fonction PairOuImpair qui va nous permettre de dire si le nombre de billes de l'ennemi est pair ou impair
    public function PairOuImpair() {
        // Ici on va retourner le reste de la division du nombre de billes du héros par 2 et si le reste est égal à 0 alors on retourne pair sinon on retourne impair
        return (Utils::generateRandomNumber(1, 2) % 2 == 0) ? 'pair' : 'impair';
    }

    // Enfin on fait le constructeur qui va nous permettre de créer le héros avec son nom, son nombre de billes, son bonus et son malus
    public function __construct($nom, $billes, $bonus, $malus) {
        parent::__construct($nom, $billes);
        $this->bonus = $bonus;
        $this->malus = $malus;

    }
}

// On fait la class ennemi qui va hériter de la class caractere
class Ennemi extends Caractere {
    // ici il nous reste juste à rajouter l'age
    private $age;

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }
// et donc on fait le constructeur qui va nous permettre de créer l'ennemi avec son nom, son nombre de billes et son age
    public function __construct ($nom, $billes, $age) {
        parent::__construct($nom, $billes);
        $this->age = $age;
    }

}
// On lance le jeu
$game = new Game();
// On récupère la difficulté
$difficulte = $game->choixDifficulte();
// On echo la difficulté
echo "Vous avez choisi le niveau " . $difficulte['difficulte'] . ".";
echo "<br>";    
// on fait une boucle pour faire tourner les manches jusqu'à ce que le nombre de manches soit atteint (qui est défini)
for ($i = 0; $i < $difficulte['nombreManches']; $i++) {
    echo "<br>";
    echo "Vous êtes à la manche " . ($i + 1) . " sur " . $difficulte['nombreManches'] . ".";
    echo "<br>";
    // On lance la rencontre 
    $game->rencontre();

    // je vérifie si le héros a perdu
    if ($game->getHeros()->getBilles() <= 0) {
        echo "<br>Vous avez perdu !";
        break;
    }

    // je vérifie si c'est la dernière manche et que le héros a encore des billes
    if (($i == $difficulte['nombreManches'] - 1) && ($game->getHeros()->getBilles() > 0)) {
        echo "<br>Vous avez gagné !";
        break;
    }
    echo "<br>";
}

?>