<?php

namespace App\Models;

use PDO;
use App\Config;

class apiGitHub extends \Core\Model
{
	
	public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public function getRepositories()
    {
        if($this->user)
        {
            // Authorization token from author GitHub
            $tokenAuth = Config::AUTH_TOKEN;

            $output1 = $this->getAllRepos($tokenAuth);

            if((isset($output1->message) && $output1->message == 'Not Found') || str_contains($this->user, ' '))
            {
                return false;
            }else{
                foreach ($output1 as $repo){

                    $output2 = $this->getContributors($tokenAuth, $repo);

                    $output3 = $this->getForkInfo($tokenAuth, $repo);

                    if($output3->fork == true){
                        $result = array(
                                "name" => $repo->name,
                                "link" => $repo->html_url,
                                "number" => count((array)$output2),
                                "isFork" => $output3->fork,
                                "name_source" => $output3->source->full_name,
                                "url_source" => $output3->source->html_url
                        );
                    }else{
                        $result = array(
                            "name" => $repo->name,
                            "link" => $repo->html_url,
                            "number" => count((array)$output2),
                            "isFork" => $output3->fork
                    ); 
                    }

                    $res[] = $result;

                    
                }
            

                return $res;
            }
        }else{
            return false;
        }
    }

    public function getAllRepos($token)
    {
         // We generate the url for curl
         $curl_url = 'https://api.github.com/users/' . $this->user . '/repos';
      
         // We generate the header part for the token
         $curl_token_auth = 'Authorization: token ' . $token;
       
         // We make the actuall curl initialization
         $ch = curl_init($curl_url);
       
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       
         // We set the right headers: any user agent type, and then the custom token header part that we generated
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
 
         // We execute the curl
         $output = curl_exec($ch);
       
         // And we make sure we close the curl       
         curl_close($ch);
       
         // Then we decode the output and we could do whatever we want with it
         $output = json_decode($output);

         return $output;
    }

    protected function getContributors($token, $repo)
    {
        // We generate the url for curl

        $curl_url = 'https://api.github.com/repos/' . $this->user . '/' . $repo->name . '/contributors';

        // We generate the header part for the token
        $curl_token_auth = 'Authorization: token ' . $token;
    
        // We make the actuall curl initialization

        $ch = curl_init($curl_url);
    

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        // We set the right headers: any user agent type, and then the custom token header part that we generated

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));
    
        // We execute the curl

        $output = curl_exec($ch);
    
        // And we make sure we close the curl       

        curl_close($ch);
    
        // Then we decode the output and we could do whatever we want with it

        $output = json_decode($output);

        return $output;
    }

    protected function getForkInfo($token, $repo)
    {
        $curl_url = 'https://api.github.com/repos/' . $this->user . '/' . $repo->name;
                    
        // We generate the header part for the token
        $curl_token_auth = 'Authorization: token ' . $token;

        // We make the actuall curl initialization

        $ch = curl_init($curl_url);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // We set the right headers: any user agent type, and then the custom token header part that we generated

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Awesome-Octocat-App', $curl_token_auth));

        // We execute the curl

        $output = curl_exec($ch);

        // And we make sure we close the curl       

        curl_close($ch);

        // Then we decode the output and we could do whatever we want with it

        $output = json_decode($output);

        return $output;
    }
	

}