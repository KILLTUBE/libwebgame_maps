rm mp_beginning.bsp
rm mp_beginning.lin
rm mp_beginning.srf
q3map2 -fs_basepath ..\.. -fs_game libwebgame_maps mp_beginning.map
copy mp_beginning.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
