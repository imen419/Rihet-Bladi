import React from "react";
import { Link } from "react-router-dom";

const Nav = () => {
  const styles = {
    nav: {
      background: "#fff",
      borderBottom: "1px solid #e0e0e0",
      boxShadow: "0 2px 8px rgba(0,0,0,0.05)",
      padding: "12px 40px",
      display: "flex",
      justifyContent: "space-between",
      alignItems: "center",
      position: "sticky",
      top: 0,
      zIndex: 1000,
      flexWrap: "wrap",
    },
    logo: {
      display: "flex",
      alignItems: "center",
      gap: "10px",
      fontSize: "20px",
      fontWeight: "bold",
      color: "#0d47a1",
    },
    logoImg: {
      width: "40px",
      height: "40px",
      borderRadius: "50%",
      objectFit: "cover",
      border: "2px solid #0d47a1",
    },
    navLinks: {
      listStyle: "none",
      display: "flex",
      gap: "20px",
      padding: 0,
      margin: 0,
      flexWrap: "wrap",
    },
    link: {
      textDecoration: "none",
      color: "#444",
      fontWeight: 500,
      padding: "8px 14px",
      borderRadius: "10px",
      transition: "all 0.3s ease",
    },
  };

  return (
    <header style={styles.nav}>
      <div style={styles.logo}>
        <img
          src="/images/Logo_rbt.png"
          alt="Logo Rihet Bladi"
          style={styles.logoImg}
        />
        <span>
          Rihet <strong>Bladi</strong>
        </span>
      </div>
      <ul style={styles.navLinks}>
        <li>
          <Link to="/" style={styles.link}>
            Accueil
          </Link>
        </li>
        <li>
          <Link to="/login" style={styles.link}>
            Connexion
          </Link>
        </li>
        <li>
          <Link to="/business" style={styles.link}>
            Business
          </Link>
        </li>
        <li>
          <Link to="/livraison" style={styles.link}>
            Livraison
          </Link>
        </li>
        <li>
          <Link to="/commande" style={styles.link}>
            Commande
          </Link>
        </li>
        <li>
          <Link to="/partenaires" style={styles.link}>
            Partenaires
          </Link>
        </li>
      </ul>
    </header>
  );
};

export default Nav;
