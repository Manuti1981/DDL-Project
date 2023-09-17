<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\I18n;
use Cake\Controller\Controller;
use Cake\Routing\Router;
use Cake\Event\EventInterface;
class AppController extends Controller
{
	public function initialize(): void {
		parent::initialize();
		$this->loadComponent('RequestHandler');
        
		 
		
		if($_SERVER['SERVER_NAME']=='localhost'){
			$this->set('base_url','http://'.$_SERVER['SERVER_NAME'].Router::url('/'));
		}else{
			$this->set('base_url','https://'.$_SERVER['SERVER_NAME'].Router::url('/'));
		}
		if($_SERVER['SERVER_NAME']=='localhost'){
			define("BASE_URL", 'http://'.$_SERVER['SERVER_NAME'].Router::url('/'));
		}else{
			define("BASE_URL", 'https://'.$_SERVER['SERVER_NAME'].Router::url('/'));
		}
		  
	}
	public function beforeFilter(EventInterface $event) {
		# We check if we have a language set
		if ($this->request->getParam('lang')) {
		   I18n::setLocale($this->request->getParam('lang'));
		} else {
		  # If we don't have one, we will set the default one (in my case it's English)
		   I18n::setLocale('en');
		}
	} 
}
