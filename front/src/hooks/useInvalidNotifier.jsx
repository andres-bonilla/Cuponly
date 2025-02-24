import { useEffect } from "react";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";
import { useAuth } from "../context/AuthContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useInvalidNotifier = (countdowns) => {
  const { trigger } = useNotifier();
  const { showError } = useError();
  const { session } = useAuth();

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
      .then((res) => 
        res.json()
        .then((result) => ({ result, status: res.status })))
      .then(({result, status})=> {
        if (result.error) 
          showError(result.data, status);
        else
          trigger("has-invalid-coupons");
      })
      .catch((err) => {
        console.error("Error al notificar que hay cupones que han dejado de ser validos.", err);
        showError();
      });
    }
  }, [countdowns]); // Cada vez que los countdowns cambian, verificamos si hay expirados
};