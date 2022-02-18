<?php
namespace GDO\LanguageEditor\Method;

use GDO\Form\MethodButton;
use GDO\Form\GDT_Form;
use GDO\Language\Module_Language;
use GDO\Language\GDO_Language;
use GDO\LanguageEditor\GDO_LangEntry;
use GDO\File\FileUtil;

final class Generate extends MethodButton
{
	public function getPermission() { return 'staff'; }
	
	public function formValidated(GDT_Form $form)
	{
		return $this->generate($form);
	}
	
	public function generate(GDT_Form $form)
	{
		$total = 0;
// 		$main = GDO_Language::getMainLanguage();
		$mainIso = GDO_LANGUAGE;
		$supported = Module_Language::instance()->cfgSupported();

		$select = GDO_LangEntry::table()->select('le_iso, le_key, le_trans');
		$result = $select->exec();
		
		$out = $this->getModule()->filePath('_generate_/');
		FileUtil::createDir($out);

		$fileData = [];
		foreach ($supported as $lang)
		{
			$iso = $lang->getISO();
			$fileData[$iso] = [];
		}
			
		$entry = GDO_LangEntry::blank();
		while ($entry = $result->fetchInto($entry))
		{
			$lang = $entry->getLanguage();
			$iso = $lang->getISO();
			$key = $entry->getKey();
			$fileData[$iso][$key] = $entry->getTrans();
			$total++;
		}
		
		foreach ($fileData as $iso => $data2)
		{
			foreach ($data2 as $key => $trans)
			{
				if (!isset($fileData[$mainIso][$key]))
				{
					$fileData[$mainIso][$key] = $trans;
				}
			}
		}
		
		foreach ($supported as $lang)
		{
			$iso = $lang->getISO();
			foreach ($fileData[$mainIso] as $key => $trans)
			{
				if (!isset($fileData[$iso][$key]))
				{
					$fileData[$iso][$key] = $trans;
				}
			}
			$this->generateFile($lang, $fileData);
		}
		
		return $this->message('msg_generated_db_lang_file', [count($fileData), $total]);
	}

	private function generateFile(GDO_Language $lang, array $fileData)
	{
		
	}
}
