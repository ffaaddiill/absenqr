@echo off
START /B /WAIT cmd /c taskkill /F /IM chrome.exe /T > nul
START chrome -incognito http://absenqr.test/qrs/qs
exit
