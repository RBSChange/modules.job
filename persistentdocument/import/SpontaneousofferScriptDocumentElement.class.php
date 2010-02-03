<?php
class job_SpontaneousofferScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return job_persistentdocument_spontaneousoffer
     */
    protected function initPersistentDocument()
    {
    	return job_SpontaneousofferService::getInstance()->getNewDocumentInstance();
    }
}