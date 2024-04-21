@echo off

call env.bat

taskkill /F /IM httpd.exe > nul 2>&1
taskkill /F /IM mysqld.exe > nul 2>&1
taskkill /F /IM xampp-control.exe > nul 2>&1

pushd %~dp0\tools\xampp\mysql

rmdir /S/Q data

tar -xf data.zip

popd

call xampp.bat
