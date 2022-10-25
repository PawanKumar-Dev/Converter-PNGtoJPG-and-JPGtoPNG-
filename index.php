<?php
//import the converter class
require('image_converter.php');

if ($_FILES) {
	$obj = new Image_converter();

	//call upload function and send the $_FILES, target folder and input name
	$upload = $obj->upload_image($_FILES, 'uploads', 'fileToUpload');
	if ($upload) {
		$imageName = urlencode($upload[0]);
		$imageType = urlencode($upload[1]);

		if ($imageType == 'jpeg') {
			$imageType = 'jpg';
		}
		header('Location: convert.php?imageName=' . $imageName . '&imageType=' . $imageType);
	}
}

?>
<?php include("includes/header.php"); ?>

<div class="container pb-4">
	<div class="row">
		<div class="col col-lg-12 col-md-12 col-sm-12">
			<h1 class="text-center h2 fw-bold">Image Converter</h1>
			<h2 class="text-center h4">Convert Any image to JPG, PNG, GIF</h2>
			<br>

			<div class="card text-center mx-auto p-2 gradient-card">
				<!-- <img src="..." class="card-img-top" alt="..."> -->
				<div class="card-body">
					<h4 class="card-title h4 fw-bold">Upload and Convert Image of your choice</h4>
					<p class="card-text">JPG to PNG | JPG to GIF | PNG to JPG | PNG to GIF | GIF to JPG | GIF to PNG | JPEG to PNG | JPEG to GIF</p>
				</div>

				<div class="card-body">
					<form action="" enctype="multipart/form-data" method="post" onsubmit="return checkEmpty()">
						<div class="mb-3">
							<label for="fileToUpload" class="form-label">Upload file</label>
							<input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
						</div>
						<button type="submit" class="btn btn-warning btn-lg fw-bold"><i class="fa-solid fa-upload"></i> Upload</button>
					</form>
				</div>
			</div>

		</div>
	</div>

	<?php include_once("includes/social_link.php"); ?>
</div>

<?php include("includes/footer.php"); ?>