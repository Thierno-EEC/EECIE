<?php

class GithubApi
{
    public static $labels = array();
    
    private $app;

    private $login;

    private $token;
    
    

    public function __construct($app)
    {
        $this->app = $app;
        $this->login = $this->app->user_config["github"]["login"];
        $this->token = $this->app->user_config["github"]["token"];
        self::$labels = $this->curl_request("repos/Thierno-EEC/vroom/labels");
    }

    
    public function parseToTestIssues()
    {
        return $this->parseIssues("vroom", "open", array("to_test"));
    }
    
    public function parseClosedBugs()
    {
        return $this->parseIssues("vroom","closed");
    }

    public function parseIssues($repo, $status = "open", $labels = array())
    {        
        $params = array();
        $params["state"] = $status;
        $label_string = "";
        foreach($labels as $label) $label_string.=$label.",";
        if($label_string != "")
        {
            $params["labels"] = $label_string;
        }
        $params["sort"] ="updated";
        $params["direction"] ="desc";
        $date = new DateTime('NOW');
        $date = date('Y-m-dTH:i:s', strtotime('last Tuesday'));    
        $params["since"] = $date;
        $content = $this->curl_request("repos/Thierno-EEC/vroom/issues", $params);     

        
       
        
        $issues = array();
        foreach($content as $issue){
            $issues[] = new Issue($issue);
        }
       //var_dump($content);
       return $issues;
    }
    
    private function curl_request($request, $params = array())
    {
        
        $string_param = '';
        foreach($params as $key=>$value)
        {
           $string_param .= "&".$key."=".urlencode($value);
        }
        
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"https://api.github.com/".$request."?access_token=".$this->token.$string_param);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_USERAGENT, "Thierno-EEC");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
        curl_setopt($ch, CURLOPT_ENCODING ,"UTF-8");
        $content = curl_exec($ch);
        if (FALSE === $content)
        {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }
            
        curl_close($ch);
        return json_decode($content);
    }

}

?>