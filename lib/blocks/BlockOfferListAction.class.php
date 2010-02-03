<?php
class job_BlockOfferListAction extends abstractdirectory_BlockListAction
{
    public function initialize($context, $request)
	{
		parent::initialize($context, $request);
		$this->setModuleName('job');
		$this->setComponentName('offer');
	}
}