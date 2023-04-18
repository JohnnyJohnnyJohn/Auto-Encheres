<?php

namespace SYRADEV\AutoEncheres\Controllers;

// On utilisera ici la classe de manipulation de la base de données PdoDb.
use SYRADEV\AutoEncheres\Utils\Database\PdoDb;
use SYRADEV\AutoEncheres\Models\UtilisateursModel;

/*
 *  Classe de gestion des annonces étendue depuis la classe Controller.
 */
class Utilisateurs extends Controller
{


    /*
    * Affiche le formulaire de login.
    */
    public function getName($uid_utilisateur): array|string
    {
        return PdoDb::getInstance()->requete('SELECT `nom`, `prenom` FROM `utilisateurs` WHERE `uid_utilisateur` = ' . $uid_utilisateur, 'fetch');
    }

    /*
    * Affiche le formulaire de login.
    */
    public function authDisplay(): array|string
    {
        return $this->render('layouts.default', 'templates.login');
    }

    /*
    * Affiche le formulaire d'inscription.
    */
    public function registerDisplay(): array|string
    {
        return $this->render('layouts.default', 'templates.register');
    }

    public function login($usernameEncode, $hashEncode): array|string
    {
        $connected = false;

        $username = base64_decode($usernameEncode);
        $password = base64_decode($hashEncode);

        // Requete de type SELECT * sur la table utilisateurs.
        $sql = 'SELECT * FROM `utilisateurs`';

        // Exécution de la requête
        $utilisateurs = PdoDb::getInstance()->requete($sql);

        foreach ($utilisateurs as $user) {
            if ($user['email'] === $username && $user['password'] === $password) {
                
                $_SESSION['username'] = $user['email'];
                $_SESSION['uid'] = $user['uid_utilisateur'];
                return json_encode([
                    'status' => 200,
                    'action' => 'cnx',
                    'connected' => true
                ]);
            }
        }
        return json_encode([
            'status' => 401,
            'action' => 'cnx',
            'connected' => false
        ]);
    }

    public function register($registerInfosEncode): array|string
    {
        $registerInfos = [
            'nom' => base64_decode($registerInfosEncode->nom),
            'prenom' => base64_decode($registerInfosEncode->prenom),
            'email' => base64_decode($registerInfosEncode->username),
            'password' => base64_decode($registerInfosEncode->hash)
        ];

        // Requete de type SELECT * sur la table utilisateurs.
        $sql = 'SELECT * FROM `utilisateurs`';
        $cnx = PdoDb::getInstance();

        // Exécution de la requête
        $utilisateurs = $cnx->requete($sql);

        foreach ($utilisateurs as $user) {
            if ($user['email'] === $registerInfos['email']){
                return json_encode([
                    'action' => 'cnx',
                    'registered' => false
                ]);
            }
        }

        $success = $cnx->inserer("utilisateurs", new UtilisateursModel($registerInfos));

        if($success) {
            $_SESSION['username'] = $registerInfos['email'];

            $idUser = $cnx->requete('SELECT `uid_utilisateur` FROM `utilisateurs` WHERE `email` = "' . $registerInfos['email'] . '"', 'fetch');
            $_SESSION['uid'] = $idUser['uid_utilisateur'];
        }

        return json_encode([
            'action' => 'cnx',
            'registered' => $success
        ]);
    }

    public function logout(): array|string
    {
        session_unset();
        session_destroy();
        return json_encode([
            'status' => 200,
            'action' => 'cnx',
            'disconnected' => true
        ]);
    }

}