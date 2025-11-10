import React, { useEffect, useState } from "react";
import axios from "axios";
import "./Menu.css"; // يمكنك إنشاء CSS خاص بالقائمة

const Menu = ({ onAddToCart }) => {
  const [plats, setPlats] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Récupérer les plats depuis l'API Flask
    axios.get("http://localhost:5000/api/plats")
      .then(res => {
        setPlats(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Chargement des plats...</p>;

  return (
    
    <section className="menu-section">
      <h2>Menu Rihet Bladi</h2>
      <div className="menu-grid">
        {plats.map(plat => (
          <div className="plat-card" key={plat.id}>
            <img src={plat.image} alt={plat.nom} />
            <h3>{plat.nom}</h3>
            <p>{plat.description}</p>
            <p className="prix">{plat.prix} TND</p>
            <button onClick={() => onAddToCart(plat)}>Ajouter au panier</button>
          </div>
        ))}
      </div>
    </section>
  );
};
