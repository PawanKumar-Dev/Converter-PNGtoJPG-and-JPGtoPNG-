<?php 

class Image_converter{
	
	function convert_image($convert_type, $target_dir, $image_name, $image_quality=100){
		$target_dir = "$target_dir/";
		
		$image = $target_dir.$image_name;
		
		$img_name = $this->remove_extension_from_image($image);
		
		if($convert_type == 'png'){
			$binary = imagecreatefromstring(file_get_contents($image));
			$image_quality = floor(10 - ($image_quality / 10));
			ImagePNG($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}
		
		if($convert_type == 'jpg'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageJpeg($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}		

		if($convert_type == 'gif'){
			$binary = imagecreatefromstring(file_get_contents($image));
			imageGif($binary, $target_dir.$img_name.'.'.$convert_type, $image_quality);
			return $img_name.'.'.$convert_type;
		}				
		return false; 
	}
	
	public function upload_image($files, $target_dir, $input_name){
		
		$target_dir = "$target_dir/";
		
		$base_name = basename($files[$input_name]["name"]);

		$imageFileType = $this->get_image_type($base_name);
		
		$new_name = $this->get_dynamic_name($base_name, $imageFileType);
		
		$target_file = $target_dir . $new_name;
	
		$validate = $this->validate_image($files[$input_name]["tmp_name"]);
		if(!$validate){
			echo "Doesn't seem like an image file :(";
			return false;
		}
		
		$file_size = $this->check_file_size($files[$input_name]["size"], 1000000);
		if(!$file_size){
			echo "You cannot upload more than 1MB file";
			return false;
		}

		$file_type = $this->check_only_allowed_image_types($imageFileType);
		if(!$file_type){
			echo "You cannot upload other than JPG, JPEG, GIF and PNG";
			return false;
		}
		
		if (move_uploaded_file($files[$input_name]["tmp_name"], $target_file)) {
			return array($new_name, $imageFileType);
		} else {
			echo "Sorry, there was an error uploading your file.";
		}

	}
	
	protected function get_image_type($target_file){
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		return $imageFileType;
	}
	
	protected function validate_image($file){
		$check = getimagesize($file);
		if($check !== false) {
			return true;
		} 
		return false;
	}
	
	protected function check_file_size($file, $size_limit){
		if ($file > $size_limit) {
			return false;
		}
		return true;
	}
	
	protected function check_only_allowed_image_types($imagetype){
		if($imagetype != "jpg" && $imagetype != "png" && $imagetype != "jpeg" && $imagetype != "gif" ) {
			return false;
		}
		return true;
	}
	
	protected function get_dynamic_name($basename, $imagetype){
		$only_name = basename($basename, '.'.$imagetype);
		$combine_time = $only_name.'_'.time();
		$new_name = $combine_time.'.'.$imagetype;
		return $new_name;
	}
	
	protected function remove_extension_from_image($image){
		$extension = $this->get_image_type($image);
		$only_name = basename($image, '.'.$extension);
		return $only_name;
	}
}
?>