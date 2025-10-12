@echo off

set filename=f
set num=%2

if "%1"=="" (
    echo Не указано имя f.
    exit /b
)
if "%2"=="" (
    echo Не указан номер n.
    exit /b
)

echo. > %filename% 

for /l %%i in (1, 1, %num%) do ( 

    if not exist %filename%.%%i (
        echo Ошибка: этот файл не существовал до выполнения команды.
    )
    type %filename%.%%i >> %filename% 

)

echo Файл %1 успешно создан, объединив %2 файлов.
