import ftplib
import os
import time
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

ftp_host = '192.168.1.142'
ftp_user = 'daniel'
ftp_pass = 'Contra123'
ftp_folder = '/opt/lampp/htdocs/docs/'


class NewFileHandler(FileSystemEventHandler):
    def on_created(self, event):
        if event.is_directory:
            return

        filename = event.src_path
        print(f"Nuevo archivo detectado: {filename}")
        upload_file(filename)
        delete_file(filename)

def upload_file(filename):
    try:
        # Crear instancia del objeto FTP
        ftp = ftplib.FTP(ftp_host)
        ftp.login(ftp_user, ftp_pass)

        # Cambiar al directorio de destino
        ftp.cwd(ftp_folder)

        # Subir el archivo al servidor FTP
        with open(filename, 'rb') as file:
            ftp.storbinary('STOR ' + os.path.basename(filename), file)

        # Cerrar la conexión FTP
        ftp.quit()

        print(f"El archivo {filename} se ha transferido correctamente al servidor FTP.")
        return True
    except ftplib.all_errors as e:
        print(f"Error al transferir el archivo al servidor FTP: {e}")
        return False

def delete_file(filename):
    try:
        os.remove(filename)
        print(f"El archivo {filename} se ha eliminado de la carpeta de origen.")
        return True
    except OSError as e:
        print(f"Error al eliminar el archivo de la carpeta de origen: {e}")
        return False

def start_monitoring():
    # Ruta de la carpeta a monitorear
    folder_to_watch = 'C:\AppServ\www\php\php2\docs'

    # Crear un observador y un controlador de eventos
    event_handler = NewFileHandler()
    observer = Observer()
    observer.schedule(event_handler, folder_to_watch, recursive=False)

    # Iniciar el observador
    observer.start()

    print("La detección de la creación de archivos ha comenzado.")

    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        observer.stop()

    observer.join()

def stop_monitoring():
    # Detener el monitoreo
    print("La detección de la creación de archivos se ha detenido.")

def main_menu():
    while True:
        print("\n----- MENÚ -----")
        print("1. Iniciar detección de la creación de archivos.")
        print("2. Detener detección de la creación de archivos.")
        print("3. Salir.")

        choice = input("Selecciona una opción (1-3): ")

        if choice == "1":
            start_monitoring()
        elif choice == "2":
            stop_monitoring()
        elif choice == "3":
            break
        else:
            print("Opción inválida. Inténtalo nuevamente.")

if __name__ == "__main__":
    main_menu()