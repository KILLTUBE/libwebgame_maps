textures/texturehaven_bricks/brick_4
{
    qer_editorimage textures/texturehaven_bricks/brick_4_diff_1k.jpg
    {
        map textures/texturehaven_bricks/brick_4_diff_1k.jpg
        rgbgen identity
    }
    {
        stage normalmap
        map textures/texturehaven_bricks/brick_4_nor_1k.jpg
        normalScale 1 1
        //parallaxDepth 0.05
    }
    {
        stage specularmap
        map textures/texturehaven_bricks/brick_4_spec_1k.jpg
        specularReflectance 0.12
        specularExponent 16
    }
    {
        map $lightmap
        blendfunc GL_DST_COLOR GL_ZERO
    }
}
