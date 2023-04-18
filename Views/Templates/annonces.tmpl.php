<main class="container my-5 py-5">
    <div class="row">
        <div class="col">
            <h1 class="display-3 text-white mb-3">Liste des Annonces :</h1>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        <?php foreach ($data as $annonce) { extract($annonce); ?>
            <div class="col">
                <div class="card h-100 border-0 shadow">
                    <img src="imgs/<?= $photo; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?= $marque; ?><br><?= $modele; ?></h5>
                        <p class="card-text"><?= $description; ?></p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="/?annonce=<?= $uid_annonce; ?>" class="btn btn-primary bg-gradient px-5 float-end stretched-link">Détails</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</main>