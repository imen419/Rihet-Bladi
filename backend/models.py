from db import get_db_connection

def insert_sample_plats():
    conn = get_db_connection()
    cursor = conn.cursor()

    plats = [
        ("Bessa", "Plat traditionnel tunisien", 12.0, "images/bessa.jpg"),
        ("Harissa", "Pâte de piment rouge", 5.0, "images/harissa.jpg"),
        ("Salata Mechouia", "Salade grillée", 8.0, "images/salata.jpg"),
        ("Zrir", "Dessert sucré tunisien", 6.0, "images/zrir.jpg")
    ]

    cursor.executemany('INSERT INTO plats (nom, description, prix, image) VALUES (?, ?, ?, ?)', plats)
    conn.commit()
    conn.close()
    print("Données initiales des plats insérées !")

if __name__ == "__main__":
    insert_sample_plats()
