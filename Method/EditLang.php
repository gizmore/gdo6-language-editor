<?php
namespace GDO\LanguageEditor\Method;

use GDO\Table\MethodQueryTable;
use GDO\User\GDO_User;
use GDO\LanguageEditor\GDO_LangEntry;
use GDO\Core\MethodAdmin;

/**
 * Edit a language table.
 *
 * @author gizmore
 */
final class EditLang extends MethodQueryTable
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	# CRUD
	public function isCreateable(GDO_User $user) { return true; }
	public function isReadable(GDO_User $user) { return true; }
	public function isUpdateable(GDO_User $user) { return true; }
	public function isDeleteable(GDO_User $user) { return true; }
	
	# Tabs
	public function beforeExecute()
	{
		$this->renderNavBar();
		Admin::make()->renderLanguageBar();
	}
	
	# Table
	public function gdoTable()
	{
		return GDO_LangEntry::table();
	}
	
}
