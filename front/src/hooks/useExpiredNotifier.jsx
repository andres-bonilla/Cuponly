import { useEffect } from "react";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useExpiredNotifier = (countdowns) => {
  const { trigger } = useNotifier();
  const { showError } = useError();

  useEffect(() => {
    const hasOneExpired = countdowns.some((countdown) => countdown === "Expirado");
    if (hasOneExpired) {
      // Informamos al backend que hay cupones que han expirado 
      fetch(`${API_URL}/coupons/has-expired`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          'Accept': 'application/json'
        }
      })
      .then((res) => 
        res.json()
        .then((result) => ({ result, status: res.status })))
      .then(({result, status})=> {
        if (result.error) 
          showError(result.data, status);
        else if (status === 201)
          trigger("has-expired-coupons");
        else
          trigger("init");
      })
      .catch((err) => {
        console.error("Error al notificar que hay cupones que han expirado.", err);
        showError();
      });
    }
  }, [countdowns]); // Cada vez que los countdowns cambian, verificamos si hay expirados
};