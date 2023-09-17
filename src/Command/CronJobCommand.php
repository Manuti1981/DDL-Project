<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Command\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * CronJob command.
 */
class CronJobCommand extends Command
{
	
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
		$this->loadModel('Waves');	
		$this->loadModel('StationTypeDetails');	
	 	ini_set('max_execution_time', '0'); // for infinite time of execution 
		 
		$StationTypeDetails = $this->StationTypeDetails->find('all')->where()->order(['StationTypeDetails.id' => 'DESC']);
		
		foreach ($StationTypeDetails as $StationTypeDetail){
				
				$url='https://www.ndbc.noaa.gov/data/realtime2/'.$StationTypeDetail->stn.'.spec';
				
				$headers = array();
				$headers = @get_headers($url);
				 
				if($headers && strpos( $headers[0], '200')) { 
						$lines_array = array();
						$lines_array=file($url); 
						$lines_string=implode('',$lines_array); 
						$new = array();
						foreach($lines_array as $line)  { 
							  $test = trim(preg_replace('/[\t\n\r\s]+/', ' ', $line));
							  $new[] = str_replace(' ', '-',  $test); 
						}  
						$logsTable = \Cake\ORM\TableRegistry::get('Waves'); 
						
						if(count($new)>0){
							for($i=2;$i<=count($new);$i++){
								if(isset($new[$i]) && !empty($new[$i])){
									$data = explode('-',$new[$i]); 
								  echo $url;
									$wavesdetails = $this->Waves->find('all')->where(['Waves.yy' => $data[0],'Waves.mm' =>$data[1],'Waves.dd' => $data[2],'Waves.hh' => $data[3],'Waves.min' => $data[4],'Waves.stn' => $StationTypeDetail->stn ]);
									 $total = $wavesdetails->count();
									if($total == 0){
										$wave = $logsTable->newEmptyEntity();  
										$wave->station_type_detail_id = $StationTypeDetail->id;
										$wave->stn = $StationTypeDetail->stn;
										$wave->yy = $data[0];
										$wave->mm = $data[1];
										$wave->dd = $data[2];
										$wave->hh = $data[3];
										$wave->min = $data[4];
										$wave->wvht = $data[5];
										$wave->swh = $data[6];
										$wave->swp = $data[7];
										$wave->wwh = $data[8];
										$wave->wwp = $data[9];
										$wave->swd = $data[10];
										$wave->wwd = $data[11];
										$wave->steepness = $data[12];
										$wave->apd = $data[13];
										$wave->mwd = $data[14];
										 $wave->final_date = $data[0].'-'.$data[1].'-'.$data[2].' '.$data[3].':'.$data[4].':00';
										 
										$save_s_b =$this->Waves->save($wave);
									}
								}
							}
						}
				}
		}
		die;
    }
}
