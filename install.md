Install.md
Proyecto Laravel Backend
Este proyecto utiliza Laravel Sail para gestionar su entorno de desarrollo con contenedores Docker. Sigue estos pasos para instalar y ejecutar el proyecto.


Prerrequisitos
Asegúrate de tener instalados los siguientes programas en tu sistema:

1. Docker
    Descargar Docker Version 27 para arriba
1.1 Git
    Descargar Git
Opcional: Composer (para instalar dependencias manualmente si no usas Sail).
    Descargar Composer

Luego 
2. Configurar el archivo .env
El archivo .env contiene las configuraciones del entorno. Sigue estos pasos:

Copia el archivo .env.example y renómbralo como .env:
cp .env.example .env

3. Instalar dependencias
Ejecuta el siguiente comando para instalar las dependencias de Laravel:
./vendor/bin/sail composer install
4. Levantar los contenedores con Sail
./vendor/bin/sail up -d
5. Configurar la base de datos
    Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
    ./vendor/bin/sail artisan migrate
6. Exportar los seeders para llenar las tablas
    ./vendor/bin/sail artisan migrate --seed
7. Generar una clave de aplicación
        Genera una clave única para tu aplicación:
        ./vendor/bin/sail artisan key:generate

Si los comandos no corren en la terminal iniciar su maquina virtual desde powershell ejecutar wsl dirigirse a la carpeta y hacer los comandos, pero solo si no le da los comandos al levantar el docker
recomendable tener el docker iniciado