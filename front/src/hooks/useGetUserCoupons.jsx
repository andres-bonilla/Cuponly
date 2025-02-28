import { useEffect, useState } from "react";
import { useNotifier } from "../context/NotifierContext";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";
import { handleAPIRes } from "./helpers/handleAPIRes";
import { createErrorHandler } from "./helpers/createErrorHandler";

const API_URL = import.meta.env.VITE_API_URL;

export const useGetUserCoupons = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [userCoupons, setUserCoupons] = useState([])

  const { session } = useAuth();
  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al solicitar cupones del usuario.");

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["init", "login", "signup", "assign-coupon", "redeem-coupon", "has-invalid-coupons"]
  
  useEffect(()=>{
    // Solo hace la petición si hay sesión y el evento es uno de los aceptados
    if (session?.user && acceptedEvents.includes(event)) {
      setIsLoading(true);
      const userId = session.user.id;
      const token = session.token;

      if (!token) {
        showError("Token de sesión no encontrado.", 401);
        setIsLoading(false);
        return;
      }

      fetch(`${API_URL}/user-coupons/${userId}/coupons`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      })
      .then(handleAPIRes)
      .then(({result})=> {
        // Almacena los cupones del usuario en el almacenamiento local
        localStorage.setItem('user-coupons', JSON.stringify(result));
        setUserCoupons(result.reverse());
        trigger(`load-user-coupons`)
      })
      .catch(handleAPIError)
      .finally(()=> setIsLoading(false));
    }
  }, [session, event])

  return {isLoading, userCoupons};
}