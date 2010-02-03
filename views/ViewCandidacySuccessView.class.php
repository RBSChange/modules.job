<?php
class job_ViewCandidacySuccessView extends f_view_BaseView
{
	/**
	 * @param Context $context
	 * @param Request $request
	 */
	public function _execute($context, $request)
	{
		$this->setTemplateName('Job-ViewCandidacy-Success', K::HTML);
		
		// Module backoffice styles :
		$this->setAttribute(
           'cssInclusion',
           $this->getStyleService()
	    	  ->registerStyle('modules.dashboard.dashboard')
	    	  ->execute(K::HTML)
	    );
		
	    $document = $request->getAttribute('document');
	    
	    $offerinfo = null;
	    if ( $document instanceof job_persistentdocument_candidacy && ! is_null($document->getOfferref()) )
	    {
	    	$offer = $document->getOfferref();
	    	$offerLabel = ! is_null($offer->getReference()) ? $offer->getlabel() . '('. $offer->getReference() .')' : $offer->getlabel();
	    	$offerinfo = f_Locale::translate('&modules.job.document.candidacy.Offerinfo;', array('offerLabel' => $offerLabel, 'offerdate' => date_DateFormat::format(date_Calendar::getInstance($offer->getStartpublicationdate()),'d M Y',RequestContext::getInstance()->getUILang())));
	    }
	    
		$this->setAttribute('offerinfo', $offerinfo);
	    $this->setAttribute('document', $document);
	}
}