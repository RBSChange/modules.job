<?php
/**
 * job_persistentdocument_preferences
 * @package job
 */
class job_persistentdocument_preferences extends job_persistentdocument_preferencesbase 
{
	/**
	 * @see f_persistentdocument_PersistentDocumentImpl::getLabel()
	 *
	 * @return String
	 */
	public function getLabel()
	{
		return f_Locale::translateUI(parent::getLabel());
	}
}