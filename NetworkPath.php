<?php

class NetworkPath
{
    public static function init()
    {
        static $init = null;

        if ($init === null)
        {
            $init = new NetworkPath();
            $init->executeCommand();
        }
        return $init;
    }

    //initial function to start the test
    private function executeCommand()
    {
        $data_arr = $this->readFile();

        while (true)
        {
            echo "Enter [Device From] [Device To] [Time] (e.g A F 1000 followed by ENTER key)";
            $handle = fopen ("php://stdin","r");
            $input = fgets($handle);
            if(strtolower(trim($input)) == 'Quit')
            {
                exit;
            }
            $data_input = explode(" ", trim($input));
            if(count($data_input) != 3)
            {
                echo "Invalid Format!\n";
                exit;
            }
            list($from, $to, $range) = $data_input;

            $draw_path = $this->determinePath($from, $to, (int)$range, $data_arr);
            if(!empty($draw_path))
            {
                echo "Output: ".implode(' => ', $draw_path['path'])." => ".$draw_path['length']."\n";
                exit;
            }
        }
    }

    //read the CSV file given
    private function readFile()
    {
        $argv = $_SERVER['argv'];
        if(!isset($argv[1]) || !file_exists($argv[1]))
        {
            echo "File not found";
            exit;
        }

        $csv_file = $argv[1];
        $output = array();
        if (($handle = fopen($csv_file, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle)) !== FALSE)
            {

                $output[$data[0]][$data[1]]= $data[2];
                $output[$data[1]][$data[0]]= $data[2];
            }
            fclose($handle);
        }

        return $output;
    }

    //determine the path between nodes
    private function determinePath($from = '', $to = '', $range = 0, $data_arr)
    {
        $S = array();
        $Q = array();
        $length = array();

        foreach(array_keys($data_arr) as $val)
        {
            $Q[$val] = $range;
            $length[$val] = 0;
        }

        $Q[$from] = 0;

        while(!empty($Q))
        {
            $min = array_search(min($Q), $Q);
            if($min == $to) break;

            $i = 0;

            if(isset($data_arr[$min]))
            {
                foreach($data_arr[$min] as $key=>$val)
                {
                    if(!empty($Q[$key]) && $length[$min] + $val < $Q[$key])
                    {
                        $Q[$key] = $i;
                        $length[$key] = $length[$min] + $val;
                        $S[$key] = array($min, $length[$key]);
                    }
                    $i++;
                }
            }

            unset($Q[$min]);
        }

        if (!array_key_exists($to, $S)) {
            echo "Path not found\n";
            return array();
        }

        $path = array();
        $p = $to;
        while($p != $from){
            $path[] = $p;
            $p = $S[$p][0];
        }

        $path[] = $from;

        return array(
            'path' => array_reverse($path),
            'length' => $S[$to][1]
        );
    }


}

function executeNetworkPath()
{
    return NetworkPath::init();
}
if(function_exists('executeNetworkPath')) executeNetworkPath();
