window.onload = () => {
    const d = document;

    const loginBtn = d.querySelector('#loginBtn');

    const logoutBtn = d.querySelector('#logoutBtn');

    const registerBtn = d.querySelector('#registerBtn');

    const nom = d.querySelector('#nom');

    const prenom = d.querySelector('#prenom');

    const login = d.querySelector('#login');

    const password = d.querySelector('#password');

    const form = d.querySelector('.form-signin');

    const enchereForm = d.querySelector('#enchereForm');

    const derniereEnchere = d.querySelector('#derniereEnchere');

    const infosDerniereEnchere = d.querySelector('#infosDerniereEnchere');

    const inputMontant = d.querySelector('#inputMontant');

    const invalidEnchere = d.querySelector('#invalidEnchere');

    const enchereSubmit = d.querySelector('#enchereSubmit');


    const ajaxHeaders = {
        'credentials': 'same-origin',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': d.querySelector('meta[name="csrf-token"]').content,
        'cache': 'no-cache',
        'Cache-Control': 'no-store, no-transform, max-age=0, private',
        'Content-Type': 'application/json'
    };

    const markLoginError = () => {
        form.classList.add('error');
        setTimeout(() => {
            form.classList.remove('error');
        }, 1000);
    };

    if (loginBtn !== null) {
        loginBtn.addEventListener('click', () => {
            if (login.value.length === 0 || password.value.length === 0) {
                markLoginError();
            } else {
                fetch('/', {
                    headers: ajaxHeaders,
                    method: 'post',
                    redirect: 'follow',
                    body: JSON.stringify({
                        "type": "cnx",
                        "action": "connect",
                        "username": window.btoa(login.value),
                        "hash": window.btoa(md5(password.value))
                    })
                }).then((response) => {
                    return response.json();
                }).then((cnx) => {
                    if (cnx.status === 401 && cnx.action === 'cnx' && cnx.connected === false) {
                        markLoginError();
                    } else if (cnx.status === 200 && cnx.action === 'cnx' && cnx.connected === true) {
                        if (loginBtn.dataset.redirect.length) {
                            url = "/?annonce=" + loginBtn.dataset.redirect;
                        } else {
                            url = "/"
                        }
                        d.location.href = url;
                    }
                });
            }
        });
    }

    if (registerBtn !== null) {
        registerBtn.addEventListener('click', () => {
            if (login.value.length === 0 || password.value.length === 0 || nom.value.length === 0 || prenom.value.length === 0) {
                markLoginError();
            } else {
                fetch('/', {
                    headers: ajaxHeaders,
                    method: 'post',
                    redirect: 'follow',
                    body: JSON.stringify({
                        "type": "cnx",
                        "action": "register",
                        "username": window.btoa(login.value),
                        "hash": window.btoa(md5(password.value)),
                        "nom": window.btoa(nom.value),
                        "prenom": window.btoa(prenom.value)
                    })
                }).then((response) => {
                    return response.json();
                }).then((cnx) => {
                    if (cnx.action === 'cnx' && cnx.registered === false) {
                        markLoginError();
                    } else if (cnx.action === 'cnx' && cnx.registered === true) {
                        if (registerBtn.dataset.redirect.length) {
                            url = "/?annonce=" + registerBtn.dataset.redirect;
                        } else {
                            url = "/"
                        }
                        d.location.href = url;
                    }
                });
            }
        });
    }

    if (logoutBtn !== null) {
        logoutBtn.addEventListener('click', () => {
            fetch('/', {
                headers: ajaxHeaders,
                method: 'post',
                body: JSON.stringify({
                    "type": "cnx",
                    "action": "disconnect"
                })
            }).then((response) => {
                return response.json();
            }).then((cnx) => {
                if (cnx.status === 200 && cnx.action === 'cnx' && cnx.disconnected === true) {
                    if (logoutBtn.dataset.redirect.length) {
                        url = "/?annonce=" + logoutBtn.dataset.redirect;
                    } else {
                        url = "/"
                    }
                    d.location.href = url;
                }
            });

            
        });
    }

    if (enchereSubmit !== null) {
        enchereSubmit.addEventListener('click', () => {
            let minEnchere = inputMontant.dataset.minenchere;
            if (parseInt(inputMontant.value) < parseInt(minEnchere)) {
                invalidEnchere.classList.remove('d-none');
                inputMontant.classList.add('error');
                setTimeout(() => {
                    inputMontant.classList.remove('error');
                }, 1000);
            } else {
                let formData = new FormData(enchereForm);
                formData.append('enchereSubmit', 'true');

                fetch('/', {
                    method: 'POST',
                    enctype: 'JSON',
                    body: formData
                }).then((response) => {
                    return response.json();
                }).then((data) => {
                    if (data.success == true) {
                        if(!invalidEnchere.classList.contains('d-none')) {
                            invalidEnchere.classList.add('d-none');
                        }
                        console.log(infosDerniereEnchere.innerHTML);
                        console.log(infosDerniereEnchere.innerHTML.length);
                        if(!infosDerniereEnchere.innerHTML.length) {
                            infosDerniereEnchere.classList.remove('d-none');
                        }
                        derniereEnchere.innerHTML = "Dernière enchère : " + inputMontant.value + " €";
                        infosDerniereEnchere.innerHTML = "Émise par " + data.prenom + " " + data.nom + " le " + data.date;

                        inputMontant.value++;
                        inputMontant.setAttribute("min", inputMontant.value);
                        inputMontant.dataset.minenchere = inputMontant.value;

                        invalidEnchere.innerHTML = "Entrez un nombre supérieur ou égal à " + inputMontant.value;

                        const enchereModal = bootstrap.Modal.getInstance("#enchereModal");
                        enchereModal.hide();
                    }
                });
            }
        
            
        });
    }

    /*** Gestion du retour en haut de page ***/
    d.querySelector('#to-top').addEventListener('click', () => {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
}

