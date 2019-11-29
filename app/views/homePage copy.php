

<div class="row card text-white bg-dark mb-3 col-12 mx-auto py-3">

    <div class="card text-white bg-secondary mb-3 col-12 mx-1">
        <div class="card-header text-dark">
            <h2>
                <?php if(!empty($h2Title)) : ?>
                <?= $h2Title; ?>
                <?php else : ?>
                <?= CFG_H2_TITLE; ?>
                <?php endif; ?>
            </h2>
        </div>

        <div class="card-body">
            <h5 class="card-title text-dark">Usage</h5>
            <p class="card-text">Cette API a vocation de collecter et mettre gratuitement à dispositon des développeurs des données relatives à l'humour (blagues, devinettes, proverbes).<br>L'API a également pour but d'initier d'éventuels développeurs web juniors sur l'utilisation d'une API et l'authentification par token.</p>
        </div>


        <div class="card-body">
            <h5 class="card-title text-dark">Token - Json Web Token</h5>
            <p class="card-text">Pour utiliser l'API, vous devez au préalable demander l'obtention d'un token (Json Web Token).<br>La procédure est simple, rapide et <strong><u>sans inscription</u></strong>.<br><a href="/token" class="text-danger">Obtenir un token.</a><br>Le token fourni a une validité de <strong class="text-dark"><u>48 heures</u></strong>. Il est possible d'automatiser la demande d'obtention d'un token afin d'en faciliter le renouvellement.<br>Le token fourni doit être renseigné dans l'en-tête d'autorisation HTTP des requêtes le nécessitant :<br><code class="bg-dark p-1">Authorization: Bearer &#8249;token&#8250;</code></p>
        </div>


        <div class="card-body">
            <h5 class="card-title text-dark">Routes à utiliser</h5>
            <p class="card-text">
                <div class="table-responsive">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                            <th scope="col">Méthode</th>
                            <th scope="col">Route</th>
                            <th scope="col">Paramètres</th>
                            <th scope="col">Valeurs</th>
                            <th scope="col">JWT</th>
                            <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row"><span class="badge badge-success">GET</span></th>
                            <td style="width: 150px;"><code>/api/get</code></td>
                            <td><b>limit</b><br><b>category</b></td>
                            <td>Min : 1 - Max : 2500<br>blague, chucknorrisfact, devinette, proverbe</td>
                            <td><i class="fas fa-check text-danger"></i></td>
                            <td>Permet de récupérer au format Json un ensemble d'enregistrements par limite et par types.</td>
                            </tr>
                            <tr>
                            <th scope="row"><span class="badge badge-success">GET</span></th>
                            <td style="width: 150px;"><code>/api/find</code></td>
                            <td><b>id</b></td>
                            <td>identifiant de l'enregistrement recherché</td>
                            <td><i class="fas fa-check text-danger"></i></td>
                            <td>Permet de récupérer un enregistrement en fonction de son identifiant (id).</td>
                            </tr>
                            <tr>
                            <th scope="row"><span class="badge badge-success">GET</span></th>
                            <td><code>/api/random</code></td>
                            <td>-</td>
                            <td>-</td>
                            <td></td>
                            <td>Permet d'obtenir une donnée aléatoire sur un échantillon restreint. Il y a une forte probabilité de redondance.</td>
                            </tr>
                            <tr>
                            <th scope="row"><span class="badge badge-success">GET</span></th>
                            <td><code>/api/get/random</code></td>
                            <td><b>limit</b><br><b>category</b></td>
                            <td>Min : 1 - Max : 50<br>blague, chucknorrisfact, devinette, proverbe</td>
                            <td><i class="fas fa-check text-danger"></i></td>
                            <td>Permet d'obtenir une ou plusieurs données aléatoires. Il est possible de préciser le type de données souhaitées.</td>
                            </tr>
                            <tr>
                            <th scope="row"><span class="badge badge-danger">POST</span></th>
                            <td><code>/api/token</code></td>
                            <td>token</td>
                            <td>Json Web Token précédemment généré (expiré ou non).</td>
                            <td></td>
                            <td>Permet d'obtenir un token sans passer par le formulaire d'obtention. Le token fourni a une durée de validité de 48 heures.<br>Il est donc possible d'automatiser l'obtention d'un token en utilisant cette route, puis en le renseignant dans l'en-tête d'autorisation HTTP pour les requêtes suivantes.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </p>
        </div>


        <div class="card-body">
            <h5 class="card-title text-dark">Exemple de "response"</h5>
            <p class="card-text">
                Tous les retours de l'API sont effectués au format <strong>JSON<strong>.
<pre class="text-white bg-dark p-2">
[
  {
    "id": 1,
    "content": "C'est une blonde qui vient d'écraser un poulet. Elle se rend à la ferme la plus proche et dit au fermier : Je viens d'écraser un poulet, je suis désolée, vraiment... - Bah c'est pas grave ma bonne dame, vous z'avez qu'à le manger. - D'accord mais qu'est-ce que je fais de sa moto ?",
    "categorie": "Blague"
  },
  {
    "id": 2,
    "content": "Quel est le meilleur électeur ? Un soutien gorge car il soutient la droite et la gauche",
    "categorie": "Blague"
  }
]
</pre>             
            </p>
        </div>

</div>