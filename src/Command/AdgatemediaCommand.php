<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Command\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Adgatemedia command.
 */
class AdgatemediaCommand extends Command
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
		$json = file_get_contents('https://api.adgatemedia.com/v3/offers/?aff=48864&api_key=155efa664a706f295fb446570041d707&wall_code=o6qb');
		$decodedData = json_decode($json);
		$this->loadModel('Adgatemedias');   
		$this->Adgatemedias->deleteAll(['Adgatemedias.id >'=>0]);
		$AdgatemediaTable = \Cake\ORM\TableRegistry::get('Adgatemedias'); 
		
		if ($decodedData !== null) {
			// Loop through each stdClass object in the array
			foreach ($decodedData->data as $item) {
				$Adgatemedia = $AdgatemediaTable->newEmptyEntity();
				$Adgatemedia->name = $this->encrypt_code_env($item->name);
				$Adgatemedia->requirements = $this->encrypt_code_env($item->requirements);
				$Adgatemedia->description = $this->encrypt_code_env($item->description);
				$Adgatemedia->epc =  $item->epc ;
				$Adgatemedia->click_url = $this->encrypt_code_env($item->click_url); 
				
				$save =$this->Adgatemedias->save($Adgatemedia); 
			}
		} else {
			echo "Failed to decode JSON.";
		}  
        $io->success('Your command has executed successfully.');
    }
	public function encrypt_code_env($string) {
		$key = '';
		$plaintext = $string;
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
		return $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
	}
}
