<?php
class job_BlockTopicAction extends abstractdirectory_BlockTopicAction
{
    
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('job');
		$this->setComponentName('offer');
	}
	
	/**
	 * @param website_persistentdocument_topic
	 * @return Array f_persistentdocument_PersistentDocument
	 */
	protected function getOrderedItems($container)
	{
		$query = $this->getPersistentProvider()->createQuery('modules_job/offer');
		$query->add(Restrictions::childOf($container->getId()))
			->add(Restrictions::published());
			
		if ( $this->hasParameter('order') && $this->getParameter('order') == 'alpha' )
		{
			$query->addOrder(Order::asc('document_label'));
		}
		else 
		{
			$query->addOrder(Order::asc('document_creationdate'));
		}
		
		return $query->find();
	}
	
	/**
	 * This is a entry to add some informations to the template without rewrite execute method
	 *
	 */
	protected function setAdditionalParameters()
	{
		// Check if spontaneous offer is publish
		$spontaneousOfferService = job_SpontaneousofferService::getInstance();
		$spontaneousOffer = $spontaneousOfferService->getSpontaneousOffer();
		if ( $spontaneousOffer !== null )
		{
			// Get the page with the tag for the form
			$ws = website_WebsiteModuleService::getInstance();
			try 
			{
				$formPage = $ws->getDocumentByContextualTag('contextual_website_website_modules_job-spontaneouscandidacyform', $ws->getCurrentWebsite());
				
				if ( $formPage->isPublicated() )
				{
					$this->setParameter('formSpontaneousCandidacyPage', $formPage);
				}
			}
			catch (TagException $e)
			{
				Framework::exception($e);
			}
		}		
	}
	
}