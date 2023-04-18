<?php

namespace SYRADEV\AutoEncheres\Utils\Php;

use NumberFormatter;

final class Outils {

    private string $session_token_label = 'CSRF_TOKEN_SESS_IDX';
    private string $hashAlgo = 'sha3-512';
    private string $hmac_data = 'nL9BmHh3wg1aVgojcbJlWEyIKC00LvkJ';
    private string $domain = 'www.auto-encheres.org';
    private string $originating_url = 'https://www.auto-encheres.org/';
    private string $session_name = 'FetchUserSession';
    protected static self|null $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /***
     * Instancie l'objet Login
     * @return Outils *
     ***/
    public static function getInstance(): Outils
    {
        if (Outils::$instance === null) {
            Outils::$instance = new Outils;
        }
        return Outils::$instance;
    }

    /***
     * Initie une nouvelle session PHP si elle n'existe pas
     * @return void *
     ***/
    public function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            ini_set('session.name', $this->session_name);
            ini_set('session.use_cookies', true);
            ini_set('session.use_only_cookies', false);
            ini_set('session.use_strict_mode', true);
            ini_set('session.cookie_httponly', true);
            ini_set('session.cookie_secure', true);
            ini_set('session.cookie_samesite', 'Strict');
            ini_set('session.gc_maxlifetime', 3600);
            ini_set('session.cookie_lifetime', 3600);
            ini_set('session.use_trans_sid', true);
            ini_set('session.trans_sid_hosts', $this->domain);
            ini_set('session.referer_check', $this->originating_url);
            ini_set('session.cache_limiter', 'nocache');
            ini_set('session.sid_length', 128);
            ini_set('session.sid_bits_per_character', 6);
            ini_set('session.hash_function', $this->hashAlgo);
            session_start();
        }
    }

    /***
     * Protège l'accès à une page par session
     * @return void *
     ***/
    public function protectPage(): void
    {
        if(!isset($_SESSION['username']) || !isset($_SESSION['uid'])) {
            header('Location:login.php');
        }
    }

    /***
     * Génère un jeton CSRF
     * @return string *
     ***/
    public function generateCSRFToken(): string
    {
        if (empty($_SESSION[$this->session_token_label])) {
            $_SESSION[$this->session_token_label] = bin2hex(openssl_random_pseudo_bytes(256));
        }
        return hash_hmac($this->hashAlgo, $this->hmac_data, $_SESSION[$this->session_token_label]);
    }

    /***
     * Valide une requête avec le jeton CSRF
     * @return bool *
     ***/
    public function validateAjaxRequest(): bool
    {
        if (!isset($_SESSION[$this->session_token_label])) {
            return false;
        }
        $expected = hash_hmac($this->hashAlgo, $this->hmac_data, $_SESSION[$this->session_token_label]);
        $requestToken = $_SERVER['HTTP_X_CSRF_TOKEN'];
        return hash_equals($requestToken, $expected);
    }

    public function validatePostRequest(): bool
    {
        if (!isset($_SESSION[$this->session_token_label])) {
            return false;
        }

        $expected = hash_hmac($this->hashAlgo, $this->hmac_data, $_SESSION[$this->session_token_label]);
        $requestToken = $_POST['csrf_token'];

        return hash_equals($requestToken, $expected);
    }

    /***
     * Valide une requête ajax avec l'entête X_REQUESTED_WITH
     * @return bool *
     ***/
    public function ajaxCheck(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /***
     * Valide un domaine
     * @return bool *
     ***/
    public function domainCheck(): bool
    {
        $domain = $this->domain;
        return $_SERVER['HTTP_HOST'] === $domain && $_SERVER['SERVER_NAME'] === $domain;
    }

    /* Nettoie les données postées avant stockage */
    static public function cleanUpValues($allValues) {
        foreach ($allValues as $key => $value) {
            if (is_array($value)) {
                $allValues[$key] = self::cleanUpValues($value);
            } else {
                $allValues[$key] = addslashes(htmlspecialchars(trim(strip_tags($value))));
            }
        }
        return $allValues;
    }

    /* Fonction qui rend conforme (sans espace et en minuscule) une chaine */
    static public function sanitizeName($name): array|string|null
    {
        return strtolower(preg_replace('/\s+/', '', $name));
    }

    /* Fonction qui renvoie les segments de l'url courante */
    static public function getUriSegments(): array
    {
        return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    /* Fonction qui convertit un Timestamp en date française */
    static public function formalizeDate($timestamp): string
    {
        return date('d/m/Y', $timestamp) . ' à ' . date('H:i', $timestamp);
    }

    /* Fonction qui formatte un nombre en monnaie Euro */
    static public function formalizeEuro($montant): string
    {
        //$fmt = numfmt_create( 'fr_FR', NumberFormatter::CURRENCY );
        //return numfmt_format_currency($fmt, $montant, "EUR");
        return $montant . ' &euro;';
    }

}