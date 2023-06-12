import telebot
import pymysql

# Definir el token del bot de Telegram
TOKEN = '6050256245:AAEHy82oPuQFavpfVSSu5vzv1x0_VuZ1aio'
bot = telebot.TeleBot(TOKEN)

# Establecer la conexión con la base de datos
conexion = pymysql.connect(
    host='localhost',
    user='root',
    password='css99',
    database='restaurante'
)

# Función para comprobar las existencias y enviar mensajes
def comprobar_existencias():
    cursor = conexion.cursor()
    conexion.connect()
    # Consulta para obtener los productos con menos de 2 existencias
    consulta = "SELECT nombre, cantidad FROM almacen WHERE cantidad <= 2"
    cursor.execute(consulta)
    productos = cursor.fetchall()
    cantidad_productos = len(productos)  # Contar la cantidad de productos obtenidos

    if cantidad_productos > 0:
        mensaje = f"Se han encontrado {cantidad_productos} productos con menos de 2 existencias:\n\n"
        for producto in productos:
            mensaje += f"- {producto[0]}: {producto[1]} existencias\n"
        CHAT_ID = 1031926853
        # Enviar el mensaje al usuario
        bot.send_message(chat_id=CHAT_ID, text=mensaje)
    else:
        mensaje = "No se han encontrado productos con menos de 2 existencias."
        CHAT_ID = 1031926853
        bot.send_message(chat_id=CHAT_ID, text=mensaje)
    conexion.close()

# Registro del comando /comprobar_cantidad
@bot.message_handler(commands=['comprobar_cantidad'])
def handle_comprobar_cantidad(message):
    comprobar_existencias()

# Registro para procesar todos los mensajes entrantes
@bot.message_handler(func=lambda message: True)
def handle_all_messages(message):
   
bot.polling()