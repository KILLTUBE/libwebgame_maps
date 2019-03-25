rm mp_city.bsp
rm mp_city.lin
rm mp_city.srf
q3map2 -fs_basepath ..\.. -fs_game libwebgame_maps mp_city.map
copy mp_city.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
