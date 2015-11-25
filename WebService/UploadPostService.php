<?php
include('ImageConverter.php');
// include('ServiceConstants.php');
class UploadPost {
	// example: http://path/to/examples/InstanceExample.php?method=sayHello&name=World
	public function FileUpload() {

		$return['success'] = dbConnect();

		if($return['success'] == 'true'){
			$return['msg'] = "This service rocks like hell2!";
		}else{
			$return['msg'] = "Connection to DB failed!";
// 			return $return;
			exit;
		}
		
		$return['parameter_test'] = $_POST;
		$return['file_test'] = $_FILES;
		
		// Get Type Id for Type Name
		$TypeId = getTypeId('post');
		$ParentId = $_POST['ParentId'];
		$userId = $_POST['UserId'];
		
// 		if(!$ParentId || !$userId){
// 			return $return;
// 		}

		// Insert New App
		mysql_query("INSERT INTO ".AppHier."
				(parent_id, type_id, create_user_id, create_datetime)
				VALUES ('$ParentId', '$TypeId', '$userId', NOW())");
		
		$return['appid'] = $NewAppId = mysql_insert_id();
		
		if ($NewAppId){
				// Get Property Id for key
				$PropertyId = getPropertyId($TypeId, 'ImageURL');
				
				// Load Image
// 				$image = new ImageConverter();
// 				$image->load($_FILES['file']['tmp_name']);

				$img = $_POST['Image'];
				$img = str_replace('data:image/jpeg;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				
				
				
				// Set new Image Name
				$imageName = UPLOAD_DIR . sha1(microtime(true).mt_rand(10000,90000)) . '.jpg';
// 				$fileExtension = $image->getExtension();
				$return['success'] = file_put_contents($imageName, $data);
				
				// Resize and save
// 				$image->resizeToWidth(1024);
// 				$image->save('upload/'.$imageName);


				// Set Property Value for Object
				$value = imageURL.$imageName;
				InsertPropertyValue($NewAppId, $PropertyId, $value, $userId);
		
		}
		

// 		$image = new ImageConverter(); 
// 		$image->load($_FILES['file']['tmp_name']); 
// 		$image->resizeToWidth(1024); 
// 		$image->save('upload/picture3');


		return  $return;

	}

}

?>