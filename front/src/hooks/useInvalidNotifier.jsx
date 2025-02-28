import { useEffect } from "react";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";
import { useAuth } from "../context/AuthContext";
import { createErrorHandler } from "./helpers/createErrorHandler";
import { handleAPIRes } from "./helpers/handleAPIRes";

const API_URL = import.meta.env.VITE_API_URL;

export const useInvalidNotifier = (countdowns) => {
  const { session } = useAuth();
  const { trigger } = useNotifier();

  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al notificar que hay cupones que han dejado de ser validos.");

  useEffect(() => {
    const hasOneInvalid = countdowns.some((countdown) => countdown === "Expirado");
    if (hasOneInvalid && session?.user) {
      // Informamos al backend que hay cupones que han expirado 
      fetch(`${API_URL}/user-coupons/${session.user.id}/has-invalid`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          'Accept': 'application/json',
          'Authorization': `Bearer ${session.token}`
        }
      })
      .then(handleAPIRes)
      .then(()=> {
        trigger("has-invalid-coupons");
      })
      .catch(handleAPIError);
    }
  }, [countdowns]); // Cada vez que los countdowns cambian, verificamos si hay expirados
};