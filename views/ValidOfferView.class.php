<?php
class job_ValidOfferView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$this->forceModuleName('job');
		$this->setTemplateName('Job-ValidOffer', K::XUL);
		$task = $request->getAttribute('task');
		$lang = $task->getWorkitem()->getCase()->getlang();
		
		try
		{
			RequestContext::getInstance()->beginI18nWork($lang);
			$workDocument = DocumentHelper::getDocumentInstance($task->getWorkitem()->getDocumentid());
			$model = $workDocument->getDocumentModel();
			$document = DocumentHelper::getPropertiesOf($workDocument);
			$document['id'] = $workDocument->getId();
			$document['taskId'] = $task->getId();
			$this->setAttribute('document', $document);
			
			$this->setAttribute('documentInstance', $workDocument);
			$this->setAttribute('task', $task);
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
		$scripts = array(
			'modules.uixul.lib.default',
			'modules.dashboard.lib.js.dashboardwidget'
		);
		foreach ($scripts as $script)
		{
			$this->getJsService()->registerScript($script);
		}

        $this->setAttribute('scriptInclusion', $this->getJsService()->executeInline(K::XUL));
	}
}
