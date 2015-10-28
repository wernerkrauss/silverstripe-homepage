<?php

/**
 * StartGeneratedWithDataObjectAnnotator
 * @method DataList|HomePageBlock[] HomePageBlocks
 * EndGeneratedWithDataObjectAnnotator
 */
class HomePage extends Page {

	private static $has_many = [
		'HomePageBlocks' => 'HomePageBlock'
	];

	public function getCMSFields() {
		$self =& $this;
		$this->beforeUpdateCMSFields(function (FieldList $fields) use ($self) {

			/**
			 * @var GridFieldConfig_RecordEditor $conf
			 */
			$conf = GridFieldConfig_RecordEditor::create();

			$conf->addComponent(new GridFieldSortableRows('SortOrder'));

			$fields->addFieldToTab(
				"Root." . _t('HomePage.BlockTabName', 'Blocks'),
				Gridfield::create(
					'HomePageBlocks',
					_t('HomePage.Block', 'Blocks'),
					$this->HomePageBlocks(),
					$conf
				)
			);
		});

		$fields = parent::getCMSFields();

		return $fields;
	}

}

class HomePage_Controller extends Page_Controller {
	public function getActiveHomePageBlocks() {
		$blocks = $this->data()->HomePageBlocks();

		if(Versioned::current_stage() === 'Live') {
			$blocks = $blocks->filter('IsActive', 1);
		}

		return $blocks;
	}
}
