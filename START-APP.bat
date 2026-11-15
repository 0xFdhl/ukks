@echo off
chcp 65001 >nul
title ParkirIN - Server
color 1F
echo.
echo  ==============================================
echo    PARKIRIN - Menjalankan server...
echo  ==============================================
echo    Buka di browser:  http://127.0.0.1:8000
echo    Tekan CTRL+C untuk berhenti.
echo.
cd /d "%~dp0"
start "" http://127.0.0.1:8000
php artisan serve --host=127.0.0.1 --port=8000
pause
