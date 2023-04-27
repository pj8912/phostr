<?php
require_once 'vendor/autoload.php';
use Phostr\Templates\Template;
$template = new Template();
?>
<?php $template->main_header('Home'); ?>

<a href="test/test.php">Test Import Key</a>

<?php $template->main_footer(); ?>