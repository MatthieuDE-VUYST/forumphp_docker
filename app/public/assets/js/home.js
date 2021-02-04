
/**
 * Affiche la liste des categories
 */
function afficheCategories() {
    url = "/api/categories";
    fetch(url)
    .then(res => res.json())
    .then(json => {
        var html = '';
        json.forEach(element => {
            html += "<button class=\"btn-primary\" onclick=\"afficheSujets(" + element.id +")\">"+ element.nom + "</butotn>\n";
        });
        document.getElementById("main-title").textContent = "Catégories";
        document.getElementById("content").innerHTML = html;
        document.getElementById("nav").innerHTML = "";
    });
}


/**
 * Affiche la liste des sujets d'une categorie passé en parametre
 * @param {int} categorieId 
 */
function afficheSujets(categorieId) {
    url = "/api/sujets/"+categorieId;
    fetch(url)
    .then(res => res.json())
    .then(json => {
        var html = '';
        json.forEach(element => {
            html += "<button class=\"btn-primary\" onclick=\"afficheReponses(" + element.id + ", " + categorieId + ")\">"+ element.titre + "</butotn>\n";
        });
        document.getElementById("main-title").textContent = "Sujets";
        document.getElementById("content").innerHTML = html;
        document.getElementById("nav").innerHTML = "<button class=\"btn-secondary\" onclick=afficheCategories()>Retour</butotn>\n";
    });
}

/**
 * Affiche les reponses d'un sujet d'une categorie
 * @param {int} sujetId 
 * @param {int} categorieId 
 */
function afficheReponses(sujetId, categorieId) {
    url = "/api/reponses/"+sujetId;
    fetch(url)
    .then(res => res.json())
    .then(json => {
        var html = '';
        json.forEach(element => {
            html += "<p>" + element.date_poste.slice(0, 10) + " - <b>"+ element.utilisateur.pseudo + ":</b> " + element.message + "</p>";
        });
        document.getElementById("main-title").textContent = "Réponses";
        document.getElementById("content").innerHTML = html;
        document.getElementById("nav").innerHTML = "<button class=\"btn-secondary\" onclick=afficheSujets("+categorieId+")>Retour</butotn>\n";
    });
}

afficheCategories();