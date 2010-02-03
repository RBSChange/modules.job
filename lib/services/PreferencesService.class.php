<?php
/**
 * @date Fri, 03 Aug 2007 10:32:47 +0200
 * @author intcoutl
 */
class job_PreferencesService extends abstractdirectory_PreferencesService
{
	/**
	 * Singleton
	 * @var job_PreferencesService
	 */
	private static $instance;

	/**
	 * @return job_PreferencesService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return job_persistentdocument_preferences
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_job/preferences');
	}

	/**
	 * Create a query based on 'modules_job/preferences' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_job/preferences');
	}
	
	/**
	 * @param job_persistentdocument_preferences $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId = null)
	{
		$document->setLabel('&modules.job.bo.general.Module-name;');
	}
}