<?php
require('image_converter.php');

$imageType = '';
$download = false;

if ($_GET) {
	$imageType = urldecode($_GET['imageType']);
	$imageName = urldecode($_GET['imageName']);
} else {
	header('Location:index.php');
}

if ($_POST) {

	$convert_type = $_POST['convert_type'];

	$obj = new Image_converter();
	$target_dir = 'uploads';

	$image = $obj->convert_image($convert_type, $target_dir, $imageName);

	if ($image) {
		$download = true;
	}
}

$types = array(
	'png' => 'PNG',
	'jpg' => 'JPG',
	'gif' => 'GIF',
);
?>
<?php include("includes/header.php"); ?>

<div class="container pb-4">
	<div class="row">
		<div class="col col-lg-12 col-md-12 col-sm-12">
			<h2 class="text-center lh-lg fw-bold">Image Converter</h2>
			<h4 class="text-center lh-lg">Convert Any image to JPG, PNG, GIF</h4>
			<p class="text-center card-text">JPG to PNG | JPG to GIF | PNG to JPG | PNG to GIF | GIF to JPG | GIF to PNG | JPEG to PNG | JPEG to GIF</p>

			<div class="card text-center mx-auto p-2 gradient-card">
				<div class="card-body">
					<?php if (!$download) { ?>
						<form method="post" action="">
							<h5 class="py-2 h4 fw-bold">File Uploaded, Select below option to convert!</h5>
							<img src="uploads/<?= $imageName; ?>" class="img-fluid rounded img-200 mb-4">

							<div class="w-50 mb-3 mx-auto">
								<label class="form-label h5 fw-bold">Convert To:</label>
								<select name="convert_type" class="form-control">
									<?php foreach ($types as $key => $type) { ?>
										<?php if ($key != $imageType) { ?>
											<option value="<?= $key; ?>"><?= $type; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>

							<div class="mb-3">
								<button type="submit" class="btn btn-success btn-lg fw-bold"><i class="fa-solid fa-arrows-rotate"></i> Convert</button>
							</div>
						</form>
					<?php } ?>

					<?php if ($download) { ?>
						<h5 class="py-2 h4 fw-bold"> Converted to <?php echo ucwords($convert_type); ?></h5>
						<img src="<?= $target_dir . '/' . $image; ?>" class="img-fluid rounded img-200 mb-4" />

						<div class="mb-3">
							<a href="download.php?filepath=<?php echo $target_dir . '/' . $image; ?>" class="btn btn-success btn-lg mb-2"><i class="fa-solid fa-download"></i> Download Converted Image</a>
							<a href="index.php" class="btn btn-primary"><i class="fa-solid fa-square-arrow-up-right mb-2"></i> Convert Another</a>
						</div>
					<?php } ?>
				</div>
			</div>

		</div>
	</div>

	<?php include_once("includes/social_link.php"); ?>
</div>

<?php include("includes/footer.php"); ?>