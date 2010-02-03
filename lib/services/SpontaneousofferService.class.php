<?php
class job_SpontaneousofferService extends f_persistentdocument_DocumentService
{
	/**
	 * Singleton
	 * @var job_SpontaneousofferService
	 */
	private static $instance;

	/**
	 * @return job_SpontaneousofferService
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
	 * @return job_persistentdocument_spontaneousoffer
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_job/spontaneousoffer');
	}

	/**
	 * Create a query based on 'modules_job/spontaneousoffer' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_job/spontaneousoffer');
	}

	/**
	 * check if a spontaneous offer already exist in databases
	 *
	 * @return Boolean
	 */
	public function spontaneousOfferExist()
	{
		if ( $this->getSpontaneousOffer() == null )
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Get the spontaneous offer
	 *
	 * @return job_persistentdocument_spontaneousoffer
	 */
	public function getSpontaneousOffer()
	{
		$query = $this->createQuery();
		return $query->findUnique();
	}
}