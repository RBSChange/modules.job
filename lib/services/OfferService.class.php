<?php
class job_OfferService extends f_persistentdocument_DocumentService
{
	/**
	 * Singleton
	 * @var job_OfferService
	 */
	private static $instance;

	/**
	 * @return job_OfferService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return job_persistentdocument_offer
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_job/offer');
	}

	/**
	 * Create a query based on 'modules_job/offer' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_job/offer');
	}

	/**
	 * @param job_persistentdocument_offer $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId = null)
	{
		$document->setOffertype(DocumentHelper::getLabelForDisplay($document->getOffertypeitem(), RequestContext::getInstance()->getLang()));
	}

	/**
	 * Count candidacy + 1 on offer
	 *
	 * @param job_persistentdocument_offer $offer
	 */
	public function addCandidacy($offer)
	{
		$offer->setCandidacycount($offer->getCandidacycount() + 1);
		$this->getPersistentProvider()->updateDocument($offer);
	}

	/**
	 * @param f_persistentdocument_PersistentDocument $document
	 * @return boolean true if the document is publishable, false if it is not.
	 */
	public function isPublishable($document)
	{
		if (!parent::isPublishable($document) || $document->getStartpublicationdate() === null)
		{
			return false;
		}

		return true;
	}

	/**
	 * @param job_persistentdocument_offer $document
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	public function addTreeAttributes($document, $moduleName, $treeType, &$nodeAttributes)
	{
	    $nodeAttributes['offertype'] = $document->getOffertype();
	}
}