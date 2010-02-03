<?php
class job_CandidacyHandlingWorkflowaction extends workflow_BaseWorkflowaction
{
	/**
	 * This method will execute the action.
	 * @return boolean true if the execution end successfully, false in error case.
	 */
	function execute()
	{
		$context = Context::getInstance();
		$request = $context->getRequest();
				
		$candidacyService = job_CandidacyService::getInstance();
		$candidacy = $this->getDocument();
		
		$notificationService = notification_NotificationService::getInstance();
		$offer = $candidacy->getOfferref();
		
		if ( $request->getParameter('decision') == 'ACCEPTED' )
		{
			$candidacyService->activate($candidacy->getId());
			$notificationCode = 'modules_job/candidacyAccepted';
		}
		else 
		{
			$candidacyService->cancel($candidacy->getId());
			$notificationCode = 'modules_job/candidacyRefused';
		}
		
		$candidacyService->updateCandidacyStatus($candidacy, $request->getParameter('decision'));
		
		if ($request->getParameter('sendmail') == 'true' || $request->getParameter('sendmail') === true)
		{
			$notification = $notificationService->getNotificationByCodeName($notificationCode);
			$notification->setSubject($request->getParameter('messageSubject'));
			$notification->setBody($request->getParameter('messageBody'));
			$notificationService->sendMail($notification, array($candidacy->getEmail()), array('offerlabel' => $offer->getLabel(), 'lastname' => $candidacy->getLastname(), 'firstname' => $candidacy->getFirstname()));
		}
		
		return parent::execute();
	}
}