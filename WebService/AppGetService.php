<?php

class AppGet {
	// example: http://path/to/examples/InstanceExample.php?method=sayHello&name=World
	public function getSubItems($objectId, $UserId) {
		//return array("Response" => "Hello, ");
		$return = array();

		$AppGet = new AppGet();

		$return['success'] = dbConnect();
		if($return['success'] == 'true'){
			$return['msg'] = "This service rocks like hell2!";
		}else{
			$return['msg'] = "Connection to DB failed!";
			return $return;
			exit;
		}

		$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
				FROM ".PropVal." JOIN ".ObjProp."
				ON ".ObjProp.".property_id = ".PropVal.".property_id
				WHERE ".PropVal.".object_id = $objectId");

		while($prop = mysql_fetch_assoc($result_prop))
		{

			$return[$prop['name']] = $prop['value'];

		}
		$return['ObjId'] = $objectId;
		InsertUserAppInviteLastVisited($objectId, $UserId);
		// Get Members
		$return['members'] = getAppMembers($objectId);
		
		// Get Folders
		$TypeId = getTypeId('folder');
		$return['folders'] = getAppSubItem($objectId, $TypeId); 

		// Get Posts
		$TypeId = getTypeId('post');
		$return['post'] = getAppSubItem($objectId, $TypeId);
		
		$max = sizeof($return['folders']);
		for($i = 0; $i < $max;$i++)
		{
			$TypeId = getTypeId('post');
			$return['folders'][$i]['PostCount'] = getSubItemCount($return['folders'][$i]['Leaf_ID'], $TypeId);
			$return['folders'][$i]['MostRecentPost'] = getMostRecentItem($return['folders'][$i]['Leaf_ID'], $TypeId);
 		}

		return  $return;

	}
	public function getNewPosts($objectId, $UserId, $LastObjectId) {
		//return array("Response" => "Hello, ");
		$return = array();
	
		$AppGet = new AppGet();
	
		$return['success'] = dbConnect();
		if($return['success'] == 'true'){
			$return['msg'] = "This service rocks like hell2!";
		}else{
			$return['msg'] = "Connection to DB failed!";
			return $return;
			exit;
		}
	
		$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
				FROM ".PropVal." JOIN ".ObjProp."
				ON ".ObjProp.".property_id = ".PropVal.".property_id
				WHERE ".PropVal.".object_id = $objectId");
	
		while($prop = mysql_fetch_assoc($result_prop))
		{
	
			$return[$prop['name']] = $prop['value'];
	
		}
		$return['ObjId'] = $objectId;

		// Get Folders
		$TypeId = getTypeId('post');
		$return['post'] = getAppNewSubItem($objectId, $TypeId, $LastObjectId);
	
		return  $return;
	
	}
	public function UpdateMenue($objectId, $UserId) {
		//return array("Response" => "Hello, ");
		$return = array();
	
		$AppGet = new AppGet();
	
		$return['success'] = dbConnect();
		if($return['success'] == 'true'){
			$return['msg'] = "This service rocks like hell2!";
		}else{
			$return['msg'] = "Connection to DB failed!";
			return $return;
			exit;
		}
	
		$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
				FROM ".PropVal." JOIN ".ObjProp."
				ON ".ObjProp.".property_id = ".PropVal.".property_id
				WHERE ".PropVal.".object_id = $objectId");
	
		while($prop = mysql_fetch_assoc($result_prop))
		{
	
			$return[$prop['name']] = $prop['value'];
	
		}
		$return['ObjId'] = $objectId;
		InsertUserAppInviteLastVisited($objectId, $UserId);
				// Get Members
		$return['members'] = getAppMembers($objectId);
	
// 		Get Folders
		$TypeId = getTypeId('folder');
		$return['folders'] = getAppSubItem($objectId, $TypeId);
		return  $return;
	
	}
	public function getChildren($object_id, $TemplateTypeName) {

// 		//Connect to DB
// 		if (dbConnect() == 'false') {
// 			return 'Keine Verbindung zur Datenbank möglich';
// 			exit;
// 		}

		if( $object_id == NULL){
			$result = mysql_query("SELECT ".AppHier.".object_id, ".AppHier.".parent_id, ".AppHier.".type_id, 
											".AppHier.".create_user_id, ".AppHier.".create_datetime, ".AppHier.".change_user_id, ".AppHier.".change_datetime, 
											".ObjType.".name
					FROM ".AppHier." JOIN ".ObjType."
					ON ".ObjType.".type_id = ".AppHier.".type_id
					WHERE ".AppHier.".parent_id IS NULL");
		}else{
			$result = mysql_query("SELECT ".AppHier.".object_id, ".AppHier.".parent_id, ".AppHier.".type_id, 
											".AppHier.".create_user_id, ".AppHier.".create_datetime, ".AppHier.".change_user_id, ".AppHier.".change_datetime, 
											".ObjType.".name
					FROM ".AppHier." JOIN ".ObjType."
					ON ".ObjType.".type_id = ".AppHier.".type_id
					WHERE ".AppHier.".parent_id = $object_id");
		}

		if (!$result) {
			return false;
// 			exit;
		}

		$cret = array();
		$counter = 0;

		while($child = mysql_fetch_assoc($result))
		{

			if ($child['name'] == $TemplateTypeName
			OR ( $TemplateTypeName == 'Other' && strpos($child['name'],'Template') == false )){

				$cret[$counter]['Type'] = $child['name'];
				$cret[$counter]['Leaf_ID'] = $child['object_id'];
				$child_id = $child['object_id'];

				$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
						FROM ".PropVal." JOIN ".ObjProp."
						ON ".ObjProp.".property_id = ".PropVal.".property_id
						WHERE ".PropVal.".object_id = $child_id");

				while($prop = mysql_fetch_assoc($result_prop))
				{

					$cret[$counter][$prop['name']] = $prop['value'];

				}
				
				// Type Conversions
				switch ($cret[$counter]['ValueType']){
					case 'Integer' :
						$cret[$counter]['Value'] = (int) $cret[$counter]['Value'];
						$cret[$counter]['maxValue'] = (int) $cret[$counter]['maxValue'];
						break;
					case 'Boolean' :
						if ($cret[$counter]['Value'] == 'false'){
							$cret[$counter]['Value'] = '';
						}
						$cret[$counter]['Value'] = (bool) $cret[$counter]['Value'];
						break;
					default :
						break;
				}

				$counter++;
			}
			
		}
		mysql_freeresult($result);
		return $cret;
	}

}

?>