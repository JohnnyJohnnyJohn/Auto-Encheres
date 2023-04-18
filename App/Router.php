<?php

use SYRADEV\AutoEncheres\Controllers\Annonces;
use SYRADEV\AutoEncheres\Controllers\Utilisateurs;
use SYRADEV\AutoEncheres\Controllers\Encheres;
use SYRADEV\AutoEncheres\Utils\Php\Outils;



/*
 * Le routeur réceptionne des variables $_POST, $_GET ou AJAX fetch.
 * Son rôle unique sera de router l'application vers les contôleurs
 * qui  définissent la logique de l'application puis génèrerent les affichages.
 */

// On démarre le moteur de sessions PHP pour gérer les variables de $_SESSION.
$outil = Outils::getInstance();
$outil->startSession();

// On crée une variable qui mixte $_POST et $_GET
$_GP = array_merge($_POST, $_GET);

// var_dump($_GP);
// exit();


// On détecte les entrées get ou post pour router vers le contôleur ad hoc.
if(count($_GP)>0) {

    if(isset($_GP['login']) && $_GP['login'] === '1') {
        $utilisateur = new Utilisateurs;
        echo $utilisateur->login($_GP);
        exit();
    }

    if(isset($_GP['register']) && $_GP['register'] === '1') {
        $utilisateur = new Utilisateurs;
        echo $utilisateur->register($_GP);
        exit();
    }

    // Gestion des autres actions ci-dessous...

    if(isset($_GP['annonce'])) {
        $annonce = new Annonces;
        echo $annonce->show($_GP['annonce']);
        exit();
    }

    if(isset($_GP['enchereSubmit'])) {
        $enchere = new Encheres;
        $success = $enchere->newEnchere($_GP);
        if($success){
            $user = new Utilisateurs;
            $name = $user->getName($_GP['uid_utilisateur']);
            $date = $outil->formalizeDate($_GP['date']);
            echo json_encode(['success'=>true, 'nom'=>$name['nom'], 'prenom'=>$name['prenom'], 'date'=>$date]);
        }else {
            echo json_encode(['success'=>false]);
        }
        exit();
    }

    if(isset($_GP['display'])) {
        if($_GP['display'] === 'login') {
            $utilisateur = new Utilisateurs;
            echo $utilisateur->authDisplay();
            exit();
        } else if($_GP['display'] === 'register') {
            $utilisateur = new Utilisateurs;
            echo $utilisateur->registerDisplay();
            exit();
        }
    }
}


if ($outil->ajaxCheck()) {
    // echo 'ajaxCheck Ok';
    if ($outil->domainCheck()) {
        // echo 'domainCheck Ok';
        if ($outil->validateAjaxRequest()) {
            // echo 'validateAjaxRequest Ok';
            header("Cache-Control: no-store, no-transform, max-age=0, private");
            // On récupère et on convertit le flux JSON en tableau d'objets.
            $ajaxRequest = json_decode(file_get_contents('php://input'));

            if (isset($ajaxRequest) && !empty($ajaxRequest)) {
                if (isset($ajaxRequest->type) && isset($ajaxRequest->action) && $ajaxRequest->type === 'cnx') {
                    if ($ajaxRequest->action === 'connect') {
                        
                        $utilisateur = new Utilisateurs;
                        echo $utilisateur->login($ajaxRequest->username, $ajaxRequest->hash);
                        exit();
                    }
                    if ($ajaxRequest->action === 'disconnect') {
                        $utilisateur = new Utilisateurs;
                        echo $utilisateur->logout();
                        exit();
                    }
                    if ($ajaxRequest->action === 'register') {
                        $utilisateur = new Utilisateurs;
                        echo $utilisateur->register($ajaxRequest);
                        exit();
                    }
                }
            }
        }
    }
}


