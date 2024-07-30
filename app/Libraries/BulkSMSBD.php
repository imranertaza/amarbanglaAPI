<?php
namespace APP\Libraries;

class BulkSMSBD {

    private string $url = "https://bulksmsbd.net/api/smsapi";
    private string $api_key = "hPUwFWX96d5MKq275z9s";
    private string $senderid = "8809617615106";


    /**
     * @description This method send SMS to admin phone number through API (BULKSMSBD)
     * @param int $phone
     * @param string $message
     */
    public function send_sms(int $phone, string $message) : void {
        $data = array(
            "api_key" => $this->api_key,
            "senderid" => $this->senderid,
            "number" => $phone,
            "message" => $message
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
    }
}

?>
