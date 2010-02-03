<?php
class job_ValidOfferWorkflowaction extends workflow_BaseWorkflowaction
{
	/**
	 * This method will execute the action.
	 * @return boolean true if the execution end successfully, false in error case.
	 */
	function execute()
	{
		$context = Context::getInstance();
		$request = $context->getRequest();
		
		$decision = $request->getParameter('decision');
		
		$offerService = job_OfferService::getInstance();
		$offer = $this->getDocument();
		
		if ( $decision == 'ACCEPTED' )
		{
			$offerService->activate($offer->getId());
		}
		else 
		{
			$offerService->cancel($offer->getId());
		}

		return parent::execute();
	}
	
	/**
	 * @see workflow_BaseWorkflowaction::updateTaskInfos()
	 *
	 * @param task_persistentdocument_usertask $task
	 */
	public function updateTaskInfos($task)
	{
		$commentary = $this->getCaseParameter('START_COMMENT');
		
		$author = $this->getCaseParameter('workflowAuthor');
		if (!empty($author))
		{
			$task->setDescription($author);
		}
		if (!empty($commentary))
		{
			$task->setCommentary($commentary);
		}	
	}
}