import React, { useState, useEffect } from 'react';

// Función que calcula la cuenta regresiva
function calcCountdown(expireDate) {
  if (!expireDate) return "";
  const now = new Date();
  const expire = new Date(expireDate);

  const diff = expire - now;

  if (diff <= 0) return `Expirado`;

  const days = Math.floor(diff / (1000 * 60 * 60 * 24));
  const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minuts = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((diff % (1000 * 60)) / 1000);

  return `${days}d ${hours}h ${minuts}m ${seconds}s`;
}

export const useCountdowns = ( expirationDates ) => {
  const [countdowns, setCountdowns] = useState([]);

  useEffect(() => {
    // Función para actualizar las cuentas regresivas
    const updateCountdowns = () => {
      const newCountdowns = expirationDates.map((expireDate) => calcCountdown(expireDate));
      setCountdowns(newCountdowns);
    };

    // Actualizar los contadores cada segundo
    const interval = setInterval(updateCountdowns, 1000);

    return () => clearInterval(interval);
  }, [expirationDates]);
  
  return {countdowns};
}