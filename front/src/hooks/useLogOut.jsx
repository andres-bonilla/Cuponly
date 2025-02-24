import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useLogOut = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { session, logOut } = useAuth();
  const { trigger } = useNotifier();
  const { showError } = useError();

  const logOutUser = () => {
    setIsLoading(true);

    fetch(`${API_URL}/users/logout`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${session.token}`
      }
    })
    .then((res) => 
      res.json()
      .then((result) => ({ result, status: res.status }))
    )
    .then(({result, status})=> {
      if (result.error)
        showError(result.data, status, false)
      else {
        logOut();
        trigger("logout");
      }
      setIsLoading(false);
    })
    .catch((err) => {
      console.error('Error al cerrar sesión.', err);
      showError();
    });
  }

  return {isLoading, logOutUser};
}