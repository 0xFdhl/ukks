@echo off
chcp 65001 >nul
title ParkirIN - Setup Awal
color 1F
echo.
echo  ==============================================
echo    PARKIRIN - SETUP AWAL (jalankan 1x saja)
echo  ==============================================
echo.

cd /d "%~dp0"

where php >nul 2>nul
if errorlevel 1 (
    color 4F
    echo  [ERROR] PHP tidak ditemukan!
    echo  Install XAMPP dulu, lalu tambahkan PHP ke PATH.
    pause
    exit /b 1
)

echo  [1/6] Install dependency Composer (2-5 menit)...
call composer install --no-interaction || goto :fail

echo  [2/6] Menyiapkan file konfigurasi .env...
if not exist .env (
    copy .env.example .env >nul
    call php artisan key:generate --quiet
) else (
    echo         .env sudah ada, dilewati.
)

echo  [3/6] Membuat database "parkirr" di MySQL...
set "MYSQL="
if exist "C:\xampp\mysql\bin\mysql.exe" set "MYSQL=C:\xampp\mysql\bin\mysql.exe"
if not defined MYSQL for %%p in ("C:\wamp64\bin\mysql\*\bin\mysql.exe") do set "MYSQL=%%p"
if defined MYSQL (
    "%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS parkirr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>nul
    echo         Database siap.
) else (
    echo         mysql.exe tidak ditemukan - buat database ^"parkirr^" manual via phpMyAdmin.
)

echo  [4/6] Membuat tabel + data awal...
call php artisan migrate --seed --force || goto :fail

echo  [5/6] Install dependency NPM (1-3 menit)...
call npm install --no-audit --no-fund || goto :fail

echo  [6/6] Build aset CSS/JS produksi...
call npm run build || goto :fail

color 2F
echo.
echo  ==============================================
echo    SELESAI! Jalankan START-APP.bat untuk
echo    membuka aplikasi.
echo  ==============================================
echo    Login: admin / petugas / owner
echo    Password: password
echo.
pause
exit /b 0

:fail
color 4F
echo.
echo  [ERROR] Setup gagal. Baca pesan error di atas.
pause
exit /b 1
