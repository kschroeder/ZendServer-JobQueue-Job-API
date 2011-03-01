<?php

require_once 'bootstrap.php';
use com\zend\jobqueue\Manager;


$session = new \Zend_Session_Namespace('urlJob');
$mgr = new Manager();
if (($job = $mgr->getCompletedJob($session->jobResponse)) !== null) {
	
	?>
<h1>Links on <?php echo $job->getUrl()?></h1>
<?php foreach ($job->getLinks() as $link): ?>
	<?php echo $link ?><br />
<?php endforeach; ?>
	<?php 
	
} else {
	?>
<h1>Waiting...</h1>
<script type="text/javascript">
window.setTimeout(function() {window.location.href="/poll.php"}, 1000);
</script>
	<?php 
}