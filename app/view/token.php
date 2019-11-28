
                    <div class="doc-content col-md-6 col-12 order-1">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Json Web Token <i class="fas fa-question"></i></h2>
                                <div class="section-block">
                                    <p class="card-text">JSON Web Token (JWT) est un standard ouvert. Il permet l'échange sécurisé de jetons (tokens) entre plusieurs parties. Cette sécurité de l’échange se traduit par la vérification de l’intégrité des données à l’aide d’une signature numérique. En pratique, l'utilisation d'un JWT est très (très très) simple.</p>

                                    <div class="dropdown text-center">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-plus-circle"></i> JWT
                                        </button>
                                        <div class="dropdown-menu px-2" aria-labelledby="dropdownMenuButton">
                                            JWT est un jeton permettant d’échanger des informations de manière sécurisée. Ce jeton est composé de trois parties(header, payload, signature), dont la dernière, la signature, permet d’en vérifier la légitimité. JWT est souvent utilisé pour offrir une authentification stateless au sein d’applications. 
                                        </div>
                                    </div>

                                    <p class="card-text mt-3">Avec le formulaire de demande de token, vous recevrez directement un email contenant le JWT. Celui-ci sera valide <b>48 heures</b>.<br>Par la suite, vous pourrez automatiser la demande d'obtention d'un token via la route API prévue à cet effet (reportez-vous à la documentation)</p>
                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->
                    <div class="doc-content col-md-6 col-12 order-2">
                        <div class="content-inner">
                            <section id="getting-started-section" class="doc-section">
                                <h2 class="section-title">Demande de token</h2>
                                <div class="section-block">
<form class="text-dark bg-white" action="" method="POST">
<div class="form-group p-3">
  <label for="email" class="font-weight-bold">Votre adresse email <span style="color: red; font-weight: bold;">(*)</span></label>
  <input type="email" class="form-control border border-success" id="email" name="email" aria-describedby="emailHelp" placeholder="Adresse email" value="
<?php if(!empty($_SESSION['email'])) : ?>
<?= $_SESSION['email']; ?>
<?php unset($_SESSION['email']); ?>
<?php endif; ?>">
  <small id="notaBene" class="form-text text-danger"><i class="fas fa-exclamation"></i> L'adresse email servira uniquement à l'envoi de votre token.<br><i class="fas fa-exclamation"></i> Elle ne sera ni conservée ni revendue à un tiers.</small>
  <label for="captcha" class="mt-3 font-weight-bold">Recopiez les 4 chiffres de l'image <span style="color: red; font-weight: bold;">(*)</span></label>
  <input type="text" class="form-control border border-success" id="captcha" name="captcha" aria-describedby="captchaHelp" placeholder="4 chiffres">
</div>

<div class="form-group px-3">
  <img src="data:image/jpeg;base64,<?= $captcha; ?>" class="img-fluid" alt="captcha" id="captchaImg">
</div>

<div class="form-group px-3">
  <input type="submit" class="btn btn-dark" value="Demande de Token">
</div>

</form>
                                </div>
                            </section><!--//doc-section-->

                        </div><!--//content-inner-->
                    </div><!--//doc-content-->

        

    
