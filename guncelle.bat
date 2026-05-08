@echo off
chcp 65001 > nul
echo =======================================
echo   SCORPION MC - GITHUB GUNCELLEYICI
echo =======================================
echo.
echo Admin paneli uzerinden yapilan fotograf yuklemeleri GitHub'i otomatik gunceller.
echo Bu yuzden kodlarinizi gonderirken once son degisiklikleri cekmek gerekir.
echo Bu arac tum bu islemleri sizin icin otomatik yapar!
echo.
set /p commit_msg="Yapilan degisikligi kisaca yazin (ornegin: iletisim butonu eklendi): "

echo.
echo [1/4] Degisiklikler ekleniyor...
git add .

echo [2/4] Degisiklikler kaydediliyor...
git commit -m "%commit_msg%"

echo [3/4] GitHub'daki son fotograflar/veriler bilgisayara cekiliyor (Senkronizasyon)...
git pull --rebase origin main

echo [4/4] Sizin kodlariniz GitHub'a gonderiliyor...
git push origin main

echo.
echo =======================================
echo ISLEM TAMAMLANDI! Siteniz guncellendi.
echo =======================================
pause
