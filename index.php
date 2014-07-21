<?php

// Settings
$title           = 'rbbl.ws share';
$url             = 'http://rbbl.ws/shr/';

// Allowed file types
$imageTypes      = array('jpg','png','gif');
$other           = array('zip,pdf,txt,html');

// Icon colours (default)
$colourPrimary   = '#48b8f7';
$colourSecondary = '#6bd0fc';

// Type-specific icon colours
$typeColours = array(
	array(
		'ext' => 'jpg',
		'primary' => '#ed5858',
		'secondary' => '#f47878'
	),
	array(
		'ext' => 'png',
		'primary' => '#ff4579',
		'secondary' => '#ff699e'
	),
	array(
		'ext' => 'gif',
		'primary' => '#c5d873',
		'secondary' => '#d4e089'
	),
	array(
		'ext' => 'pdf',
		'primary' => '#ffc359',
		'secondary' => '#ffce88'
	),
	array(
		'ext' => 'zip',
		'primary' => '#f7984a',
		'secondary' => '#fcab75'
	),
	array(
		'ext' => 'txt',
		'primary' => '#998c7a',
		'secondary' => '#a3978d'
	),
	array(
		'ext' => 'html',
		'primary' => '#c5d873',
		'secondary' => '#d4e089'
	),
);
?>

<!DOCTYPE HTML>
<html>

	<head>
	
		<title><?php echo $title; ?></title>
		
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
		<link href="inc/featherlight.css" type="text/css" rel="stylesheet" />
		
		<style type="text/css">
			body {
				background-color: #eceef1;
				font-family: 'Lato', sans-serif;
			}

			#wrapper {
				margin: 0 auto;
				width: 100%;
				background-color: white;
			}

			section {
				margin: 0 auto;
				width: 100%;
				max-width: 800px;
				padding-top: 50px;
				padding-bottom: 50px;
			}

			.file {
				width: 100%;
				overflow: auto;
				border-bottom: 1px solid #eceef1;
			}

			.file:hover {
				background-color: #eceef1;
				cursor: pointer;
			}

			.file .icon,
			.file .date,
			.file .filename {
				float: left;
				padding: 10px;
				height: 50px;
			}

			.file .icon span,
			.file .date span,
			.file .filename span {
				vertical-align: middle;
				line-height: 50px;
			}

			.file .icon { width: 10%; }
			.file .date { width: 20%; text-align: right; }
			.file .filename { font-weight: bold; }

			.file-icon {
				text-align: center;
				width: 55%;
				position: relative;
				overflow: hidden;
				min-width: 40px;
				color: white;
				background: <?php echo $colourPrimary; ?>;
			}

			.file-icon:before {
			  content: "";
			  position: absolute;
			  top: 0;
			  right: 0;
			  border-width: 0 16px 16px 0;
			  border-style: solid;
			  border-color: <?php echo $colourSecondary; ?> #fff;
			}

			.file:hover .file-icon:before { border-color: <?php echo $colourSecondary; ?> #eceef1; }

			.featherlight-content img {
				max-width: 100%;
				max-height: 100%;
			}

			@media screen and (max-width: 600px) {
				.file .date { display: none; }
			}

			<?php foreach ($typeColours as $colours) {
					echo ' ';
					echo '.file-icon.'.$colours['ext'].' { background: '.$colours['primary'].'; }';
					echo ' ';
					echo '.file-icon.'.$colours['ext'].':before { border-color: '.$colours['secondary'].' #fff; }';
					echo ' ';
					echo '.file:hover .file-icon.'.$colours['ext'].':before { border-color: '.$colours['secondary'].' #eceef1; }';
				}
			?>
		</style>
		
	</head>
	
	<body>

		<div id="wrapper">
			<section>
					<?php
                    $filetypes = implode(',', array_merge($imageTypes, $other));
                    $files = glob("*.{".$filetypes."}", GLOB_BRACE);
                    usort($files, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

                    foreach ($files as $file): ?>
                    	<?php
	                    	$ext = pathinfo($file, PATHINFO_EXTENSION);
	                    	$type = 'other';

	                    	if (in_array($ext, $imageTypes))
	                    		$type = 'image';
                    	?>

                    	<div 
                    		class="file"
                    		data-type="<?php echo $type; ?>"
                    		data-img="<?php echo $file; ?>"
                    	>
                    		<div class="icon">
                    			<span><div class="file-icon <?php echo $ext; ?>"><?php echo $ext; ?></div></span>
                    		</div>
                    		<div class="date">
                    			<span><?php echo date ("dS F Y", filemtime($file)); ?></span>
                    		</div>
                    		<div class="filename">
                    			<span><?php echo $file; ?></span>
                    		</div>
                    	</div>

                    <?php endforeach; ?>
			</section>
		</div>

	</body>

	<script src="inc/jquery.min.js"></script>
	<script src="inc/featherlight.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$('.file').click(function(e) {
			var url = $(e.currentTarget).data('img');
			if ($(e.currentTarget).data('type') == 'image') {
				$.featherlight(url);
			}
			else {
				window.location.href = '<?php echo $url; ?>'+url;
			}
		});
	</script>
	
</html>