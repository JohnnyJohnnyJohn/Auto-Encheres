<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        border-bottom-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: background 1s;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .error {
        background: rgba(222, 0, 0, .8) !important;
    }
</style>

<main class="form-signin w-100 m-auto border text-center text-bg-dark bg-gradient shadow">
    <form autocomplete="off">
    <a href="/">
            <img src="imgs/logo.png" class="my-2" alt="" width="150">
        </a>
        <h1 class="h3 mb-3 fw-normal">Veuillez vous connecter</h1>

        <div class="form-floating">
            <input type="email" class="form-control ps-4" id="login" placeholder="name@example.com">
            <label class="ps-4 text-secondary" for="login">Adresse mail</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control ps-4" id="password" placeholder="Password">
            <label class="ps-4 text-secondary" for="password">Mot de passe</label>
        </div>

        <button id="loginBtn" data-redirect="<?php if (isset($_GET['redirect'])) { echo $_GET['redirect']; } ; ?>" class="w-100 btn btn-lg btn-dark bg-gradient mb-2" type="button">Se connecter</button>
        <p class="mb-0">Vous n'avez pas de compte?</p>
        <a href="/?display=register<?php if (isset($_GET['redirect'])) { echo "&redirect=" . $_GET['redirect']; } ; ?>" class="badge text-bg-primary bg-gradient text-decoration-none">Cliquez ici pour vous inscrire</a>
    </form>
</main>

<script src="js/md5.min.js"></script>
