import React from "react";
import PortfolioLogo from "../assets/portfolio_logo.svg?react";

export const Footer = () => {
  return (
    <footer id="foot" className={`fade-in-large`}>
      <a
        id="portfolio"
        className="no-link-style"
        href="https://andres-bonilla.vercel.app"
      >
        <PortfolioLogo id="portfolio-logo" />

        <span id="name">
          Andrés
          <br />
          Bonilla
          <br />© 2025
        </span>
      </a>

      <span id="rights" className="label">
        All Rights Reserved.
      </span>

    </footer>
  );
};