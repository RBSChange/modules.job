<?php
class job_SpontaneouscandidacyScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return job_persistentdocument_spontaneouscandidacy
     */
    protected function initPersistentDocument()
    {
    	return job_SpontaneouscandidacyService::getInstance()->getNewDocumentInstance();
    }
}