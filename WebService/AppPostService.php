<?php

class AppPost {
	// example: http://path/to/examples/InstanceExample.php?method=sayHello&name=World

	public function CreateApplication($userId) {
		$return['success'] = dbConnect();
		
		if($return['success'] != 'true'){
			return $return;
			exit;
		}

		// Get Type Id for Application
		$TypeId = getTypeId('Application');
		
		// Insert New App
		mysql_query("INSERT INTO ".AppHier."
					(type_id, create_user_id, create_datetime)
					VALUES ('$TypeId', '$userId', NOW())");

		$NewAppId = mysql_insert_id();
		
		if ($NewAppId){
			$JSONdata = array();
			$JSONdata = $_POST;
			foreach($JSONdata as $key => $value){
				
				// Get Property Id for key
				$PropertyId = getPropertyId($TypeId, $key);
				
				// Set Property Value for Object
				InsertPropertyValue($NewAppId, $PropertyId, $value, $userId);
			}
			
			// Generate Secure Key
			$PropertyId = getPropertyId($TypeId, 'secure_key');
			
			$value = sha1(microtime(true).mt_rand(10000,90000));
			
			InsertPropertyValue($NewAppId, $PropertyId, $value, $userId);

		}
		InsertUserAppInvite($NewAppId, $userId);
		$return['ObjectId'] = $NewAppId;
		
		// Create List and FeedListItem
// 		$FolderTypeId = getTypeId('folder');
// 		$ListTypeId = getTypeId('List');
// 		$FeedListTypeId = getTypeId('FeedListItem');
// 		$TextPropertyId = getPropertyId($ListTypeId, 'text');
// 		$IconPropertyId = getPropertyId($ListTypeId, 'icon');
// 		$ValuePropertyId = getPropertyId($ListTypeId, 'value');
// 		$TextPropertyId = getPropertyId($ListTypeId, 'text');
		
// 		$FolderObjectId = InsertObject($NewAppId, $FolderTypeId, $userId);
// 		InsertPropertyValue($FolderObjectId, $TextPropertyId, "Systemmeldungen", $userId);
		
// 		$ListObjectId = InsertObject($FolderObjectId, $ListTypeId, $userId);
// 		InsertPropertyValue($ListObjectId, $TextPropertyId, '', $userId);

// 		$FeedListObjectId = InsertObject($ListObjectId, $FeedListTypeId, $userId);
// 		InsertPropertyValue($FeedListObjectId, $ValuePropertyId, "Forum wurde erstellt.", $userId);
		
		return $return;
	
	}
	
	public function CreateObject($userId, $ParentId, $TypeName) {
		$return['success'] = dbConnect();
	
		if($return['success'] != 'true'){
			return $return;
			exit;
		}
	
		// Get Type Id for Type Name
		$TypeId = getTypeId($TypeName);
	
		// Insert New App
		mysql_query("INSERT INTO ".AppHier."
		(parent_id, type_id, create_user_id, create_datetime)
		VALUES ('$ParentId', '$TypeId', '$userId', NOW())");
	
		$NewAppId = mysql_insert_id();
	
		if ($NewAppId){
			$JSONdata = array();
			$JSONdata = $_POST;
			foreach($JSONdata as $key => $value){
	
				// Get Property Id for key
				$PropertyId = getPropertyId($TypeId, $key);
	
				// Set Property Value for Object
				InsertPropertyValue($NewAppId, $PropertyId, $value, $userId);
			}
	
		}
	
		return $return;
	
	}
}

?>