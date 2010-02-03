<?php
class job_CandidacyScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return job_persistentdocument_candidacy
     */
    protected function initPersistentDocument()
    {
    	return job_CandidacyService::getInstance()->getNewDocumentInstance();
    }
}