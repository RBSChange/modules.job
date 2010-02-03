<?php
class job_PreferencesScriptDocumentElement extends import_ScriptDocumentElement
{
    /**
     * @return job_persistentdocument_preferences
     */
    protected function initPersistentDocument()
    {
    	$document = ModuleService::getInstance()->getPreferencesDocument('job');
    	return ($document !== null) ? $document : job_PreferencesService::getInstance()->getNewDocumentInstance();
    }
}