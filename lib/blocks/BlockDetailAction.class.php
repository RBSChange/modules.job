<?php
class job_BlockDetailAction extends abstractdirectory_BlockDetailAction
{
	/**
     * @param block_BlockContext $context
     * @param block_BlockRequest $request
     */
	public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('job');
		$this->setComponentName('offer');
		$this->setViewModuleName('job');
	}
		
	/**
	 * This is a entry to add some informations to the template without rewrite execute method
	 *
	 */
	protected function setAdditionalParameters()
	{
		// Get the page with the tag for the form
		$ws = website_WebsiteModuleService::getInstance();
		try 
		{
			$formPage = $ws->getDocumentByContextualTag('contextual_website_website_modules_job-responseform', $ws->getCurrentWebsite());
			
			if ( $formPage->isPublicated() )
			{
				$this->setParameter('formPage', $formPage);
			}
		}
		catch (TagException $e)
		{
			Framework::exception($e);
		}
	}
}

class job_BlockDetailDummyView extends abstractdirectory_BlockDetailDummyView
{

	
}

class job_BlockDetailSuccessView extends abstractdirectory_BlockDetailSuccessView
{
}
