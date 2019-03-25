rm mp_grass.bsp
rm mp_grass.lin
rm mp_grass.srf
q3map2 -fs_basepath ..\.. -fs_game libwebgame_maps mp_grass.map
copy mp_grass.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
