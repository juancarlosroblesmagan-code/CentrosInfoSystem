@echo off
title Encediendo Servidor Anti-Gravity - Centros InfoSystem
echo Levantando los contenedores locales de Docker...
cd /d "%~dp0"
docker compose up -d
echo ==========================================
echo   PROYECTO SEGURO LEVANTADO CON EXITO
echo   Tu web esta disponible en: http://localhost:8080
echo ==========================================
pause