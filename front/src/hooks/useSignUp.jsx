import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";
import { createErrorHandler } from "./helpers/createErrorHandler";
import { handleAPIRes } from "./helpers/handleAPIRes";

const API_URL = import.meta.env.VITE_API_URL;

export const useSignUp = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { logIn } = useAuth();
  const { trigger } = useNotifier();

  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, 'Error al registrarse.');

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
    .then(handleAPIRes)
    .then(({result})=> {
      logIn(result) // Al registrarse se inicia session directamente.
      trigger("signup")
    })
    .catch(handleAPIError)
    .finally(()=> setIsLoading(false));
  }

  return {isLoading, signUpUser};
}