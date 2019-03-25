textures/caulk
{
	qer_editorimage kungtile/tile6_dio.jpg
	surfaceparm nodraw
}

textures/tools/ladder
{
	//qer_editorimage kungtile/tile6_dio.jpg
	surfaceparm ladder
	surfaceparm nodraw
	surfaceparm solid
	//surfaceparm noimpact
	surfaceparm trans
}

textures/liquids/water
{
	//qer_editorimage liquids/water.png
	qer_trans .5
	q3map_globaltexture

	surfaceparm trans
	surfaceparm nonsolid
	surfaceparm water
	surfaceparm nolightmap

	cull disable
	tesssize 64
	deformVertexes wave 100 sin 1 1 1 .1
	
	{
		//map liquids/water.png
		blendfunc GL_ONE GL_SRC_COLOR	
		tcMod scale .03 .03
		tcMod scroll .001 .001
	}

	//{
	//	map liquids/pool3.tga
	//	blendfunc GL_DST_COLOR GL_ONE
	//	tcMod turb .1 .1 0 .01
	//	tcMod scale .5 .5
	//	tcMod scroll -.025 .02
	//}
}
	
skybox
{
      qer_editorimage mymap/skybox1.tga
      surfaceparm noimpact
      surfaceparm nolightmap
      surfaceparm sky
      q3map_sun .5 .37 .19 155 170 78
      q3map_surfacelight 130
      skyparms env/mymap/skybox - -
}

skybox
{
      qer_editorimage mymap/skybox1.tga
      surfaceparm noimpact
      surfaceparm nolightmap
      surfaceparm sky
      q3map_sun .5 .37 .19 155 170 78
      q3map_surfacelight 130
      skyparms env/mymap/skybox - -
}

skybox
{
      qer_editorimage mymap/skybox1.tga
      surfaceparm noimpact
      surfaceparm nolightmap
      surfaceparm sky
      q3map_sun .5 .37 .19 155 170 78
      q3map_surfacelight 130
      skyparms env/mymap/skybox - -
}

//skybox
//{
//	surfaceparm sky
//	surfaceparm noimpact
//	surfaceparm nolightmap
//	//q3map_surfacelight 300
//	//q3map_sun 1 1 1 100 -41 58
//	qer_editorimage liquids/water.png
//	//skyparms env/space1 - -
//	//skyparms env/xnight2 - -
//}