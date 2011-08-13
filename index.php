<?php

include_once './Settings/settings.php';

include_once './Modules/Output.php';

include_once './Modules/Copyright.php';

class Template {

	public $Layout, $layoutOptions = array();

	public function __construct(){
		require_once ('./Twig/Autoloader.php');
		Twig_Autoloader::register();

		$this->Loader = new Twig_Loader_Filesystem ('Templates');
		$this->Twig = new Twig_Environment ($this->Loader, array (
			'cache' => false,
			'debug' => true,
			'auto_reload' => true,
			'strict_variables' => false,
			)
		);

	}

	public function setLayout ($Layout){
		$this->Layout = $Layout;
	}

	public function setOptions ($Key, $Value){
		$this->layoutOptions[$Key] = $Value;
	}

	public function Output(){
		$this->Layout = empty ($this->Layout) ? 'index.html' : $this->Layout . '.html';

		$Template = $this->Twig->loadTemplate ($this->Layout);
		$Template->display($this->layoutOptions);
	}

}

$Template = new Template;

$Template->setLayout('Template');
$Template->setOptions('columns', $columns);
$Template->setOptions('position', $position);
$Template->setOptions('copyright', $copyright);
$Template->Output();
?>
