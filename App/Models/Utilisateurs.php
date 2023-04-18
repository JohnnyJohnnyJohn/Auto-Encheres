<?php

namespace SYRADEV\AutoEncheres\Models;

/*
 * Modèle Utilisateurs
 */
class UtilisateursModel
{
    public string $nom;
    public string $prenom;
    public string $email;
    public string $password;

    public function __construct($userInfos) {
        $this->nom = utf8_encode($userInfos['nom']);
        $this->prenom = utf8_encode($userInfos['prenom']);
        $this->email = $userInfos['email'];
        $this->password = utf8_encode($userInfos['password']);
        return $this;
    }
}