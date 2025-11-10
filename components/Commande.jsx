import React, { useState } from "react";
import axios from "axios";

const Commande = ({ cart, onClearCart }) => {
  const [client, setClient] = useState({ nom: "", prenom: "", email: "", ville: "" });
  const [message, setMessage] = useState("");

  const handleChange = e => {
    setClient({ ...client, [e.target.name]: e.target.value });
  };

  const handleSubmit = e => {
    e.preventDefault();
    if (!client.nom || !client.prenom || !client.email || !client.ville) {
      setMessage("⚠️ Veuillez remplir tous les champs !");
      return;
    }
    if (cart.length === 0) {
      setMessage("⚠️ Votre panier est vide !");
      return;
    }

    axios.post("http://localhost:5000/api/commande", { client, plats: cart })
      .then(res => {
        setMessage("✅ Commande passée avec succès !");
        onClearCart();
      })
      .catch(err => {
        console.error(err);
        setMessage("❌ Erreur lors de la commande !");
      });
  };

  return (
    <section className="commande-section">
      <h2>Passer une commande</h2>
      {message && <p>{message}</p>}
      <form onSubmit={handleSubmit} className="commande-form">
        <input type="text" name="nom" placeholder="Nom" value={client.nom} onChange={handleChange} />
        <input type="text" name="prenom" placeholder="Prénom" value={client.prenom} onChange={handleChange} />
        <input type="email" name="email" placeholder="Email" value={client.email} onChange={handleChange} />
        <input type="text" name="ville" placeholder="Ville" value={client.ville} onChange={handleChange} />
        <button type="submit">Confirmer la commande</button>
      </form>

      {cart.length > 0 && (
        <div className="cart-summary">
          <h3>Votre panier</h3>
          <ul>
            {cart.map(plat => (
              <li key={plat.id}>{plat.nom} - {plat.prix} TND</li>
            ))}
          </ul>
          <p>Total: {cart.reduce((sum, p) => sum + p.prix, 0)} TND</p>
        </div>
      )}
    </section>
  );
};

export default Commande;
