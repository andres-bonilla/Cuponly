import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useNotifier } from "../context/NotifierContext";
import { useError } from "../context/ErrorContext";
import { handleAPIRes } from "./helpers/handleAPIRes";
import { createErrorHandler } from "./helpers/createErrorHandler";

const API_URL = import.meta.env.VITE_API_URL;

export const useAssignCoupon = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { session } = useAuth();
  const { trigger } = useNotifier();
  
  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al asignar un cupón.");
  
  const assignCoupon = (couponId, showMessage) => {
    if (session?.user) {
      setIsLoading(true);
      const userId = session.user.id;

      fetch(`${API_URL}/user-coupons/${userId}/${couponId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${session.token}`
        }
      })
      .then(handleAPIRes)
      .then(()=> {
        trigger(`assign-coupon`);
        showMessage();
      })
      .catch(handleAPIError)
      .finally(()=> setIsLoading(false));
    }
  }

  return {isLoading, assignCoupon};
}