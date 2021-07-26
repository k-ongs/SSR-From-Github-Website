<?PHP
namespace app\data;

class ssr
{
	private $cache_path = __STORAGE__ . 'cache/';
	private function SetCache($data)
	{
		if(!file_exists($this->cache_path))
		{
			if(!mkdir($this->cache_path, 0777, true))
			{
				return false;
			}
		}
		$file_path = $this->cache_path . 'ssr';
		if(file_put_contents($file_path, $data, LOCK_EX) !== false){
			touch($file_path, time() + 432000);
			return true;
		}
		return false;
	}
	
	private function GetCache()
	{	
		$data = '';
		$file_path = $this->cache_path . 'ssr';
		if(is_file($file_path))
		{
			@$data = file_get_contents($file_path);
			if(fileatime($file_path) < time())
			{
				$data = '';
			}
		}
		return $data;
	}

    public function index()
    {
		$data = $this -> GetCache();
		if($data == '' || isset($_GET['true']))
		{
			$url = 'https://github.com/Alvin9999/new-pac/wiki/ss%E5%85%8D%E8%B4%B9%E8%B4%A6%E5%8F%B7';
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_DNS_SERVERS, '127.0.0.1');
			$output = curl_exec($curl);
			curl_close($curl);
			$msg = '';
			if(preg_match_all ("/<p>([\w:\/=]*?)<\/p>/U", $output, $match))
			{
				foreach($match[1] as $value)
				{
					$msg .= $value . "\n";
				}
			}
			$data = base64_encode($msg);
			$this->SetCache($data);
		}
		return $data;
    }
}