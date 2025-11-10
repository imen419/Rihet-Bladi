import React from "react";
import "./Business.css"; // يمكنك إنشاء CSS خاص بهذا القسم

const services = [
  {
    id: 1,
    titre: "Livraison rapide",
    description: "Nous livrons vos plats tunisiens directement chez vous en moins de 45 minutes.",
    icon: "🚚"
  },
  {
    id: 2,
    titre: "Repas authentiques",
    description: "Découvrez le vrai goût des plats traditionnels tunisiens préparés avec amour.",
    icon: "🍲"
  },
  {
    id: 3,
    titre: "Commande facile",
    description: "Commandez en ligne via notre application ou site web facilement et rapidement.",
    icon: "📱"
  },
  {
    id: 4,
    titre: "Support client",
    description: "Notre équipe est disponible pour répondre à toutes vos questions et besoins.",
    icon: "💬"
  }
];

const Business = () => {
  return (
    <section className="business-section">
      <div className="container">
        <h2>Nos Services</h2>
        <div className="services-grid">
          {services.map(service => (
            <div className="service-card" key={service.id}>
              <div className="icon">{service.icon}</div>
              <h3>{service.titre}</h3>
              <p>{service.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Business;
