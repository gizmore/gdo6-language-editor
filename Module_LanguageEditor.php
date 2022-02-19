<?php
namespace GDO\LanguageEditor;

use GDO\Core\GDO_Module;
use GDO\LanguageEditor\Method\Generate;

/**
 * Edit language files via a database.
 * Import CSV files for language.
 * 
 * @author gizmore
 * @license MIT
 * @version 6.11.4
 * @since 6.11.4
 */
final class Module_LanguageEditor extends GDO_Module
{
    public $module_priority = 200;
    
    public function href_administrate_module()
    {
    	return href('LanguageEditor', 'Admin');
    }
    
    public function onLoadLanguage()
    {
    	$this->loadLanguage('lang/langeditor');
    	$this->loadLanguage('_generated_/langfile');
    }
    
    public function getClasses()
    {
    	return [
    		GDO_LangEntry::class,
    	];
    }
    
	public function onInstall()
	{
		$this->generateFiles();
	}
	
	public function generateFiles()
	{
		return Generate::make()->generate();
	}

}
