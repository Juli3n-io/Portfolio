<?php
require_once __DIR__ . '/global/config/bootstrap.php';

$page_title ='Hello';

include __DIR__. '/assets/includes/header.php';
?>

<div id="notif"></div>

<?php
include __DIR__. '/assets/views/hero.php';

include __DIR__. '/assets/views/about.php';

include __DIR__. '/assets/views/services.php';

include __DIR__. '/assets/views/price.php';

include __DIR__. '/assets/views/skills.php';

include __DIR__. '/assets/views/portfolio.php';

include __DIR__. '/assets/views/experiences.php';

include __DIR__. '/assets/views/contact.php';
?>



<?php
include __DIR__. '/assets/includes/footer.php';
?>



