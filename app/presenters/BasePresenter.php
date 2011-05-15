<?php

use Nette\Application\UI\Presenter,
	Nette\Utils\Strings,
	Nette\Utils\Html,
	Nette\Environment,
	Addons\Tabella;

class BasePresenter extends Presenter {

		public function renderDefault( $id ) {
			$this->setLayout( false );
			$foo = file_get_contents( APP_DIR."/presenters/BasePresenter.php" );
	  	  	preg_match( "/\/\/".Strings::upper( $id )."(.*?)\/\/".Strings::upper( $id )."/sm", $foo, $regs );
	  	  	$this->template->code = str_replace( "\t", "    ", $regs[1] );
	  	  	$this->template->name = $id;
	  	  	$this->template->tabellaName = $id."Tabella";
		}
		
		//BASIC
		protected function createComponentBasicTabella( $name ) {
			// asi nepotřebuje komentář :-)
			$grid = new Tabella( UsersModel::dataSource() );
			$grid->addColumn( "Id", "id", array( "width" => 30 ) );
			$grid->addColumn( "Surame", "surname", array( "width" => 100 ) );
			$grid->addColumn( "Name", "name", array( "width" => 100 ) );
			$grid->addColumn( 'Sex', 'sex', array( "width" => 50 ) );
			$grid->addColumn( "Sons", "sons", array( "width" => 65 ) );
			$grid->addColumn( "Daughters", "daughters", array( "width" => 65 ) );
			$grid->addColumn( 'Born', 'born', array( "type" => Tabella::DATETIME ) );
			$grid->addColumn( 'Dead', 'dead', array( "type" => Tabella::DATETIME ) );
			$this->addComponent( $grid, $name );		    
		}//BASIC

		//EDITABLE
		protected function createComponentEditableTabella( $name ) {
			$grid = new Tabella( UsersModel::dataSource(), array(
	    		"limit" => 15,					// limit
	    		"sorting" => "desc",
	    		"onSubmit" => function( $post ) {
	    			$post['born'] = strtotime( $post['born'] );
	    			UsersModel::save( $post, $post['id'] );
				},
				"onDelete" => function( $id ) {
					//UsersModel::delete( $id );
				}
			));
			$grid->addColumn( "Id", "id", array( "width" => 30 ) );
			$grid->addColumn( "Surname", "surname", array( 
					"width" => 100,
					"editable" => true 
			));
			$grid->addColumn( "Name", "name", array( 
					"width" => 100,
					"editable" => true ));
			$grid->addColumn( 'Sex', 'sex', array( 
					"type" => Tabella::SELECT,
					"options" => array( 'male' => 'Male', 'female' => 'Female' ),
					"width" => 50,
					"editable" => true,
			));
			$grid->addColumn( "Sons", "sons", array( 
					"width" => 65,
					"editable" => true ));
			$grid->addColumn( "Daughters", "daughters", array( 
					"width" => 65,
					"editable" => true ));
			$grid->addColumn( "Born", "born", array( 
					"type" => Tabella::DATE,
					"dateFormat" => "%Y/%m/%d",
					"editable" => true
			));
			
			$grid->addColumn( "+", Tabella::ADD, array( 
					"type" => Tabella::DELETE 
			));
			
			$this->addComponent( $grid, $name );		    
		}//EDITABLE

		//COMPLEX
		protected function createComponentComplexTabella( $name ) {
		    $grid = new Tabella( UsersModel::dataSource(), array( 
		    		"order" => "surname", 			// default order by surname
		    		"limit" => 15,					// limit
		    		"rowRenderer" => function( $row ) {
		    			return Html::el( "tr class=".$row->sex );
		    		}
		    ));
   		    
			$grid->addColumn( 'Id', 'id', array( 
   		    		"width" => 30
		    ));

			$grid->addColumn( "Surame", "surname", array( 
					"renderer" => function( $row ) {
						// can be a link within the application
				    	return Html::el( "td class=al" )->add( Html::el( 'a target=_blank' )
				    				->href( Environment::getApplication()->getPresenter()
				    						->link( "this", array( "id" => $row->id ) ) )
				    							->add( Strings::truncate( $row->surname, 25 ) ) );
				    	return $td;
		    		},
		    		// own filter handler which reacts on change in the filter input
		    		"filterHandler" => function( $val ) {
		    			return "surname LIKE '$val%'";
		    		},
		    		"width" => 100 
		    ));

			$grid->addColumn( "Name", "name", array( 
					// own filter handler which reacts on change in the filter input
		    		"filterHandler" => function( $val ) {
		    			return "name LIKE '$val%'";
		    		},
		    		"class" => array( "center", "upper" ),
		    		// html class can be a string or array
		    		"width" => 100 
		    ));

		    $grid->addColumn( 'Sex', 'sex', array( 
		    		"width" => 50,
		    		// makes selectbox filter
		    		"filter" => array( "" => "", "male" => "male", "female" => "female" ),
		    		"filterHandler" => function( $val ) {
		    			return "sex = '$val'";
		    		}
		    ));
		    
			$grid->addColumn( "Children", "children", array( 
					"width" => 40,
					"filter" => array( 
						"" => "", 
						0 => "having none", 
						1 => "having son", 
						2 => "having daughter", 
						3 => "having both" ),
					"filterHandler" => function( $val ) {
						switch( $val ) {
							case 0: return "children = 0";
							case 1: return "sons > 0";
							case 2: return "daughters > 0";
							case 3: return "sons > 0 AND daughters > 0";
						}
					},
					"headerElement" => Html::el( "th colspan=2" ),
					"renderer" => function( $row ) {
				    	$td = Html::el( "td" )->style("width:17px;")->add( $row->sons ).
				    			Html::el( "td" )->style("width:17px;")->add( $row->daughters );
				    	return $td;
					}
			));
			
			$grid->addColumn( 'Born', 'born', array( 
					"type" => Tabella::DATE,
					"class" => "center",
					"dateFormat" => "%Y/%m/%d",
					"filterHandler" => function( $val ) {
						$start = strtotime( "$val 00:00" );
						$end = $start + 86400;
						return "born > $start AND born < $end";
					}
			));
			$grid->addColumn( 'Dead', 'dead', array( 
   					"type" => Tabella::DATE,
					"class" => "center",
   					"dateFormat" => "%Y/%m/%d", 
					"filterHandler" => function( $val ) {
						$start = strtotime( "$val 00:00" );
						$end = $start + 86400;
						return "born > $start AND born < $end";
					}
			));

			$this->addComponent( $grid, $name );		    
		}//COMPLEX
}
