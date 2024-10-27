import mysql.connector
from mysql.connector import Error
import os
from dotenv import load_dotenv

load_dotenv('config.env')

def create_connection():
    try:
        conn = mysql.connector.connect(
            host=os.getenv("DB_HOST"),
            database=os.getenv("DB_NAME"),
            user=os.getenv("DB_USER"),
            password=os.getenv("DB_PASSWORD")
        )
        if conn.is_connected():
            print("Conexão com o banco de dados bem-sucedida.")
            return conn
    except Error as e:
        print(f"Erro ao conectar ao banco de dados: {e}")
        return None

if __name__ == "__main__":
    create_connection()
