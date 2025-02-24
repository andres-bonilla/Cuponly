import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useNotifier } from "../context/NotifierContext";
import { useError } from "../context/ErrorContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useRedeemCoupon = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { session } = useAuth();
  const { trigger } = useNotifier();
  const { showError } = useError();
  
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
      .then((res) => 
        res.json()
        .then((result) => ({ result, status: res.status })))
      .then(({result, status})=> {
        if (result.error)
          showError(result.data, status)
        else {
          trigger(`redeem-coupon`);
          showMessage();
        }
        setIsLoading(false);
      })
      .catch((err) => {
        console.error("Error al canjear un cupón.", err);
        showError();
      });
    }
  }

  return {isLoading, redeemCoupon};
}