<?php
class job_BlockOfferAction extends abstractdirectory_BlockItemAction
{
    public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('job');
		$this->setComponentName('offer');
	}
	
	/**
	 * This is a entry to add some informations to the template without rewrite execute method
	 *
	 */
	protected function setAdditionalParameters()
	{
		$document = $this->getDocumentParameter();
                if ($document !== null)
                {
                        $this->setParameter('summary', f_util_StringUtils::shortenString($document->getPresentation(), 100));
                }
	}
}
