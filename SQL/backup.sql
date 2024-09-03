BACKUP DATABASE [NombreDeTuBaseDeDatos]
TO DISK = 'C:\Backups\bdrendimientos.bak'
WITH FORMAT, INIT, SKIP, NOREWIND, NOUNLOAD, STATS = 10;


--.bat part
@echo off
setlocal
set "dbname=NombreDeTuBaseDeDatos"
set "backupdir=F:\Microsoft SQL Server\MSSQL 16.SQLEXPRESS\Backup\rendimientos"
set "datetime=%date:~10,4%%date:~7,2%%date:~4,2%_%time:~0,2%%time:~3,2%%time:~6,2%"
set "backupfile=%backupdir%\%dbname%_%datetime%.bak"
sqlcmd -S .\SQLEXPRESS -Q "BACKUP DATABASE [%dbname%] TO DISK = N'%backupfile%' WITH FORMAT, INIT, SKIP, NOREWIND, NOUNLOAD, STATS = 10;"
endlocal
