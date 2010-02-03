<?php
class job_listener_FormSubmittedListener
{

	/**
	* Get the informations posted by the module form to create a faq and 
	* @param form_persistentdocument_form $sender
	* @param mixed $params
	* @return void
	*/
	public function onFormSubmitted($sender, $params)
	{		
		// Get the id of form and check if is a job offer response form
		if ( $sender->getFormid() == 'modules_job/respondtooffer' || $sender->getFormid() == 'modules_job/spontaneouscandidacy' )
		{
			
			$reponseData = $params['response']->getAllData();
			
			$data['lastname'] = $reponseData['lastname']['value'];
			$data['firstname'] = $reponseData['firstname']['value'];
			$data['birthdate'] = $reponseData['birthdate']['value'];
			$data['postaladdress1'] = $reponseData['postaladdress1']['value'];
			$data['postaladdress2'] = isset($reponseData['postaladdress2']['value']) ? $reponseData['postaladdress2']['value'] : '';
			$data['postaladdress3'] = isset($reponseData['postaladdress3']['value']) ? $reponseData['postaladdress3']['value'] : '';
			$data['postalcode'] = $reponseData['postalcode']['value'];
			$data['city'] = $reponseData['city']['value'];
			$data['country'] = $reponseData['country']['value'];
			$data['email'] = $reponseData['receiverIds']['value'];
			$data['cvtext'] = $reponseData['cvtext']['value'];
			$data['motivationtext'] = $reponseData['motivationtext']['value'];			
			
			if ( isset($reponseData['offerref']['value']) )
			{
				$data['offerref'] = DocumentHelper::getDocumentInstance($reponseData['offerref']['value']);
			}			
			
			if ( isset($reponseData['cvfile']['value']) && $reponseData['cvfile']['value'] != '' )
			{
				$data['cvfile'] = DocumentHelper::getDocumentInstance($reponseData['cvfile']['value']);
			}
			else 
			{
				$data['cvfile'] = null;
			}
			
			if ( isset($reponseData['motivationfile']['value']) && $reponseData['motivationfile']['value'] != '' )
			{
				$data['motivationfile'] = DocumentHelper::getDocumentInstance($reponseData['motivationfile']['value']);
			}
			else 
			{
				$data['motivationfile'] = null;
			}
			
			if ($sender->getFormid() == 'modules_job/respondtooffer')
			{
				job_CandidacyService::getInstance()->addCandidacy($data);
			}
			else 
			{
				job_SpontaneouscandidacyService::getInstance()->addSpontaneousCandidacy($data);
			}
						
		}
		
	}
}