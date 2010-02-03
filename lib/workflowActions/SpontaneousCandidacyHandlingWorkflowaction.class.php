<?php
class job_SpontaneousCandidacyHandlingWorkflowaction extends workflow_BaseWorkflowaction
{
	/**
	 * This method will execute the action.
	 * @return boolean true if the execution end successfully, false in error case.
	 */
	function execute()
	{
		$context = Context::getInstance();
		$request = $context->getRequest();
				
		$candidacyService = job_SpontaneouscandidacyService::getInstance();
		$candidacy = $this->getDocument();
		
		$notificationService = notification_NotificationService::getInstance();
		
		if ( $request->getParameter('decision') == 'ACCEPTED' )
		{
			$candidacyService->activate($candidacy->getId());
			$notificationCode = 'modules_job/spontaneousCandidacyAccepted';
		}
		else 
		{
			$candidacyService->cancel($candidacy->getId());
			$notificationCode = 'modules_job/spontaneousCandidacyRefused';
		}

		$candidacyService->updateCandidacyStatus($candidacy, $request->getParameter('decision'));
		
		if ($request->getParameter('sendmail') == 'true' || $request->getParameter('sendmail') === true)
		{
			$notification = $notificationService->getNotificationByCodeName($notificationCode);
			$notification->setSubject($request->getParameter('messageSubject'));
			$notification->setBody($request->getParameter('messageBody'));
			$notificationService->sendMail($notification, array($candidacy->getEmail()), array('lastname' => $candidacy->getLastname(), 'firstname' => $candidacy->getFirstname()));
		}
		
		return parent::execute();
	}
}