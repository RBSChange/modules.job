<?php
class job_persistentdocument_spontaneousoffer extends job_persistentdocument_spontaneousofferbase implements export_ExportableDocument
{
	
	/**
	 * Get the exported document
	 *
	 * @return export_ExportedDocument
	 */
	public function getExportedDocument()
	{
		$pp = $this->getProvider();
		$candidacies = $pp->createQuery('modules_job/spontaneouscandidacy')->add(Restrictions::descendentOf($this->getId()))->find();
		
		$exportedDoc = new export_ExportedDocument();
		$exportedDoc->setLang(RequestContext::getInstance()->getLang());
		
		foreach ($candidacies as $candidacy)
		{
			$exportedCandidacy = $candidacy->getExportedDocument();
			$exportedDoc->addChildProperties($exportedCandidacy->getProperties());
		}
		return $exportedDoc;
	}
	
}