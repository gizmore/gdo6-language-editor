<?php
namespace GDO\LanguageEditor\Method;

use GDO\Core\MethodAdmin;
use GDO\Core\Method;
use GDO\UI\GDT_Tabs;
use GDO\Language\Module_Language;
use GDO\UI\GDT_Tab;
use GDO\Core\GDT_Method;

/**
 * Edit the language tables.
 * 
 * @author gizmore
 */
final class Edit extends Method
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	# Tabs
	public function beforeExecute()
	{
		$this->renderNavBar();
		Admin::make()->renderLanguageBar();
	}
	
	public function execute()
	{
		$tabs = GDT_Tabs::make();
		$languages = Module_Language::instance()->cfgSupported();
		foreach ($languages as $lang)
		{
			$method = GDT_Method::make()->method(EditLang::make());
			$tabs->tab(GDT_Tab::makeWith($method)->labelRaw($lang->getISO()));
		}
		return $tabs;
	}
	
}
