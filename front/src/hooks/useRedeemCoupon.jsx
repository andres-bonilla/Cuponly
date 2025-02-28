import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useNotifier } from "../context/NotifierContext";
import { useError } from "../context/ErrorContext";
import { createErrorHandler } from "./helpers/createErrorHandler";
import { handleAPIRes } from "./helpers/handleAPIRes";

const API_URL = import.meta.env.VITE_API_URL;

export const useRedeemCoupon = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { session } = useAuth();
  const { trigger } = useNotifier();

  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al canjear un cupón.");
  
  const redeemCoupon = (couponId, showMessage) => {
    if (session?.user) {
      setIsLoading(true);
      const userId = session.user.id;

      fetch(`${API_URL}/user-coupons/${userId}/${couponId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${session.token}`
        },
        body: JSON.stringify({status: 'redeemed'})
      })
      .then(handleAPIRes)
      .then(()=> {
        trigger(`redeem-coupon`);
        showMessage();
      })
      .catch(handleAPIError)
      .finally(()=> setIsLoading(false));
    }
  }

  return {isLoading, redeemCoupon};
}