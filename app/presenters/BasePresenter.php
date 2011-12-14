<?php

use Nette\Application\UI\Presenter,
	Nette\Utils\Strings,
	Nette\Utils\Html,
	Maite\Tabella;

class BasePresenter extends Presenter {

	public function renderDefault($id) {
		$this->setLayout(false);
		$content = file_get_contents($this->context->params['appDir'].'/presenters/BasePresenter.php');

		$upperId = Strings::upper($id);
		$matches = Strings::match($content,
				sprintf('#//%s(.*?)//%s#sm', $upperId, $upperId));

			$this->template->code = str_replace('\t', '	 ', $matches[1]);
			$this->template->name = $id;
			$this->template->tabellaName = $id.'Tabella';
	}



	//BASIC
	protected function createComponentBasicTabella($name) {
		$grid = new Tabella(array(
				'context' => $this->context,
				'source'  => $this->context->model->users->source()
			));

		$grid->addColumn('Id', 'id', array('width' => 30));

		$grid->addColumn('Surame', 'surname', array('width' => 100));

		$grid->addColumn('Name', 'name', array('width' => 100));

		$grid->addColumn('Sex', 'sex', array('width' => 50));

		$grid->addColumn('Sons', 'sons', array('width' => 65));

		$grid->addColumn('Daughters', 'daughters', array('width' => 65));

		$grid->addColumn('Born', 'born', array('type' => Tabella::DATETIME));

		$grid->addColumn('Dead', 'dead', array('type' => Tabella::DATETIME));

		$this->addComponent($grid, $name);
	}//BASIC



	//EDITABLE
	protected function createComponentEditableTabella($name) {
		$model = $this->context->model; // in PHP 5.4 won't be necessary
		$grid = new Tabella(array(
				'context'  => $this->context,
				'source'   => $this->context->model->users->source(),
		 		'limit'    => 15,
		 		'sorting'  => 'desc',
		 		'onSubmit' => function($post) use ($model) {
		 			$post['born'] = strtotime($post['born']);
		 			$model->users->save($post);
				},
				'onDelete' => function($id) {
					//$model->users->delete($id);
				}
			));

		$grid->addColumn('Id', 'id', array(
				'width' => 30
			));

		$grid->addColumn('Surname', 'surname', array(
				'width'    => 100,
				'editable' => true
			));

		$grid->addColumn('Name', 'name', array(
				'width'    => 100,
				'editable' => true
			));

		$grid->addColumn('Sex', 'sex', array(
				'type'     => Tabella::SELECT,
				'options'  => array('male' => 'Male', 'female' => 'Female'),
				'width'    => 50,
				'editable' => true,
			));

		$grid->addColumn('Sons', 'sons', array(
				'width'    => 65,
				'editable' => true
			));

		$grid->addColumn('Daughters', 'daughters', array(
				'width'   => 65,
				'editable' => true
			));

		$grid->addColumn('Born', 'born', array(
				'type' => Tabella::DATE,
				'dateFormat' => '%Y/%m/%d',
				'editable' => true
			));

		$grid->addColumn('+', Tabella::ADD, array(
				'type' => Tabella::DELETE
			));

		$this->addComponent($grid, $name);
	}//EDITABLE



	//COMPLEX
	protected function createComponentComplexTabella($name) {

		$context = $this->context;

		$grid = new Tabella(array(
				'context'     => $this->context,
				'source'      => $this->context->model->users->source(),
				'order'       => 'surname',
				'limit'       => 15,
				'rowRenderer' => function($row) {
					return Html::el('tr')->class($row->sex);
				}
			));

		$grid->addColumn('Id', 'id', array(
			  		'width' => 30
			));

		$grid->addColumn('Surname', 'surname', array(
				'renderer' => function($row) use ($context) {
					// can be a link within the application
					return Html::el('td')->class('al')->add(Html::el('a')->target('_blank')
						->href($context->application->presenter
							->link('this', array(
								'complexTabella-filter' => array('id' => $row->id))))
						->add(Strings::truncate($row->surname, 25)));
					return $td;
		 		},
		 		// own filter handler which reacts on change in the filter input
		 		'filterHandler' => function($source, $value) {
					$source->where('surname')->like('%s', $value.'%');
		 		},
		 		'width' => 100
		));

		$grid->addColumn('Name', 'name', array(
				// own filter handler which reacts on change in the filter input
				'filterHandler' => function($source, $value) {
					$source->where('name')->like('%s', $value.'%');
				},
				'class' => array('center', 'upper'),
				// html class can be a string or array
				'width' => 100
		));

		$grid->addColumn('Sex', 'sex', array(
				'width' => 50,
				// makes selectbox filter
				'filter' => array('' => '', 'male' => 'male', 'female' => 'female'),
				'filterHandler' => function($source, $value) {
					$source->where('sex = %s', $value);
				}
		));

		$grid->addColumn('Children', 'children', array(
				'width' => 40,
				'filter' => array(
					'' => '',
					0 => 'having none',
					1 => 'having son',
					2 => 'having daughter',
					3 => 'having both'),
				'filterHandler' => function($source, $value) {
					switch($value) {
						case 0: $source->having('children = 0');
						case 1: $source->having('sons > 0');
						case 2: $source->having('daughters > 0');
						case 3: $source->having('sons > 0 AND daughters > 0');
					}
				},
				'headerElement' => Html::el('th')->colspan('2'),
				'renderer' => function($row) {
					$td = Html::el('td')->style('width:17px;')->add($row->sons).
							Html::el('td')->style('width:17px;')->add($row->daughters);
					return $td;
				}
		));

		$grid->addColumn('Born', 'born', array(
				'type' => Tabella::DATE,
				'class' => 'center',
				'dateFormat' => '%Y/%m/%d',
				'filterHandler' => function($source, $value) {
					$start = strtotime('$val 00:00');
					$end = $start + Nette\DateTime::DAY;
					$source->where('born > %i AND born < %i', $start, $end);
				}
		));
		$grid->addColumn('Dead', 'dead', array(
					'type' => Tabella::DATE,
				'class' => 'center',
					'dateFormat' => '%Y/%m/%d',
				'filterHandler' => function($source, $value) {
					$start = strtotime('$val 00:00');
					$end = $start + Nette\DateTime::DAY;
					$source->where('dead > %i AND dead < %i', $start, $end);
				}
		));

		$this->addComponent($grid, $name);
	}//COMPLEX
}
