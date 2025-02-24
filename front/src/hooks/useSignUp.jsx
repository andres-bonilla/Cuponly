import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";

const API_URL = import.meta.env.VITE_API_URL;

export const useSignUp = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { logIn } = useAuth();
  const { trigger } = useNotifier();
  const { showError } = useError();

  const signUpUser = (userData) => {
    setIsLoading(true);

    fetch(`${API_URL}/users/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({...userData})
    })
    .then((res) => 
      res.json()
      .then((result) => ({ result, status: res.status }))
    )
    .then(({result, status})=> {
      if (result.error)
        showError(result.data, status, false)
      else {
        logIn(result.data)
        trigger("signup")
      }
      setIsLoading(false);
    })
    .catch((err) => {
      console.error('Error al registrarse.', err);
      showError();
    });
  }

  return {isLoading, signUpUser};
}