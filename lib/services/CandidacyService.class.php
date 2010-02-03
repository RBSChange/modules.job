<?php
class job_CandidacyService extends job_SpontaneouscandidacyService
{
	/**
	 * Singleton
	 * @var job_CandidacyService
	 */
	private static $instance;

	/**
	 * @return job_CandidacyService
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
	 * @return job_persistentdocument_candidacy
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_job/candidacy');
	}

	/**
	 * Create a query based on 'modules_job/candidacy' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_job/candidacy');
	}

	public function addCandidacy($data)
	{
		$candidacy = $this->createCandidacy($data);
		job_OfferService::getInstance()->addCandidacy($candidacy->getOfferref());
	}
}