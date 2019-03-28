q3map2 -fs_basepath ..\.. -fs_game libwebgame mp_test.map
q3map2 -vis -v -saveprt mp_test.map
REM q3map2 -light -fast -patchshadows -samples 3 -bounce 8 -gamma 2 -compensate 4 -dirty -v mp_test.map
q3map2 -light -fast -v mp_test.map

REM copy mp_test.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
