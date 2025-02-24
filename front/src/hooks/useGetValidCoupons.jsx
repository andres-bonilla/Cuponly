import { useEffect, useState } from "react";
import { useNotifier } from "../context/NotifierContext";
import { useError } from "../context/ErrorContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useGetValidCoupons = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [coupons, setCoupons] = useState([]);


  const { showError } = useError();

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["init", "has-expired-coupons", "load-user-coupons", "logout"]

  useEffect(()=>{
      if (acceptedEvents.includes(event)) {
        setIsLoading(true);

        const filterCouponsNotUsed = (validCoupons)=>{
          const userCoupons = JSON.parse(localStorage.getItem('user-coupons')) || [];
          return validCoupons.filter(validCoupon => 
            !userCoupons.some(userCoupon => userCoupon.id === validCoupon.id)
          );
        }

        fetch(`${API_URL}/coupons/status/valid`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        })
        .then((res) => 
          res.json()
          .then((result) => ({ result, status: res.status }))
        )
        .then(({result, status})=> {
          if (result.error)
            showError(result.data, status)
          else {
            setCoupons(filterCouponsNotUsed(result.data))
            trigger("");
          }
          setIsLoading(false);
        })
        .catch((error) => {
          console.error("Error al solicitar cupones validos.", error);
          showError();
        });
      }
   
    },[event])

  return {isLoading, coupons};
}