<?php
require_once 'bootstrap.php';

$form = new \Zend_Form();
$form->addElement('text', 'url', array('label' => 'URL'));
$form->addElement('submit', 'submit', array('label' => 'Get Output'));
$form->setMethod('POST');
$form->setView(new Zend_View());

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $form->isValid($_POST)) {
	$session = new \Zend_Session_Namespace('urlJob');
	$response = new \Zend_Controller_Response_Http();
	$job = new org\eschrade\job\GetRemoteLinks($form->getValue('url'));
	$session->jobResponse = $job->execute();
	$response->setRedirect('/poll.php');
	$response->sendHeaders();
} else {
	echo $form;
}
