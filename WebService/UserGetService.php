<?php

  class UserGet {
    function __construct() {
       
    }
    public function checkLogin($email, $pass)
    {
        $return = array();
        $return['success'] = dbConnect();
    	
        
        $sql = "SELECT
                    COUNT(*) as count
                FROM
                    ".UserTab."
                WHERE
                    email = '".$email."' AND
                    password = MD5('".$pass."');";
        $result = mysql_query($sql) OR die(mysql_error());
        $row = mysql_fetch_assoc($result);
        mysql_free_result($result);
        
        if($row['count']=='1'){
                    $return['success'] = "true";
            }else{
                    $return['success'] = "false";
            }
        return $return;
    }

    public function getProperties($object_id)
    {
        
        $sql = "SELECT
                    ".ObjProp.".name, ".PropVal.".value
                FROM
                    ".PropVal."
                JOIN ".ObjProp."
                ON ".ObjProp.".property_id = ".PropVal.".property_id
                WHERE
                    ".PropVal.".object_id = '".$object_id."';";
                    
        $result_prop = mysql_query($sql) OR die(mysql_error());
        
        $array['Application'] = $object_id;

        while($prop = mysql_fetch_assoc($result_prop)){
                  
          $array[$prop['name']] = $prop['value'];

        }
        mysql_free_result($result_prop);
        return $array;
        
    }
    
    public function getApps($user_id)
    {
        $user = new UserGet;
        $return = array();
        $return['success'] = dbConnect();
        $return['UserId'] = $user_id;

        
        $sql = "SELECT
                    *
                FROM
                    ".UserInv."
                WHERE
                    user_id = '".$user_id."';";
        $result = mysql_query($sql) OR die(mysql_error());
        
        $array = array();
        $counter = 0;
        
//         while($row = mysql_fetch_assoc($result)){
//           $object_id = $row['object_id'];
          
//           //$array[$counter]['Application'] = $object_id;
//           $array[$counter] = $user->getProperties($object_id);
//           $counter++;
          
//         }
        while($row = mysql_fetch_assoc($result)){
        	$array[$counter] = $row;
        	$array[$counter] = $user->getProperties($row['object_id']);
        	$array[$counter]['Application'] = $row['object_id'];
        	$array[$counter]['ActiveMemberCount'] = (int) getUserAppInviteCount($row['object_id']);
        	$ItemTypeId = getTypeId('post');
        	$array[$counter]['SubItemCount'] = (string) getSubItemCount($row['object_id'], $ItemTypeId);
        	$array[$counter]['info'] = "19 neue Beitr&#228;ge";
        	$array[$counter]['infoState'] = 'Success';
        	$array[$counter]['icon'] = 'sap-icon://question-mark';
//         	$array[$counter]['icon'] = 'http://boardingarea.wpengine.netdna-cdn.com/deltapoints/files/2012/07/test.jpg';
        	$counter++;
        
        }
        $return['children'] = $array;
        mysql_free_result($result);
        return $return;
    }
  }

?>