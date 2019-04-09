<?php

	$fullnames = [];
	
	// enable/disable whatever you currently need
	if (0) {
		$fullnames[] = "texturehaven_concrete/concrete";
		$fullnames[] = "texturehaven_concrete/concrete_floor_01";
		$fullnames[] = "texturehaven_concrete/concrete_floor_02";
	}
	
	if (0) {
		$fullnames[] = "texturehaven_bricks/brick_4";
		$fullnames[] = "texturehaven_bricks/brown_brick_02";
		$fullnames[] = "texturehaven_bricks/plaster_brick_01";
		$fullnames[] = "texturehaven_bricks/random_bricks_thick";
		$fullnames[] = "texturehaven_bricks/red_brick_03";
		$fullnames[] = "texturehaven_bricks/red_brick_02"; // renamed from red_brick_plaster_patch_02, path too long (max MAX_QPATH which is 64)
		$fullnames[] = "texturehaven_bricks/white_bricks";
		$fullnames[] = "texturehaven_bricks/yellow_brick";
		$fullnames[] = "texturehaven_bricks/yellow_bricks";
	}
	
	if (0) {
		$fullnames[] = "texturehaven_metal/factory_wall";
		$fullnames[] = "texturehaven_metal/green_metal_rust";
		$fullnames[] = "texturehaven_metal/metal_plate";
		$fullnames[] = "texturehaven_metal/rusty_metal_02";
		$fullnames[] = "texturehaven_metal/rusty_metal";
	}
	
	if (1) {
		$fullnames[] = "texturehaven_floor/brick_floor";
		$fullnames[] = "texturehaven_floor/cobblestone_01";
		$fullnames[] = "texturehaven_floor/cobblestone_05";
		$fullnames[] = "texturehaven_floor/cobblestone_color";
		$fullnames[] = "texturehaven_floor/cobblestone_floor_02";
		$fullnames[] = "texturehaven_floor/cobblestone_floor_03";
		$fullnames[] = "texturehaven_floor/cobblestone_floor_05";
		$fullnames[] = "texturehaven_floor/cobblestone_floor_07";
		$fullnames[] = "texturehaven_floor/cobblestone_floor_13";
		$fullnames[] = "texturehaven_floor/cobblestone_square";
		$fullnames[] = "texturehaven_floor/floor_bricks_02";
		$fullnames[] = "texturehaven_floor/floor_klinkers_01";
		$fullnames[] = "texturehaven_floor/floor_klinkers_04";
		$fullnames[] = "texturehaven_floor/floor_pattern_01";
		$fullnames[] = "texturehaven_floor/floor_pebbles_01";
		$fullnames[] = "texturehaven_floor/floor_tiles_04";
		$fullnames[] = "texturehaven_floor/floor_tiles_06";
		$fullnames[] = "texturehaven_floor/floor_tiles_08";
		$fullnames[] = "texturehaven_floor/floor_tiles_09";
		$fullnames[] = "texturehaven_floor/marble_01";
		$fullnames[] = "texturehaven_floor/square_floor_patern_01";
	}
	
	$shader = "";
	
	foreach ($fullnames as $fullname) {
		echo "processing $fullname\n";
		
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
		
		//if (!file_exists($diff))
		//	$diff  = $folder . "/" . $name . "_Diff_1k.jpg";
		//if (!file_exists($spec))
		//	$spec  = $folder . "/" . $name . "_Spec_1k.jpg";
		//if (!file_exists($rough))
		//	$rough = $folder . "/" . $name . "_Rough_1k.jpg";
		//if (!file_exists($ao))
		//	$ao    = $folder . "/" . $name . "_ao_1k.jpg";
		//if (!file_exists($nor))
		//	$nor   = $folder . "/" . $name . "_Nor_1k.jpg";
		//if (!file_exists($disp))
		//	$disp  = $folder . "/" . $name . "_Disp_1k.jpg";
			
		
		if (!file_exists($diff))
			echo "diff $fullname does not exist\n";
		if (!file_exists($spec))
			echo "spec $fullname does not exist\n";
		if (!file_exists($rough))
			echo "rough $fullname does not exist\n";
		if (!file_exists($ao))
			echo "ao $fullname does not exist\n";
		if (!file_exists($nor))
			echo "nor $fullname does not exist\n";
		if (!file_exists($disp))
			echo "disp $fullname does not exist\n";
		
		// this command will generate:
		// - output_n.png (4 channels)
		// - output_s.png (3 channels)
		system("pbr_converter.exe $spec $rough $ao $nor $disp");
		
		$gen_n = $folder . "/" . $name . "_1k_n.png";
		$gen_s = $folder . "/" . $name . "_1k_s.jpg";
		
		if (!rename("output_n.png", $gen_n))
			echo "rename failed";
		
		// now convert the output_s.png into a 100kb output_s.jpg
		system("magick convert output_s.png -define jpeg:extent=100kb " . $gen_s);
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
		$shader .= "	qer_editorimage textures/" . $diff . "\n";
		$shader .= "	{\n";
		$shader .= "		map textures/" . $diff . "\n";
		$shader .= "		rgbgen identity\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage normalparallaxmap\n";
		$shader .= "		map textures/" . $gen_n . "\n";
		$shader .= "	}\n";
		$shader .= "	{\n";
		$shader .= "		stage specularmap\n";
		$shader .= "		map textures/" . $gen_s . "\n";
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
