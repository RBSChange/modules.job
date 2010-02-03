<?php
class job_persistentdocument_candidacy extends job_persistentdocument_candidacybase implements export_ExportableDocument
{
	/**
	 * Get the exported document
	 * @return export_ExportedDocument
	 */
	public function getExportedDocument()
	{
	    $exportedDoc = parent::getExportedDocument();
		$offer = $this->getOfferref();
		$exportedDoc->setProperty('offerlabel', $offer->getLabel());
		$exportedDoc->setProperty('offerref', $offer->getReference());
		return $exportedDoc;
	}
	
}