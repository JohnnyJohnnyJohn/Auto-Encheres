<?php extract($data['annonce']); ?>

<main class="container my-5 py-5">
    <div class="row">
        <div class="col mt-3">
            <div class="card text-bg-dark bg-gradient border-0 shadow">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="imgs/<?= $photo; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-7 d-flex flex-column">
                        <div class="card-header border-0 bg-gradient fs-1 fw-semibold">
                            <?= $titre_annonce; ?>
                        </div>
                        <div class="position-relative card-body border-0">
                            <div class="card-text table-responsive">
                                <table class="table table-sm table-dark table-striped table-hover table-borderless">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Description</th>
                                            <td>
                                                <?= $description; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Marque</th>
                                            <td>
                                                <?= $marque; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Modèle</th>
                                            <td>
                                                <?= $modele; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Année</th>
                                            <td>
                                                <?= $annee; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Puissance</th>
                                            <td>
                                                <?= $puissance; ?> CH
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Prix de départ</th>
                                            <td>
                                                <?= $outil->formalizeEuro($prix_depart); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p id="derniereEnchere" class="badge text-bg-primary bg-gradient fs-5">
                                <?php if(empty($data['enchere'])) { ?>
                                Aucune enchère pour l'instant</p><br>
                                <p id="infosDerniereEnchere" class="badge text-bg-dark bg-gradient fs-6 d-none"><?php } else { extract($data['enchere']); ?>
                                Dernière enchère : <?= $montant; ?> €</p><br>
                                <p id="infosDerniereEnchere" class="badge text-bg-dark bg-gradient fs-6">Émise par <?= $prenom . ' ' . $nom; ?> le <?= $outil->formalizeDate($date); ?>
                                <?php } ?></p>
                            <p class="text-white mb-1 me-3 px-1 position-absolute bottom-0 end-0">Fin de l'enchère :
                                <?= $outil->formalizeDate($date_fin_enchere); ?>
                            </p>
                        </div>
                        <div class="card-footer border-0 d-flex justify-content-end gap-2">
                            <a href="/" class="btn btn-dark bg-gradient">Retour aux annonces</a>
                            <?php if(isset($_SESSION['username'])) { ?>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary bg-gradient" data-bs-toggle="modal" data-bs-target="#enchereModal">
                                    Enchérir
                                </button>
                            <?php } else { ?>
                                <a href="/?display=login&redirect=<?= $uid_annonce; ?>" class="btn btn-primary bg-gradient">Se connecter et placer une enchère</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php if(isset($_SESSION['username'])) { if(empty($data['enchere'])) { $minEnchere = $prix_depart + 1; } else { $minEnchere = $montant + 1; } ?>
<!-- Modal -->
<div class="modal fade" id="enchereModal" tabindex="-1" aria-labelledby="enchereModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="enchereForm">
            <div class="modal-content text-bg-dark bg-gradient" data-bs-theme="dark">
                <div class="modal-header text-bg-primary bg-gradient border-0">
                    <h1 class="modal-title fs-5" id="enchereModalLabel">Faites vos jeux</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border-0">
                    <div class="input-group">
                        <input type="hidden" name="uid_utilisateur" value="<?= $_SESSION['uid']; ?>">
                        <input type="hidden" name="uid_annonce" value="<?= $_GET['annonce']; ?>">
                        <input type="hidden" name="date" value="<?= time(); ?>">
                        <span class="input-group-text bg-gradient text-white">Montant de l'enchère :</span>
                        <input id="inputMontant" data-minenchere="<?= $minEnchere; ?>" type="number" class="form-control bg-gradient text-white" name="montant" value="<?= $minEnchere; ?>" min="<?= $minEnchere; ?>" aria-label="Montant">
                        <span class="input-group-text bg-gradient text-white"> €</span>
                        
                    </div>
                    <div id="invalidEnchere" class="d-none badge text-bg-danger bg-gradient">
                        Entrez un nombre supérieur ou égal à <?= $minEnchere; ?>.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark bg-gradient" data-bs-dismiss="modal">Annuler</button>
                    <button id="enchereSubmit" type="button" class="btn btn-primary bg-gradient">Placer enchère</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php } ?>