rm mp_toujane.bsp
rm mp_toujane.lin
rm mp_toujane.srf
q3map2 -fs_basepath ..\.. -fs_game libwebgame_maps mp_toujane.map
copy mp_toujane.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
