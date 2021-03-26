<?php
require_once __DIR__ . '/global/config/bootstrap.php';

$page_title ='Hello';

include __DIR__. '/assets/includes/header.php';
?>

<div id="notif"></div>

<div id="fullpage">

<?php
include __DIR__. '/assets/views/hero.php';

include __DIR__. '/assets/views/about.php';

include __DIR__. '/assets/views/services.php';

include __DIR__. '/assets/views/skills.php';

include __DIR__. '/assets/views/portfolio.php';

include __DIR__. '/assets/views/price.php';

include __DIR__. '/assets/views/experiences.php';

include __DIR__. '/assets/views/contact.php';
?>

</div>

<?php
include __DIR__. '/assets/views/modal_view.php';
include __DIR__. '/assets/includes/cookie.php';
include __DIR__. '/assets/includes/footer.php';
?>



