echo off
C:\wamp\bin\mysql\mysql5.7.36\bin\mysqldump -hlocalhost -uroot -pAdmin*gif zonacgg > C:\backup_GrupoGif\BackUpGrupoGif_%Date:~6,4%%Date:~3,2%%Date:~0,2%.sql
exit
