<?php
class job_persistentdocument_spontaneouscandidacy extends job_persistentdocument_spontaneouscandidacybase implements export_ExportableDocument
{
	
	/**
	 * Get the exported document
	 *
	 * @return export_ExportedDocument
	 */
	public function getExportedDocument()
	{
		$exportedDoc = new export_ExportedDocument();
		$exportedDoc->setProperty('lastname', $this->getLastname());
		$exportedDoc->setProperty('firstname', $this->getFirstname());
		$exportedDoc->setProperty('birthdate', $this->getBirthdate());
		$exportedDoc->setProperty('postaladdress1', $this->getPostaladdress1());
		$exportedDoc->setProperty('postaladdress2', $this->getPostaladdress2());
		$exportedDoc->setProperty('postaladdress3', $this->getPostaladdress3());
		$exportedDoc->setProperty('postalcode', $this->getPostalcode());
		$exportedDoc->setProperty('city', $this->getCity());
		$exportedDoc->setProperty('country', $this->getCountry());
		$exportedDoc->setProperty('email', $this->getEmail());
		$exportedDoc->setProperty('cvtext', $this->getCvtext());
		$exportedDoc->setProperty('motivationtext', $this->getMotivationtext());
		$exportedDoc->setLang(RequestContext::getInstance()->getLang());
		return $exportedDoc;
	}
	
	/**
	 * @param string $moduleName
	 * @param string $treeType
	 * @param array<string, string> $nodeAttributes
	 */	
	protected function addTreeAttributes($moduleName, $treeType, &$nodeAttributes)
	{
		$nodeAttributes['creationdate'] = date_DateFormat::format($this->getUICreationdate(), 'D d M Y H:i', RequestContext::getInstance()->getUILang());
		if ($this->getHandlingdate() != NULL)
		{
		    $nodeAttributes['modifdate'] = date_DateFormat::format($this->getUIHandlingdate(), 'D d M Y H:i', RequestContext::getInstance()->getUILang());
		}
		else
		{
		    $nodeAttributes['modifdate'] = '';
		}		
	}
	
}