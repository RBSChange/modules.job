<?php
class job_SpontaneouscandidacyService extends f_persistentdocument_DocumentService
{
	/**
	 * Singleton
	 * @var job_SpontaneouscandidacyService
	 */
	private static $instance;

	/**
	 * @return job_SpontaneouscandidacyService
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = self::getServiceClassInstance(get_class());
		}
		return self::$instance;
	}

	/**
	 * @return job_persistentdocument_spontaneouscandidacy
	 */
	public function getNewDocumentInstance()
	{
		return $this->getNewDocumentInstanceByModelName('modules_job/spontaneouscandidacy');
	}

	/**
	 * Create a query based on 'modules_job/spontaneouscandidacy' model
	 * @return f_persistentdocument_criteria_Query
	 */
	public function createQuery()
	{
		return $this->pp->createQuery('modules_job/spontaneouscandidacy');
	}

	/**
	 * @param job_persistentdocument_spontaneouscandidacy $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function preSave($document, $parentNodeId = null)
	{
		$document->setLabel($document->getFirstname() . ' ' . $document->getLastname() );
	}

	/**
	 * Update the status of treatment
	 *
	 * @param job_persistentdocument_spontaneouscandidacy $document
	 * @param String ACCEPTED or REFUSED
	 */
	public function updateCandidacyStatus($document, $status)
	{
		$document->setCandidacystatus($status);
		$document->setHandlingdate(gmdate('Y-m-d H:i:s'));
		$this->getPersistentProvider()->updateDocument($document);
	}

	/**
	 * Add a spontaneous candidacy to the tree under spontaneous offer
	 *
	 * @param array<String> $data
	 */
	public function addSpontaneousCandidacy($data)
	{
		$candidacy = $this->createCandidacy($data);
		$node = TreeService::getInstance()->getInstanceByDocumentId($this->getFolderOfDay());
		$node->addNewChild($node, $candidacy);
	}

	/**
	 * Create a candidacy from an array
	 *
	 * @param array<String> $data
	 * @return job_persistentdocument_spontaneouscandidacy
	 */
	protected function createCandidacy($data)
	{
		$candidacy = $this->getNewDocumentInstance();
		foreach ($data as $key => $value)
		{
			$methoName = 'set'.ucfirst($key);
			$candidacy->$methoName($value);
		}
		$candidacy->save();
		return $candidacy;
	}

	/**
	 * Return the Id of folder where the spontaneous candidacy must be saved
	 *
	 * @return Integer
	 */
	private function getFolderOfDay()
	{
		// Get the current year, month, day
		$today = date_Calendar::getInstance();

		$pp = $this->getPersistentProvider();

		$spontaneousOffer = job_SpontaneousofferService::getInstance()->getSpontaneousOffer();

		// Search if folders exist
		$query = $pp->createQuery('modules_generic/folder')
			->setProjection(Projections::max('id'))
			->add(Order::desc('creationdate'))
			->add(Restrictions::like('creationdate', date_DateFormat::format($today, 'Y-m-d'), MatchMode::ANYWHERE() ) )
			->add(Restrictions::descendentOf($spontaneousOffer->getId()))
			->add(Restrictions::eq('label', date_DateFormat::format($today, 'd')));

		$folderDay = $query->findUnique();
		$folderDay = $folderDay['maxid'];

		if ( is_null($folderDay) )
		{
			$this->folderService = generic_FolderService::getInstance();

			// Year folder
			$folderYear = $pp->createQuery('modules_generic/folder')
				->setProjection(Projections::max('id'))
				->add(Restrictions::eq('label', date_DateFormat::format($today, 'Y')))
				->add(Restrictions::childOf($spontaneousOffer->getId()))
				->findUnique();
			$folderYear = $folderYear['maxid'];

			if ( ! is_null($folderYear) )
			{
				// Month folder
				$folderMonth = $pp->createQuery('modules_generic/folder')
					->setProjection(Projections::max('id'))
					->add(Restrictions::childOf($folderYear))
					->add(Restrictions::eq('label', date_DateFormat::format($today, 'm')))
					->findUnique();
				$folderMonth = $folderMonth['maxid'];

				if ( ! is_null($folderMonth) )
				{
					// Day folder
					$folderDay = $pp->createQuery('modules_generic/folder')
						->setProjection(Projections::max('id'))
						->add(Restrictions::childOf($folderMonth))
						->add(Restrictions::eq('label', date_DateFormat::format($today, 'd')))
						->findUnique();
					$folderDay = $folderDay['maxid'];

					if ( is_null($folderDay) )
					{
						// Create the day folder
						$folderDay = $this->createDayFolder(date_DateFormat::format($today, 'd'), $folderMonth);
					}
				}
				else
				{
					// Create the month and the day folder
					$folderMonth = $this->createMonthFolder(date_DateFormat::format($today, 'm'), $folderYear);
					$folderDay = $this->createDayFolder(date_DateFormat::format($today, 'd'), $folderMonth);
				}
			}
			else
			{
				// Create the year, month and the day folder
				$folderYear = $this->createYearFolder(date_DateFormat::format($today, 'Y'));
				$folderMonth = $this->createMonthFolder(date_DateFormat::format($today, 'm'), $folderYear);
				$folderDay = $this->createDayFolder(date_DateFormat::format($today, 'd'), $folderMonth);
			}
		}

		return $folderDay;
	}

	private function createYearFolder($label)
	{
		$folderYear = $this->folderService->getNewDocumentInstance();
		$folderYear->setLabel($label);
		$folderYear->save(job_SpontaneousofferService::getInstance()->getSpontaneousOffer()->getId());

		return $folderYear->getId();
	}

	private function createMonthFolder($label, $parent)
	{
		$folderMonth = $this->folderService->getNewDocumentInstance();
		$folderMonth->setLabel($label);
		$folderMonth->save($parent);

		return $folderMonth->getId();
	}

	private function createDayFolder($label, $parent)
	{
		$folderDay = $this->folderService->getNewDocumentInstance();
		$folderDay->setLabel($label);
		$folderDay->save($parent);

		return $folderDay->getId();
	}

	/**
	 * @param job_persistentdocument_spontaneouscandidacy $document
	 * @param Integer $parentNodeId Parent node ID where to save the document (optionnal => can be null !).
	 * @return void
	 */
	protected function postInsert($document, $parentNodeId = null)
	{
		// Launch the workflow on the candidacy
		$this->createWorkflowInstance($document->getId());
	}

	/**
	 * @param f_persistentdocument_PersistentDocument $document
	 * @return boolean true if the document is publishable, false if it is not.
	 */
	public function isPublishable($document)
	{
		return false;
	}
}