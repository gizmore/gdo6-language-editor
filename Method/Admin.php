<?php
namespace GDO\LanguageEditor\Method;

use GDO\Core\GDT_Template;
use GDO\Core\MethodAdmin;
use GDO\UI\GDT_Page;
use GDO\Core\Method;

final class Admin extends Method
{
	use MethodAdmin;
	
	public function beforeExecute()
	{
		$this->renderNavBar();
		$this->renderLanguageBar();
	}
	
	public function renderLanguageBar()
	{
		GDT_Page::$INSTANCE->topTabs->addField(
		GDT_Template::templatePHP('LanguageEditor', 'adminbar.php'));
	}
	
	public function execute()
	{
	}

}
