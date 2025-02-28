import { useEffect } from "react";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";
import { createErrorHandler } from "./helpers/createErrorHandler";
import { handleAPIRes } from "./helpers/handleAPIRes";

const API_URL = import.meta.env.VITE_API_URL;

export const useExpiredNotifier = (countdowns) => {
  const { trigger } = useNotifier();
  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al notificar que hay cupones que han expirado.");

  useEffect(() => {
    const hasOneExpired = countdowns.some((countdown) => countdown === "Expirado");
    if (hasOneExpired) {
      // Informamos a la API que hay cupones que han expirado 
      fetch(`${API_URL}/coupons/has-expired`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          'Accept': 'application/json'
        }
      })
      .then(handleAPIRes)
      .then(({status})=> {
        if (status === 201)
          trigger("has-expired-coupons");
        else
          trigger("init"); // Si no fueron creados nuevos cupones se reinicia el event
      })
      .catch(handleAPIError);
    }
  }, [countdowns]); // Cada vez que los countdowns cambian, verificamos si hay expirados
};