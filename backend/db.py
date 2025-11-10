import sqlite3

DB_NAME = "rihet_bladi.db"

def get_db_connection():
    conn = sqlite3.connect(DB_NAME)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    conn = get_db_connection()
    cur = conn.cursor()
    
    # Table clients
    cur.execute("""
        CREATE TABLE IF NOT EXISTS clients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            prenom TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            ville TEXT NOT NULL
        )
    """)
    
    # Table plats
    cur.execute("""
        CREATE TABLE IF NOT EXISTS plats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL,
            type TEXT NOT NULL,
            prix REAL NOT NULL
        )
    """)
    
    # Table commandes
    cur.execute("""
        CREATE TABLE IF NOT EXISTS commandes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            client_email TEXT NOT NULL,
            plats TEXT NOT NULL,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    """)
    
    conn.commit()
    conn.close()

if __name__ == "__main__":
    init_db()
    print("Base de données initialisée !")
# db.py
import sqlite3

conn = sqlite3.connect('rihet_bladi.db')
cursor = conn.cursor()

# حذف الجدول القديم إذا كان موجوداً
cursor.execute("DROP TABLE IF EXISTS plats")

# إنشاء جدول جديد بالعمود description
cursor.execute("""
CREATE TABLE plats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT,
    prix REAL NOT NULL,
    image TEXT
)
""")

conn.commit()
conn.close()
print("Table plats créé avec succès !")
