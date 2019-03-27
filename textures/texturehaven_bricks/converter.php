<?php

	$names = [
		"brick_4",
		"brown_brick_02",
		"plaster_brick_01",
		"random_bricks_thick",
		"red_brick_03",
		"red_brick_plaster_patch_02",
		"white_bricks",
		"yellow_brick",
		"yellow_bricks"
	];
	
	
	$shader = "";
	
	foreach ($names as $name) {
		// diffuse texture will be in quake shader
		$diff = $name . "_diff_1k.jpg";
		// these three one-channel-textures will turn into one _s.jpg
		$spec = $name . "_spec_1k.jpg";
		$rough = $name . "_rough_1k.jpg";
		$ao = $name . "_AO_1k.jpg";
		// normal (3 channels) + displacement (1 channel) will turn into _n.png, needs alpha of .png (at least until ioq3 is rewritten, normal.z isn't needed)
		$nor = $name . "_nor_1k.jpg";
		$disp = $name . "_disp_1k.jpg";
		
		// this command will generate:
		// - output_n.png (4 channels)
		// - output_s.png (3 channels)
		system("pbr_converter.exe $spec $rough $ao $nor $disp");
		
		
		if (!rename("output_n.png", $name . "_1k_n.png"))
			echo "rename failed";
		
		// now convert the output_s.png into a 100kb output_s.jpg
		system("magick convert output_s.png -define jpeg:extent=100kb " . $name . "_1k_s.jpg");
		
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
		
		$shader .= "textures/texturehaven_bricks/" . $name . "_1k\n";
		$shader .= "{\n";
		$shader .= "	qer_editorimage textures/texturehaven_bricks/" . $name . "_diff_1k.jpg\n";
		$shader .= "	{\n";
		$shader .= "		map textures/texturehaven_bricks/" . $name . "_diff_1k.jpg\n";
		$shader .= "		rgbgen identity\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage normalparallaxmap\n";
		$shader .= "		map textures/texturehaven_bricks/" . $name . "_1k_n.png\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage specularmap\n";
		$shader .= "		map textures/texturehaven_bricks/" . $name . "_1k_s.jpg\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		map \$lightmap\n";
		$shader .= "		blendfunc GL_DST_COLOR GL_ZERO\n";
		$shader .= "	}\n";
		$shader .= "}\n";
		$shader .= "\n";
	}
	
	file_put_contents("../../scripts/texturehaven_bricks.shader", $shader);
	
	// this is the e-end,
	// huge success?
