<?php

namespace SYRADEV\AutoEncheres\Controllers;

// On utilisera ici la classe de manipulation de la base de données PdoDb.
use SYRADEV\AutoEncheres\Utils\Database\PdoDb;
use SYRADEV\AutoEncheres\Models\EncheresModel;

/*
 *  Classe de gestion des annonces étendue depuis la classe Controller.
 */
class Encheres extends Controller
{

    public function newEnchere($encheresInfos): bool
    {
        $cnx = PdoDb::getInstance();
        return $cnx->inserer("encheres", new EncheresModel($encheresInfos));
    }

}