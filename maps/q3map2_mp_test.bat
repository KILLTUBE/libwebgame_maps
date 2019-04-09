q3map2 -fs_basepath ..\.. -fs_game libwebgame mp_test.map
q3map2 -fs_basepath ..\.. -fs_game libwebgame -vis -v mp_test.map
q3map2 -fs_basepath ..\.. -fs_game libwebgame -light -fast -patchshadows -deluxe mp_test.map

REM copy mp_test.bsp c:\web\libwebgame_assets\libwebgame\maps
pause
