


<div class="card text-white bg-dark mb-3 col-md-6">
  <div class="card-header">Obtenir un JSON Web Token (JWT)</div>
  <div class="card-body">
    <h5 class="card-title">Qu'est-ce qu'un JSON Web Token (JWT) ?</h5>
    <p class="card-text">JSON Web Token (JWT) est un standard ouvert. Il permet l'échange sécurisé de jetons (tokens) entre plusieurs parties. Cette sécurité de l’échange se traduit par la vérification de l’intégrité des données à l’aide d’une signature numérique. En pratique, l'utilisation d'un JWT est très (très très) simple.</p>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                JWT <i class="fas fa-search"></i>
            </button>
            <div class="dropdown-menu px-2" aria-labelledby="dropdownMenuButton">
                JWT est un jeton permettant d’échanger des informations de manière sécurisée. Ce jeton est composé de trois parties, dont la dernière, la signature, permet d’en vérifier la légitimité. JWT est souvent utilisé pour offrir une authentification stateless au sein d’applications. 
            </div>
        </div>
  </div>

  <div class="card-body">
    <h5 class="card-title">Comment utiliser le JWT</h5>
        <p class="card-text">Pour chaque requête auprès de Humour API, il vous suffira de renseigner votre JWT dans le header. Voici un exemple avec Curl :
        </p>
        <pre class="bg-light px-2">curl -H "Authorization: Bearer your.jwt.token" https://humour-api.com/</pre>
  </div>
</div>

<form class="col-md-6 text-dark bg-white" action="" method="POST">

  <div class="form-group p-3">
    <label for="email">Votre adresse email <span style="color: red; font-weight: bold;">(*)</span></label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Adresse email" value="
<?php if(!empty($_SESSION['email'])) : ?>
<?= $_SESSION['email']; ?>
<?php unset($_SESSION['email']); ?>
<?php endif; ?>">
    <small id="notaBene" class="form-text text-danger"><i class="fas fa-exclamation"></i> L'adresse email servira uniquement à l'envoi de votre token.<br><i class="fas fa-exclamation"></i> Elle ne sera ni conservée ni revendue à un tiers.</small>
    <label for="captcha" class="mt-3">Recopiez les 4 chiffres de l'image <span style="color: red; font-weight: bold;">(*)</span></label>
    <input type="text" class="form-control" id="captcha" name="captcha" aria-describedby="captchaHelp" placeholder="4 chiffres">
  </div>

  <div class="form-group px-3">
    <img src="data:image/jpeg;base64,<?= $captcha; ?>" class="img-fluid" alt="captcha" id="captchaImg">
  </div>

  <div class="form-group px-3">
    <input type="submit" class="btn btn-dark" value="Demande de Token">
  </div>
  
</form>