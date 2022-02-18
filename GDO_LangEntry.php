<?php
namespace GDO\LanguageEditor;

use GDO\Core\GDO;
use GDO\Language\GDT_Language;
use GDO\DB\GDT_Name;
use GDO\DB\GDT_String;
use GDO\Language\GDO_Language;

final class GDO_LangEntry extends GDO
{
	public function gdoColumns()
	{
		return [
			GDT_Language::make('le_iso')->primary(),
			GDT_Name::make('le_key')->primary(),
			GDT_String::make('le_trans')->notNull(),
		];
	}
	
	/**
	 * @return GDO_Language
	 */
	public function getLanguage() { return $this->getValue('le_iso'); }
	public function getKey() { return $this->getVar('le_key'); }
	public function getTrans() { return $this->getVar('le_trans'); }
	
}
