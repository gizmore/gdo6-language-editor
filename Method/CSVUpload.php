<?php
namespace GDO\LanguageEditor\Method;

use GDO\Core\MethodAdmin;
use GDO\Form\GDT_Form;
use GDO\Form\MethodButton;
use GDO\File\GDT_File;
use GDO\Util\CSV;
use GDO\File\GDO_File;

final class CSVUpload extends MethodButton
{
	use MethodAdmin;
	
	public function beforeExecute()
	{
		$this->renderNavBar();
		Admin::make()->renderLanguageBar();
	}
	
	public function createForm(GDT_Form $form)
	{
		$form->addFields([
			GDT_File::make('csvFile')->mime('text/csv')->notNull(),
		]);
		return parent::createForm($form);
	}
	
	/**
	 * @return GDO_File
	 */
	public function getFile()
	{
		return $this->getForm()->getFormValue('csvFile');
	}
	
	public function formValidated(GDT_Form $form)
	{
		$file = $this->getFile();
		$csv = new CSV($file->getPath());
		$csv->eachLine(function($row) {
		});
	}
	
}
