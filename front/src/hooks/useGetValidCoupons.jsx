import { useEffect, useState } from "react";
import { useNotifier } from "../context/NotifierContext";
import { useError } from "../context/ErrorContext";
import { handleAPIRes } from "./helpers/handleAPIRes";
import { createErrorHandler } from "./helpers/createErrorHandler";

const API_URL = import.meta.env.VITE_API_URL;

export const useGetValidCoupons = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [coupons, setCoupons] = useState([]);


  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, "Error al solicitar cupones validos.");

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["init", 'error', "has-expired-coupons", "load-user-coupons", "logout"]

  useEffect(()=>{
      // Solo realiza la petición si el evento es uno de los aceptados
      if (acceptedEvents.includes(event)) {
        setIsLoading(true);

        // Función que filtra los cupones válidos que el usuario aún no ha usado
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
        .then(handleAPIRes)
        .then(({result})=> {
          // Establece los cupones válidos no usados por el usuario
          setCoupons(filterCouponsNotUsed(result));
          trigger("");
        })
        .catch(handleAPIError)
        .finally(()=> setIsLoading(false));
      }
   
    },[event])

  return {isLoading, coupons};
}