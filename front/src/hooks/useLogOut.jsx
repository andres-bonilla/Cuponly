import { useEffect, useState } from "react";
import { useAuth } from "../context/AuthContext";
import { useError } from "../context/ErrorContext";
import { useNotifier } from "../context/NotifierContext";
import { handleAPIRes } from "./helpers/handleAPIRes";
import { createErrorHandler } from "./helpers/createErrorHandler";

const API_URL = import.meta.env.VITE_API_URL;

export const useLogOut = () => {
  const [isLoading, setIsLoading] = useState(false);

  const { session, logOut } = useAuth();

  const { showError } = useError();
  const handleAPIError = createErrorHandler(showError, 'Error al cerrar sesión.');

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["force-logout"]


  useEffect(()=>{
    // Se fuerza el cierre de sesion en caso de error 401 o 403 en otra petición.
    if (session?.user && acceptedEvents.includes(event)) logOutUser();
  },[event, session])

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
    .then(handleAPIRes)
    .then(()=> {
      logOut();
      trigger("logout");
    })
    .catch((error)=>{
      // Si el error es de autenticación (401 o 403), también cierra la sesión local
      if (error?.status === 401 || error?.status === 403 ) {
        logOut();
        error = {error: true, data: "Acceso no autorizado. La sesión se ha cerrado.", status: 400};
      }
      
      handleAPIError(error)
    })
    .finally(()=> setIsLoading(false));
  }

  return {isLoading, logOutUser};
}