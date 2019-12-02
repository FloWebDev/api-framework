                    <div class="doc-content col-md-9 col-12 order-1">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Getting Started</h2>
                                <div class="section-block">
                                    <p>Cette API vise à de collecter et mettre gratuitement à dispositon des développeurs des contenus variés (proverbes, blagues, chuck norris facts, devinettes, fakes news, etc) pour leurs projets ou besoin de fixtures.</p>
                                    <a href="<?= $router->generate('token'); ?>" class="btn btn-green"><i class="fas fa-medal"></i> Demander un token</a>
                                </div>
                            </section><!--//doc-section-->
                            <section id="token-jwt-section" class="doc-section">
                                <h2 class="section-title">Json Web Token</h2>
                                <div id="step1"  class="section-block">
                                    <h3 class="block-title">&Eacute;tape une</h3>
                                    <p>Pour utiliser l'API, vous devez au préalable demander l'obtention d'un token (Json Web Token).<br>La procédure est simple, rapide et <strong><u>sans inscription</u></strong>. <a href="<?= $router->generate('token'); ?>" class="text-green"><i class="fas fa-external-link-square-alt"></i></a></p>
                                </div><!--//section-block-->
                                <div id="step2"  class="section-block">
                                    <h3 class="block-title">&Eacute;tape deux</h3>
                                    <p>Le token envoyé par email a une validité de <strong><u>48 heures</u></strong>.<br>
                                    Ce JWT doit ensuite être renseigné dans l'en-tête d'autorisation HTTP des requêtes le nécessitant.
                                    </p>
                                    <div class="code-block">
                                        <h6>En-tête HTTP d'autorisation :</h6>
                                        <p><code>Authorization: Bearer &#8249;your_token&#8250;</code></p>
                                    </div><!--//code-block-->
                                </div><!--//section-block-->
                                <div id="step3"  class="section-block">
                                    <h3 class="block-title">&Eacute;tape trois</h3>
                                    <p>Il est possible d'automatiser la demande d'obtention d'un token afin d'en faciliter le renouvellement.<br>
                                    Pour cela, reportez-vous aux tableaux des routes de l'API. L'une d'elles est prévue à cet effet.
                                    </p>
                                    <div class="code-block">
                                        <h6>Route API token :</h6>
                                        <p><code>/api/token</code></p>
                                    </div><!--//code-block-->
                                </div><!--//section-block-->
                            </section><!--//doc-section-->
                            
                            <section id="routes-section" class="doc-section">
                                <h2 class="section-title">Routes API</h2>
                                <div class="section-block">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
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
                                                <td>- Min : 1 - Max : 2500<br>- <?= !empty($categoryList) ? $categoryList : '<b>Pas de catégorie</b>'; ?></td>
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
                                                <td>- Min : 1 - Max : 50<br>- <?= !empty($categoryList) ? $categoryList : '<b>Pas de catégorie</b>'; ?></td>
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
                                    </div><!-- table-responsive -->

                                    <div class="callout-block callout-success">
                                        <div class="icon-holder">
                                            <i class="fas fa-thumbs-up"></i>
                                        </div><!--//icon-holder-->
                                        <div class="content">
                                            <h4 class="callout-title">Faites connaître l'API</h4>
                                            <p>Vous pouvez utliser l'un de ces liens <a href="#" id="facebook_share"><i class="fab fa-facebook-square"></i> Facebook</a> ou <a href="#" id="twitter_share"><i class="fab fa-twitter-square"></i> Twitter</a> pour partager le site sur les réseaux sociaux.</p>
                                        </div><!--//content-->
                                    </div>
                                    
                                </div><!--//section-block-->
                                <div id="html" class="section-block">
                            </section><!--//doc-section-->
                                   
                            <section id="requete-section" class="doc-section">
                                <h2 class="section-title">Requête vers l'API</h2>
                                    <!--<div class="code-block">-->
                                <div id="php-request" class="section-block">
                                    <div class="code-block">
                                        <h6>Exemple d'utilisation avec PHP Curl</h6>
                                        <pre><code class="language-php">&lt;?php 

$url = "https://example.com/api/get";
$params = "?limit=20&category=blague";

$jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI1ZGRlY2VmMGE4ZTNkIiwiZXhwIjoiMjAxOS0xMS0yOSAyMDozMDo1NiIsInRlc3QiOiIrXC89In0.bZhb_fgx2IHj-M6Lbr3B-CyFoVZPzvtFzbpBsrBsKnzQFSomB-UFCTXZaNolcIWvslsvorq_YLjTgMZRpfSsRQ";

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer " . $jwt
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url . $params);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT, 60);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
$jsonResponse = curl_exec($curl);
$response = json_decode($jsonResponse, 1);
curl_close($curl);

echo "&lsaquo;pre&rsaquo;";
var_dump($response);
echo "&lsaquo;/pre&rsaquo;";

?&gt;</code></pre>
                                    </div><!--//code-block-->
                                </div><!--//section-block-->
                        </section>

                            <section id="response-section" class="doc-section">
                                <h2 class="section-title">Response</h2>
                                    <!--<div class="code-block">-->
                                <div id="json-response" class="section-block">
                                    <div class="code-block">
                                        <h6>Exemple de retour en Json</h6>
                                        <pre><code class="language-json">[
    {
        "id": 720,
        "content": "Comment appelle-t-on une chauve-souris qui a des cheveux ?\r\n- Une souris",
        "vote": 1717,
        "category": "Blague"
    },
    {
        "id": 719,
        "content": "Comment appelle-t-on un chat dans l’espace ?\nUn chatellite",
        "vote": 3832,
        "category": "Devinette"
    },
    {
        "id": 718,
        "content": "Pourquoi est-ce que les éoliennes n'ont pas de copain ?
        Parce qu’elles se prennent toujours des vents",
        "vote": 3791,
        "category": "Blague"
    }
]</code></pre>
                                    </div><!--//code-block-->
                                </div><!--//section-block-->

                                <div id="php-response" class="section-block">
                                    <div class="code-block">
                                        <h6>Exemple de retour en PHP (après json_decode)</h6>
                                        <pre><code class="language-php">[
  {
    "id": 212,
    "content": "Un jour, Chuck Norris a fait la blague de \"j'ai volé ton nez\" à Mickael Jackson...",
    "vote": 2557,
    "categorie": "Chuck Norris Fact"
  },
  {
    "id": 112,
    "content": "Comment appelle-t-on un combat entre un petit pois et une carotte ?\nUn bon duel",
    "vote": 5664,
    "categorie": "Blague"
  }
]</code></pre>
                                    </div><!--//code-block-->
                                </div><!--//section-block-->
                            </section><!--//doc-section-->

   
                            

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->
                    <div class="doc-sidebar col-md-3 col-12 order-0 d-none d-md-flex">
                        <div id="doc-nav" class="doc-nav">
	                        
	                            <nav id="doc-menu" class="nav doc-menu flex-column sticky">
	                                <a class="nav-link scrollto" href="#getting-started-section">Getting Started</a>
	                                <a class="nav-link scrollto" href="#token-jwt-section">Token - Json Web Token</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#step1">&Eacute;tape Une</a>
                                        <a class="nav-link scrollto" href="#step2">&Eacute;tape Deux</a>
                                        <a class="nav-link scrollto" href="#step3">&Eacute;tape Trois</a>
                                    </nav><!--//nav-->
                                    <a class="nav-link scrollto" href="#routes-section">Routes API</a>
                                    <a class="nav-link scrollto" href="#requete-section">Requête vers l'API</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#php-request">Exemple avec PHP Curl</a>
                                    </nav><!--//nav-->
                                    <a class="nav-link scrollto" href="#response-section">Response</a>
                                    <nav class="doc-sub-menu nav flex-column">
                                        <a class="nav-link scrollto" href="#json-response">Exemple de retour en Json</a>
                                        <a class="nav-link scrollto" href="#php-response">Exemple de retour en PHP</a>
                                    </nav><!--//nav-->
	                            </nav><!--//doc-menu-->
	                        
                        </div>
                    </div><!--//doc-sidebar-->
 
        

    
