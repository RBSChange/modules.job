<?php
class job_OfferScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return job_persistentdocument_offer
     */
    protected function initPersistentDocument()
    {
    	return job_OfferService::getInstance()->getNewDocumentInstance();
    }
}