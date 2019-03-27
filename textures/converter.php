<?php

	$fullnames = [
	
		"texturehaven_concrete/concrete",
		"texturehaven_concrete/concrete_floor_01",
		"texturehaven_concrete/concrete_floor_02",
		
		//"texturehaven_bricks/brick_4",
		//"texturehaven_bricks/brown_brick_02",
		//"texturehaven_bricks/plaster_brick_01",
		//"texturehaven_bricks/random_bricks_thick",
		//"texturehaven_bricks/red_brick_03",
		//"texturehaven_bricks/red_brick_02", // renamed from red_brick_plaster_patch_02, path too long (max MAX_QPATH which is 64)
		//"texturehaven_bricks/white_bricks",
		//"texturehaven_bricks/yellow_brick",
		//"texturehaven_bricks/yellow_bricks"
		
		
	];
	
	
	$shader = "";
	
	foreach ($fullnames as $fullname) {
		$parts_folder_name = explode("/", $fullname);
		$folder = $parts_folder_name[0];
		$name = $parts_folder_name[1];
		
		// diff: wont be changed/converted, used as quake editor image and diffuse map in shader
		// spec/rough/ao: these three one-channel-textures will turn into one _s.jpg
		// nor/disp: normal (3 channels) + displacement (1 channel) will turn into _n.png, needs alpha of .png (at least until ioq3 is rewritten, normal.z isn't needed)
		$diff  = $folder . "/" . $name . "_diff_1k.jpg";
		$spec  = $folder . "/" . $name . "_spec_1k.jpg";
		$rough = $folder . "/" . $name . "_rough_1k.jpg";
		$ao    = $folder . "/" . $name . "_AO_1k.jpg";
		$nor   = $folder . "/" . $name . "_nor_1k.jpg";
		$disp  = $folder . "/" . $name . "_disp_1k.jpg";
		
		// this command will generate:
		// - output_n.png (4 channels)
		// - output_s.png (3 channels)
		system("pbr_converter.exe $spec $rough $ao $nor $disp");
		
		
		if (!rename("output_n.png", $folder . "/" . $name . "_1k_n.png"))
			echo "rename failed";
		
		// now convert the output_s.png into a 100kb output_s.jpg
		system("magick convert output_s.png -define jpeg:extent=100kb " . $folder . "/" . $name . "_1k_s.jpg");
		unlink("output_s.png"); // we generated a .jpg out of it, can be deleted
		
		// now add a proper shader, gonna look like this:
		/*
			textures/texturehaven_bricks/brick_4_1k
			{
				qer_editorimage textures/texturehaven_bricks/brick_4_diff_1k.jpg
				{
					map textures/texturehaven_bricks/brick_4_diff_1k.jpg
					rgbgen identity
				}
				{
					stage normalparallaxmap
					map textures/texturehaven_bricks/brick_4_1k_n.png
				}
				{
					stage specularmap
					map textures/texturehaven_bricks/brick_4_1k_s.jpg
				}
				{
					map $lightmap
					blendfunc GL_DST_COLOR GL_ZERO
				}
			}
		*/
		
		$shader .= "textures/" . $folder . "/" . $name . "_1k\n";
		$shader .= "{\n";
		$shader .= "	qer_editorimage textures/" . $folder . "/" . $name . "_diff_1k.jpg\n";
		$shader .= "	{\n";
		$shader .= "		map textures/" . $folder . "/" . $name . "_diff_1k.jpg\n";
		$shader .= "		rgbgen identity\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage normalparallaxmap\n";
		$shader .= "		map textures/" . $folder . "/" . $name . "_1k_n.png\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage specularmap\n";
		$shader .= "		map textures/" . $folder . "/" . $name . "_1k_s.jpg\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		map \$lightmap\n";
		$shader .= "		blendfunc GL_DST_COLOR GL_ZERO\n";
		$shader .= "	}\n";
		$shader .= "}\n";
		$shader .= "\n";
	}
	
	file_put_contents("../scripts/" . $folder . ".shader", $shader);
	
	// this is the e-end,
	// huge success?
