<?php

namespace M2MAPP {

class MessagesModel
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

<<<<<<< Updated upstream
        public function __destruct(){
        }
/*
        public function getMessageData($soap_call_result, $counter){


            for ($i=0; $i<25; $i++){
            $xml = $soap_call_result[$i];
            $final = simplexml_load_string($xml);

            echo 'MESSAGE ' . $i . ' <br/>Source - ' . $final[0]->sourcemsisdn .
                 '<br/>Dest - ' . $final[0]->destinationmsisdn .
                 '<br/>Date - ' . $final[0]->receivedtime .
                 '<br/>Type - ' . $final[0]->bearer .
                 '<br/>Message: '. $final[0]->message .'<br/><br/>';

            }

            $xml = $soap_call_result[0];
            $final = simplexml_load_string($xml);
            $themessage = $final[0]->message;
            echo $themessage .'<br/>';

        }

=======
    public function __construct(){}
>>>>>>> Stashed changes

    public function __destruct(){}

<<<<<<< Updated upstream
            try {

                $filteredArray = (array_filter($message_content, function($k) {
                    return $k == 37;
                }, ARRAY_FILTER_USE_KEY));

                //echo json_encode($filteredArray);
                $str = json_encode($filteredArray);

                //SMS message format: "switch1:onswitch2:onswitch3:offswitch4:onfan:forward
                // heater:3keypad:4id:19-3110-AZ"

                $switch1     = get_string_between($str, 'switch1:', 'switch2');
                $switch2     = get_string_between($str, 'switch2:', 'switch3');
                $switch3     = get_string_between($str, 'switch3:', 'switch4');
                $switch4     = get_string_between($str, 'switch4:', 'fan');
                $fan         = get_string_between($str, 'fan:',     'heater');
                $heater      = get_string_between($str, 'heater:',  'keypad');
                $keypad      = get_string_between($str, 'keypad:',  'id');
                $group_id     = get_string_between($str, 'id:',      'Z');


                $final_message = "Switch1: $switch1 Switch2: $switch2 Switch3: $switch3 Switch4: $switch4 Fan: $fan Heater: $heater Keypad: $keypad ID: $group_id";

            }
            catch (\SoapFault $exception)
            {
                $final_message = 'Oops - something went wrong connecting to the data supplier.  Please try again later';
            }

            return $final_message;

        }

        public function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
=======
    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function getMessages()
    {
        $messages_to_show = [];
        $query_string = $this->sql_queries->getMessages();

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();
>>>>>>> Stashed changes

        if ($number_of_data_sets > 0)
        {
            $x = 0;
            while ($row = $this->database_wrapper->safeFetchArray())
            {
                $finalmessages[$x]['source'] = $row['source'];
                $finalmessages[$x]['destination'] = $row['destination'];
                $finalmessages[$x]['date'] = $row['date'];
                $finalmessages[$x]['type'] = $row['type'];
                $finalmessages[$x]['message'] = $row['message'];
            }
        }
        else
        {
            $messages_to_show[0] = 'No messages found or there are 0 messages in the database.';
        }

        $messages_to_show['number_of_messages_data_sets'] = $number_of_data_sets;
        $messages_to_show['retrieved_messages'] = $finalmessages;

        return $messages_to_show;
    }

/*
    public function decodeMessage($message_content){

        $str = $message_content;

        //SMS message format: "switch1:onswitch2:onswitch3:offswitch4:onfan:forward
        // heater:3keypad:4id:19-3110-AZ"

        $switch1     = $this->get_string_between($str, 'switch1:', 'switch2');
        $switch2     = $this->get_string_between($str, 'switch2:', 'switch3');
        $switch3     = $this->get_string_between($str, 'switch3:', 'switch4');
        $switch4     = $this->get_string_between($str, 'switch4:', 'fan');
        $fan         = $this->get_string_between($str, 'fan:',     'heater');
        $heater      = $this->get_string_between($str, 'heater:',  'keypad');
        $keypad      = $this->get_string_between($str, 'keypad:',  'id');
        $group_id    = $this->get_string_between($str, 'id:',      'Z');


        $final_message = "Switch1: $switch1 Switch2: $switch2 Switch3: $switch3 Switch4: $switch4 Fan: $fan Heater: $heater Keypad: $keypad ID: $group_id";

         return $final_message;

     }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

*/

*/
    }
}