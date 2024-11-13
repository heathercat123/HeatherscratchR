<?php
Class InfoController extends AppController {
	var $pageTitle = "Scratch Documentation Site";
	var $uses = array();
    var $helpers = array('Template');
	var $layout = 'scratchr_info';
	
	function s14download() {
		$this->pageTitle = "Scratch 1.4 Download | Scratch Documentation Site";
		$this->render('download');
	}
	
	function donate() {
		$this->pageTitle = "Donate | Scratch Documentation Site";
		$this->render('donate');
	}
	
	function terms() {
		$this->pageTitle = "Community Guidelines | Scratch Documentation Site";
		$this->render('terms');
	}
	
	function privacy() {
		$this->pageTitle = "Privacy Policy | Scratch Documentation Site";
		$this->render('privacy');
	}
	function about() {
		$this->pageTitle = "About Scratch | Scratch Documentation Site";
		$this->render('about');
	}
}
?>