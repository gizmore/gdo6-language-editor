<?php
namespace GDO\LanguageEditor\Method;

use GDO\Form\MethodButton;
use GDO\Form\GDT_Form;
use GDO\Language\Module_Language;
use GDO\Language\GDO_Language;
use GDO\LanguageEditor\GDO_LangEntry;
use GDO\File\FileUtil;
use GDO\Core\GDO;
use GDO\Core\MethodAdmin;

/**
 * Generate language files from the language editor database.
 * 
 * @author gizmore
 */
final class Generate extends MethodButton
{
	use MethodAdmin;
	
	public function beforeExecute()
	{
		$this->renderNavBar();
		Admin::make()->renderLanguageBar();
	}
	
	public function getPermission() { return 'staff'; }
	
	public function formValidated(GDT_Form $form)
	{
		return $this->generate();
	}
	
	public function getGeneratedFileDir($path='')
	{
		$out = $this->getModule()->filePath('_generated_/');
		FileUtil::createDir($out);
		return $out . $path;
	}
	
	public function generate()
	{
		$total = 0;

		$mainIso = GDO_LANGUAGE;
		$supported = Module_Language::instance()->cfgSupported();

		$select = GDO_LangEntry::table()->select('le_iso, le_key, le_trans');
		$result = $select->exec();
		
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
		$iso = $lang->getISO();
		$filename = $this->getGeneratedFileDir("langfile_{$iso}.php");
		$data = sprintf("<?php\nreturn unserialize(\"%s\");\n", GDO::escapeS(serialize($fileData[$iso])));
		if (!file_put_contents($filename, $data))
		{
			$this->error('err_file_not_found', [$filename]);
			return false;
		}
		return true;
	}

}
