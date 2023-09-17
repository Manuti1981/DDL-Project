<?php
declare(strict_types=1);

namespace App\Controller;
use \SplFileObject;
use Cake\Event\EventInterface;
use App\Controller\AppController;  
/**
 * Maps Controller
 *
 * @method \App\Model\Entity\SchoolClass[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdgatemediasController extends AppController
{
	public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event); 
		 $this->viewBuilder()->setLayout('index');
		 
    } 
	public function index($regionid = 0)
    {
		$data = $this->Adgatemedias->find('all')->order(['Adgatemedias.id' => 'ASC']); ; 
		 
        $this->set(compact('data'));
    }
	 

       
}



