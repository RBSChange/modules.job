<?php
class job_XmlListTreeParser extends tree_parser_XmlListTreeParser
{
	/**
     * Returns the document's specific and/or overridden attributes.
     *
	 * @param f_persistentdocument_PersistentDocument $document
	 * @param XmlElement $treeNode
	 * @param f_persistentdocument_PersistentDocument $reference
	 * @return array<mixed>
	 */
	protected function getAttributes($document, $treeNode, $reference = null)
	{
		$data = parent::getAttributes($document, $treeNode, $reference);
		if ( ! is_null($startDate = $document->getStartpublicationdate()))
		{
			$data['startpublicationdate'] = $this->normalizeDate($startDate);
		}
		else
		{
			$data['startpublicationdate'] = '-';
		}
		if ( ! is_null($endDate = $document->getEndpublicationdate()) )
		{
			$data['endpublicationdate'] = $this->normalizeDate($endDate);
		}
		else
		{
			$data['endpublicationdate'] = '-';
		}
		return $data;
	}
}