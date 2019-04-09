q3map2 -fs_basepath ..\.. -fs_game libwebgame mp_toujane.map
REM q3map2 -fs_basepath ..\.. -fs_game libwebgame -vis -fast -v mp_toujane.map
REM q3map2 -fs_basepath ..\.. -fs_game libwebgame -vis -v mp_toujane.map
REM q3map2 -fs_basepath ..\.. -fs_game libwebgame -light -fast -patchshadows -samples 3 -bounce 8 -gamma 2 -compensate 4 -dirty -v mp_toujane.map
q3map2 -fs_basepath ..\.. -fs_game libwebgame -light -fast -patchshadows -v mp_toujane.map

REM copy mp_toujane.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
