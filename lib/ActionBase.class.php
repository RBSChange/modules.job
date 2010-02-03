<?php
class job_ActionBase extends f_action_BaseAction
{
		
	/**
	 * Returns the job_OfferService to handle documents of type "modules_job/offer".
	 *
	 * @return job_OfferService
	 */
	public function getOfferService()
	{
		return job_OfferService::getInstance();
	}
		
	/**
	 * Returns the job_PreferencesService to handle documents of type "modules_job/preferences".
	 *
	 * @return job_PreferencesService
	 */
	public function getPreferencesService()
	{
		return job_PreferencesService::getInstance();
	}
		
	/**
	 * Returns the job_SpontaneousofferService to handle documents of type "modules_job/spontaneousoffer".
	 *
	 * @return job_SpontaneousofferService
	 */
	public function getSpontaneousofferService()
	{
		return job_SpontaneousofferService::getInstance();
	}
		
	/**
	 * Returns the job_SpontaneouscandidacyService to handle documents of type "modules_job/spontaneouscandidacy".
	 *
	 * @return job_SpontaneouscandidacyService
	 */
	public function getSpontaneouscandidacyService()
	{
		return job_SpontaneouscandidacyService::getInstance();
	}
		
	/**
	 * Returns the job_CandidacyService to handle documents of type "modules_job/candidacy".
	 *
	 * @return job_CandidacyService
	 */
	public function getCandidacyService()
	{
		return job_CandidacyService::getInstance();
	}
		
}