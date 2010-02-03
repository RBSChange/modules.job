<?php
class job_persistentdocument_offer extends job_persistentdocument_offerbase implements indexer_IndexableDocument, export_ExportableDocument{
	/**
	 * Get the indexable document
	 *
	 * @return indexer_IndexedDocument
	 */
	public function getIndexedDocument()
	{
		$indexedDoc = new indexer_IndexedDocument();
		$indexedDoc->setId($this->getId());
		$indexedDoc->setDocumentModel('modules_job/offer');
		$indexedDoc->setLabel($this->getLabel());
		$indexedDoc->setLang(RequestContext::getInstance()->getLang());
		$indexedDoc->setText($this->getLabel() . ' ' . $this->getReference() . ' ' . $this->getPresentation()  . ' ' . $this->getLocation()  . ' ' . $this->getBackground()  . ' ' . $this->getProfile() );
		return $indexedDoc;
	}
	
	/* Validate the documentinstance */
	public function isValid()
	{
		if (!is_null($this->getEndpublicationdate()))
		{
			$startDate = date_Calendar::getInstance($this->getStartpublicationdate());
			$endDate = date_Calendar::getInstance($this->getEndpublicationdate());
			if (!$startDate->isBefore($endDate))
			{
				throw new ValidationException('Start date must be before end date');
			}
		}

		return parent::isValid();
	}
	
	/**
	 * Get the exported document
	 *
	 * @return export_ExportedDocument
	 */
	public function getExportedDocument()
	{
		$candidacies = $this->getCandidacyArrayInverse(0, -1);
		
		$exportedDoc = new export_ExportedDocument();
		$exportedDoc->setLang(RequestContext::getInstance()->getLang());
		
		foreach ($candidacies as $candidacy)
		{
			$exportedCandidacy = $candidacy->getExportedDocument();
			$exportedDoc->addChildProperties($exportedCandidacy->getProperties());
		}
		return $exportedDoc;
	}

	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
	    $nodeAttributes['offertype'] = $this->getOffertype();
	}
}