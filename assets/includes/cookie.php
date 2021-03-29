<?php
if(isset($_COOKIE['accept_cookie'])){
    $showcookie = false;
}else{
    $showcookie = true;
}
?>

<?php if($showcookie):?>
<div class="cookie-alert" id="cookie">
    <div class="cookie-content">
    <div class="cookie-body">
    <img src="assets/img/cookie.png" alt="cookie">
        <p>
            Avec tout l'amour que je porte à ces petits gâteaux, je n'en utilise aucun pour vous suivre sur mon site !
        </p>
    </div>
    <a href="assets/functions/accept_cookie.php">J'accepte</a>
    </div>
</div>
<?php endif;?>