rm mp_test.bsp
rm mp_test.lin
rm mp_test.srf
q3map2 -fs_basepath ..\.. -fs_game libwebgame_maps mp_test.map
copy mp_test.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
