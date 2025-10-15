@echo off
REM Create Symlink for Laravel Storage
REM This script creates the necessary symbolic link for Laravel storage
REM Use this on Windows servers where symlink is available

echo Creating symlink for Laravel storage...

REM Define paths
set TARGET=storage\app\public
set LINK=public\storage

REM Check if target exists
if not exist "%TARGET%" (
    echo ❌ Target directory does not exist: %TARGET%
    echo Please check your Laravel installation.
    pause
    exit /b 1
)

echo ✅ Target directory exists: %TARGET%

REM Check if link already exists
if exist "%LINK%" (
    echo ⚠️ Link already exists.
    echo Please manually delete it first if you want to recreate it.
    pause
    exit /b 1
)

REM Create symbolic link
echo Creating symbolic link...
mklink /D "%LINK%" "..\%TARGET%"

if %errorlevel% equ 0 (
    echo ✅ SUCCESS! Storage link created.
    echo From: %LINK%
    echo To: %TARGET%
    echo.
    echo ✅ Link verified and working correctly.
) else (
    echo ❌ Failed to create symbolic link.
    echo Please run as Administrator or check permissions.
    pause
    exit /b 1
)

echo 🎉 Symlink created successfully!
echo Storage images should now be accessible at: https://yourdomain.com/storage/images/your-image.jpg
pause
