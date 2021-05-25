</main>
</div> <!-- fin div main__content-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

<?php
if (stripos($_SERVER['REQUEST_URI'], 'connexion')){
     echo '<script type="text/javascript" src="assets/js/login_admin.js"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'team')){
    echo '<script type="text/javascript" src="assets/js/team_admin.js"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'posts')){
     echo '<script type="text/javascript" src="assets/js/posts_admin.js"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'categories')){
     echo '<script type="text/javascript" src="assets/js/cat_admin.js"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'experiences')){
     echo '<script type="text/javascript" src="assets/js/experiences.js"></script>';
     echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'education')){
     echo '<script type="text/javascript" src="assets/js/education.js"></script>';
     echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'langages')){
     echo '<script type="text/javascript" src="assets/js/lang_admin.js"></script>';
}elseif (stripos($_SERVER['REQUEST_URI'], 'skills')){
     echo '<script type="text/javascript" src="assets/js/skills_admin.js"></script>';
}else if(stripos($_SERVER['REQUEST_URI'], 'register')){
     echo '<script type="text/javascript" src="assets/js/register_admin.js"></script>';  
}else if(stripos($_SERVER['REQUEST_URI'], 'update_profil')){
     echo '<script type="text/javascript" src="assets/js/update_admin.js"></script>';
}else if(stripos($_SERVER['REQUEST_URI'], 'hello')){
     echo '<script type="text/javascript" src="assets/js/index.js"></script>';
     echo '<script type="text/javascript" src="assets/js/posts_admin.js"></script>';
}else if(stripos($_SERVER['REQUEST_URI'], 'docs')){
     echo '<script type="text/javascript" src="assets/js/docs.js"></script>';
}else if(stripos($_SERVER['REQUEST_URI'], 'stats')){
     echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
     echo '<script type="text/javascript" src="assets/js/stats.js"></script>';
}else{
     echo '';
}

if (!stripos($_SERVER['REQUEST_URI'],  'login_admin.php')){
     // echo '<script type="text/javascript" src="assets/js/logout.js"></script>';
}
?>   
<script type="text/javascript" src="assets/js/app.js"></script>
</body>
</html>