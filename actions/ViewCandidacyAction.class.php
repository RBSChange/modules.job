<?php
class job_ViewCandidacyAction extends job_Action
{
    
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
    {
	
    	$documentId = $request->getParameter( K::COMPONENT_ID_ACCESSOR );
    	$document = DocumentHelper::getDocumentInstance($documentId);
    	
    	$request->setAttribute('document', $document);
    	
    	return View::SUCCESS ;
       
    }

}
?>