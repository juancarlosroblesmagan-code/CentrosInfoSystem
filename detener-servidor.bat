@echo off
title Detener Centros InfoSystem - Anti-Gravity
cd /d "%~dp0"

echo ====================================================
echo    DETENIENDO CONTENEDORES (CENTROS INFOSYSTEM)
echo ====================================================
echo.

docker compose down

echo.
echo ====================================================
echo    ENTORNO DETENIDO CORRECTAMENTE
echo ====================================================
echo.
pause
