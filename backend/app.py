# backend/app.py
from flask import Flask, request, jsonify
from flask_cors import CORS
import sqlite3
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
CORS(app)

DB_PATH = "rihet_bladi.db"

# --- Utilitaires base de données ---
def get_db():
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    conn = get_db()
    cursor = conn.cursor()
    # Table clients
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS clients (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT,
        prenom TEXT,
        email TEXT UNIQUE,
        password TEXT
    )''')
    # Table plats
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS plats (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT,
        description TEXT,
        prix REAL,
        image TEXT
    )''')
    # Table commandes
    cursor.execute('''
    CREATE TABLE IF NOT EXISTS commandes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        client_id INTEGER,
        items TEXT,
        total REAL,
        FOREIGN KEY(client_id) REFERENCES clients(id)
    )''')
    conn.commit()
    conn.close()

init_db()

# --- Routes API ---
@app.route("/api/plats", methods=["GET"])
def get_plats():
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM plats")
    plats = [dict(row) for row in cursor.fetchall()]
    conn.close()
    return jsonify(plats)

@app.route("/api/register", methods=["POST"])
def register():
    data = request.get_json()
    nom = data.get("nom")
    prenom = data.get("prenom")
    email = data.get("email")
    password = generate_password_hash(data.get("password"))

    conn = get_db()
    cursor = conn.cursor()
    try:
        cursor.execute(
            "INSERT INTO clients (nom, prenom, email, password) VALUES (?, ?, ?, ?)",
            (nom, prenom, email, password)
        )
        conn.commit()
        return jsonify({"message": "Compte créé avec succès"})
    except sqlite3.IntegrityError:
        return jsonify({"message": "Email déjà utilisé"}), 400
    finally:
        conn.close()

@app.route("/api/login", methods=["POST"])
def login():
    data = request.get_json()
    email = data.get("email")
    password = data.get("password")

    conn = get_db()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM clients WHERE email = ?", (email,))
    user = cursor.fetchone()
    conn.close()

    if user and check_password_hash(user["password"], password):
        return jsonify({"message": "Connexion réussie", "user": {"id": user["id"], "nom": user["nom"]}})
    return jsonify({"message": "Email ou mot de passe incorrect"}), 401

@app.route("/api/commande", methods=["POST"])
def commande():
    data = request.get_json()
    client = data.get("client")
    items = data.get("items", [])

    if not client or not items:
        return jsonify({"message": "Données manquantes"}), 400

    # Vérifier si le client existe ou créer un nouveau
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM clients WHERE email = ?", (client["email"],))
    existing_client = cursor.fetchone()
    if existing_client:
        client_id = existing_client["id"]
    else:
        password = generate_password_hash("123456")  # mot de passe par défaut
        cursor.execute(
            "INSERT INTO clients (nom, prenom, email, password) VALUES (?, ?, ?, ?)",
            (client.get("nom"), client.get("prenom", ""), client.get("email"), password)
        )
        client_id = cursor.lastrowid

    total = 0
    for item in items:
        total += item.get("quantite", 1) * item.get("prix", 0)

    cursor.execute(
        "INSERT INTO commandes (client_id, items, total) VALUES (?, ?, ?)",
        (client_id, str(items), total)
    )
    order_id = cursor.lastrowid
    conn.commit()
    conn.close()

    return jsonify({"message": "Commande reçue", "order_id": order_id})

if __name__ == "__main__":
    app.run(debug=True)
