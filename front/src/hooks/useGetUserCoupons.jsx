import { useEffect, useState } from "react";
import { useNotifier } from "../context/NotifierContext";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useGetUserCoupons = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [userCoupons, setUserCoupons] = useState([])

  const { session } = useAuth();
  const { showError } = useError();

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["init", "login", "signup", "assign-coupon", "redeem-coupon", "has-invalid-coupons"]
  
  useEffect(()=>{
    if (session?.user && acceptedEvents.includes(event)) {
      setIsLoading(true);
      const userId = session.user.id;
      const token = session.token;

      fetch(`${API_URL}/user-coupons/${userId}/coupons`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      })
      .then((res) => 
        res.json()
        .then((result) => ({ result, status: res.status })))
      .then(({result, status})=> {
        if (result.error)
          showError(result.data, status)
        else {
          localStorage.setItem('user-coupons', JSON.stringify(result.data));
          setUserCoupons(result.data.reverse())
        }
        setIsLoading(false);
      })
      .then(()=> trigger(`load-user-coupons`))
      .catch((error) => {
        console.error("Error al solicitar cupones del usuario.", error);
        showError();
      });
    }
  }, [session, event])

  return {isLoading, userCoupons};
}