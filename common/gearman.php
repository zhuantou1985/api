<?
class Gearman
{
	protected $gm;
	
	public function __construct($type)
	{
		if($type == 'client')
		{
			$obj = new GearmanClient();
		}
		elseif($type == 'worker')
		{
			$obj = new GearmanWorker();
		}
		else
		{
			$obj = new GearmanClient();
			$obj->setTimeout(5000);
		}
		
		//Gearman
		$config_arr = array(
			'hosts' => array(
				array(
					'host' => '127.0.0.1',
					'port' => 4730,
					'persistent' => true,
				),
			)
		);
		foreach( $config_arr['hosts'] as $host_v )
			$obj->addServer($host_v['host'],$host_v['port']);
		
		$this->gm = $obj;
	}
	
	public function getInstance()
	{
		return $this->gm;
	}
	
	public function doBack($channel, $data)
	{
		$this->gm->doBackground($channel, serialize($data));
	}
	
	public function addWork($channel, $func)
	{
		$this->gm->addFunction($channel, $func);
	}
	
	public function work()
	{
		$this->gm->work();
	}
}
?>