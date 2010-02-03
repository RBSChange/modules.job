<?php
class job_CandidacyHandlingView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$this->forceModuleName('job');
		$this->setTemplateName('Job-CandidacyHandling', K::XUL);
		$task = $request->getAttribute('task');
		$lang = $task->getWorkitem()->getCase()->getlang();

		try
		{
			RequestContext::getInstance()->beginI18nWork($lang);
			$workDocument = DocumentHelper::getDocumentInstance($task->getWorkitem()->getDocumentid());
			
			// Get the four default notification
			$notificationService = notification_NotificationService::getInstance();
			$acceptNotif = $notificationService->getNotificationByCodeName('modules_job/candidacyAccepted');
			$refuseNotif = $notificationService->getNotificationByCodeName('modules_job/candidacyRefused');
			
			$notificationAccept = f_util_StringUtils::php_to_js(array('subject' => $acceptNotif->getSubject(), 'body' => $acceptNotif->getBody(), 'authorizedParams' => $acceptNotif->getAvailableparameters()), true);
			$notificationRefuse =  f_util_StringUtils::php_to_js(array('subject' => $refuseNotif->getSubject(), 'body' => $refuseNotif->getBody(), 'authorizedParams' => $refuseNotif->getAvailableparameters()), true);

			$this->setAttribute('document', $workDocument);
			$this->setAttribute('task', $task);
			$this->setAttribute('notificationAccept', $notificationAccept);
			$this->setAttribute('notificationRefuse', $notificationRefuse);
			RequestContext::getInstance()->endI18nWork();
		}
		catch (Exception $e)
		{
			RequestContext::getInstance()->endI18nWork($e);
		}
		
		$this->setAttribute(
           'cssInclusion',
           $this->getStyleService()
	    	  ->registerStyle('modules.dashboard.dashboard')
	    	  ->registerStyle('modules.uixul.bindings')
	    	  ->registerStyle('modules.uixul.backoffice')
	    	  ->execute(K::XUL)
	    );

		// include JavaScript
		$this->getJsService()->registerScript('modules.uixul.lib.default');
		$this->getJsService()->registerScript('modules.dashboard.lib.js.dashboardwidget');
        $this->setAttribute('scriptInclusion', $this->getJsService()->executeInline(K::XUL));
	}
}
